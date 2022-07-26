<?php

namespace Sdkconsultoria\WhatsappCloudApi\Models\Template\Button;

use Sdkconsultoria\WhatsappCloudApi\Models\Template\Validation\ValidateIfNeedExample;
use Sdkconsultoria\WhatsappCloudApi\Models\Template\Validation\ValidateTextLength;

class TextButton extends Button
{
    use ValidateIfNeedExample;
    use ValidateTextLength;

    function __construct(string $text) {
        $this->type = "QUICK_REPLY";
        $this->text = $text;
    }

    public function validate(): void
    {
        $this->validateTextMinLength($this->text, 2);
        $this->validateTextMaxLength($this->text, 25);
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'text' => $this->text,
        ];
    }
}
