<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Chat;

use Sdkconsultoria\WhatsappCloudApi\Models\Chat;
use Sdkconsultoria\WhatsappCloudApi\Tests\TestCase;

class ChatTest extends TestCase
{
    public function test_get_all_chats()
    {
        Chat::factory()->count(10)->create();

        $this->get(route('chat.index'))
            ->assertJsonCount(10, 'data')
            ->assertStatus(200);
    }

    public function test_get_chat_filter_by_client_phone()
    {
        Chat::factory()->count(10)->create();
        $chat = Chat::factory()->create();

        $this->get(route('chat.index').'?client_phone='.$chat->client_phone)
            ->assertJsonCount(1, 'data')
            ->assertStatus(200);
    }
}
