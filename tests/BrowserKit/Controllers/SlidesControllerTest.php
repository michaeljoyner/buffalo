<?php
use App\SiteContent\Slide;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 9/5/16
 * Time: 10:03 AM
 */
class SlidesControllerTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_slide_may_be_updated_by_posting_to_an_api_endpoint()
    {
        $slide = factory(Slide::class)->create();
        $this->asLoggedInUser();

        $this->post('/admin/api/slides/' . $slide->id, [
            'slide_text'  => 'A brand new day in Tools',
            'action_text' => 'Do it',
            'action_link' => '/products',
            'text_colour' => 'white'
        ])
            ->assertResponseOk()
            ->seeJson([
                'id'           => $slide->id,
                'slide_text'   => 'A brand new day in Tools',
                'action_text'  => 'Do it',
                'action_link'  => '/products',
                'is_video'     => false,
                'video'        => null,
                'is_published' => false
            ])->seeInDatabase('slides', [
                'id'          => $slide->id,
                'slide_text'  => 'A brand new day in Tools',
                'action_text' => 'Do it',
                'action_link' => '/products'
            ]);
    }

    /**
     *@test
     */
    public function a_request_to_create_a_slide_creates_default_slide_and_returns_edit_view()
    {
        $this->asLoggedInUser();
        $this->assertCount(0, Slide::all());

        $this->visit('/admin/slides/create')
            ->seeInDatabase('slides', ['slide_text' => Slide::DEFAULT_SLIDE_TEXT])
            ->seePageIs('/admin/slides/1/edit');
    }

    /**
     *@test
     */
    public function a_slide_can_be_deleted()
    {
        $this->asLoggedInUser();
        $slide = factory(Slide::class)->create();

        $this->delete('/admin/slides/' . $slide->id)
            ->assertRedirectedTo('/admin/slides')
            ->notSeeInDatabase('slides', [
                'id' => $slide->id
            ]);
    }
}