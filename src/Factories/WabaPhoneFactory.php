<?php

namespace Sdkconsultoria\WhatsappCloudApi\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Sdkconsultoria\WhatsappCloudApi\Models\Waba;
use Sdkconsultoria\WhatsappCloudApi\Models\WabaPhone;

class WabaPhoneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WabaPhone::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'waba_id' => Waba::factory(),
            'address' => $this->faker->word,
            'description' => $this->faker->word,
            'vertical' => $this->faker->word,
            'about' => $this->faker->word,
            'email' => $this->faker->word,
            'websites' => $this->faker->word,
            'profile_picture_url' => $this->faker->word,
            'name' => $this->faker->word,
            'code_verification_status' => $this->faker->word,
            'display_phone_number' => $this->faker->word,
            'phone_number_clean' => $this->faker->word,
            'quality_rating' => $this->faker->word,
            'phone_id' => $this->faker->word,
        ];
    }
}
