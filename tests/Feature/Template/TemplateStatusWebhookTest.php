<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Template;

use Illuminate\Foundation\Testing\WithFaker;
use Sdkconsultoria\WhatsappCloudApi\Models\Template;
use Sdkconsultoria\WhatsappCloudApi\Tests\Fake\Webhook\FakeTemplateStatusWebhook;
use Sdkconsultoria\WhatsappCloudApi\Tests\TestCase;

class TemplateStatusWebhookTest extends TestCase
{
    use WithFaker;

    public function test_receive_approved_status()
    {
        $template = Template::factory([
            'status' => 'PENDING',
        ])->create();

        $webhookRequest = FakeTemplateStatusWebhook::statusWebHookRequest($template->template_id, $template->name, 'APPROVED');
        $this->post(route('meta.webhook'), $webhookRequest)->assertStatus(200);

        $this->assertDatabaseHas('templates', [
            'id' => $template->id,
            'status' => 'APPROVED',
        ]);
    }
}
