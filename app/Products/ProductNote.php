<?php

namespace App\Products;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ProductNote extends Model
{
    protected $table = 'product_notes';

    protected $fillable = ['user_id', 'content'];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
