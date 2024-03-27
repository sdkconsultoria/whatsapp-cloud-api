<?php

namespace Sdkconsultoria\WhatsappCloudApi\Lib\Message;

use Sdkconsultoria\WhatsappCloudApi\Events\NewWhatsappMessageHook;
use Sdkconsultoria\WhatsappCloudApi\Models\Chat;
use Sdkconsultoria\WhatsappCloudApi\Models\Message;
use Sdkconsultoria\WhatsappCloudApi\Models\WabaPhone;
use Sdkconsultoria\WhatsappCloudApi\Services\MediaManagerService;

class ReceivedMessage
{
    public function process(array $messageEvent)
    {
        $phoneNumberId = $messageEvent['metadata']['phone_number_id'];
        $wabaPhoneNumber = WabaPhone::where('phone_id', $phoneNumberId)->first();

        $content = $messageEvent['messages'][0];
        $chat = Chat::findOrCreateChat($content['from'], $wabaPhoneNumber);

        switch ($content['type']) {
            case 'contacts':
            case 'text':
                $this->processIfIsResponse($content);
                $this->processTextMessage($chat, $content);
                break;
            case 'document':
            case 'sticker':
            case 'video':
            case 'audio':
            case 'image':
                $this->processIfIsResponse($content);
                $content[$content['type']]['url'] = $this->saveFile($content[$content['type']], $phoneNumberId, $chat);
                $this->processTextMessage($chat, $content);
                break;
            case 'reaction':
                Message::where('message_id', $content['reaction']['message_id'])
                    ->update(['reaction' => $content['reaction']['emoji']]);
                break;
        }

        NewWhatsappMessageHook::dispatch(['chat_id' => $chat->id]);
    }

    private function processIfIsResponse(array &$content): void
    {
        if (isset($content['context']) && isset($content['context']['id'])) {
            $message = Message::where('message_id', $content['context']['id'])->firstOrFail();
            $content['context']['message'] = $message->body;
        }
    }

    private function processTextMessage(Chat $chat, array $content): void
    {
        $messageModel = new Message();
        $messageModel->chat_id = $chat->id;
        $messageModel->message_id = $content['id'];
        $messageModel->timestamp = $content['timestamp'];
        $messageModel->status = Message::STATUS_DELIVERED;
        $messageModel->type = $content['type'];
        $messageModel->body = json_encode($content);
        $messageModel->direction = 'toApp';
        $messageModel->save();
    }

    private function saveFile(array $file, string $phoneNumberId, Chat $chat): string
    {
        $service = resolve(MediaManagerService::class);

        return $service->download($file['id'], $phoneNumberId, "received/$chat->id/{$file['id']}", 'public');
    }
}
