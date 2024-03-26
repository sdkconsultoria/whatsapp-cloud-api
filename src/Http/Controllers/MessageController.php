<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Controllers;

use Illuminate\Http\Request;
use Sdkconsultoria\WhatsappCloudApi\Http\Resources\MessageResource;
use Sdkconsultoria\WhatsappCloudApi\Lib\Message\SendMessage;
use Sdkconsultoria\WhatsappCloudApi\Models\Chat;
use Sdkconsultoria\WhatsappCloudApi\Models\Message;

class MessageController extends APIResourceController
{
    protected $resource = Message::class;

    protected $transformer = MessageResource::class;

    protected $isReverseElements = true;

    protected function defaultOptions($models, Request $request)
    {
        $models->where('type', '!=', 'reaction');
        $models->orderBy('timestamp', 'desc');

        return $models;
    }

    protected function filters(): array
    {
        return [
            'chat_id' => function ($query, $value) {
                return $query->where('chat_id', "$value");
            },
        ];
    }

    public function index(Request $request)
    {
        $models = new $this->resource;
        $models = $this->applyFilters($models, $request);
        $models = $this->defaultOptions($models, $request);
        $models = $models->simplePaginate()->appends(request()->except('page'));

        $chat = Chat::where('id', $request->input('chat_id'))->first();
        $chat->unread_messages = 0;
        $chat->save();

        return $this->transformer::collection($this->reverseElements($models));
    }

    public function sendMessage(Request $request)
    {
        $message = resolve(SendMessage::class)->send($request->all());

        return response()->json($message);
    }
}
