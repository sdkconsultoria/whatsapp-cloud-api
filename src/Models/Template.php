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

    public array $componentsWithVars = [];

    public array $vars = [];

    public function getComponents()
    {
        return json_decode($this->content, true)['components'];
    }

    public function setVars(array $vars): void
    {
        $components = $this->getComponents();
        $fixedVars = [];
        foreach ($vars as $key => $var) {
            $key = strtoupper($key);
            $fixedVars[] = array_merge($var, ['type' => $key]);
            $components[$key] = $components[$key] ?? [];

            switch ($key) {
                case 'BODY':
                    $components[$key] = $this->replaceVars($components[$key], $var);
                    break;
                case 'BUTTON':
                    $components['BUTTON'] = $components['BUTTON'] ?? [];
                    $components['BUTTON'][] = $var;
                    break;

                default:
                    $components[$key]['parameters'] = $var;
                    break;
            }
        }

        $this->componentsWithVars = $components;
        $this->vars = $fixedVars;
    }

    private function replaceVars(array $component, array $var): array
    {
        $text = $component['text'];
        foreach ($var['parameters'] as $index => $value) {
            $text = str_replace('{{'.($index + 1).'}}', $value['text'], $text);
        }
        $component['text'] = $text;

        return $component;
    }
}
