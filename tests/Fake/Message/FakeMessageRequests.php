<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Fake\Message;

use Sdkconsultoria\WhatsappCloudApi\Models\Message;

class FakeMessageRequests
{
    public static function getFakeMessageStatusWebhookSent(Message $message)
    {
        return [
            'entry' => [
                [
                    'changes' => [
                        [
                            'field' => 'messages',
                            'value' => [
                                'messaging_product' => 'whatsapp',
                                'id' => $message->message_id,
                                'metadata' => [
                                    'phone_number_id' => $message->message_id,
                                    'display_phone_number' => $message->chat->waba_phone,
                                ],
                                'statuses' => [
                                    [
                                        'id' => $message->message_id,
                                        'status' => 'sent',
                                        'timestamp' => '1709440196',
                                        'recipient_id' => $message->chat->client_phone,
                                        'conversation' => [
                                            'id' => 'b2f9c8b2ebc0a5f66957383852b11a1e',
                                            'expiration_timestamp' => '1709507460',
                                            'origin' => ['type' => 'service'],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public static function getFakeMessageStatusWebhookDelivered(Message $message)
    {
        $request = self::getFakeMessageStatusWebhookSent($message);
        $request['entry'][0]['changes'][0]['value']['statuses'][0]['status'] = 'delivered';

        return $request;
    }

    public static function getFakeMessageStatusWebhookRead(Message $message)
    {
        $request = self::getFakeMessageStatusWebhookSent($message);
        $request['entry'][0]['changes'][0]['value']['statuses'][0]['status'] = 'read';

        return $request;
    }
}
