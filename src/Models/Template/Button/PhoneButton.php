<?php

namespace Sdkconsultoria\WhatsappCloudApi\Models\Template\Button;

use Sdkconsultoria\WhatsappCloudApi\Models\Template\Validation\ValidateIfNeedExample;
use Sdkconsultoria\WhatsappCloudApi\Models\Template\Validation\ValidateTextLength;

class PhoneButton extends Button
{
    use ValidateIfNeedExample;
    use ValidateTextLength;

    protected $phone_number;

    function __construct() {
        $this->type = "PHONE_NUMBER";
    }

    public function validate(): void
    {
        $this->validateTextMinLength($this->text, 2);
        $this->validateTextMaxLength($this->text, 25);
        $this->validateTextMinLength($this->phone_number, 2);
        $this->validateTextMaxLength($this->phone_number, 20);
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'text' => $this->text,
            'phone_number' => $this->phone_number,
        ];
    }
}
