<?php

namespace App\Listeners;

use App\AccessToken;
use App\Events\PostFirstPublished;
use App\Social\Facebook;
use App\Social\FacebookUser;
use App\Social\GooglePlus;
use App\Social\Twitter;
use App\SocialSharingSetting;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SharePost
{
    /**
     * @var LaravelFacebookSdk
     */
    private $facebook;
    /**
     * @var Twitter
     */
    private $twitter;
    /**
     * @var GooglePlus
     */
    private $googlePlus;

    /**
     * Create the event listener.
     *
     * @param Facebook $facebook
     * @param Twitter $twitter
     * @param GooglePlus $googlePlus
     * @internal param LaravelFacebookSdk $facebookSdk
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  PostFirstPublished  $event
     * @return void
     */
    public function handle(PostFirstPublished $event)
    {
        if(SocialSharingSetting::shareToFacebook()) {
            $fb = new Facebook(AccessToken::forFacebook());
            $fb->postArticle($event->post);
        }

        if(SocialSharingSetting::shareToTwitter()) {
            $tw = new Twitter(AccessToken::forTwitter());
            $tw->postTweet($event->post);
        }

    }
}
