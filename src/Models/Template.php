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

    public function setVarsToComponents(array $vars): void
    {
        if (empty($vars)) {
            $this->componentsWithVars = $this->getComponents();
        }
    }

    public function getComponentsWithVars(): array
    {
        return $this->componentsWithVars;
    }
}
