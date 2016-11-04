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
        'category_id'      => function () {
            return factory(\App\Products\Category::class)->create()->id;
        },
        'subcategory_id'   => function () {
            return factory(\App\Products\Subcategory::class)->create()->id;
        },
        'product_group_id' => function () {
            return factory(\App\Products\ProductGroup::class)->create()->id;
        },
        'product_code'     => \Illuminate\Support\Str::random(7),
        'name'             => $faker->words(4, true),
        'description'      => $faker->paragraph,
        'writeup'          => $faker->paragraph,
        'available'        => 1,
        'is_promoted'      => 0,
        'marked_new'       => 0
    ];
});

$factory->define(App\Products\Category::class, function (Faker\Generator $faker) {
    return [
        'name'        => $faker->words(4, true),
        'description' => $faker->paragraph,
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

