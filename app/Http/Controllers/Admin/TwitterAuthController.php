<?php

namespace App\Http\Controllers\Admin;

use App\Http\FlashMessaging\Flasher;
use App\Social\Twitter;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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

    public function login(Twitter $twitter)
    {
        return $twitter->login();
    }

    public function callback(Request $request, Twitter $twitter)
    {
        $user = $twitter->createAuthenticatedUser($request->get('oauth_verifier', false));

        if(! $user) {
            $this->flasher->error('Oops, sorry.', 'Something went wrong getting authorisation from twitter');
        }

        return redirect('admin/social');
    }
}