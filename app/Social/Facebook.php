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

    public function login()
    {
        return redirect($this->facebookSdk->getLoginUrl(['email', 'publish_actions']));
    }

    public function createAuthentictedUser()
    {
        try {
            $token = $this->facebookSdk->getAccessTokenFromRedirect();
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            return false;
        }

        if (! $token) {
            $helper = $this->facebookSdk->getRedirectLoginHelper();

            if (! $helper->getError()) {
                abort(403, 'Unauthorized action.');
            }

            return false;
        }

        if (! $token->isLongLived()) {
            $oauth_client = $this->facebookSdk->getOAuth2Client();
            try {
                $token = $oauth_client->getLongLivedAccessToken($token);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                return false;
            }
        }
        $this->facebookSdk->setDefaultAccessToken($token);

        return $this->createUser($token);

    }

    protected function createUser($token)
    {
        $facebook_user = $this->getUserDetails();

        if(! $facebook_user) {
            return false;
        }

        FacebookUser::all()->each(function($outdated) {
            $outdated->delete();
        });

        return FacebookUser::create([
            'token_serialized' => serialize($token),
            'name' => $facebook_user['name'],
            'cover_src' => isset($facebook_user['cover']['source']) ? isset($facebook_user['cover']['source']) : ''
        ]);
    }

    protected function getUserDetails()
    {
        try {
            $response = $this->facebookSdk->get('/me?fields=id,name,cover');
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            return false;
        }

        return $response->getGraphUser();
    }

    public function getCurrentUserDetails()
    {
        $user = $this->getLastSavedUser();

        if(! $user) {
            return new FacebookUser(['name' => '', 'cover_src' => '', 'authorized' => 'false']);
        }

        $this->facebookSdk->setDefaultAccessToken($this->tokenFromUser($user));

        $facebook_user = $this->getUserDetails();

        if(! $facebook_user) {
            $user->authorized = false;
            return $user;
        }

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


        $this->facebookSdk->setDefaultAccessToken($this->tokenFromUser($user));

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
        return FacebookUser::latest()->first();
    }

    protected function tokenFromUser($user)
    {
        $token = unserialize($user->token_serialized);
        return $token->getValue();
    }
}