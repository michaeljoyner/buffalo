<?php

namespace App\Mail;

use App\Events\EnquiryWasMade;
use App\Orders\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnquiryMade extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Order
     */
    public $order;

    public $items;

    /**
     * Create a new message instance.
     *
     * @param EnquiryWasMade $event
     * @internal param Order $order
     */
    public function __construct(EnquiryWasMade $event)
    {
        $this->order = $event->order;
        $this->items = $event->order->items;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Site Enquiry from ' + $this->order->company)
            ->view('email.enquiry');
    }
}
