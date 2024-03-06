<?php

namespace Sdkconsultoria\WhatsappCloudApi\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    public const STATUS_CREATED = 0;

    public const STATUS_PENDING = 10;

    public const STATUS_SEND = 20;

    public const STATUS_DELIVERED = 30;

    public const STATUS_READ = 40;

    public $timestamps = false;

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}
