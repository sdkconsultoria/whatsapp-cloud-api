<?php

namespace Sdkconsultoria\WhatsappCloudApi\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    public const STATUS_APPROVED = 'APPROVED';

    public const STATUS_PENDING = 'PENDING';

    public const STATUS_REJECTED = 'REJECTED';

    private $componentsWithVars = [];

    public function getMessage()
    {
        $components = $this->getComponents();

        return [
            'text' => [
                'body' => $components['BODY']->text,
            ],
            'type' => 'text',
        ];
    }

    public function setComponentsWithVars(array $components)
    {
        $this->componentsWithVars = $components;
    }

    public function getComponentsWithVars(): array
    {
        return $this->componentsWithVars;
    }

    private function getComponents(): array
    {
        $components = json_decode($this->content)->components;
        $formattedComponents = [];

        foreach ($components as $component) {
            $formattedComponents[$component->type] = $component;
        }

        return $formattedComponents;
    }
}
