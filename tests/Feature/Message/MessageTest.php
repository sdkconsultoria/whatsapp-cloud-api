<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Message;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Sdkconsultoria\WhatsappCloudApi\Models\Chat;
use Sdkconsultoria\WhatsappCloudApi\Models\Message;
use Sdkconsultoria\WhatsappCloudApi\Models\Template;
use Sdkconsultoria\WhatsappCloudApi\Models\WabaPhone;
use Sdkconsultoria\WhatsappCloudApi\Tests\TestCase;

class MessageTest extends TestCase
{
    use WithFaker;

    public function test_send_text_message()
    {
        $messageId = 'wamid.'.$this->faker()->numberBetween(111, 450);
        $this->mockMessageResponse($messageId);

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

    public function test_get_messages_from_chat()
    {
        $this->assertTrue(true);
    }

    public function test_send_text_template()
    {
        $template = Template::factory(['language' => 'en_US', 'name' => 'hello_world'])->create();
        $messageId = 'wamid.'.$this->faker()->numberBetween(111, 450);
        $this->mockMessageResponse($messageId);

        $phoneNumber = WabaPhone::factory(['phone_id' => '104246142661561'])->create();

        $this->post(route('message.template.send'), [
            'waba_phone' => $phoneNumber->id,
            'to' => '2213428198',
            'template' => $template->id,
        ])
            ->assertStatus(200);

        $this->assertDatabaseHas('messages', [
            'direction' => 'toClient',
            'message_id' => $messageId,
        ]);
    }

    private function mockMessageResponse($messageId)
    {
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
    }

    public function test_get_messages_filter_by_chat_id()
    {
        $chat = Chat::factory()->create();
        Message::factory()->count(5)->create();
        Message::factory()->count(10)->create(['chat_id' => $chat->id]);

        $this->get(route('message.index').'?chat_id='.$chat->id)
            ->assertJsonCount(10, 'data')
            ->assertStatus(200);
    }
}
