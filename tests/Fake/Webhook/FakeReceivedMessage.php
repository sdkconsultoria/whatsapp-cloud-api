<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Fake\Webhook;

class FakeReceivedMessage
{
    public static function textMessage($wabaPhone, $messageId): array
    {
        return FakeWebhook::getBaseWebhook(
            [
                'field' => 'messages',
                'value' => [
                    'messaging_product' => 'whatsapp',
                    'metadata' => [
                        'display_phone_number' => $wabaPhone->display_phone_number,
                        'phone_number_id' => $wabaPhone->phone_id,
                    ],
                    'contacts' => [
                        [
                            'profile' => [
                                'name' => 'Kerry Fisher',
                            ],
                            'wa_id' => '16315551234',
                        ],
                    ],
                    'messages' => [
                        [
                            'from' => '16315551234',
                            'id' => $messageId,
                            'timestamp' => '1603059201',
                            'text' => [
                                'body' => 'Hello this is an answer',
                            ],
                            'type' => 'text',
                        ],
                    ],
                ],
            ]
        );
    }

    public static function responseTextMessage($wabaPhone, $messageId): array
    {
        return FakeWebhook::getBaseWebhook(
            [
                'field' => 'messages',
                'value' => [
                    'messaging_product' => 'whatsapp',
                    'metadata' => [
                        'display_phone_number' => $wabaPhone->display_phone_number,
                        'phone_number_id' => $wabaPhone->phone_id,
                    ],
                    'contacts' => [
                        [
                            'profile' => [
                                'name' => 'Kerry Fisher',
                            ],
                            'wa_id' => '16315551234',
                        ],
                    ],
                    'messages' => [
                        [
                            'context' => [
                                'from' => '16315558011',
                                'id' => $messageId.'-reply',
                            ],
                            'from' => '16315551234',
                            'id' => $messageId,
                            'timestamp' => '1603059201',
                            'text' => [
                                'body' => 'Hello this is an answer',
                            ],
                            'type' => 'text',
                        ],
                    ],
                ],
            ]
        );
    }

    public static function imageMessage($wabaPhone, $messageId): array
    {
        return FakeWebhook::getBaseWebhook(
            [
                'field' => 'messages',
                'value' => [
                    'messaging_product' => 'whatsapp',
                    'metadata' => [
                        'display_phone_number' => $wabaPhone->display_phone_number,
                        'phone_number_id' => $wabaPhone->phone_id,
                    ],
                    'contacts' => [
                        [
                            'profile' => [
                                'name' => 'Kerry Fisher',
                            ],
                            'wa_id' => '16315551234',
                        ],
                    ],
                    'messages' => [
                        [
                            'from' => '16315551234',
                            'id' => $messageId,
                            'timestamp' => '1603059201',
                            'type' => 'image',
                            'image' => [
                                'id' => $messageId.'xx',
                            ],
                        ],
                    ],
                ],
            ]
        );
    }

    public static function reactionMessage($wabaPhone, $messageId): array
    {
        return FakeWebhook::getBaseWebhook(
            [
                'field' => 'messages',
                'value' => [
                    'messaging_product' => 'whatsapp',
                    'metadata' => [
                        'display_phone_number' => $wabaPhone->display_phone_number,
                        'phone_number_id' => $wabaPhone->phone_id,
                    ],
                    'contacts' => [
                        [
                            'profile' => [
                                'name' => 'Kerry Fisher',
                            ],
                            'wa_id' => '16315551234',
                        ],
                    ],
                    'messages' => [
                        [
                            'from' => '16315551234',
                            'id' => $messageId.'xx',
                            'timestamp' => '1603059201',
                            'type' => 'reaction',
                            'reaction' => [
                                'emoji' => 'Carita feliz',
                                'message_id' => $messageId,
                            ],
                        ],
                    ],
                ],
            ]
        );
    }
}
