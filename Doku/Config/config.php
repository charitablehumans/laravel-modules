<?php

return [
    'name' => 'Doku',

    'cancel_route' => env('DOKU_CANCEL_ROUTE', 'frontend'),
    'ip_address' => env('DOKU_IP_ADDRESS', '103.10.128.14'),
    'production' => env('DOKU_PRODUCTION', false),
    'redirect_route' => env('DOKU_REDIRECT_ROUTE', 'frontend.doku.redirect'),
    'SCOUNTRY' => env('DOKU_SCOUNTRY', 360),
    'SHARED_KEY' => env('DOKU_SHARED_KEY'),
    'STORE_ID' => env('DOKU_STORE_ID'),
];
