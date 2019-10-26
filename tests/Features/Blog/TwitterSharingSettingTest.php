<?php


namespace Tests\Feature\Blog;


use App\SocialSharingSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TwitterSharingSettingTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function set_twitter_sharing_to_on()
    {
        $this->withoutExceptionHandling();
        $this->asLoggedInUser();

        $response = $this->postJson("/admin/social-sharing/twitter");
        $response->assertStatus(200);

        $this->assertTrue(SocialSharingSetting::shareToTwitter());
    }

    /**
     *@test
     */
    public function set_twitter_sharing_to_off()
    {
        $this->withoutExceptionHandling();
        $this->asLoggedInUser();
        SocialSharingSetting::twitterOn();
        sleep(1);

        $response = $this->deleteJson("/admin/social-sharing/twitter");
        $response->assertStatus(200);

        $this->assertFalse(SocialSharingSetting::shareToTwitter());
    }
}