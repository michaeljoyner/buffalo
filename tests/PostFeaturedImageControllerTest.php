<?php


use App\Blog\Post;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PostFeaturedImageControllerTest extends TestCase
{
    use DatabaseMigrations, TestsImageUploads;

    /**
     *@test
     */
    public function a_featured_image_may_be_set_by_posting_to_endpoint()
    {
        $this->asLoggedInUser();
        $post = factory(Post::class)->create();
        $image = $post->addImage($this->prepareFileUpload('tests/testpic1.png'));
        $this->assertNull($post->featuredImage());

        $this->post('/admin/blog/posts/' . $post->id . '/images/featured', ['image_id' => $image->id]);

        $post = Post::find($post->id);
        $this->assertEquals($image->id, $post->featuredImage()->id);

        $post->clearMediaCollection();
    }
}