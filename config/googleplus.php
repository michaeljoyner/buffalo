<?php

return [
    'web' => [
        'client_id'                   => env("GOOGLE_PLUS_CLIENT_ID"),
        'project_id'                  => 'statsdash-1192',
        'auth_uri'                    => 'https://accounts.google.com/o/oauth2/auth',
        'token_uri'                   => 'https://accounts.google.com/o/oauth2/token',
        'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
        'client_secret'               => env("GOOGLE_PLUS_CLIENT_SECRET"),
        'redirect_uris'               => [
            'http:buffalo.app/admin/googleplus/callback'
        ],
        'javascript_origins'          => [
            'http://buffalo-tools.com'
        ]
    ]
];