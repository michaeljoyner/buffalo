<?php

namespace App\Sourcing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;

    protected $table = 'suppliers';

    protected $fillable = ['name', 'email', 'address', 'phone', 'contact_person', 'website'];

    protected $dates = ['deleted_at'];
}