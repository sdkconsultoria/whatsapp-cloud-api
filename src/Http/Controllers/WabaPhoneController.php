<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Controllers;

use Illuminate\Http\Request;
use Sdkconsultoria\WhatsappCloudApi\Lib\Message\BussinessProfile;
use Sdkconsultoria\WhatsappCloudApi\Models\WabaPhone;

class WabaPhoneController extends APIResourceController
{
    protected $resource = WabaPhone::class;

    protected function filters(): array
    {
        return [
            'waba_id' => function ($query, $value) {
                return $query->where('waba_id', "$value");
            },
        ];
    }

    public function getBussinesProfile(string $phoneId)
    {
        return resolve(BussinessProfile::class)->process($phoneId);
    }

    public function setBussinesProfile(string $phoneId, Request $request)
    {
        return resolve(BussinessProfile::class)->update($phoneId, $request->all());
    }
}
