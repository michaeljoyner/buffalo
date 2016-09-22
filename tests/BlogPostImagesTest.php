<?php
use App\Blog\Post;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 5/5/16
 * Time: 11:48 AM
 */
class BlogPostImagesTest extends TestCase
{
    use DatabaseMigrations, TestsImageUploads;

    /**
     *@test
     */
    public function an_image_can_be_uploaded_to_a_blog_post()
    {
        $post = factory(Post::class)->create();
        $this->asLoggedInUser();
        \Illuminate\Support\Facades\Session::start();

        $response = $this->call('POST', '/admin/blog/posts/'.$post->id.'/images', ['_token' => csrf_token()], [], [
            'file' => $this->prepareFileUpload('tests/testpic1.png'),
        ]);


        $this->assertEquals(200, $response->status());

        $this->assertCount(1, $post->getImages());

        $post->clearMediaCollection();
    }
}