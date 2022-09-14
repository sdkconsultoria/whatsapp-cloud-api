<?php

namespace Sdkconsultoria\WhatsappCloudApi\Models\Template\Button;

use Sdkconsultoria\WhatsappCloudApi\Models\Template\Validation\ValidateIfNeedExample;
use Sdkconsultoria\WhatsappCloudApi\Models\Template\Validation\ValidateTextLength;

class UrlButton extends Button
{
    use ValidateIfNeedExample;
    use ValidateTextLength;

    protected $type;
    protected $url;
    protected $example;
    protected $dynamic_url;

    function __construct() {
        $this->type = "URL";
    }

    public function setText(string $text)
    {
        $this->text = $text;
    }

    public function setUrl(string $url, $dynamic_url = false)
    {
        $this->url = $url . $dynamic_url?'{{1}}':'';
    }

    public function validate(): void
    {
        $this->validateTextMinLength($this->text, 2);
        $this->validateTextMaxLength($this->text, 25);
        $this->validateTextMinLength($this->url, 2);
        $this->validateTextMaxLength($this->url, 2000);
        $this->validateIfNeedExample();
    }

    public function toArray(): array
    {
        $element = [
            'type' => $this->type,
            'text' => $this->text,
            'url' => $this->url,
        ];

        if ($this->example) {
            $element['example'] = ['header_text' => [$this->example]];
        }

        return $element;
    }
}
