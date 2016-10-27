<?php

namespace App\Social;

use App\Social\SharesPosts;
use Illuminate\Database\Eloquent\Model;

class GooglePlusUser extends Model
{
    use SharesPosts;

    protected $table = 'google_plus_users';

    protected $fillable = [
        'name',
        'cover_src',
        'token_serialized',
    ];

    protected $hidden = ['token_serialized'];
}
