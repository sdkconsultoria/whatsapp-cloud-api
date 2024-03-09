<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Message;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Mockery\MockInterface;
use Sdkconsultoria\WhatsappCloudApi\Events\NewWhatsappMessageHook;
use Sdkconsultoria\WhatsappCloudApi\Models\WabaPhone;
use Sdkconsultoria\WhatsappCloudApi\Services\MediaManagerService;
use Sdkconsultoria\WhatsappCloudApi\Tests\TestCase;

class ReceivedMessageTest extends TestCase
{
    use WithFaker;

    public function test_recive_text_message()
    {
        $messageId = 'wamid.'.$this->faker()->numberBetween(111, 450);
        $wabaPhone = WabaPhone::factory()->create();
        Event::fake();

        $response = $this->post(route('meta.webhook'), [
            'entry' => [
                [
                    'changes' => [
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
                        ],
                    ],
                ],
            ],
        ]);

        $response->assertStatus(200);

        Event::assertDispatched(NewWhatsappMessageHook::class, function ($e) {
            return true;
        });
    }

    public function test_recive_image_message()
    {
        $messageId = 'wamid.'.$this->faker()->numberBetween(111, 450);
        $file = UploadedFile::fake()->image('avatar.jpg', 100, 100)->size(100);
        $wabaPhone = WabaPhone::factory()->create();
        Event::fake();

        $this->partialMock(MediaManagerService::class, function (MockInterface $mock) {
            $mock->shouldReceive('download')->once()->andReturn('http://localhost/avatar.jpg');
        });

        $response = $this->post(route('meta.webhook'), [
            'entry' => [
                [
                    'changes' => [
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
                                            'id' => $this->faker()->numberBetween(111, 450),
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $response->assertStatus(200);

        Event::assertDispatched(NewWhatsappMessageHook::class, function ($e) {
            return true;
        });
    }
}
