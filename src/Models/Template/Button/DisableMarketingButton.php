<?php

namespace Sdkconsultoria\WhatsappCloudApi\Models\Template\Button;

class DisableMarketingButton extends TextButton
{
    function __construct() {
        $this->type = "QUICK_REPLY";
        $this->text = "Stop promotions";
    }
}
