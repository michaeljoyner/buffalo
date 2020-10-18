<?php
use App\SiteContent\Slide;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 9/5/16
 * Time: 9:23 AM
 */
class SlidesTest extends BrowserKitTestCase
{
    use DatabaseMigrations, TestsImageUploads;

    /**
     * @test
     */
    public function a_slide_can_be_created_and_persisted()
    {
        factory(Slide::class)->create([
            'slide_text'  => 'We do communications',
            'action_link' => '/contact',
            'action_text' => 'Contact us now'
        ]);

        $this->seeInDatabase('slides', [
            'slide_text'  => 'We do communications',
            'action_link' => '/contact',
            'is_video'    => 0,
            'video'       => null,
            'position'    => null
        ]);
    }

    /**
     * @test
     */
    public function an_image_can_be_associated_with_a_slide()
    {
        $slide = factory(Slide::class)->create();

        $slide->setImage($this->prepareFileUpload('tests/testpic1.png'));
        $this->assertCount(1, $slide->getMedia());

        $slide->clearMediaCollection();
    }

    /**
     *@test
     */
    public function a_video_can_be_associated_with_a_slide()
    {
        $slide = factory(Slide::class)->create();
        $slide->setVideo($this->prepareFileUpload('tests/video.mp4'));

        $this->assertFileExists(public_path('videos/'.$slide->video));
        $this->assertTrue($slide->is_video);
    }

    /**
     *@test
     */
    public function adding_a_video_will_remove_any_previous_videos()
    {
        $slide = factory(Slide::class)->create();
        $original_path = $slide->setVideo($this->prepareFileUpload('tests/video.mp4'));

        $slide->setVideo($this->prepareFileUpload('tests/video2.mp4'));
        $this->assertFileExists(public_path('videos/'.$slide->video));

        $this->assertFileDoesNotExist(public_path('videos/' . $original_path));
    }

    /**
     *@test
     */
    public function a_slide_with_neither_image_nor_video_is_considered_incomplete()
    {
        $slide = factory(Slide::class)->create();

        $this->assertCount(0, $slide->getMedia());
        $this->assertFalse($slide->is_video);

        $this->assertFalse($slide->isComplete());
    }

    /**
     *@test
     */
    public function a_slide_can_be_published_or_unpublished()
    {
        $slide = factory(Slide::class)->create();
        $this->assertFalse($slide->is_published);

        $slide->publish();
        $this->assertTrue($slide->is_published);

        $slide->unpublish();
        $this->assertFalse($slide->is_published);
    }

    /**
     *@test
     */
    public function a_default_slide_can_be_created()
    {
        $slide = Slide::createDefault();

        $this->seeInDatabase('slides', ['id' => $slide->id]);
        $this->assertEquals(Slide::DEFAULT_SLIDE_TEXT, $slide->slide_text);
    }

    /**
     *@test
     */
    public function deleting_a_video_slide_will_automatically_delete_its_accompanying_video()
    {
        $slide = factory(Slide::class)->create();
        $path = $slide->setVideo($this->prepareFileUpload('tests/video.mp4'));
        $this->assertFileExists(public_path('videos/' . $path));

        $slide->delete();

        $this->assertFileDoesNotExist(public_path('videos/' . $path));
    }

    /**
     *@test
     */
    public function the_slides_can_be_ordered_by_passing_ordered_array_of_ids()
    {
        factory(Slide::class, 5)->create();

        Slide::setOrder([2,4,3,1,5]);

        $this->assertEquals(1, Slide::find(2)->position);
        $this->assertEquals(2, Slide::find(4)->position);
        $this->assertEquals(3, Slide::find(3)->position);
        $this->assertEquals(4, Slide::find(1)->position);
        $this->assertEquals(5, Slide::find(5)->position);
    }

    /**
     *@test
     */
    public function slides_not_included_in_the_ordering_array_will_have_their_position_reset_to_null()
    {
        factory(Slide::class, 5)->create(['position' => 3]);

        Slide::setOrder([2,4,3,5]);

        $this->assertNull(Slide::find(1)->position);
    }
}