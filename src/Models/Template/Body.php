<?php

namespace Sdkconsultoria\WhatsappCloudApi\Models\Template;

use Sdkconsultoria\WhatsappCloudApi\Models\Template\Validation\ValidateIfNeedExample;
use Sdkconsultoria\WhatsappCloudApi\Models\Template\Validation\ValidateTextLength;

class Body implements MetaElement
{
    use ValidateIfNeedExample;
    use ValidateTextLength;

    private $type;
    private $text;
    private $example;

    function __construct()
    {
        $this->type = "BODY";
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function setExample(array $example): void
    {
        $this->example = $example;
    }

    public function validate(): void
    {
        $this->validateTextMinLength($this->text, 2);
        $this->validateTextMaxLength($this->text, 1024);
        $this->validateIfNeedExample();
    }

    public function toArray(): array
    {
        $element = [
            'type' => $this->type,
            'text' => $this->text
        ];

        if ($this->example) {
            $element['example'] = ['body_text' => [$this->example]];
        }

        return $element;
    }
}
