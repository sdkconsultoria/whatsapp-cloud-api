<?php

namespace Sdkconsultoria\WhatsappCloudApi\Services;

use Illuminate\Support\Facades\Http;

class TemplateManagerService extends FacebookService
{
    public function createTemplate(string $wabaId, array $template)
    {
        $this->graph_url .= $wabaId.'/message_templates';
        $response = Http::withToken(config('meta.token'))->post($this->graph_url, $template);

        return $response->json();
    }

    public function getTemplate(string $templateId): array
    {
        $this->graph_url .= $templateId;
        $response = Http::withToken(config('meta.token'))->get($this->graph_url);

        return $response->json();
    }

    // public function getAllTemplates(string $wabaId): array
    // {
    //     $this->graph_url .= $wabaId;
    //     $response = Http::withToken(config('meta.token'))->get($this->graph_url);

    //     return $response->json();
    // }

    // public function setTemplate(string $phoneId): array
    // {
    //     $this->graph_url .= $phoneId.'/whatsapp_business_profile?fields=about,address,description,email,profile_picture_url,websites,vertical';
    //     $response = Http::withToken(config('meta.token'))->get($this->graph_url);

    //     return $response->json();
    // }

    // public function deleteTemplate(string $phoneId): array
    // {
    //     $this->graph_url .= $phoneId.'/whatsapp_business_profile?fields=about,address,description,email,profile_picture_url,websites,vertical';
    //     $response = Http::withToken(config('meta.token'))->get($this->graph_url);

    //     return $response->json();
    // }
}
