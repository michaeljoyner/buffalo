<?php

namespace App;

use App\Blog\Post;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function resetPassword($password)
    {
        $this->password = $password;
        return $this->save();
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function addPost($attributes)
    {
        return $this->posts()->create($attributes);
    }
}
