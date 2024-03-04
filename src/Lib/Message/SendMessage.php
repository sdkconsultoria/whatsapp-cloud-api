<?php

namespace Sdkconsultoria\WhatsappCloudApi\Lib\Message;

use Sdkconsultoria\WhatsappCloudApi\Models\Chat;
use Sdkconsultoria\WhatsappCloudApi\Models\Message;
use Sdkconsultoria\WhatsappCloudApi\Models\WabaPhone;
use Sdkconsultoria\WhatsappCloudApi\Services\MessageService;

class SendMessage
{
    public function Send($request)
    {
        $phoneNumber = WabaPhone::find($request['waba_phone_id']);

        $message = resolve(MessageService::class)->sendMessage($phoneNumber->phone_id, $request['to'], $request['message']);

        $messageModel = new Message();
        $messageModel->direction = 'toClient';
        $messageModel->body = json_encode($request['message']);
        $messageModel->timestamp = time();
        $messageModel->message_id = $message['messages'][0]['id'];
        $messageModel->type = 'text';
        $messageModel->chat_id = $this->getChatId($phoneNumber, $request['to']);
        $messageModel->save();
    }

    private function getChatId($phoneNumber, $to)
    {
        $chat = Chat::firstOrCreate([
            'waba_phone' => $phoneNumber->phone_number_clean,
            'waba_phone_id' => $phoneNumber->id,
            'client_phone' => $to,
        ]);

        $chat->last_message = date('Y-m-d H:i:s');
        $chat->save();

        return $chat->id;
    }
}
