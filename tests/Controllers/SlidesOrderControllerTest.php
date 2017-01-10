<?php


use App\SiteContent\Slide;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SlidesOrderControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function slides_may_be_ordered_by_posting_array_of_ordered_ids()
    {
        factory(Slide::class, 5)->create();
        $this->asLoggedInUser();

        $this->post('/admin/api/slides/order', ['order' => [2,4,3,1,5]])
            ->assertResponseOk();

        $this->assertEquals(1, Slide::find(2)->position);
        $this->assertEquals(2, Slide::find(4)->position);
        $this->assertEquals(3, Slide::find(3)->position);
        $this->assertEquals(4, Slide::find(1)->position);
        $this->assertEquals(5, Slide::find(5)->position);
    }
}