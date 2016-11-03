<?php

namespace App\Console\Commands;

use App\Products\Product;
use Illuminate\Console\Command;

class ConvertExistingProductImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'buffalo:images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert original images into model images';

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
        $this->info('It begins');

        Product::all()->each(function($product) {
            if(! $product->hasModelImageSet()) {
                $product->setImage(public_path($product->getOriginalImage()));
            }
        });

        $this->info('All done :)');
    }
}
