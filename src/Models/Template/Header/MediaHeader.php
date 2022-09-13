<?php

namespace Sdkconsultoria\WhatsappCloudApi\Models\Template\Header;

use Sdkconsultoria\WhatsappCloudApi\Models\Template\Header\Header;
use Sdkconsultoria\WhatsappCloudApi\Models\Template\MetaElement;

class MediaHeader extends Header
{
    public function validate(): void
    {

    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
        ];
    }
}
