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

    Route::get('waba/{wabaId}/loadtemplates', 'WabaController@loadTemplatesFromWaba')->name('waba.loadtemplates');
    Route::get('waba/{wabaId}/getinfo', 'WabaController@getWabaInfoFromMeta')->name('waba.getWabaInfoFromMeta');
    Route::get('waba/{wabaId}/phonenumbers', 'WabaController@getWabaPhonesFromMeta')->name('waba.getWabaPhonesFromMeta');

    Route::get('template', 'TemplateController@index')->name('template.index');
    Route::post('template', 'TemplateController@storage')->name('template.storage');
    Route::put('template/{id}', 'TemplateController@edit')->name('template.edit');
    Route::delete('template/{id}', 'TemplateController@delete')->name('template.delete');

    Route::post('message/send', 'MessageController@sendMessage')->name('message.send');
    Route::get('message', 'MessageController@index')->name('message.index');

    Route::get('get-conversations', 'ConversationController@index')->name('conversation.index');
});
