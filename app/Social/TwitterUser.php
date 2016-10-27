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
        'token_serialized',
        'share'
    ];

    protected $hidden = ['token_serialized'];
}
