<?php

namespace Sdkconsultoria\WhatsappCloudApi\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Sdkconsultoria\WhatsappCloudApi\Models\Waba;

class WabaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Waba::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'timezone_id' => $this->faker->word,
            'currency' => $this->faker->word,
            'message_template_namespace' => $this->faker->word,
            'waba_id' => $this->faker->numberBetween(111111111),
        ];
    }
}
