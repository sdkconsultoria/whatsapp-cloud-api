<?php

namespace Sdkconsultoria\WhatsappCloudApi\Models\Template;

use Sdkconsultoria\WhatsappCloudApi\Models\Template\Validation\ValidateIfNeedExample;
use Sdkconsultoria\WhatsappCloudApi\Models\Template\Validation\ValidateTextLength;

class Footer implements MetaElement
{
    use ValidateIfNeedExample;
    use ValidateTextLength;

    private $type;
    private $text;

    function __construct(string $text) {
        $this->text = $text;
        $this->type = "FOOTER";
    }

    public function validate(): void
    {
        $this->validateTextMinLength($this->text, 2);
        $this->validateTextMaxLength($this->text, 60);
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'text' => $this->text
        ];
    }
}
