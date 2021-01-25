<?php
/**
 * PayPal Setting & API Credentials
 */

return [
    'mode' => env('PAYPAL_API_MODE', 'sandbox'), // default sandbox, if empty or invalid, 'live_client_id' will be used
    'sandbox_client_id' => env('PAYPAL_SANDBOX_API_CLIENT_ID', null),
    'sandbox_client_secret' => env('PAYPAL_SANDBOX_API_CLIENT_SECRET', null),
    'live_client_id' => env('PAYPAL_LIVE_API_CLIENT_ID', null),
    'live_client_secret' => env('PAYPAL_LIVE_API_CLIENT_SECRET', null),
];
