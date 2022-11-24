<?php

return [
    'esia_url' => env('ESIA_URL', 'https://esia-portal1.test.gosuslugi.ru'),
    'client_id' => env('ESIA_CLIENT_ID', ''),
    'redirect_url' => env('ESIA_REDIRECT_URL', ''),
    'signer' => [
        'url' => env('ESIA_SIGNER_URL', ''),
        'client' => env('ESIA_SIGNER_CLIENT', ''),
        'secret' => env('ESIA_SIGNER_SECRET', '')
    ]
];
