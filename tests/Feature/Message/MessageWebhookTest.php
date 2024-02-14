<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Template;

use Illuminate\Foundation\Testing\WithFaker;
use Sdkconsultoria\WhatsappCloudApi\Tests\TestCase;

class MessageWebhookTest extends TestCase
{
    use WithFaker;

    public function test_recive_webhook_message()
    {
        // $this->withoutExceptionHandling();

        $response = $this->post(route('meta.webhook'), [
            'entry' => [
                [
                    'changes' => [
                        [
                            'field' => 'messages',
                            'value' => [
                                'messaging_product' => 'whatsapp',
                                'metadata' => [
                                    'display_phone_number' => '16505553333',
                                    'phone_number_id' => '27681414235104944',
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
                                        'id' => 'wamid.ABGGFlCGg0cvAgo-sJQh43L5Pe4W',
                                        'timestamp' => '1603059201',
                                        'text' => [
                                            'body' => 'Hello this is an answer',
                                        ],
                                        'type' => 'text',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $response->assertStatus(200);
    }
}
