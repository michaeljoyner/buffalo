<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
{
    protected $fillable = ['platform', 'token', 'token_secret'];

    public static function forFacebook()
    {
        $token = static::where('platform', 'facebook')->latest()->first();

        return $token->token ?? '';
    }

    public static function forTwitter()
    {
        $token = static::where('platform', 'twitter')->latest()->first();

        return $token ?? (object)['token' => '', 'token_secret' => ''];
    }
}
