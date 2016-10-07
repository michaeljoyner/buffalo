<?php

namespace App\Social;

use Illuminate\Database\Eloquent\Model;

class TwitterUser extends Model
{
    use SharesPosts;

    protected $table = 'twitter_users';

    protected $fillable = [
        'name',
        'cover_src',
        'token',
        'token_secret',
        'share'
    ];

    protected $hidden = ['token', 'token_secret'];
}
