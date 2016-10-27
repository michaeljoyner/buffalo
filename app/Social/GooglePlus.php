<?php


namespace App\Social;


use App\Blog\Post;
use Google_Client;
use Google_Service_Plus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mockery\CountValidator\Exception;

class GooglePlus
{

    /**
     * @var Google_Client
     */
    private $google;

    public function __construct(Google_Client $google)
    {
        $this->google = $google;
    }

    public function login()
    {
        return $this->google->createAuthUrl();
    }

    public function createAuthenticatedUser($requestToken)
    {
        $this->google->authenticate($requestToken);
        $token = $this->google->getAccessToken();
        $this->google->setAccessToken($token);

        return $this->createUser($token);
    }

    protected function createUser($token)
    {
        $user = $this->fetchUserDetails();

        if(! $user) {
            return false;
        }


        return GooglePlusUser::create([
            'name' => $user->displayName,
            'token_serialized' => serialize($token),
            'cover_src' => $user->getCover() ? $user->getCover()->getCoverPhoto()->getUrl() : ''
        ]);
    }

    public function getCurrentUser()
    {
        $user = GooglePlusUser::latest()->first();

        if(!$user) {
            return new GooglePlusUser(['name' => '', 'cover_src' => '', 'authorised' => false]);
        }


        $this->google->setAccessToken(unserialize($user->token_serialized));

        $user_details = $this->fetchUserDetails();

        if($user_details) {
            $this->updateUserDetails($user, $user_details);
            $user->authorised = true;
            return $user;
        }

        return new GooglePlusUser(['name' => '', 'cover_src' => '', 'authorised' => false]);
    }

    protected function updateUserDetails($user, $newDetails) {
        $user->update([
            'name' => $newDetails->displayName,
            'cover_pic' => $newDetails->getCover() ? $newDetails->getCover()->getCoverPhoto()->getUrl() : ''
        ]);
    }

    protected function fetchUserDetails()
    {
        $plus = new Google_Service_Plus($this->google);
        try {
            $user_details = $plus->people->get('me');
        } catch(\Exception $e) {
            $user_details = false;
        }

        return $user_details;
    }

    public function sharePost(Post $post)
    {
        $user = $this->getLatestStoredUser();

        if(!$user || ! $user->share) {
            return;
        }

        $this->google->setAccessToken(unserialize($user->token_serialized));

        $plus = new \Google_Service_PlusDomains($this->google);

        try {
            $plus->activities->insert("me", new \Google_Service_PlusDomains_Activity([
                'object' => [
                    'originalContent' => $post->description,
                    'attachments' => [
                        'url' => url('/news/' . $post->slug),
                        'objectType' => 'article'
                    ]
                ],
                'access' => [
                    'items' => ['type' => 'public'],
                    'domainRestricted' => true
                ]
            ]));

        } catch(\Exception $e) {

        }
    }

    protected function getLatestStoredUser()
    {
        return GooglePlusUser::latest()->first();
    }
}