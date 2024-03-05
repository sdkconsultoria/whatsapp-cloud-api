<?php

namespace Sdkconsultoria\WhatsappCloudApi\Lib\Message;

use Sdkconsultoria\WhatsappCloudApi\Models\Chat;
use Sdkconsultoria\WhatsappCloudApi\Models\Message;
use Sdkconsultoria\WhatsappCloudApi\Models\WabaPhone;
use Sdkconsultoria\WhatsappCloudApi\Services\MediaManagerService;
use Sdkconsultoria\WhatsappCloudApi\Services\MessageService;

class SendMessage
{
    public function Send(array $request): void
    {
        $phoneNumber = WabaPhone::find($request['waba_phone_id']);
        $processedMessage = $this->processMessage($phoneNumber, $request['message']);
        $message = resolve(MessageService::class)
            ->sendMessage($phoneNumber->phone_id, $request['to'], $processedMessage);

        $messageModel = new Message();
        $messageModel->direction = 'toClient';
        $messageModel->body = json_encode($request['message']);
        $messageModel->timestamp = time();
        $messageModel->message_id = $message['messages'][0]['id'];
        $messageModel->type = $request['message']['type'];
        $messageModel->chat_id = $this->getChatId($phoneNumber, $request['to']);
        $messageModel->save();
    }

    private function processMessage(WabaPhone $phoneNumber, array $request): array
    {
        switch ($request['type']) {
            case 'text':
                return $request;
                break;
            case 'audio':
            case 'video':
            case 'document':
            case 'image':
                $media = resolve(MediaManagerService::class)->upload($phoneNumber->phone_id, $request[$request['type']]);
                $request[$request['type']] = ['id' => $media['id']];

                return $request;
                break;
        }
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
