<?php

namespace Sdkconsultoria\WhatsappCloudApi\Lib\Message;

class ProcessMessageWebhook
{
    public function process($messageEvent): void
    {
        if (isset($messageEvent['messages'])) {
            resolve(ReceivedMessage::class)->process($messageEvent);
        }

        if (isset($messageEvent['statuses'])) {
            resolve(ReceivedMessageStatus::class)->process($messageEvent);
        }
    }
}
