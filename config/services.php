<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'slack' => [
        'backup_webhook' => env('SLACK_ENDPOINT')
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => env("FACEBOOK_APP_ID"),
        'client_secret' => env("FACEBOOK_APP_SECRET"),
        'redirect' => '/oauth/facebook/callback',
        'page_id' => env('FACEBOOK_PAGE_ID'),
    ],

    'twitter' => [
        'client_id' => env("TWITTER_CONSUMER_KEY"),
        'client_secret' => env("TWITTER_CONSUMER_SECRET"),
        'redirect' => '/oauth/twitter/callback',
    ]

];
