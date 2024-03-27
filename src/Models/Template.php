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

    private array $componentsWithVars = [];

    public array $vars = [];

    public function getComponents()
    {
        return json_decode($this->content, true);
    }

    public function getComponentsWithVars(): array
    {
        $components = $this->getComponents();
        if (empty($this->vars)) {
            return $components;
        }

        foreach ($this->vars as $key => $var) {
            switch ($key) {
                case 'body':
                    $components[$key] = $this->replaceVars($components[$key], $var);
                    break;

                default:
                    $components[$key]['parameters'] = $var['parameters'];
                    break;
            }
        }

        return $components;
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
