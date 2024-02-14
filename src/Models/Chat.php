<?php

namespace Sdkconsultoria\WhatsappCloudApi\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['waba_phone', 'client_phone', 'status'];

    public const STATUS_UNREAD = 0;
}
