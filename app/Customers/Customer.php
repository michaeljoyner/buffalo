<?php

namespace App\Customers;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'name',
        'contact_person',
        'email',
        'phone',
        'fax',
        'website',
        'address',
        'remarks',
        'payment_terms'
    ];
}
