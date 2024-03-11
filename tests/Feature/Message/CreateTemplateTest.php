<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Message;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Sdkconsultoria\WhatsappCloudApi\Models\Waba;
use Sdkconsultoria\WhatsappCloudApi\Tests\TestCase;

class CreateTemplateTest extends TestCase
{
    use WithFaker;

    public function test_create_template_with_image_header()
    {
        $waba = Waba::factory()->create();
        $sessionId = $this->faker()->uuid;

        Http::fake([
            '*/uploads*' => Http::response(['id' => $sessionId]),
            "*/$sessionId" => Http::response(['h' => $this->faker()->uuid]),
            "*/$waba->waba_id/message_templates" => Http::response([
                'id' => $this->faker()->uuid,
                'status' => 'PENDING',
                'category' => 'MARKETING',
            ]),
        ]);

        Storage::fake('local');
        $file = UploadedFile::fake()->create('file.jpg');

        $this->post(route('template.store'), [
            'waba_id' => $waba->id,
            'name' => 'seasonal_promotion_text_only',
            'language' => 'en',
            'category' => 'MARKETING',
            'components' => [
                [
                    'type' => 'header',
                    'format' => 'IMAGE',
                    'text' => 'Our {{1}} is on!',
                    'example' => [
                        'header_handle' => $file,
                    ],
                ],
                [
                    'type' => 'body',
                    'text' => 'Shop now through to get of all merchandise.',
                ],
            ],
        ])->assertStatus(200);

        $this->assertDatabaseHas('templates', [
            'waba_id' => $waba->id,
            'name' => 'seasonal_promotion_text_only',
            'language' => 'en',
            'category' => 'MARKETING',
            'status' => 'PENDING',
        ]);
    }
}
