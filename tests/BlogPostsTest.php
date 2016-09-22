<?php
use App\Blog\Post;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Session;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 5/5/16
 * Time: 11:19 AM
 */
class BlogPostsTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * @test
     */
    public function a_blog_post_can_be_created()
    {
        $this->asLoggedInUser();

        $this->visit('/admin/blog/posts/create')
            ->submitForm('Save', [
                'title'       => 'My Test Post',
                'description' => 'Just a test',
                'body'        => 'Once upon a time.'
            ])->seeInDatabase('posts', [
                'title'       => 'My Test Post',
                'description' => 'Just a test',
                'body'        => 'Once upon a time.'
            ]);
    }

    /**
     * @test
     */
    public function a_blog_post_can_be_edited()
    {
        $post = factory(Post::class)->create();
        $this->asLoggedInUser();

        $this->visit('/admin/blog/posts/' . $post->id . '/edit')
            ->type('a new description', 'description')
            ->type('a revitalised body', 'body')
            ->press('Save')
            ->seeInDatabase('posts', [
                'id'          => $post->id,
                'title'       => $post->title,
                'description' => 'a new description',
                'body'        => 'a revitalised body'
            ]);
    }

    /**
     * @test
     */
    public function a_blog_post_can_be_published_via_posting_to_endpoint()
    {
        $post = factory(Post::class)->create();
        $this->asLoggedInUser();
        $this->assertFalse(!! $post->published);

        Session::start();
        $response = $this->call('POST', '/admin/blog/posts/' . $post->id . '/publish', [
            'publish' => true,
            '_token' => csrf_token()
        ]);

        $this->assertEquals(200, $response->status());

        $this->seeInDatabase('posts', [
            'id'        => $post->id,
            'published' => 1
        ]);
    }

    /**
     *@test
     */
    public function a_blog_post_can_be_deleted()
    {
        $post = factory(Post::class)->create();
        $this->asLoggedInUser();

        Session::start();
        $response = $this->call('DELETE', '/admin/blog/posts/'.$post->id, ['_token' => csrf_token()]);
        $this->assertEquals(302, $response->status());

        $this->notSeeInDatabase('posts', [
            'id' => $post->id
        ]);
    }
}