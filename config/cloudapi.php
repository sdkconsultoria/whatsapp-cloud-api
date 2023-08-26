
<?php
return [
    /*
     |--------------------------------------------------------------------------
     | Configuraciones basicas
     |--------------------------------------------------------------------------
     |
     |
     */
    'token' => env('WHATSAPP_TOKEN'),
    'webhook_token' => env('WHATSAPP_WEBHOOK_TOKEN'),
    'api_version' => env('WHATSAPP_API_VERSION', 'v17.0'),
];
