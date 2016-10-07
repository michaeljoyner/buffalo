<?php


namespace App\Social;


use App\Blog\Post;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;

class Facebook
{
    /**
     * @var LaravelFacebookSdk
     */
    private $facebookSdk;

    public function __construct(LaravelFacebookSdk $facebookSdk)
    {
        $this->facebookSdk = $facebookSdk;
    }

    public function getCurrentUserDetails()
    {
        $user = $this->getLastSavedUser();

        if(! $user || !$user->token_string) {
            $user->authorised = false;
            return $user;
        }

        $this->facebookSdk->setDefaultAccessToken($user->token_string);

        try {
            $response = $this->facebookSdk->get('/me?fields=id,name,cover');
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            $user->authorised = false;
            return $user;
        }

        $facebook_user = $response->getGraphUser();

        $user->update([
            'name'      => $facebook_user['name'],
            'cover_src' => $facebook_user['cover']['source']
        ]);
        $user->authorised = true;
        return $user;
    }

    public function sharePost(Post $post)
    {
        $user = $this->getLastSavedUser();

        if (!$user || !$user->share) {
            return;
        }

        $this->facebookSdk->setDefaultAccessToken($user->token_string);

        try {
            $this->facebookSdk->post('/me/feed', [
                'message' => $post->description,
                'link' => url('/news/' . $post->slug)
            ]);
        } catch (Facebook\Exceptions\FacebookSDKException $e) {

        }
    }

    protected function getLastSavedUser()
    {
        $user =  FacebookUser::latest()->first();

        return $user ?: new FacebookUser(['name' => '', 'cover_src' => '', 'share' => false]);
    }
}