<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Controllers;

use Illuminate\Http\Request;
use Sdkconsultoria\WhatsappCloudApi\Models\Chat;

class ChatController extends APIResourceController
{
    protected $resource = Chat::class;

    protected function defaultOptions($models, Request $request)
    {
        $models = $models->orderBy('last_message', 'desc');

        return $models;
    }

    protected function filters(): array
    {
        return [
            'client_phone' => function ($query, $value) {
                return $query->where('client_phone', 'like', "%$value%");
            },
        ];
    }
}
