<?php


namespace App\Social;


use App\Blog\Post;
use Illuminate\Support\Facades\Log;
use Vinkla\Facebook\Facades\Facebook as SDK;

class Facebook
{
    private $token;
    private $page_id;

    public function __construct($token)
    {
        $this->token = $token;
        $this->page_id = config('services.facebook.page_id');
    }

    private function getPageAccessToken()
    {
        $response = SDK::get("/{$this->page_id}?fields=access_token", $this->token);
        return $response->getAccessToken();
    }

    public function postArticle(Post $post)
    {
        if(!$this->token) {
            return;
        }

        $token = $this->getPageAccessToken();
        try {
            SDK::post(
                "/{$this->page_id}/feed",
                ['message' => $post->description, 'link' => url("news/{$post->slug}")],
                $token
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function checkToken()
    {
        $result = false;
        try {
            $response = SDK::get("/debug_token?input_token={$this->token}", $this->token);
            $result = $response->getDecodedBody()['data']['is_valid'];
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }

        return $result;
    }
}