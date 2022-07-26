<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Http\Controllers;

use Sdkconsultoria\WhatsappCloudApi\Tests\TestCase;

class WebhookControllerTest extends TestCase
{
    public function test_subscribe_webhook()
    {
        $response = $this->get('whatsapp-webhook-subscribe');

        $response->assertStatus(200);
    }
}
