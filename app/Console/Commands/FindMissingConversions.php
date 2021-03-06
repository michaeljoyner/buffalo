<?php

namespace App\Console\Commands;

use App\Products\Product;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FindMissingConversions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'conversions:find-missing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find media images that cannot be displayed';

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
        $this->info("Checking images using " . config('app.url'));

        $product_images = Media::where('model_type', Product::class)->get();
        $missing = $product_images->filter(function($image) {
            $response_code = 500;
            try {
                $client = new Client(['verify' => false]);
                $url = config('app.url') . $image->getUrl('web');
                $response = $client->get($url);
                $response_code = $response->getStatusCode();
                $s = sprintf("Found (%s): %s", $response->getStatusCode(), $url);
                $this->info($s);
            } catch(\Exception $e) {
                $this->warn(class_basename($e));
            }
            return $response_code !== 200;
        });

        $this->warn("Found {$missing->count()} problematic images.\n\n");

        $missing->each(function($image) {
            $s = sprintf("Media ID: %s Name: %s", $image->id, $image->file_name);
            $this->info($s);
        });
    }
}
