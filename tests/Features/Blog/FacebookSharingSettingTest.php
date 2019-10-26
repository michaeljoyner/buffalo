<?php


namespace Tests\Feature\Blog;


use App\SocialSharingSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FacebookSharingSettingTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     *@test
     */
    public function set_facebook_sharing_to_on()
    {
        $this->withoutExceptionHandling();
        $this->asLoggedInUser();

        $response = $this->postJson("/admin/social-sharing/facebook");
        $response->assertStatus(200);

        $this->assertTrue(SocialSharingSetting::shareToFacebook());
    }

    /**
     *@test
     */
    public function set_facebook_sharing_to_off()
    {
        $this->withoutExceptionHandling();
        $this->asLoggedInUser();
        SocialSharingSetting::facebookOn();
        sleep(1);

        $response = $this->deleteJson("/admin/social-sharing/facebook");
        $response->assertStatus(200);

        $this->assertFalse(SocialSharingSetting::shareToFacebook());
    }
}