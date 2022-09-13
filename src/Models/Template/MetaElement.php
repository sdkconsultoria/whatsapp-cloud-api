<?php

namespace Sdkconsultoria\WhatsappCloudApi\Models\Template;

interface MetaElement
{
    public function toArray(): array;
    public function validate(): void;
}