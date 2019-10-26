<?php

namespace App\Http\Controllers\Admin;

use App\AccessToken;
use App\Http\FlashMessaging\Flasher;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class FacebookAuthController extends Controller
{
    /**
     * @var Flasher
     */
    private $flasher;
    /**
     * @var Facebook
     */
    private $facebook;

    public function __construct(Flasher $flasher)
    {
        $this->flasher = $flasher;
    }

    public function login()
    {
        return Socialite::driver('facebook')
                        ->scopes(['manage_pages', 'publish_pages'])
                        ->redirect();
    }

    public function callback()
    {
        $user = false;

        try {
            $user = Socialite::driver('facebook')->user();
        } catch (\Exception $e) {

        }

        if ($user) {
            AccessToken::create([
                'platform' => 'facebook',
                'token' => $user->token,
            ]);
        } else {
            $this->flasher->error('Error', 'Unable to get authentication from Facebook.');
        }

        return redirect('/admin/social');
    }
}
