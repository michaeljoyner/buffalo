<?php


namespace Tests\Feature\Products;


use App\Products\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AddProductImageUsesRandomNameTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function an_uploaded_images_name_gets_replaced_with_random_name()
    {
        Storage::fake('test_media');

        $product = factory(Product::class)->create();
        $image = $product->setImage(UploadedFile::fake()->image("test_pic.png"));

        $conversions = collect($image->fresh()->getMediaConversionNames());
        $conversions->each(function($con) use ($image) {
            $this->assertStringNotContainsString("test_pic", $image->getUrl($con));
        });
        $this->assertNotEquals("test_pic.png", $image->fresh()->file_name);

    }
}