<?php

namespace App\Listeners;

use App\Events\PostFirstPublished;
use App\Social\Facebook;
use App\Social\FacebookUser;
use App\Social\GooglePlus;
use App\Social\Twitter;
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
    public function __construct(Facebook $facebook, Twitter $twitter, GooglePlus $googlePlus)
    {
        $this->facebook = $facebook;
        $this->twitter = $twitter;
        $this->googlePlus = $googlePlus;
    }

    /**
     * Handle the event.
     *
     * @param  PostFirstPublished  $event
     * @return void
     */
    public function handle(PostFirstPublished $event)
    {
        $this->facebook->sharePost($event->post);
        $this->twitter->sharePost($event->post);
        $this->googlePlus->sharePost($event->post);
    }
}
