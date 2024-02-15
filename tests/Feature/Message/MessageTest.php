<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Message;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Sdkconsultoria\WhatsappCloudApi\Models\WabaPhone;
use Sdkconsultoria\WhatsappCloudApi\Tests\TestCase;

class MessageTest extends TestCase
{
    use WithFaker;

    public function test_send_text_message()
    {
        $messageId = 'wamid.'.$this->faker()->numberBetween(111, 450);
        Http::fake([
            '*' => Http::response([
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
            ], 200),
        ]);

        $phoneNumber = WabaPhone::factory(['phone_id' => '107722695662343'])->create();

        $this->post(route('message.send'), [
            'phone_id' => $phoneNumber->phone_id,
            'to' => '2213428198',
            'message' => [
                'type' => 'text',
                'text' => [
                    'preview_url' => false,
                    'body' => 'text-message-content',
                ],
            ],
        ])
            ->assertStatus(200);

        $this->assertDatabaseHas('messages', [
            'direction' => 'toClient',
            'message_id' => $messageId,
        ]);
    }
}
