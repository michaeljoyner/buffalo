<?php
use App\SiteContent\Slide;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 9/5/16
 * Time: 10:38 AM
 */
class SlidesMediaControllerTest extends TestCase
{
    use DatabaseMigrations, TestsImageUploads;

    /**
     *@test
     */
    public function an_image_can_be_posted_for_a_given_slide()
    {
        $slide = factory(Slide::class)->create();
        $this->asLoggedInUser();

        $response = $this->call('POST', '/admin/slides/' . $slide->id . '/media', [], [], [
            'file' => $this->prepareFileUpload('tests/testpic1.png')
        ]);
        $this->assertOkResponse($response);

        $this->assertCount(1, $slide->getMedia());
        $slide->clearMediaCollection();
    }
}