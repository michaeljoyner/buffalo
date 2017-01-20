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

    public function supplies()
    {
        return $this->hasMany(Supply::class, 'supplier_id');
    }

    public function products()
    {
        return $this->supplies()->with('product')->get()->map(function($supply) {
            return $supply->product;
        })->unique();
    }
}
