<?php


use App\Blog\Post;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PostFeaturedImagesTest extends BrowserKitTestCase
{
    use DatabaseMigrations, TestsImageUploads;

    /**
     *@test
     */
    public function an_image_associated_with_a_post_can_be_set_as_a_featured_image()
    {
        $post = factory(Post::class)->create();
        $image1 = $post->addImage($this->prepareFileUpload('tests/testpic1.png'));

        $post->setFeaturedImage($image1);
        $post = Post::find($post->id);
        $this->assertEquals($image1->id, $post->featuredImage()->id);

        $post->clearMediaCollection();
    }

    /**
     *@test
     */
    public function a_featured_image_not_associated_with_a_model_cant_be_set_as_featured_image()
    {
        $post = factory(Post::class)->create();
        $post2 = factory(Post::class)->create();

        $image = $post->addImage($this->prepareFileUpload('tests/testpic1.png'));

        try {
            $post2->setFeaturedImage($image);

        } catch(Exception $e) {
            $this->assertEquals('Image must belong to post to be set as featured.', $e->getMessage());
            $post->clearMediaCollection();
            return;
        }

        $post->clearMediaCollection();
        $this->fail();

    }
}