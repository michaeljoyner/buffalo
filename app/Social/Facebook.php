<?php


namespace App\Social;


use App\Blog\Post;
use Illuminate\Support\Facades\Log;
use Facebook\Facebook as SDK;

class Facebook
{
    private $token;
    private $page_id;
    private $sdk;

    public function __construct($token)
    {
        $this->token = $token;
        $this->page_id = config('services.facebook.page_id');
        $this->sdk = new SDK([
            'app_id' => config('services.facebook.client_id'),
            'app_secret' => config('services.facebook.client_secret'),
            'default_graph_version' => 'v2.10',
        ]);
    }

    private function getPageAccessToken()
    {
        $response = $this->sdk->get("/{$this->page_id}?fields=access_token", $this->token);

        return $response->getAccessToken();
    }

    public function postArticle(Post $post)
    {
        if(!$this->token) {
            return;
        }

        $token = $this->getPageAccessToken();
        try {
            $this->sdk->post(
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
            $response = $this->sdk->get("/debug_token?input_token={$this->token}", $this->token);
            $result = $response->getDecodedBody()['data']['is_valid'];
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }

        return $result;
    }
}