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

    Route::get('waba/{wabaId}/init', 'WabaController@init')->name('waba.init');
    Route::get('waba/{wabaId}/get-templates', 'WabaController@loadTemplatesFromWaba')->name('waba.getTemplatesFromMeta');
    Route::get('waba/{wabaId}/get-info', 'WabaController@getWabaInfoFromMeta')->name('waba.getInfoFromMeta');
    Route::get('waba/{wabaId}/get-phones', 'WabaController@getWabaPhonesFromMeta')->name('waba.getPhonesFromMeta');

    Route::get('template', 'TemplateController@index')->name('template.index');
    Route::post('template', 'TemplateController@storage')->name('template.storage');
    Route::put('template/{id}', 'TemplateController@edit')->name('template.edit');
    Route::delete('template/{id}', 'TemplateController@delete')->name('template.delete');

    Route::post('message/send', 'MessageController@sendMessage')->name('message.send');
    Route::post('message/template/send', 'MessageController@sendTemplate')->name('message.template.send');
    Route::get('message', 'MessageController@index')->name('message.index');

    Route::get('waba-phone', 'WabaPhoneController@index')->name('waba.waba_number');

    Route::get('chat', 'ChatController@index')->name('chat.index');

    Route::post('campaign', 'CampaignController@store')->name('campaign.store');
});
