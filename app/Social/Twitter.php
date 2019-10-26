<?php


namespace App\Social;


use App\AccessToken;
use App\Blog\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class Twitter
{

    public function __construct($accessToken)
    {
        $this->consumer_key = config('services.twitter.client_id');
        $this->consumer_secret = config('services.twitter.client_secret');
        $this->token = $accessToken->token;
        $this->token_secret = $accessToken->token_secret;
    }

    public function postTweet(Post $post)
    {
        $tweeter = $this->makeTweeter();

        $url = url("/news/{$post->slug}");

        try {
            $tweeter->send("{$post->title} {$url}");
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

    }

    public function checkToken()
    {
        $result = false;
        $tw = $this->makeTweeter();

        try {
            $result = $tw->authenticate();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return $result;
    }

    private function makeTweeter()
    {
        return new \DG\Twitter\Twitter(
            $this->consumer_key,
            $this->consumer_secret,
            $this->token,
            $this->token_secret
        );
    }
}