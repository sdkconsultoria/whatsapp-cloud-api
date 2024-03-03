<?php

namespace Sdkconsultoria\WhatsappCloudApi\Models;

use Illuminate\Database\Eloquent\Model;
use Sdkconsultoria\WhatsappCloudApi\Events\NewWhatsappMessageHook;
use Sdkconsultoria\WhatsappCloudApi\Services\MediaManagerService;

class Message extends Model
{
    public const STATUS_SENDED = 0;

    public $timestamps = false;

    public static function processMessage($messageEvent): void
    {
        if (isset($messageEvent['messages'])) {
            self::processConversation($messageEvent);
        }

        if (isset($messageEvent['statuses'])) {
        }
    }

    private static function processConversation(array $messageEvent)
    {
        $phoneNumberId = $messageEvent['metadata']['phone_number_id'];

        $content = $messageEvent['messages'][0];
        $chat = Chat::findOrCreateChat($content['from'], $messageEvent['metadata']['display_phone_number']);

        switch ($content['type']) {
            case 'text':
                self::processTextMessage($chat, $content);
                break;
            case 'audio':
                break;
            case 'sticker':
                break;
            case 'image':
            case 'video':
                $content[$content['type']]['url'] = self::saveFile($content[$content['type']], $phoneNumberId, $chat);
                self::processTextMessage($chat, $content);
                break;
            case 'reaction':
                break;
        }

        NewWhatsappMessageHook::dispatch(['chat_id' => $chat->id]);
    }

    private static function processTextMessage(Chat $chat, array $content): void
    {
        $messageModel = new Message();
        $messageModel->chat_id = $chat->id;
        $messageModel->message_id = $content['id'];
        $messageModel->timestamp = $content['timestamp'];
        $messageModel->status = self::STATUS_SENDED;
        $messageModel->type = $content['type'];
        $messageModel->body = json_encode($content);
        $messageModel->direction = 'toApp';
        $messageModel->save();
    }

    private static function saveFile(array $file, string $phoneNumberId, Chat $chat): string
    {
        $service = resolve(MediaManagerService::class);

        return $service->download($file['id'], $phoneNumberId, "$chat->id/{$file['id']}", 'public');
    }
}
