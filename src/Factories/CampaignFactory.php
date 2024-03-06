<?php

namespace Sdkconsultoria\WhatsappCloudApi\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Sdkconsultoria\WhatsappCloudApi\Models\Campaign;
use Sdkconsultoria\WhatsappCloudApi\Models\Template;
use Sdkconsultoria\WhatsappCloudApi\Models\WabaPhone;

class CampaignFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Campaign::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'waba_phone_id' => WabaPhone::factory(),
            'waba_phone' => $this->faker->numberBetween(1111111),
            'client_phone' => $this->faker->numberBetween(1111111),

            'status' => 20,
            'template_id' => Template::factory(),
            'name' => $this->faker->word,
            'total_messages' => $this->faker->numberBetween(1111111),
            'total_sent' => 0,
            'total_delivered' => 0,
            'total_read' => 0,
            'total_error' => 0,
        ];
    }
}
