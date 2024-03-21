
<?php
return [
    /*
     |--------------------------------------------------------------------------
     | Configuraciones basicas
     |--------------------------------------------------------------------------
     |
     |
     */
    'token' => env('META_TOKEN'),
    'webhook_token' => env('META_WEBHOOK_TOKEN'),
    'webhook_redirect' => env('META_WEBHOOK_REDIRECT'),
    'api_version' => env('WHATSAPP_API_VERSION', 'v19.0'),
    'app_id' => env('META_APP_ID'),
    'app_secret' => env('META_APP_SECRET'),
    'webhook_verify_signature' => env('META_WEBHOOK_VERIFY_SIGNATURE', false),
];
