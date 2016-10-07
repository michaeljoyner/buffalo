<?php


namespace App\Social;


use App\Blog\Post;
use Thujohn\Twitter\Facades\Twitter as TwitterSdk;

class Twitter
{
    public function getCurrentUser()
    {
        $user = TwitterUser::latest()->first();

        if(!$user) {
            return new TwitterUser(['name' => '', 'cover_pic' => '', 'authorised' => false]);
        }

        TwitterSdk::reconfig(['token' => $user->token, 'secret' => $user->token_secret]);

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

        if(!$user || !$user->share) {
            return;
        }

        TwitterSdk::reconfig(['token' => $user->token, 'secret' => $user->token_secret]);

        try {
            TwitterSdk::postTweet(['status' => $post->title . ' ' . url('/news/' . $post->slug)]);
        } catch (\Exception $e) {

        }
    }
}