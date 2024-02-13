<?php

namespace Sdkconsultoria\WhatsappCloudApi\Models;

use Illuminate\Database\Eloquent\Model;

class WabaPhone extends Model
{
    public static function savePhones(array $phones, $wabaId) : void
    {
        foreach ($phones['data'] as $phone) {
            $waba = Waba::where('waba_id', $wabaId)->first();
            $wabaPhone = WabaPhone::where('phone_id', $phone['id'])->first();

            if (!$wabaPhone) {
                $wabaPhone = new WabaPhone();
                $wabaPhone->phone_id = $phone['id'];
                $wabaPhone->waba_id = $waba->id;
            }

            $wabaPhone->name = $phone['verified_name'];
            $wabaPhone->display_phone_number = $phone['display_phone_number'];
            $wabaPhone->quality_rating = $phone['quality_rating'];
            $wabaPhone->phone_number_clean = trim(str_replace('+', '', $phone['display_phone_number']));
            $wabaPhone->save();
        }
    }
}
