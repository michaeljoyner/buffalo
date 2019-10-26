<?php

namespace App\Http\Controllers\Admin;

use App\AccessToken;
use App\Http\FlashMessaging\Flasher;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

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
        return Socialite::driver('twitter')->redirect();
    }

    public function callback()
    {
        $user = false;

        try {
            $user = Socialite::driver('twitter')->user();
        } catch (\Exception $e) {
            Log::error($e);
        }

        if ($user) {
            AccessToken::create([
                'platform' => 'twitter',
                'token' => $user->token,
                'token_secret' => $user->tokenSecret,
            ]);
        } else {
            $this->flasher->error('Error', 'Unable to get authentication from Twitter.');
        }

        return redirect('/admin/social');
    }
}