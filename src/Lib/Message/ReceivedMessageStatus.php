<?php

namespace Sdkconsultoria\WhatsappCloudApi\Lib\Message;

use Sdkconsultoria\WhatsappCloudApi\Models\Message;

class ReceivedMessageStatus
{
    public function process($messageEvent): void
    {
        switch ($messageEvent['statuses'][0]['status']) {
            case 'sent':
                $this->processSent($messageEvent);
                break;
            case 'delivered':
                $this->processDelivered($messageEvent);
                break;
            case 'read':
                $this->processRead($messageEvent);
                break;
        }
    }

    private function processSent($messageEvent): void
    {
        $message = Message::where('message_id', $messageEvent['statuses'][0]['id'])->firstOrFail();
        $message->sent_at = $messageEvent['statuses'][0]['timestamp'];
        $message->save();

        $chat = $message->chat;
        $chat->expiration_timestamp = $messageEvent['statuses'][0]['conversation']['expiration_timestamp'];
        $chat->save();
    }

    private function processDelivered($messageEvent): void
    {
        $message = Message::where('message_id', $messageEvent['statuses'][0]['id'])->firstOrFail();
        $message->delivered_at = $messageEvent['statuses'][0]['timestamp'];
        $message->save();
    }

    private function processRead($messageEvent): void
    {
        $message = Message::where('message_id', $messageEvent['statuses'][0]['id'])->firstOrFail();
        $message->read_at = $messageEvent['statuses'][0]['timestamp'];
        $message->save();
    }
}
