
<?php
return [
    /*
     |--------------------------------------------------------------------------
     | Configuraciones basicas
     |--------------------------------------------------------------------------
     |
     |
     */
    'api_version' => env('WHATSAPP_CLOUD_API_VERSION', 'v13.0'),
    'token' => env('WHATSAPP_CLOUD_API_TOKEN'),
    'phone_number_id' => env('WHATSAPP_CLOUD_API_PHONE_NUMBER_ID'),
    'verification_token' => env('WHATSAPP_CLOUD_API_VERIFICATION_TOKEN'),
];
