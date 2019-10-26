<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SocialSharingSetting;
use Illuminate\Http\Request;

class FacebookSharingSettingsController extends Controller
{
    public function store()
    {
        SocialSharingSetting::facebookOn();

        return [
            'facebook' => ['share' => SocialSharingSetting::shareToFacebook()],
            'twitter' => ['share' => SocialSharingSetting::shareToTwitter()],
        ];
    }

    public function destroy()
    {
        SocialSharingSetting::facebookOff();

        return [
            'facebook' => ['share' => SocialSharingSetting::shareToFacebook()],
            'twitter' => ['share' => SocialSharingSetting::shareToTwitter()],
        ];
    }
}
