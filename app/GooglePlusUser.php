<?php

namespace App;

use App\Social\SharesPosts;
use Illuminate\Database\Eloquent\Model;

class GooglePlusUser extends Model
{
    use SharesPosts;

    protected $table = 'google_plus_users';

    protected $fillable = [
        'name',
        'cover_src',
        'token',
        'token_expires',
        'refresh_token'
    ];

    protected $hidden = ['token'];
}
