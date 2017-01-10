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

    /**
     *@test
     */
    public function a_post_has_a_title_image_which_is_the_featured_image_if_set()
    {
        $post = factory(Post::class)->create();
        $image = $post->addImage($this->prepareFileUpload('tests/testpic1.png'));
        $post->setFeaturedImage($image);

        $post = Post::find($post->id);

        $titleImg = $post->titleImg('web');
        $this->assertEquals($image->getUrl('web'), $titleImg);

        $post->clearMediaCollection();
    }

    /**
     *@test
     */
    public function a_posts_title_image_will_be_the_first_media_image_if_there_is_no_featured_image()
    {
        $post = factory(Post::class)->create();
        $image = $post->addImage($this->prepareFileUpload('tests/testpic1.png'));

        $post = Post::find($post->id);

        $this->assertNull($post->featuredImage());
        $this->assertEquals($image->getUrl(), $post->titleImg());

        $post->clearMediaCollection();

    }

    /**
     *@test
     */
    public function a_post_with_no_featured_image_and_no_media_images_still_returns_an_image_url()
    {
        $post = factory(Post::class)->create();

        $this->assertNotNull($post->titleImg());
        $this->assertNotEquals("", $post->titleImg());
    }
}