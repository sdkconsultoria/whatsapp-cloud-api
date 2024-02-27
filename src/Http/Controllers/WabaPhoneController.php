<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Controllers;

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
}
