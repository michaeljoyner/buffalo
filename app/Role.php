<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const LIMITED = 'limited';
    const SUPER_ADMIN = 'super_admin';

    protected $table = 'roles';

    protected $fillable = ['name'];

    public static function limited()
    {
        return static::firstOrCreate(['name' => static::LIMITED]);
    }

    public static function superadmin()
    {
        return static::firstOrCreate(['name' => static::SUPER_ADMIN]);
    }
}
