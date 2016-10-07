<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SiteMessage extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
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
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New website message from ' . $this->name)
            ->line('A new message has been received from the website')
            ->line('From: ' . $this->name)
            ->line('Email: ' . $this->email)
            ->line('Company: ' . $this->company)
            ->line('Company website: ' . $this->company_website)
            ->line('Country: ' . $this->country)
            ->line('How they found us: ' . $this->referrer)
            ->line('Message:')
            ->line($this->enquiry)
            ->action('View on website', 'https://laravel.com');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
