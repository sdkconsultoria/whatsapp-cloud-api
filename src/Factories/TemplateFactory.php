<?php

namespace Sdkconsultoria\WhatsappCloudApi\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Sdkconsultoria\WhatsappCloudApi\Models\Template;
use Sdkconsultoria\WhatsappCloudApi\Models\Waba;

class TemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Template::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'waba_id' => Waba::factory(),
            'name' => $this->faker->word,
            'status' => 'APPROVED',
            'category' => 'UTILITY',
            'language' => 'es_MX',
            'template_id' => $this->faker->numberBetween(111111111),
            'content' => '{"id": "242255344975523", "name": "hello_world", "status": "APPROVED", "category": "UTILITY", "language": "en_US", "components": [{"text": "Hello World", "type": "HEADER", "format": "TEXT"}, {"text": "Welcome and congratulations!! This message demonstrates your ability to send a WhatsApp message notification from the Cloud API, hosted by Meta. Thank you for taking the time to test with us.", "type": "BODY"}, {"text": "WhatsApp Business Platform sample message", "type": "FOOTER"}]}',
        ];
    }
}
