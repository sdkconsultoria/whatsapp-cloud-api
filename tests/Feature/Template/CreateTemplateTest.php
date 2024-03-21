<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Template;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Sdkconsultoria\WhatsappCloudApi\Models\Waba;
use Sdkconsultoria\WhatsappCloudApi\Tests\TestCase;

class CreateTemplateTest extends TestCase
{
    use WithFaker;

    public function test_create_text_template()
    {
        $waba = Waba::factory()->create();

        Http::fake([
            "*/$waba->waba_id/message_templates" => Http::response([
                'id' => $this->faker()->uuid,
                'status' => 'PENDING',
                'category' => 'MARKETING',
            ]),
        ]);

        $this->post(route('template.store'), [
            'waba_id' => $waba->id,
            'name' => 'template_name',
            'language' => 'en',
            'category' => 'MARKETING',
            'components' => [
                [
                    'type' => 'text',
                    'text' => 'Hello World',
                ],
            ],
        ])->assertStatus(201);
    }

    public function test_create_text_template_with_buttons_footer_buttons()
    {
        $waba = Waba::factory()->create();

        Http::fake([
            "*/$waba->waba_id/message_templates" => Http::response([
                'id' => $this->faker()->uuid,
                'status' => 'PENDING',
                'category' => 'MARKETING',
            ]),
        ]);

        $this->post(route('template.store'), [
            'waba_id' => $waba->id,
            'name' => 'template_name',
            'language' => 'en_US',
            'category' => 'MARKETING',
            'components' => [
                [
                    'type' => 'BODY',
                    'text' => 'Hi {{1}}! For can get our {{2}} for as low as {{3}} for more information.',
                    'example' => [
                        'body_text' => [
                            [
                                'Mark', 'Tuscan Getaway package', '800',
                            ],
                        ],
                    ],
                ],
                [
                    'type' => 'FOOTER',
                    'text' => 'Shop now through to get of all merchandise.',
                ],
                [
                    'type' => 'BUTTONS',
                    'buttons' => [
                        [
                            'type' => 'QUICK_REPLY',
                            'text' => 'Unsubcribe from Promos',
                        ],
                        [
                            'type' => 'PHONE_NUMBER',
                            'text' => 'Call',
                            'phone_number' => '15550051310',
                        ],
                        [
                            'type' => 'URL',
                            'text' => 'Shop Now',
                            'url' => 'https://www.examplesite.com/shop?promo={{1}}',
                            'example' => [
                                'summer2023',
                            ],
                        ],
                    ],

                ],
            ],
        ])->assertStatus(201);
    }

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
            'language' => 'en_US',
            'category' => 'MARKETING',
            'components' => [
                [
                    'type' => 'HEADER',
                    'format' => 'IMAGE',
                    'example' => [
                        'header_handle' => $file,
                    ],
                ],
                [
                    'type' => 'BODY',
                    'text' => 'Shop now through to get of all merchandise.',
                ],
            ],
        ])->assertStatus(201);

        $this->assertDatabaseHas('templates', [
            'waba_id' => $waba->id,
            'name' => 'seasonal_promotion_text_only',
            'language' => 'en_US',
            'category' => 'MARKETING',
            'status' => 'PENDING',
        ]);
    }
}
