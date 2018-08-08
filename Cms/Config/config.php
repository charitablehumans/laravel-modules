<?php

return [
    'cache' => true,
    'currency' => [
        'symbol' => [
            'left' => [
                'default' => 'Rp',
            ]
        ],
    ],
    'database' => [
        'eloquent' => [
            'model' => [
                'per_page' => env('CMS_DATABASE_ELOQUENT_MODEL_PER_PAGE', 10),
            ],
        ],
    ],
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
            'product_categories' => false,
            'product_testimonials' => false,
        ],
    ],
    'pages' => [
        'postmetas' => [
            'template_options' => [
                'bank_accounts' => false,
                'cnr_cash' => false,
                'home' => false,
                'new_arrival' => false,
            ],
        ],
    ],
    'posts' => [
        'postmetas' => [
            'template_options' => [
                'example' => false,
            ],
        ],
    ],
    'products' => [
        'postmetas' => [
            'template' => ['default' => 'default'],
            'template_options' => [
                'foreverjewelry' => false,
            ],
        ],
        'product_testimonials' => [
            'rating_average' => false,
        ],

        'frontend' => [
            'limit_options' => [
                '12' => '12',
                '24' => '24',
                '36' => '36',
            ],
        ],
    ],
    'theme' => [
        'frontend' => 'default',
    ],
    'transactions' => [
        'sender_id' => true,
        'sender' => [
            'store_id' => true,
        ],
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
        'usermetas' => [
            'job' => false,
        ],
        'user_socialites' => true,
    ],
];
