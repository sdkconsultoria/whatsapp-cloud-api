<?php

namespace Sdkconsultoria\WhatsappCloudApi\Lib\Message;

use Sdkconsultoria\WhatsappCloudApi\Models\WabaPhone;
use Sdkconsultoria\WhatsappCloudApi\Services\WabaManagerService;

class BussinessProfile
{
    public function process(string $phoneId)
    {
        $bussinesProfile = resolve(WabaManagerService::class)->getBussinesProfile($phoneId);

        return $this->updateWabaPhone($phoneId, $bussinesProfile['data'][0]);
    }

    private function updateWabaPhone(string $phoneId, array $profile): WabaPhone
    {
        $wabaPhone = WabaPhone::where('phone_id', $phoneId)->first();
        $wabaPhone->about = $profile['about'];
        $wabaPhone->address = $profile['address'];
        $wabaPhone->description = $profile['description'];
        $wabaPhone->email = $profile['email'];
        $wabaPhone->profile_picture_url = $profile['profile_picture_url'];
        $wabaPhone->websites = json_encode($profile['websites']);
        $wabaPhone->vertical = $profile['vertical'];
        $wabaPhone->messaging_product = $profile['messaging_product'];
        $wabaPhone->save();

        return $wabaPhone;
    }
}
