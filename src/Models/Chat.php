<?php

namespace Sdkconsultoria\WhatsappCloudApi\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['waba_phone', 'client_phone', 'status'];

    public const STATUS_UNREAD = 0;

    public static function findOrCreateChat(string $from, string $to): Chat
    {
        $chat = Chat::firstOrCreate([
            'waba_phone' => $to,
            'client_phone' => $from,
        ]);

        $chat->unread_messages += 1;
        $chat->last_message = date('Y-m-d H:i:s');
        $chat->status = Chat::STATUS_UNREAD;
        $chat->save();

        return $chat;
    }
}
