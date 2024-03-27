<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Template;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Sdkconsultoria\WhatsappCloudApi\Models\Template;
use Sdkconsultoria\WhatsappCloudApi\Models\WabaPhone;
use Sdkconsultoria\WhatsappCloudApi\Tests\Fake\Message\FakeMessageCreteResponse;
use Sdkconsultoria\WhatsappCloudApi\Tests\TestCase;

class SendTemplateTest extends TestCase
{
    use WithFaker;

    public function test_send_text_template()
    {
        $wabaPhone = WabaPhone::factory()->create();
        $template = Template::factory()->create();
        $messageId = 'wamid.'.$this->faker()->numberBetween(111, 450);

        Http::fake([
            "*/$wabaPhone->phone_id/messages" => Http::response(FakeMessageCreteResponse::getFakeMessageCreateResponse($messageId)),
        ]);

        $this->post(route('message.template.send'), [
            'waba_phone' => $wabaPhone->id,
            'to' => '2213428198',
            'template' => $template->id,
        ])->assertStatus(200);

        $this->assertDatabaseHas('messages', [
            'direction' => 'toClient',
            'message_id' => $messageId,
        ]);
    }

    public function test_send_text_template_invalid_template()
    {
        $wabaPhone = WabaPhone::factory()->create();

        $this->post(route('message.template.send'), [
            'waba_phone' => $wabaPhone->id,
            'to' => '2213428198',
            'template' => $this->faker()->numberBetween(10000),
        ])
            ->assertSessionHasErrors(['template'])
            ->assertStatus(302);
    }

    public function test_send_text_header_template()
    {
        $wabaPhone = WabaPhone::factory()->create();
        $template = Template::factory()->create([
            'content' => json_encode([
                'components' => [
                    'BODY' => [
                        'text' => 'Hello this is a test',
                    ],
                    'HEADER' => ['format' => 'text', 'text' => 'Header text'],
                ],
            ]),
        ]);
        $messageId = 'wamid.'.$this->faker()->numberBetween(111, 450);

        Http::fake([
            "*/$wabaPhone->phone_id/messages" => Http::response(FakeMessageCreteResponse::getFakeMessageCreateResponse($messageId)),
        ]);

        $this->post(route('message.template.send'), [
            'waba_phone' => $wabaPhone->id,
            'to' => '2213428198',
            'template' => $template->id,
        ])->assertStatus(200);
    }

    public function test_send_text_header_template_missing_vars()
    {
        $wabaPhone = WabaPhone::factory()->create();
        $template = Template::factory()->create([
            'content' => json_encode(['components' => [
                'BODY' => [
                    'text' => 'Hello this is a test',
                ],
                'HEADER' => ['format' => 'text', 'text' => 'Header {{1}} text'],
            ]]),
        ]);

        $this->post(route('message.template.send'), [
            'waba_phone' => $wabaPhone->id,
            'to' => '2213428198',
            'template' => $template->id,
        ])->assertSessionHasErrors(['vars.header.parameters.0.text'])
            ->assertStatus(302);
    }

    public function test_send_text_template_with_missing_vars()
    {
        $wabaPhone = WabaPhone::factory()->create();
        $template = Template::factory()->create([
            'content' => json_encode(['components' => ['BODY' => ['text' => 'Hello {{1}}']]]),
        ]);

        $this->post(route('message.template.send'), [
            'waba_phone' => $wabaPhone->id,
            'to' => '2213428198',
            'template' => $template->id,
        ])
            ->assertSessionHasErrors(['vars.body.parameters.0.text'])
            ->assertStatus(302);
    }

    public function test_send_text_template_with_vars()
    {
        $wabaPhone = WabaPhone::factory()->create();
        $template = Template::factory()->create([
            'content' => json_encode(['components' => ['BODY' => ['text' => 'Hello {{1}}']]]),
        ]);
        $messageId = 'wamid.'.$this->faker()->numberBetween(111, 450);

        Http::fake([
            "*/$wabaPhone->phone_id/messages" => Http::response(FakeMessageCreteResponse::getFakeMessageCreateResponse($messageId)),
        ]);

        $this->post(route('message.template.send'), [
            'waba_phone' => $wabaPhone->id,
            'to' => '2213428198',
            'template' => $template->id,
            'vars' => [
                'body' => [
                    'parameters' => [
                        [
                            'type' => 'text',
                            'text' => 'World',
                        ],
                    ],
                ],
            ],
        ])
            ->assertStatus(200);
    }

    public function test_send_template_header_image()
    {
        $wabaPhone = WabaPhone::factory()->create();
        $template = Template::factory()->create([
            'content' => json_encode([
                'components' => ['components' => ['BODY' => ['text' => 'Hello this is a test'], 'HEADER' => ['format' => 'image']]],
            ]),
        ]);
        $messageId = 'wamid.'.$this->faker()->numberBetween(111, 450);

        Http::fake([
            "*/$wabaPhone->phone_id/messages" => Http::response(FakeMessageCreteResponse::getFakeMessageCreateResponse($messageId)),
        ]);

        $this->post(route('message.template.send'), [
            'waba_phone' => $wabaPhone->id,
            'to' => '2213428198',
            'template' => $template->id,
            'vars' => [
                'header' => [
                    'parameters' => [
                        [
                            'type' => 'image',
                            'image' => [
                                'link' => 'https://example.com/image.jpg',
                            ],
                        ],
                    ],
                ],
            ],
        ])
            ->assertStatus(200);
    }

    public function test_send_template_header_image_missing_var()
    {
        $wabaPhone = WabaPhone::factory()->create();
        $template = Template::factory()->create([
            'content' => json_encode(['components' => ['BODY' => ['text' => 'Hello this is a test'], 'HEADER' => ['format' => 'image']]]),
        ]);

        $this->post(route('message.template.send'), [
            'waba_phone' => $wabaPhone->id,
            'to' => '2213428198',
            'template' => $template->id,
        ])
            ->assertSessionHasErrors(['vars.header.parameters.0.image.link'])
            ->assertStatus(302);
    }

    public function test_send_template_fail_to_send()
    {
        $wabaPhone = WabaPhone::factory()->create();
        $template = Template::factory()->create();
        $messageId = 'wamid.'.$this->faker()->numberBetween(111, 450);

        Http::fake([
            "*/$wabaPhone->phone_id/messages" => Http::response([
                'error' => [
                    'message' => 'Invalid OAuth access token - Cannot parse access token',
                    'type' => 'OAuthException',
                    'code' => 190,
                    'fbtrace_id' => 'ACbE05M7Rh6qXPVN_9_NNdG',
                ],
            ], 500),
        ]);

        $this->post(route('message.template.send'), [
            'waba_phone' => $wabaPhone->id,
            'to' => '2213428198',
            'template' => $template->id,
        ])->assertStatus(500);
    }
}
