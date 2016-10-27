<?php

namespace App\Http\Controllers\Admin;

use App\Http\FlashMessaging\Flasher;
use App\Social\Facebook;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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

    public function __construct(Flasher $flasher, Facebook $facebook)
    {
        $this->flasher = $flasher;
        $this->facebook = $facebook;
    }
    
    public function login()
    {
        return $this->facebook->login();
    }

    public function callback()
    {
        $user = $this->facebook->createAuthentictedUser();

        if(! $user) {
            $this->flasher->error('Error', 'Unable to get authentication from Facebook.');
        }

        return redirect('admin/social');
    }
}
