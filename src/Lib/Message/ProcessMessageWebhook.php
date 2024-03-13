<?php

namespace Sdkconsultoria\WhatsappCloudApi\Lib\Message;

class ProcessMessageWebhook
{
    public function process($messageEvent): void
    {
        \Log::info('ProcessMessageWebhook', $messageEvent);
        if (isset($messageEvent['messages'])) {
            resolve(ReceivedMessage::class)->process($messageEvent);
        }

        if (isset($messageEvent['statuses'])) {
            resolve(ReceivedMessageStatus::class)->process($messageEvent);
        }
    }
}
