<?php


use App\Blog\Post;
use App\Events\PostFirstPublished;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FirstTimePublishedPostTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function an_event_is_fired_when_a_post_is_fired_for_the_first_time()
    {
        $post = factory(Post::class)->create(['published_at' => null, 'published' => 0]);

        $this->expectsEvents(PostFirstPublished::class);

        $post->setPublishedStatus(true);
    }

    /**
     *@test
     */
    public function an_event_is_not_fired_if_a_previously_published_post_is_republished()
    {
        $post = factory(Post::class)->create(['published_at' => '2015-01-01', 'published' => 0]);

        $this->doesntExpectEvents(PostFirstPublished::class);

        $post->setPublishedStatus(true);
    }

    /**
     *@test
     */
    public function an_event_is_not_fired_when_a_post_is_being_retracted()
    {
        $post = factory(Post::class)->create(['published_at' => '2015-01-01', 'published' => 1]);

        $this->doesntExpectEvents(PostFirstPublished::class);

        $post->setPublishedStatus(false);
    }
}