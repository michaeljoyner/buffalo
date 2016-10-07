<?php

namespace App\Social;

use Illuminate\Database\Eloquent\Model;

class FacebookUser extends Model
{

    use SharesPosts;

    protected $table = 'facebook_users';

    protected $fillable = [
        'token_string',
        'name',
        'cover_src'
    ];

    protected $hidden = ['token_string'];

    protected $casts = ['share' => 'boolean'];


}
