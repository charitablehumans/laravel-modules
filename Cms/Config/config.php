<?php

return [
    'geocodes' => [
        'code' => true,
        'latitude' => true,
        'longitude' => true,
        'rajaongkir_id' => true,
    ],
    'menus' => [
        'accordion' => [
            'doku_myshortcart_payment_methods' => false,
            'products' => true,
        ],
    ],
    'pages' => [
        'postmetas' => [
            'template_options' => [
                'bank_accounts' => false,
                'cnr_cash' => false,
            ],
        ],
    ],
    'transactions' => [
        'status_options' => [
            'received' => true,
            'finished' => true,
            'returned' => true,
        ],
    ],
    'user_addresses' => true,
    'users' => [
        'store_id' => true,
        'balance' => true,
        'game_token' => true,

        'role_default' => 'member',
    ],
];
