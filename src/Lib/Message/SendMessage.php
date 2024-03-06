<?php

namespace Sdkconsultoria\WhatsappCloudApi\Lib\Message;

use Illuminate\Support\Facades\Storage;
use Sdkconsultoria\WhatsappCloudApi\Models\Chat;
use Sdkconsultoria\WhatsappCloudApi\Models\Message;
use Sdkconsultoria\WhatsappCloudApi\Models\WabaPhone;
use Sdkconsultoria\WhatsappCloudApi\Services\MediaManagerService;
use Sdkconsultoria\WhatsappCloudApi\Services\MessageService;

class SendMessage
{
    private array $processedMessage = [];

    public function Send(array $request): void
    {
        $messageModel = $this->createNewMessage($request);
        $processedMessage = $this->processMessage($messageModel, $request['message']);
        $messageResponse = resolve(MessageService::class)
            ->sendMessage($messageModel->chat->wabaPhone->phone_id, $request['to'], $processedMessage);
        $this->finishMessage($messageModel, $messageResponse, $processedMessage);
    }

    private function createNewMessage(array $request): Message
    {
        $phoneNumber = WabaPhone::find($request['waba_phone_id']);
        $message = new Message();
        $message->status = Message::STATUS_PENDING;
        $message->direction = 'toClient';
        $message->timestamp = time();
        $message->type = $request['message']['type'];
        $message->chat_id = $this->getChatId($phoneNumber, $request['to'])->id;
        $message->save();

        return $message;
    }

    private function processMessage(Message $message, array $request): array
    {
        $this->processedMessage = $request;

        switch ($request['type']) {
            case 'audio':
            case 'video':
            case 'document':
            case 'image':
                $url = "sended/{$message->chat->id}/$message->id.{$request[$request['type']]->extension()}";
                $request[$request['type']]->storeAs('public', $url);
                $media = resolve(MediaManagerService::class)->upload($message->chat->wabaPhone->phone_id, $request[$request['type']]);
                $request[$request['type']] = ['id' => $media['id']];

                $this->processedMessage[$request['type']] = ['url' => Storage::disk()->url($url)];
                break;
        }

        return $request;
    }

    private function getChatId($phoneNumber, $to): Chat
    {
        $chat = Chat::firstOrCreate([
            'waba_phone' => $phoneNumber->phone_number_clean,
            'waba_phone_id' => $phoneNumber->id,
            'client_phone' => $to,
        ]);
        $chat->last_message = date('Y-m-d H:i:s');
        $chat->save();

        return $chat;
    }

    private function finishMessage(Message $messageModel, array $messageResponse): void
    {
        $messageModel->message_id = $messageResponse['messages'][0]['id'];
        $messageModel->body = json_encode($this->processedMessage);
        $messageModel->save();
    }
}
