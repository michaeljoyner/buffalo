<?php


namespace App\Social;


use App\Blog\Post;
use Illuminate\Support\Facades\Session;
use Thujohn\Twitter\Facades\Twitter as TwitterSdk;

class Twitter
{

    public function __construct()
    {

    }

    public function login()
    {
        TwitterSdk::reconfig(['token' => '', 'secret' => '']);
        $token = TwitterSdk::getRequestToken(url('admin/twitter/callback'));

        if (isset($token['oauth_token_secret'])) {
            $url = TwitterSdk::getAuthorizeURL($token, true, false);
            $this->storeRequestToken($token);

            return redirect($url);
        }

        $this->flasher->error('Sorry', 'Unable to begin Twitter authorization');

        return redirect('admin/social');
    }

    public function createAuthenticatedUser($verifier)
    {
        TwitterSdk::reconfig($this->getRequestTokenFromStore());

        $token = TwitterSdk::getAccessToken($verifier);

        return $this->createUser($token);
    }

    protected function createUser($token)
    {
        if (!isset($token['oauth_token_secret'])) {
            return false;
        }
        $credentials = TwitterSdk::getCredentials();

        if (is_object($credentials) && !isset($credentials->error)) {
            return TwitterUser::create([
                'name'             => $credentials->name,
                'cover_src'        => $credentials->profile_banner_url,
                'token_serialized' => serialize($token)
            ]);
        }

        return false;
    }


    protected function storeRequestToken($token)
    {
        Session::put('twitter.oauth_state', 'start');
        Session::put('twitter.oauth_request_token', $token['oauth_token']);
        Session::put('twitter.oauth_request_token_secret', $token['oauth_token_secret']);
    }

    protected function getRequestTokenFromStore()
    {
        return [
            'token'  => Session::get('twitter.oauth_request_token'),
            'secret' => Session::get('twitter.oauth_request_token_secret'),
        ];
    }

    public function getCurrentUser()
    {
        $user = TwitterUser::latest()->first();

        if (!$user) {
            return new TwitterUser(['name' => '', 'cover_pic' => '', 'authorised' => false]);
        }

        TwitterSdk::reconfig($this->tokenFromUser($user));

        $credentials = TwitterSdk::getCredentials();

        if (is_object($credentials) && !isset($credentials->error)) {
            $user->update([
                'name'      => $credentials->name,
                'cover_src' => $credentials->profile_banner_url,
            ]);

            $user->authorised = true;

            return $user;
        }

        return new TwitterUser(['name' => '', 'cover_pic' => '', 'authorised' => false]);
    }

    public function sharePost(Post $post)
    {
        $user = TwitterUser::latest()->first();

        if (!$user || !$user->share) {
            return;
        }

        TwitterSdk::reconfig($this->tokenFromUser($user));

        try {
            TwitterSdk::postTweet(['status' => $post->title . ' ' . url('/news/' . $post->slug)]);
        } catch (\Exception $e) {

        }
    }

    protected function tokenFromUser($user)
    {
        $token = unserialize($user->token_serialized);

        return [
            'token'  => $token['oauth_token'],
            'secret' => $token['oauth_token_secret']
        ];
    }
}