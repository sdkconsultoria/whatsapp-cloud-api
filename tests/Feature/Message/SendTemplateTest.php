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
        $wabaPhone = WabaPhone::factory(['phone_id' => '104246142661561'])->create();

        $template = Template::factory(['language' => 'en_US', 'name' => 'hello_world'])->create();
        $messageId = 'wamid.'.$this->faker()->numberBetween(111, 450);
        Http::fake([
            "*/$wabaPhone->phone_id/messages" => Http::response(FakeMessageCreteResponse::getFakeMessageCreateResponse($messageId)),
        ]);

        $this->post(route('message.template.send'), [
            'waba_phone' => $wabaPhone->id,
            'to' => '2213428198',
            'template' => $template->id,
        ])
            ->assertStatus(200);

        $this->assertDatabaseHas('messages', [
            'direction' => 'toClient',
            'message_id' => $messageId,
        ]);
    }
}
