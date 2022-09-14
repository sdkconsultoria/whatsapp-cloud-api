<?php

namespace Sdkconsultoria\WhatsappCloudApi\Models\Template\Button;

use Sdkconsultoria\WhatsappCloudApi\Models\Template\MetaElement;

abstract class Button implements MetaElement
{
    protected $text;

    abstract public function validate(): void;
    abstract public function toArray(): array;
}
