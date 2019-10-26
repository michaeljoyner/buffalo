<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialSharingSetting extends Model
{
    protected $fillable = ['platform', 'share'];

    protected $casts = ['share' => 'boolean'];

    public static function shareToFacebook()
    {
        $setting = static::where('platform', 'facebook')->latest()->first();

        return $setting->share ?? false;
    }

    public static function facebookOn()
    {
        static::create([
            'platform' => 'facebook',
            'share' => true,
        ]);
    }

    public static function facebookOff()
    {
        static::create([
            'platform' => 'facebook',
            'share' => false,
        ]);
    }

    public static function shareToTwitter()
    {
        $setting = static::where('platform', 'twitter')->latest()->first();

        return $setting->share ?? false;
    }

    public static function twitterOn()
    {
        static::create([
            'platform' => 'twitter',
            'share' => true,
        ]);
    }

    public static function twitterOff()
    {
        static::create([
            'platform' => 'twitter',
            'share' => false,
        ]);
    }
}
