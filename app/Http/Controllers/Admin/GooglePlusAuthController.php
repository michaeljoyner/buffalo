<?php

namespace App\Http\Controllers\Admin;

use App\GooglePlusUser;
use Google_Service_Plus;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GooglePlusAuthController extends Controller
{
    public function login()
    {
        $client = new \Google_Client();
        $client->setAuthConfig(config('googleplus'));
        $client->addScope([
            Google_Service_Plus::PLUS_ME,
            'https://www.googleapis.com/auth/plus.stream.write'
        ]);
        $client->setAccessType('offline');
        $client->setApprovalPrompt('force');
        $client->setRedirectUri('http://buffalo.app:8000/admin/googleplus/callback');

        return redirect($client->createAuthUrl());

    }

    public function callback(Request $request)
    {
        $client = new \Google_Client();
        $client->setAuthConfig(config('googleplus'));
        $client->setRedirectUri('http://buffalo.app:8000/admin/googleplus/callback');

        $client->authenticate($request->get('code'));
        $token = $client->getAccessToken();
        $client->setAccessToken($token);

        $plus = new Google_Service_Plus($client);
        $user = $plus->people->get('me');


        GooglePlusUser::create([
            'name' => $user->displayName,
            'token' => $token['access_token'],
            'token_expires' => $token['expires_in'],
            'refresh_token' => $token['refresh_token'],
            'cover_src' => ''
        ]);

        return redirect('admin/social');
    }
}
