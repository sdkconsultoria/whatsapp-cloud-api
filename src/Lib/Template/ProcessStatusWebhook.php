<?php

namespace Sdkconsultoria\WhatsappCloudApi\Lib\Template;

use Sdkconsultoria\WhatsappCloudApi\Models\Template;

class ProcessStatusWebhook
{
    public function process($messageEvent): void
    {
        \Log::info('ProcessMessageWebhook', $messageEvent);
        $template = Template::where('template_id', $messageEvent['message_template_id'])->firstOrFail();
        $template->status = $messageEvent['event'];
        $template->save();
    }
}
