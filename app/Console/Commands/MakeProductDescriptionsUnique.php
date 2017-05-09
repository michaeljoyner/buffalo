<?php

namespace App\Console\Commands;

use App\Products\Product;
use Illuminate\Console\Command;

class MakeProductDescriptionsUnique extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:describe_unique';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds product code to default description to make each unique';

    /**
     * Create a new command instance.
     *
     * @return void
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
        Product::with('category')->get()->each(function($product) {
            if(str_contains($product->description, $product->name) && ! str_contains($product->description, $product->product_code)) {
                $product->description = str_replace($product->name, $product->name . ' (' . $product->product_code . ')', $product->description);
                $product->save();
            }
        });

        $this->info("Fin.");
    }
}
