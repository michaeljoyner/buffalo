<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SocialSharingSetting;
use Illuminate\Http\Request;

class SocialSharingSettingsController extends Controller
{
    public function show()
    {
        return [
            'facebook' => ['share' => SocialSharingSetting::shareToFacebook()],
            'twitter' => ['share' => SocialSharingSetting::shareToTwitter()],
        ];
    }
}
