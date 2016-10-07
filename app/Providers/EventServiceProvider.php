<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\EnquiryWasMade' => [
            'App\Listeners\NotifyOfEnquiry',
        ],
        'App\Events\PostFirstPublished' => [
            'App\Listeners\SharePost'
        ]
    ];

    /**
     * Register any other events for your application.
     *
     * @internal param DispatcherContract $events
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
