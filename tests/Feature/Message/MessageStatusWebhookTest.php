<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Message;

use Sdkconsultoria\WhatsappCloudApi\Models\Message;
use Sdkconsultoria\WhatsappCloudApi\Tests\TestCase;

class MessageStatusWebhookTest extends TestCase
{
    public function test_sent_hook()
    {
        $message = Message::factory()->create();
        $this->post(route('meta.webhook'), FakeWebhookRequests::getFakeMessageStatusWebhookSent($message));

        $this->assertDatabaseHas('messages', [
            'message_id' => $message->message_id,
            'sent_at' => '1709440196',
        ]);

        $this->assertDatabaseHas('chats', [
            'waba_phone' => $message->chat->waba_phone,
            'expiration_timestamp' => '1709507460',
        ]);
    }

    public function test_delivered_hook()
    {
        $message = Message::factory()->create();
        $this->post(route('meta.webhook'), FakeWebhookRequests::getFakeMessageStatusWebhookDelivered($message));

        $this->assertDatabaseHas('messages', [
            'message_id' => $message->message_id,
            'delivered_at' => '1709440196',
        ]);
    }

    public function test_read_hook()
    {
        $message = Message::factory()->create();
        $this->post(route('meta.webhook'), FakeWebhookRequests::getFakeMessageStatusWebhookRead($message));

        $this->assertDatabaseHas('messages', [
            'message_id' => $message->message_id,
            'read_at' => '1709440196',
        ]);
    }
}
