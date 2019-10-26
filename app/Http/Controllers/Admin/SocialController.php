<?php

namespace App\Http\Controllers\Admin;

use App\AccessToken;
use App\Social\Facebook;
use App\Social\Twitter;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SocialController extends Controller
{
    public function index()
    {
        $fb = new Facebook(AccessToken::forFacebook());
        $tw = new Twitter(AccessToken::forTwitter());

        return view('admin.social.index', [
            'has_fb_auth' => $fb->checkToken(),
            'has_tw_auth' => $tw->checkToken(),
        ]);
    }
}
