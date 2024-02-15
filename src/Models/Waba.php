<?php

namespace Sdkconsultoria\WhatsappCloudApi\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waba extends Model
{
    use HasFactory;

    public static function saveWaba(array $wabaInfo): void
    {
        $waba = Waba::where('waba_id', $wabaInfo['id'])->first();

        if (! $waba) {
            $waba = new Waba();
            $waba->waba_id = $wabaInfo['id'];
        }

        $waba->waba_id = $wabaInfo['id'];
        $waba->name = $wabaInfo['name'];
        $waba->timezone_id = $wabaInfo['timezone_id'];
        $waba->message_template_namespace = $wabaInfo['message_template_namespace'];
        $waba->currency = $wabaInfo['currency'] ?? 'USD';
        $waba->save();
    }
}
