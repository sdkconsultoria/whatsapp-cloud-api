<?php

namespace Sdkconsultoria\WhatsappCloudApi\Models\Template\Header;

use Sdkconsultoria\WhatsappCloudApi\Models\Template\Header\Header;
use Sdkconsultoria\WhatsappCloudApi\Models\Template\Validation\ValidateIfNeedExample;
use Sdkconsultoria\WhatsappCloudApi\Models\Template\Validation\ValidateTextLength;

class TextHeader extends Header
{
    use ValidateIfNeedExample;
    use ValidateTextLength;

    private $text;
    private $example;

    function __construct() {
        $this->format = self::FORMAT_TEXT;
        parent::__construct();
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
            'format' => $this->format,
            'text' => $this->text,
        ];

        if ($this->example) {
            $element['example'] = ['header_text' => $this->example];
        }

        return $element;
    }
}
