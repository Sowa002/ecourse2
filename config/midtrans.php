<?php

return [
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'sandbox_base_url' => env('MIDTRANS_SANDBOX_BASE_URL'),
    'production_base_url' => env('MIDTRANS_PRODUCTION_BASE_URL'),
];
