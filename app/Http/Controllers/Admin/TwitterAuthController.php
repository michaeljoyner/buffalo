<?php

namespace App\Http\Controllers\Admin;

use App\Http\FlashMessaging\Flasher;
use App\Social\TwitterUser;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Thujohn\Twitter\Facades\Twitter;

class TwitterAuthController extends Controller
{

    /**
     * @var Flasher
     */
    private $flasher;

    public function __construct(Flasher $flasher)
    {
        $this->flasher = $flasher;
    }

    public function login()
    {
        Twitter::reconfig(['token' => '', 'secret' => '']);
        $token = Twitter::getRequestToken(url('admin/twitter/callback'));

        if (isset($token['oauth_token_secret'])) {
            $url = Twitter::getAuthorizeURL($token, true, false);

            Session::put('oauth_state', 'start');
            Session::put('oauth_request_token', $token['oauth_token']);
            Session::put('oauth_request_token_secret', $token['oauth_token_secret']);

            return redirect($url);
        }

        $this->flasher->error('Sorry', 'Unable to begin Twitter authorization');

        return redirect()->back();
    }

    public function callback(Request $request)
    {
        // You should set this route on your Twitter Application settings as the callback
        // https://apps.twitter.com/app/YOUR-APP-ID/settings
        if (Session::has('oauth_request_token')) {
            $request_token = [
                'token'  => Session::get('oauth_request_token'),
                'secret' => Session::get('oauth_request_token_secret'),
            ];

            Twitter::reconfig($request_token);

            $oauth_verifier = false;

            if ($request->has('oauth_verifier')) {
                $oauth_verifier = $request->get('oauth_verifier');
            }

            // getAccessToken() will reset the token for you
            $token = Twitter::getAccessToken($oauth_verifier);

            if (!isset($token['oauth_token_secret'])) {
                $this->flasher->error('Oh dear!', 'We were unable to log you in to Twitter');

                return redirect('admin/social');
            }

            $credentials = Twitter::getCredentials();

            if (is_object($credentials) && !isset($credentials->error)) {
                TwitterUser::create([
                    'name'         => $credentials->name,
                    'cover_src'    => $credentials->profile_banner_url,
                    'token'        => $token['oauth_token'],
                    'token_secret' => $token['oauth_token_secret']
                ]);

                Session::put('access_token', $token);
                $this->flasher->success('Success', 'You have been authorized with Twitter');

                return redirect('admin/social');
            }
        }
        $this->flasher->error('Oops, sorry.', 'Something went wrong getting authorisation from twitter');
        return redirect('admin/social');
    }
}