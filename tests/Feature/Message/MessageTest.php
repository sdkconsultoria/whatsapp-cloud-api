<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Template;

use Sdkconsultoria\WhatsappCloudApi\Tests\TestCase;

class MessageTest extends TestCase
{
    public function test_send_text_message()
    {
        $this->post(route('message.send'), [
            'phone_id' => '107722695662343',
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
    }
}
