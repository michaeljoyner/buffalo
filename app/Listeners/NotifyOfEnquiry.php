<?php

namespace App\Listeners;

use App\Events\EnquiryWasMade;
use App\Mail\EnquiryMade;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NotifyOfEnquiry
{

    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EnquiryWasMade  $event
     * @return void
     */
    public function handle(EnquiryWasMade $event)
    {
        Mail::to('sales@buffalo-tools.com')->send(new EnquiryMade($event));
    }
}
