<?php

namespace Sdkconsultoria\WhatsappCloudApi\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['from', 'to', 'status'];

    public const STATUS_UNREAD = 0;
}
