<?php

namespace Sdkconsultoria\WhatsappCloudApi\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 20;

    public const STATUS_SENDING = 30;

    public const STATUS_SENT = 40;

    public const STATUS_FINALIZED = 50;

    public function wabaPhone()
    {
        return $this->belongsTo(WabaPhone::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }
}
