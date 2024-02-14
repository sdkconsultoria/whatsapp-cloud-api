<?php

namespace Sdkconsultoria\WhatsappCloudApi\Services;

use Illuminate\Support\Facades\Http;

class MessageService extends FacebookService
{
    public function sendMessage(string $phoneId, $to, array $message): array
    {
        $this->graph_url .= "$phoneId/messages";
        $response = Http::withToken(config('meta.token'))->post($this->graph_url, array_merge([
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $to,
        ], $message));

        return $response->json();
    }
}
