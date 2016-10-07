<?php

namespace App\Http\Controllers\Admin;

use App\Http\FlashMessaging\Flasher;
use App\Social\FacebookUser;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;

class FacebookAuthController extends Controller
{
    /**
     * @var Flasher
     */
    private $flasher;
    /**
     * @var LaravelFacebookSdk
     */
    private $facebookSdk;

    public function __construct(Flasher $flasher, LaravelFacebookSdk $facebookSdk)
    {
        $this->flasher = $flasher;
        $this->facebookSdk = $facebookSdk;
    }
    
    public function login()
    {
        $login_url = $this->facebookSdk->getLoginUrl(['email', 'publish_actions']);

        return redirect($login_url);
    }

    public function callback()
    {
        try {
            $token = $this->facebookSdk->getAccessTokenFromRedirect();
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            $this->flasher->error('An error occured', 'Unable to get permission from Facebook');

            return redirect('admin/social');
        }

        if (! $token) {
            $helper = $this->facebookSdk->getRedirectLoginHelper();

            if (! $helper->getError()) {
                abort(403, 'Unauthorized action.');
            }

            $this->flasher->error('Permission Denied', $helper->getErrorReason());
            return redirect('admin/social');
        }

        if (! $token->isLongLived()) {
            // OAuth 2.0 client handler
            $oauth_client = $this->facebookSdk->getOAuth2Client();

            // Extend the access token.
            try {
                $token = $oauth_client->getLongLivedAccessToken($token);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                $this->flasher->error('Error', "An error occured while extending permission");
                return redirect('admin/social');
            }
        }

        $this->facebookSdk->setDefaultAccessToken($token);

        try {
            $response = $this->facebookSdk->get('/me?fields=id,name,cover');
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            $this->flasher->error('Error', "An error occurred while getting user info from facebook");
            return redirect('admin/social');
        }

        // Convert the response to a `Facebook/GraphNodes/GraphUser` collection
        $facebook_user = $response->getGraphUser();

        //Delete all previous users
        FacebookUser::all()->each(function($outdated) {
            $outdated->delete();
        });

        FacebookUser::create([
            'token_string' => $token->getValue(),
            'name' => $facebook_user['name'],
            'cover_src' => $facebook_user['cover']['source']
        ]);

        return redirect('admin/social');
    }
}
