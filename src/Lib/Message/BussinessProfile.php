<?php

namespace Sdkconsultoria\WhatsappCloudApi\Lib\Message;

use Sdkconsultoria\WhatsappCloudApi\Models\WabaPhone;
use Sdkconsultoria\WhatsappCloudApi\Services\ResumableUploadAPI;
use Sdkconsultoria\WhatsappCloudApi\Services\WabaManagerService;

class BussinessProfile
{
    public function process(string $phoneId)
    {
        $bussinesProfile = resolve(WabaManagerService::class)->getBussinesProfile($phoneId);

        return $this->saveWabaPhone($phoneId, $bussinesProfile['data'][0]);
    }

    private function saveWabaPhone(string $phoneId, array $profile): WabaPhone
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

    public function update(string $phoneId, array $profile)
    {
        if (isset($profile['picture_profile'])) {
            $filePath = $profile['picture_profile']->getRealPath();
            $handler = resolve(ResumableUploadAPI::class)->uploadFile($filePath);
            unset($profile['picture_profile']);
            $profile['profile_picture_handle'] = $handler->handler;
        }

        resolve(WabaManagerService::class)->setBussinesProfile($phoneId, $profile);

        return $this->process($phoneId);
    }
}
