<?php

return [
    'name' => 'Doku MyShortcart',

    'cancel_route' => env('DOKU_MYSHORTCART_ROUTE', 'frontend'),
    'ip_address' => env('DOKU_MYSHORTCART_IP_ADDRESS', '103.10.128.14'),
    'payment_confirmation_route' => env('DOKU_MYSHORTCART_PAYMENT_CONFIRMATION_ROUTE', 'frontend.transactions.purchases.payment.confirmation.index'),
    'production' => env('DOKU_MYSHORTCART_PRODUCTION', false),
    'redirect_route' => env('DOKU_MYSHORTCART_REDIRECT_ROUTE', 'frontend.doku-myshortcart.redirect'),
    'SCOUNTRY' => env('DOKU_MYSHORTCART_SCOUNTRY', 360),
    'SHARED_KEY' => env('DOKU_MYSHORTCART_SHARED_KEY'),
    'STORE_ID' => env('DOKU_MYSHORTCART_STORE_ID'),
];
