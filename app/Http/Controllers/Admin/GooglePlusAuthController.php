<?php

namespace App\Http\Controllers\Admin;

use App\Http\FlashMessaging\Flasher;
use App\Social\GooglePlus;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GooglePlusAuthController extends Controller
{
    /**
     * @var Flasher
     */
    private $flasher;

    public function __construct(Flasher $flasher)
    {
        $this->flasher = $flasher;
    }

    public function login(GooglePlus $googlePlus)
    {
        return redirect($googlePlus->login());
    }

    public function callback(Request $request, GooglePlus $googlePlus)
    {
        if(! $request->get('code')) {
            $this->flasher->error('Failed', 'Unable to authorize with Google Plus at the moment.');
            return redirect('admin/social');
        }

        $user = $googlePlus->createAuthenticatedUser($request->get('code'));

        if(! $user) {
            $this->flasher->error('Failed', 'Unable to authorize with Google Plus at the moment.');
        }

        return redirect('admin/social');
    }
}
