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
        $content = [
            'BODY' => [
                'text' => 'Welcome',
            ],
        ];

        return [
            'waba_id' => Waba::factory(),
            'name' => $this->faker->word,
            'status' => 'APPROVED',
            'category' => 'UTILITY',
            'language' => 'es_MX',
            'template_id' => $this->faker->numberBetween(111111111),
            'content' => json_encode(['components' => $content]),
        ];
    }
}
