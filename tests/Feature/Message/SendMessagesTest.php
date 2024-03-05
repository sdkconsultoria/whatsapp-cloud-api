<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Message;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Sdkconsultoria\WhatsappCloudApi\Models\WabaPhone;
use Sdkconsultoria\WhatsappCloudApi\Tests\Fake\Message\FakeMessageCreteResponse;
use Sdkconsultoria\WhatsappCloudApi\Tests\TestCase;

class SendMessagesTest extends TestCase
{
    use WithFaker;

    public function test_send_text_message()
    {
        $messageId = 'wamid.'.$this->faker()->numberBetween(111, 450);
        $wabaPhone = WabaPhone::factory()->create();

        Http::fake([
            "*/$wabaPhone->phone_id/messages" => Http::response(FakeMessageCreteResponse::getFakeMessageCreateResponse($messageId)),
        ]);

        $this->post(route('message.send'), [
            'waba_phone_id' => $wabaPhone->id,
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

    public function test_send_image_message()
    {
        $messageId = 'wamid.'.$this->faker()->numberBetween(111, 450);
        $wabaPhone = WabaPhone::factory()->create();

        Http::fake([
            "*/$wabaPhone->phone_id/media" => Http::response(['id' => $this->faker()->uuid]),
            "*/$wabaPhone->phone_id/messages" => Http::response(FakeMessageCreteResponse::getFakeMessageCreateResponse($messageId)),
        ]);

        Storage::fake('local');
        $file = UploadedFile::fake()->image('avatar.jpg', 100, 100)->size(100);

        $this->post(route('message.send'), [
            'waba_phone_id' => $wabaPhone->id,
            'to' => '2213428198',
            'message' => [
                'type' => 'image',
                'image' => $file,
            ],
        ])
            ->assertStatus(200);

        $this->assertDatabaseHas('messages', [
            'direction' => 'toClient',
            'message_id' => $messageId,
        ]);
    }
}
