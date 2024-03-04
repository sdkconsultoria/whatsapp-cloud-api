<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Fake\Message;

class FakeMessageCreteResponse
{
    public static function getFakeMessageCreateResponse(string $messageId): array
    {
        return [
            'messaging_product' => 'whatsapp',
            'contacts' => [
                [
                    'input' => '48XXXXXXXXX',
                    'wa_id' => '48XXXXXXXXX ',
                ],
            ],
            'messages' => [
                [
                    'id' => $messageId,
                ],
            ],
        ];
    }
}
