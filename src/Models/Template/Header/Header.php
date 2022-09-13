<?php

namespace Sdkconsultoria\WhatsappCloudApi\Models\Template\Header;

use Sdkconsultoria\WhatsappCloudApi\Models\Template\MetaElement;

abstract class Header implements MetaElement
{
    public const FORMAT_IMAGE = 'IMAGE';
    public const FORMAT_TEXT = 'TEXT';
    public const FORMAT_DOCUMENT = 'DOCUMENT';
    public const FORMAT_VIDEO = 'VIDEO';

    protected $type;
    protected $format;

    abstract public function validate(): void;
    abstract public function toArray(): array;

    function __construct() {
        $this->type = "HEADER";
    }
}
