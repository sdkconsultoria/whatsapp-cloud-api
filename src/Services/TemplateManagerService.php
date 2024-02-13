<?php

namespace Sdkconsultoria\WhatsappCloudApi\Services;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class TemplateManagerService extends FacebookService
{
    public function getAllTemplates(string $wabaId): array
    {
        $this->graph_url .= $wabaId ;
        $response = Http::withToken(config('meta.token'))->get($this->graph_url);

        return $response->json();
    }

    public function getTemplate(string $wabaId): array
    {
        $this->graph_url .= $wabaId . '/phone_numbers';
        $response = Http::withToken(config('meta.token'))->get($this->graph_url);

        return $response->json();
    }

    public function setTemplate(string $phoneId): array
    {
        $this->graph_url .= $phoneId . '/whatsapp_business_profile?fields=about,address,description,email,profile_picture_url,websites,vertical';
        $response = Http::withToken(config('meta.token'))->get($this->graph_url);

        return $response->json();
    }

    public function deleteTemplate(string $phoneId): array
    {
        $this->graph_url .= $phoneId . '/whatsapp_business_profile?fields=about,address,description,email,profile_picture_url,websites,vertical';
        $response = Http::withToken(config('meta.token'))->get($this->graph_url);

        return $response->json();
    }
}
