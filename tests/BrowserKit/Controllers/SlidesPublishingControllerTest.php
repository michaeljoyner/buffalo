<?php
use App\SiteContent\Slide;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 9/8/16
 * Time: 12:11 PM
 */
class SlidesPublishingControllerTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_slide_can_be_published_by_posting_to_an_endpoint()
    {
        $this->asLoggedInUser();
        $slide = factory(Slide::class)->create();
        $this->assertFalse($slide->is_published);

        $this->post('/admin/slides/' . $slide->id . '/publishing', ['publish' => true])
            ->assertResponseOk()
            ->seeJson(['new_state' => true])
            ->assertTrue(Slide::find($slide->id)->is_published);
    }
}