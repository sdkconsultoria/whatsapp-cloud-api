<?php

namespace Sdkconsultoria\WhatsappCloudApi\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Sdkconsultoria\WhatsappCloudApi\Models\Chat;
use Sdkconsultoria\WhatsappCloudApi\Models\Message;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'chat_id' => Chat::factory(),
            'timestamp' => time(),
            'sent_at' => null,
            'delivered_at' => null,
            'read_at' => null,
            'message_id' => 'wamid.'.$this->faker->numberBetween(1111111),
            'type' => 'text',
            'direction' => 'toApp',
            'body' => '{"text": {"body": "Todo bien", "preview_url": false}, "type": "text"}',
            'status' => 20,
            'response_to' => null,
            'reaction' => null,
        ];
    }
}
