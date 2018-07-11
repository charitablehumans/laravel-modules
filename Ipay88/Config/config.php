<?php

return [
    'name' => 'Ipay88',

    'ip_address' => env('IPAY88_IP_ADDRESS', 'https://payment.ipay88.co.id'),
    'merchant_code' => env('IPAY88_MERCHANT_CODE'),
    'merchant_key' => env('IPAY88_MERCHANT_KEY'),
    'mode' => env('IPAY88_MODE', 'sandbox'), // production, sandbox
];
