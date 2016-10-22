<?php

namespace App\Console\Commands;

use App\Products\Category;
use App\Products\ProductGroup;
use App\Products\Subcategory;
use Illuminate\Console\Command;

class CreateDefaultCategoryDescriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'categories:describe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $default = 'This item has no description yet. This is important for SEO, please add a description as soon as possible.';

        Category::all()->each(function($category) use ($default) {
            if((! $category->description) || $category->description === $default) {
                $category->description = 'A collection of Buffalo Tools\' products in our ' . $category->name . ' category';
                $category->save();
            }
        });

        Subcategory::with('category')->get()->each(function($subcategory) use ($default) {
            if((! $subcategory->description) || $subcategory->description === $default) {
                $subcategory->description = $subcategory->name . ' is a subcategory of Buffalo Tools\' products in our ' . $subcategory->category->name . ' category';
                $subcategory->save();
            }
        });

        ProductGroup::with('subcategory')->get()->each(function($productgroup) use ($default) {
            if((! $productgroup->description) || $productgroup->description === $default) {
                $productgroup->description = $productgroup->name . ' is a group of Buffalo Tools\' products in our ' . $productgroup->subcategory->name . ' category of our ' . $productgroup->subcategory->category->name . ' products';
                $productgroup->save();
            }
        });

        $this->info("Fin.");
    }
}
