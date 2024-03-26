<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Message;

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

    public function test_send_text_template_with_missing_vars()
    {
        $wabaPhone = WabaPhone::factory()->create();
        $template = Template::factory()->create([
            'content' => json_encode(['BODY' => ['text' => 'Hello {{1}}']]),
        ]);
        $messageId = 'wamid.'.$this->faker()->numberBetween(111, 450);

        Http::fake([
            "*/$wabaPhone->phone_id/messages" => Http::response(FakeMessageCreteResponse::getFakeMessageCreateResponse($messageId)),
        ]);

        $this->post(route('message.template.send'), [
            'waba_phone' => $wabaPhone->id,
            'to' => '2213428198',
            'template' => $template->id,
        ])
            ->assertSessionHasErrors(['vars.body.parameters.0.text'])
            ->assertStatus(302);
    }
}
