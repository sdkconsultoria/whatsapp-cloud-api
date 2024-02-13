
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
    'api_version' => env('WHATSAPP_API_VERSION', 'v19.0'),
    'app_id' => env('META_APP_ID'),
];
