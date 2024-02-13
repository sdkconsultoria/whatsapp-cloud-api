<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Waba;

use Sdkconsultoria\WhatsappCloudApi\Tests\TestCase;

class WebhookSubscribeTest extends TestCase
{
    public function test_subscribe_webhook_with_valid_token()
    {
        $response = $this->get(route('meta.webhook.subscribe').'?hub_verify_token=23653244');

        $response->assertStatus(200);
    }

    public function test_subscribe_webhook_with_invalid_token()
    {
        $response = $this->get(route('meta.webhook.subscribe'));

        $response->assertStatus(400);
    }
}
