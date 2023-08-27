<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Sdkconsultoria\WhatsappCloudApi\Http\Controllers')->group(function () {
    Route::get('whatsapp-webhook', 'WebhookController@subscribe')->name('meta.webhook.subscribe');
    Route::post('whatsapp-webhook', 'WebhookController@webhook')->name('meta.webhook');
});
