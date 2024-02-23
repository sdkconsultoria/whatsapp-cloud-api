<?php

namespace Sdkconsultoria\WhatsappCloudApi\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    public const STATUS_APPROVED = 'APPROVED';

    public const STATUS_PENDING = 'PENDING';

    public const STATUS_REJECTED = 'REJECTED';
}
