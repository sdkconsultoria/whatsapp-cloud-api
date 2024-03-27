<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Message;

use Illuminate\Foundation\Testing\WithFaker;
use Sdkconsultoria\WhatsappCloudApi\Models\Chat;
use Sdkconsultoria\WhatsappCloudApi\Models\Message;
use Sdkconsultoria\WhatsappCloudApi\Tests\TestCase;

class MessageTest extends TestCase
{
    use WithFaker;

    public function test_get_messages_filter_by_chat_id()
    {
        $chat = Chat::factory()->create();
        Message::factory()->count(5)->create();
        Message::factory()->count(6)->create(['chat_id' => $chat->id]);
        Message::factory()->create([
            'chat_id' => $chat->id,
            'type' => 'image',
            'body' => '{"image":{"url":"https:\/\/los-chavos.site\/storage\/received\/16\/2514991862013041.jpg"}}',
        ]);
        Message::factory()->create([
            'chat_id' => $chat->id,
            'type' => 'contacts',
            'body' => '{"contacts":{"contact":"Mire esta slegible"}}',
        ]);
        Message::factory()->create([
            'chat_id' => $chat->id,
            'type' => 'contacts',
            'body' => '{"contacts":{"contact":"Mire esta slegible"},"context": "contexto"}',
        ]);
        Message::factory()->create([
            'chat_id' => $chat->id,
            'type' => 'template',
            'body' => '{}',
        ]);

        $this->get(route('message.index').'?chat_id='.$chat->id)
            ->assertJsonCount(10, 'data')
            ->assertStatus(200);
    }
}
