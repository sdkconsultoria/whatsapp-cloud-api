<?php

namespace Sdkconsultoria\WhatsappCloudApi\Services;

use Illuminate\Support\Facades\Http;
use Sdkconsultoria\WhatsappCloudApi\Models\Template;
use Sdkconsultoria\WhatsappCloudApi\Models\WabaPhone;

class MessageService extends FacebookService
{
    public function sendMessage(string $phoneId, $to, array $message): array
    {
        $this->graph_url .= "$phoneId/messages";

        $response = Http::withToken(config('meta.token'))->post($this->graph_url, array_merge([
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $to,
        ], $message))->throw();

        return $response->json();
    }

    public function sendTemplate(WabaPhone $phone, string $to, Template $template): array
    {
        $this->graph_url .= "$phone->phone_id/messages";
        $response = Http::withToken(config('meta.token'))->post($this->graph_url, [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $to,
            'type' => 'template',
            'template' => [
                'name' => $template->name,
                'language' => [
                    'code' => $template->language,
                ],
                'components' => $template->vars,
            ],
        ])->throw();

        return $response->json();
    }
}
