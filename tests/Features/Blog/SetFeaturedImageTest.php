<?php

namespace Tests\Feature\Blog;

use App\Blog\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class SetFeaturedImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_featured_image_can_be_set_for_a_blog_post()
    {
        $this->withoutExceptionHandling();

        $post = factory(Post::class)->create();
        $image = $post->addImage(UploadedFile::fake()->image('testpic.png'));
        $this->assertNull($post->featuredImage());

        $this->asLoggedInUser();
        $response = $this->post("/admin/blog/posts/{$post->id}/images/featured", ['image_id' => $image->id]);
        $response->assertStatus(302);

        $this->assertEquals($image->id, $post->fresh()->featuredImage()->id);

        $post->clearMediaCollection();
    }
}