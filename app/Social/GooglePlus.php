<?php


namespace App\Social;


use App\Blog\Post;
use App\GooglePlusUser;
use Google_Service_Plus;
use Illuminate\Support\Facades\Log;

class GooglePlus
{
    public function getCurrentUser()
    {
        $user = GooglePlusUser::latest()->first();

        if(!$user) {
            return new GooglePlusUser(['name' => '', 'cover_src' => '', 'authorised' => false]);
        }

        $client = new \Google_Client();
        $client->setAuthConfig(config('googleplus'));
        $client->setRedirectUri('http://buffalo.app:8000/admin/googleplus/callback');
        $client->setAccessToken([
            'access_token' => $user->token,
            'expires_in' => $user->token_expires,
            'refresh_token' => $user->refresh_token,
        ]);

        $plus = new Google_Service_Plus($client);
        $user_details = $plus->people->get('me');
        if($user_details) {
            $user->update([
                'name' => $user_details->displayName,
                'cover_pic' => ''
            ]);
            $user->authorised = true;
            return $user;
        }

        return new GooglePlusUser(['name' => '', 'cover_src' => '', 'authorised' => false]);
    }

    public function sharePost(Post $post)
    {
        $user = GooglePlusUser::latest()->first();

        if(!$user || ! $user->share) {
            return;
        }

        $client = new \Google_Client();
        $client->setAuthConfig(config('googleplus'));
        $client->setRedirectUri('http://buffalo.app:8000/admin/googleplus/callback');
        $client->addScope([
            Google_Service_Plus::PLUS_ME,
            'https://www.googleapis.com/auth/plus.stream.write',
            'https://www.googleapis.com/auth/plus.stream.read',
            'https://www.googleapis.com/auth/plus.circles.read',
            'https://www.googleapis.com/auth/plus.circles.write'
        ]);
        $client->setAccessToken([
            'access_token' => $user->token,
            'expires_in' => $user->token_expires,
            'refresh_token' => $user->refresh_token,
        ]);

        $http = $client->authorize();

        $userId = "me";

        $url = sprintf('https://www.googleapis.com/plusDomains/v1/people/%s/activities', $userId);

        $headers = ['content-type' => 'application/json'];
        $body = [
            "object" => [
                "originalContent" => $post->description
            ],
            "access" => [
                "items" => [
                    ["type" => "public"]
                ],
                "domainRestricted" => true
            ]
        ];
        $request = new \GuzzleHttp\Psr7\Request('POST', $url, $headers, json_encode($body));

// make the HTTP request
        $response = $http->send($request);

        Log::info($response->getBody()->getContents());

//        $plus = new \Google_Service_PlusDomains($client);
//
//        $plus->activities->insert("me", new \Google_Service_PlusDomains_Activity([
//            'object' => [
//                'originalContent' => $post->description,
//                'attachments' => [
//                    'url' => url('news/'.$post->slug)
//                ]
//            ],
//            'access' => [
//                'items' => ['type' => 'public'],
//                'domainRestricted' => true
//            ]
//        ]));


    }
}