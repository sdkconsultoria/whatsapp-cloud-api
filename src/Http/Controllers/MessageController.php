<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Controllers;

use Illuminate\Http\Request;
use Sdkconsultoria\WhatsappCloudApi\Models\Chat;
use Sdkconsultoria\WhatsappCloudApi\Models\Message;
use Sdkconsultoria\WhatsappCloudApi\Models\WabaPhone;
use Sdkconsultoria\WhatsappCloudApi\Services\MessageService;

class MessageController extends APIResourceController
{
    protected $resource = Message::class;

    public function sendMessage(Request $request)
    {
        $request = $request->all();

        $message = resolve(MessageService::class)->sendMessage($request['phone_id'], $request['to'], $request['message']);

        $messageModel = new Message();
        $messageModel->direction = 'toClient';
        $messageModel->body = json_encode($message);
        $messageModel->timestamp = time();
        $messageModel->message_id = $message['messages'][0]['id'];
        $messageModel->type = 'text';
        $messageModel->chat_id = $this->getChatId($request['phone_id'], $request['to']);
        $messageModel->save();

        return response()->json($message);
    }

    private function getChatId($phoneId, $to)
    {
        $phoneNumber = WabaPhone::where('phone_id', $phoneId)->first();

        return Chat::firstOrCreate([
            'waba_phone' => $phoneNumber->display_phone_number,
            'client_phone' => $to,
        ])->id;
    }
}
