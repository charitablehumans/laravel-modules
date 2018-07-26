<?php

return [
    'name' => 'Ravintola',
    'SECRET_KEY' => env('RAVINTOLA_SECRET_KEY'),
    'value' => [
        'enabled' => env('RAVINTOLA_VALUE_ENABLED', true),
    ],
];
