<?php

namespace Sdkconsultoria\WhatsappCloudApi\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['waba_phone', 'client_phone', 'status', 'waba_phone_id'];

    public const STATUS_UNREAD = 0;

    public static function findOrCreateChat(string $from, WabaPhone $wabaPhoneNumber): Chat
    {
        $chat = Chat::firstOrCreate([
            'waba_phone_id' => $wabaPhoneNumber->id,
            'waba_phone' => $wabaPhoneNumber->phone_number_clean,
            'client_phone' => $from,
        ]);

        $chat->unread_messages += 1;
        $chat->last_message = date('Y-m-d H:i:s');
        $chat->status = Chat::STATUS_UNREAD;
        $chat->save();

        return $chat;
    }

    public function wabaPhone()
    {
        return $this->belongsTo(WabaPhone::class);
    }
}
