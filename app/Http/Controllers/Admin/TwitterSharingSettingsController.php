<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SocialSharingSetting;
use Illuminate\Http\Request;

class TwitterSharingSettingsController extends Controller
{
    public function store()
    {
        SocialSharingSetting::twitterOn();

        return [
            'facebook' => ['share' => SocialSharingSetting::shareToFacebook()],
            'twitter' => ['share' => SocialSharingSetting::shareToTwitter()],
        ];
    }

    public function destroy()
    {
        SocialSharingSetting::twitterOff();

        return [
            'facebook' => ['share' => SocialSharingSetting::shareToFacebook()],
            'twitter' => ['share' => SocialSharingSetting::shareToTwitter()],
        ];
    }
}
