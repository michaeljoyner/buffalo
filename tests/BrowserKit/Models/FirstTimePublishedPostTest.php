<?php


use App\Blog\Post;
use App\Events\PostFirstPublished;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;

class FirstTimePublishedPostTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function an_event_is_fired_when_a_post_is_published_for_the_first_time()
    {
        Event::fake();

        $post = factory(Post::class)->create(['published_at' => null, 'published' => false, 'slug' => 'slug']);
        $post->setPublishedStatus(true);

        Event::assertDispatched(PostFirstPublished::class, function($event) use ($post) {
            return $event->post->id === $post->id;
        });
    }

    /**
     *@test
     */
    public function an_event_is_not_fired_if_a_previously_published_post_is_republished()
    {
        Event::fake();

        $post = factory(Post::class)->create(['published_at' => '2015-01-01', 'published' => 0, 'slug' => 'slug']);
        $post->setPublishedStatus(true);

        Event::assertNotDispatched(PostFirstPublished::class);
    }

    /**
     *@test
     */
    public function an_event_is_not_fired_when_a_post_is_being_retracted()
    {
        Event::fake();

        $post = factory(Post::class)->create(['published_at' => '2015-01-01', 'published' => 1, 'slug' => 'slug']);
        $post->setPublishedStatus(false);

        Event::assertNotDispatched(PostFirstPublished::class);
    }
}