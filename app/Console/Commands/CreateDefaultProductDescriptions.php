<?php

namespace App\Console\Commands;

use App\Products\Product;
use Illuminate\Console\Command;

class CreateDefaultProductDescriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:describe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create descriptions for imported products';

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

        Product::with('category')->get()->each(function($product) use ($default) {
            if((! $product->description) || $product->description === $default) {
                $product->description = $product->name . ' - a Buffalo Tools product in our ' . $product->category->name . ' category';
                $product->save();
            }
        });

        $this->info("Fin.");
    }
}
