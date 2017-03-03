<?php

namespace App\Customers;

use App\Quotes\Quote;
use Carbon\Carbon;
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
        'payment_terms',
        'terms'
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

    public static function matchingOrder($order)
    {
        return static::where('name', 'LIKE', $order->company)
            ->orWhere('email', $order->email)
            ->orWhere('contact_person', 'LIKE', $order->contact_person)
            ->get();
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class, 'customer_id');
    }

    public function newQuote($order = null)
    {
        if(! $order) {
            return $this->createCustomerQuote();
        }

        $quote = $this->createCustomerQuote(['order_id' => $order->id]);

        $order->items->each(function($item) use ($quote) {
            $quote->addItemFromOrder($item);
        });

        return $quote;
    }

    protected function createCustomerQuote($parameters = [])
    {
        $data = array_merge([
            'valid_until' => Carbon::parse('+30 days'),
            'payment_terms' => $this->payment_terms,
            'terms' => $this->terms
        ], $parameters);
        return $this->quotes()->create($data);
    }
}
