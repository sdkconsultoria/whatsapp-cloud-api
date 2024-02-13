<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Waba;

trait FakeWabaResponses
{
    private function getFakeWabaInfo()
    {
        return [
            "id" => "104996122399160",
            "currency" => "USD",
            "name" => "Lucky Shrub",
            "timezone_id" => "1",
            "message_template_namespace" => "58e6d318_b627_4112_b9c7_2961197553ea"
        ];
    }

    private function fakePhoneNumbers()
    {
        return [
            "data" => [
                [
                    "verified_name" => "Jasper's Market",
                    "display_phone_number" => "+1 631-555-5555",
                    "id" => "1906385232743451",
                    "quality_rating" => "GREEN"
                ],
                [
                    "verified_name" => "Jasper's Ice Cream",
                    "display_phone_number" => "+1 631-555-5556",
                    "id" => "1913623884432103",
                    "quality_rating" => "NA"
                ]
            ]
        ];
    }
}
