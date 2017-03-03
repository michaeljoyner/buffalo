<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->safeEmail,
        'password'       => str_random(10),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Blog\Post::class, function (Faker\Generator $faker) {
    return [
        'title'        => $faker->sentence,
        'description'  => $faker->paragraph,
        'body'         => $faker->paragraphs(5, true),
        'published'    => 0,
        'published_at' => null
    ];
});

$factory->define(App\Products\Product::class, function (Faker\Generator $faker) {
    return [
        'category_id'            => function () {
            return factory(\App\Products\Category::class)->create()->id;
        },
        'subcategory_id'         => function () {
            return factory(\App\Products\Subcategory::class)->create()->id;
        },
        'product_group_id'       => function () {
            return factory(\App\Products\ProductGroup::class)->create()->id;
        },
        'product_code'           => \Illuminate\Support\Str::random(7),
        'name'                   => $faker->words(4, true),
        'description'            => $faker->paragraph,
        'writeup'                => $faker->paragraph,
        'available'              => 1,
        'is_promoted'            => 0,
        'marked_new'             => 0,
        'minimum_order_quantity' => 500
    ];
});

$factory->define(App\Products\Packaging::class, function (Faker\Generator $faker) {
    return [
        'product_id'   => function () {
            return factory(\App\Products\Product::class)->create()->id;
        },
        'type'         => 'Example package type',
        'unit'         => 'Example unit',
        'inner'        => $faker->numberBetween(24, 80),
        'outer'        => $faker->numberBetween(80, 160),
        'carton'       => $faker->word,
        'net_weight'   => $faker->randomFloat(1, 1.0, 15.0),
        'gross_weight' => $faker->randomFloat(1, 1.0, 15.0)
    ];
});

$factory->define(App\Products\ProductNote::class, function (Faker\Generator $faker) {
    return [
        'product_id' => function () {
            return factory(\App\Products\Product::class)->create()->id;
        },
        'user_id'    => function () {
            return factory(\App\User::class)->create()->id;
        },
        'content'    => $faker->paragraph
    ];
});

$factory->define(App\Products\Category::class, function (Faker\Generator $faker) {
    return [
        'name'        => $faker->words(4, true),
        'description' => $faker->paragraph,
        'position'    => null
    ];
});

$factory->define(App\Products\Subcategory::class, function (Faker\Generator $faker) {
    return [
        'category_id' => function () {
            return factory(\App\Products\Category::class)->create()->id;
        },
        'name'        => $faker->words(4, true),
        'description' => $faker->paragraph,
    ];
});

$factory->define(App\Products\ProductGroup::class, function (Faker\Generator $faker) {
    return [
        'subcategory_id' => function () {
            return factory(\App\Products\Subcategory::class)->create()->id;
        },
        'name'           => $faker->words(4, true),
        'description'    => $faker->paragraph,
    ];
});

$factory->define(App\Orders\Order::class, function (Faker\Generator $faker) {
    return [
        'company'        => $faker->company,
        'contact_person' => $faker->name,
        'phone'          => $faker->phoneNumber,
        'fax'            => $faker->phoneNumber,
        'email'          => $faker->email,
        'website'        => $faker->url,
        'referrer'       => $faker->randomElement(['google', 'taiwan trade', 'expo', 'trade magazine']),
        'requirements'   => $faker->paragraph
    ];
});

$factory->define(App\Orders\OrderItem::class, function (Faker\Generator $faker) {
    return [
        'order_id'   => function () {
            return factory(\App\Orders\Order::class)->create()->id;
        },
        'product_id' => function () {
            return factory(\App\Products\Product::class)->create()->id;
        },
        'name'       => $faker->words(4, true),
        'quantity'   => $faker->numberBetween(1, 100)
    ];
});

$factory->define(App\SiteContent\Slide::class, function (Faker\Generator $faker) {
    return [
        'slide_text'   => $faker->sentence,
        'action_text'  => $faker->word,
        'action_link'  => $faker->randomElement(['/about', '/#servics', '/contact', '/products']),
        'text_colour'  => $faker->randomElement(['dark', 'brand', 'white']),
        'is_video'     => 0,
        'video'        => null,
        'position'     => null,
        'is_published' => 0
    ];
});

$factory->define(App\Sourcing\Supplier::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->company,
        'email'          => $faker->companyEmail,
        'address'        => $faker->address,
        'phone'          => $faker->phoneNumber,
        'website'        => $faker->url,
        'contact_person' => $faker->name
    ];
});

$factory->define(App\Sourcing\Supply::class, function (Faker\Generator $faker) {
    return [
        'supplier_id'   => function () {
            return factory(\App\Sourcing\Supplier::class)->create()->id;
        },
        'product_id'    => function () {
            return factory(\App\Products\Product::class)->create()->id;
        },
        'quoted_date'   => \Carbon\Carbon::now(),
        'valid_until'   => \Carbon\Carbon::parse('+30 days'),
        'item_number'   => $faker->numberBetween(10000, 99999),
        'currency'      => $faker->currencyCode,
        'price'         => $faker->numberBetween(1000, 9999),
        'package_price' => $faker->numberBetween(100, 999),
        'remarks'       => $faker->paragraph
    ];
});

$factory->define(App\Customers\Customer::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->company,
        'contact_person' => $faker->name,
        'phone'          => $faker->phoneNumber,
        'fax'            => $faker->phoneNumber,
        'email'          => $faker->email,
        'website'        => $faker->url,
        'remarks'        => $faker->paragraph,
        'address'        => $faker->address,
        'payment_terms'  => $faker->sentence,
        'terms'          => $faker->sentence
    ];
});

$factory->define(App\Quotes\Quote::class, function (Faker\Generator $faker) {
    return [
        'quote_number'  => $faker->word,
        'customer_id'   => function () {
            return factory(\App\Customers\Customer::class)->create()->id;
        },
        'order_id'      => function () {
            return factory(\App\Orders\Order::class)->create()->id;
        },
        'finalized_on'  => null,
        'valid_until'   => null,
        'payment_terms' => $faker->sentence,
        'remarks'       => $faker->paragraph
    ];
});

$factory->define(App\Quotes\QuoteItem::class, function (Faker\Generator $faker) {
    $product = factory(\App\Products\Product::class)->create();

    return [
        'quote_id'             => function () {
            return factory(\App\Quotes\Quote::class)->create()->id;
        },
        'product_id'           => $product->id,
        'name'                 => $product->name,
        'buffalo_product_code' => $product->product_code,
        'supplier_name'        => $faker->company,
        'factory_number'       => str_random(6),
        'currency'             => $faker->randomElement(['USD', 'NTD', 'GBP', 'ZAR']),
        'factory_price'        => $faker->randomFloat(2, 5.0, 5000.0),
        'additional_cost'      => $faker->randomFloat(2, 1.0, 500.0),
        'exchange_rate'        => $faker->randomFloat(2, 1.0, 50.0),
        'quantity'             => $faker->numberBetween(1, 200),
        'description'          => $product->writeup
    ];
});