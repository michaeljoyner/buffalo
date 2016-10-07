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
        \Illuminate\Support\Facades\DB::unprepared(file_get_contents(base_path('finalthree.sql')));

        \App\Products\Product::all()->each(function ($product) {
            $product->available = true;
            $product->save();
        });
//
        $ss = new \Cviebrock\EloquentSluggable\Services\SlugService();

        \App\Products\Subcategory::all()->each(function($subcat) use ($ss) {
            $ss->slug($subcat);
            $subcat->save();
        });

        \App\Products\ProductGroup::all()->each(function($pg) use ($ss) {
            $ss->slug($pg);
            $pg->save();
        });
    }
}
