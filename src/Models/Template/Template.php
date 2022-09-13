<?php

namespace Sdkconsultoria\WhatsappCloudApi\Models\Template;

use ErrorException;
use Sdkconsultoria\WhatsappCloudApi\Models\Template\Header\Header;

class Template
{
    public const TYPE_TRANSACTIONAL = 'TRANSACTIONAL';
    public const TYPE_MARKETING = 'MARKETING';
    public const TYPE_OTP = 'OTP';

    public string $name;
    public string $language;
    public string $category;

    private Body $body;
    private Header $header;
    private Footer $footer;
    private ButtonGroup $buttons;

    public function bodyComponent(Body $body)
    {
        $body->validate();
        $this->body = $body;

        return $this;
    }

    public function headerComponent(Header $header)
    {
        $header->validate();
        $this->header = $header;

        return $this;
    }

    public function footerComponent(Footer $footer)
    {
        $footer->validate();
        $this->footer = $footer;

        return $this;
    }

    public function buttonComponent(ButtonGroup $buttons)
    {
        $buttons->validate();
        $this->buttons = $buttons;

        return $this;
    }

    public function toHttpQuery(): string
    {
        $this->validate();

        $template = '';
        $template .= "?name={$this->name}";
        $template .= "&language={$this->language}";
        $template .= "&category={$this->category}";
        $template .= "&components=".json_encode($this->getComponents());

        return $template;
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'language' => $this->language,
            'components' => $this->getComponents(),
        ];
    }

    private function validate()
    {
        if (!isset($this->name)) {
            throw new ErrorException("name no puede estar vacio");
        }

        if (!isset($this->language)) {
            throw new ErrorException("language no puede estar vacio");
        }

        if (!isset($this->category)) {
            throw new ErrorException("category no puede estar vacio");
        }

        if (!isset($this->body)) {
            throw new ErrorException("Body no puede estar vacio");
        }
    }

    private function getComponents(): array
    {
        $components = [];

        $components[] = $this->body->toArray();

        if (isset($this->header)) {
            $components[] = $this->header->toArray();
        }

        if (isset($this->footer)) {
            $components[] = $this->footer->toArray();
        }

        if (isset($this->buttons)) {
            $components[] = $this->buttons->toArray();
        }

        return $components;
    }
}
