<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SiteMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $original;
    public $name;
    public $email;
    public $country;
    public $company;
    public $company_website;
    public $referrer;
    public $enquiry;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fields)
    {
        $this->original = $fields;
        $this->name = $fields['name'];
        $this->email = $fields['email'];
        $this->country = array_get($fields, 'country', 'not provided') ?: "Not Provided";
        $this->company = array_get($fields, 'company', 'not provided') ?: "Not Provided";
        $this->company_website = array_get($fields, 'company_website', 'not provided') ?: "Not Provided";
        $this->referrer = array_get($fields, 'referrer', 'not provided' ?: "Not Provided");
        $this->enquiry = array_get($fields, 'enquiry', 'not provided') ?: "Not Provided";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New webite message from ' . $this->name)
            ->view('email.sitemessage');
    }
}
