<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Fake\Webhook;

class FakeTemplateStatusWebhook
{
    public static function statusWebHookRequest(string $id, string $name, string $status): array
    {
        return FakeWebhook::getBaseWebhook(
            [
                'field' => 'message_template_status_update',
                'value' => [
                    'event' => $status,
                    'message_template_id' => $id,
                    'message_template_name' => $name,
                    'message_template_language' => 'es_MX',
                    'reason' => null,
                ],
            ]
        );
    }
}
