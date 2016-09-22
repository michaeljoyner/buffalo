<?php

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::unprepared(file_get_contents(base_path('allgoodproducts.sql')));

        \App\Products\Product::all()->each(function ($product) {
            $product->writeup = $product->description;
            $product->description = '';
            $product->save();
        });
    }
}
