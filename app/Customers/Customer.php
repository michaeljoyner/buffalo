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

    public static function createFromOrder($order)
    {
        return static::create([
            'name' => $order->company,
            'contact_person' => $order->contact_person,
            'email' => $order->email,
            'phone' => $order->phone,
            'fax' => $order->fax,
            'website' => $order->website,
        ]);
    }
}
