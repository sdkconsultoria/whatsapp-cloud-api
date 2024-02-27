<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Controllers;

use Illuminate\Http\Request;
use Sdkconsultoria\WhatsappCloudApi\Http\Resources\MessageResource;
use Sdkconsultoria\WhatsappCloudApi\Models\Chat;
use Sdkconsultoria\WhatsappCloudApi\Models\Message;
use Sdkconsultoria\WhatsappCloudApi\Models\Template;
use Sdkconsultoria\WhatsappCloudApi\Models\WabaPhone;
use Sdkconsultoria\WhatsappCloudApi\Services\MessageService;

class MessageController extends APIResourceController
{
    protected $resource = Message::class;

    protected $transformer = MessageResource::class;

    protected $isReverseElements = true;

    protected function defaultOptions($models, Request $request)
    {
        $models->where('type', 'text');
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

    public function sendMessage(Request $request)
    {
        $request = $request->all();
        $phoneNumber = WabaPhone::where('phone_id', $request['phone_id'])->orWhere('phone_number_clean', $request['phone_id'])->first();

        $message = resolve(MessageService::class)->sendMessage($phoneNumber->phone_id, $request['to'], $request['message']);

        $messageModel = new Message();
        $messageModel->direction = 'toClient';
        $messageModel->body = json_encode($request['message']);
        $messageModel->timestamp = time();
        $messageModel->message_id = $message['messages'][0]['id'];
        $messageModel->type = 'text';
        $messageModel->chat_id = $this->getChatId($phoneNumber, $request['to']);
        $messageModel->save();

        return response()->json($message);
    }

    private function getChatId($phoneNumber, $to)
    {
        $chat = Chat::firstOrCreate([
            'waba_phone' => $phoneNumber->phone_number_clean,
            'client_phone' => $to,
        ]);

        $chat->last_message = date('Y-m-d H:i:s');
        $chat->save();

        return $chat->id;
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

    public function sendTemplate(Request $request)
    {

        $request->validate([
            'waba_phone' => 'required',
            'to' => 'required',
            'template' => 'required',
        ]);

        $template = Template::find($request['template']);
        $phoneNumber = WabaPhone::where('id', $request['waba_phone'])->first();
        $message = resolve(MessageService::class)
            ->sendTemplate($phoneNumber, $request['to'], $template);

        $messageModel = new Message();
        $messageModel->direction = 'toClient';
        $messageModel->body = json_encode($template->getMessage());
        $messageModel->timestamp = time();
        $messageModel->message_id = $message['messages'][0]['id'];
        $messageModel->type = 'text';
        $messageModel->chat_id = $this->getChatId($phoneNumber, $request['to']);
        $messageModel->save();

        return response()->json($message);
    }
}
