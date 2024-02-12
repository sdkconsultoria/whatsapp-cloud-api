<?php

namespace Sdkconsultoria\WhatsappCloudApi\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public const STATUS_SENDED = 0;
    public $timestamps = false;

    public static function processMessage($messageEvent): void
    {
        if (isset($messageEvent['messages'])){
            $content = $messageEvent['messages'][0];
            $chat = self::findOrCreateChat($content['from'], $messageEvent['metadata']['display_phone_number']);

            $messageModel = new Message();
            $messageModel->chat_id = $chat->id;
            $messageModel->message_id = $content['id'];
            $messageModel->timestamp = $content['timestamp'];
            $messageModel->status = self::STATUS_SENDED;
            $messageModel->type = $content['type'];
            $messageModel->body = json_encode($content);
            $messageModel->save();
        }

        if (isset($messageEvent['statuses'])){

        }
    }

    private static function findOrCreateChat(string $from, string $to): Chat
    {
        return Chat::firstOrCreate([
            'from' => $from,
            'to' => $to,
            'status' => Chat::STATUS_UNREAD,
        ]);
    }
}
