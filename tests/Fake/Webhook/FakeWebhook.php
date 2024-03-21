<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Fake\Webhook;

class FakeWebhook
{
    public static function getBaseWebhook(array $data): array
    {
        return [
            'entry' => [
                [
                    'changes' => [
                        $data,
                    ],
                ],
            ],
        ];
    }
}
