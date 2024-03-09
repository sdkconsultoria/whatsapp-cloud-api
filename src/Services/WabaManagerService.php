<?php

namespace Sdkconsultoria\WhatsappCloudApi\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Sdkconsultoria\WhatsappCloudApi\Models\Waba;
use Sdkconsultoria\WhatsappCloudApi\Models\WabaPhone;

class WabaManagerService extends FacebookService
{
    public function getWabaInfo(string $wabaId): array
    {
        $this->graph_url .= $wabaId;
        $response = Http::withToken(config('meta.token'))->get($this->graph_url);

        Waba::saveWaba($response->json());

        return $response->json();
    }

    public function getPhoneNumbers(string $wabaId): array
    {
        $this->graph_url .= $wabaId.'/phone_numbers';
        $response = Http::withToken(config('meta.token'))->get($this->graph_url);

        WabaPhone::savePhones($response->json(), $wabaId);

        return $response->json();
    }

    public function getBussinesProfile(string $phoneId): array
    {
        $this->graph_url .= $phoneId.'/whatsapp_business_profile?fields=about,address,description,email,profile_picture_url,websites,vertical';
        $response = Http::withToken(config('meta.token'))->get($this->graph_url);

        return $response->json();
    }

    public function setBussinesProfile(string $phoneId, $data): array
    {
        $this->graph_url .= $phoneId.'/whatsapp_business_profile';

        $response = Http::withToken(config('meta.token'))
            ->post($this->graph_url, array_merge($data, ['messaging_product' => 'whatsapp']));

        return $response->json();
    }

    public function getAllTemplates(string $wabaId): array
    {
        $this->graph_url .= $wabaId.'/message_templates';
        $response = Http::withToken(config('meta.token'))->get($this->graph_url);

        return $response->json();
    }

    // public function getAllWabas(): Response
    // {
    //     $this->graph_url .= config('meta.app_id') . '/owned_whatsapp_business_accounts';
    //     $response = Http::withToken(config('meta.token'))->get($this->graph_url);
    //     return $response->json();
    // }

    // public function subscribeWaba(string $wabaId): Response
    // {
    //     $this->graph_url .= $wabaId.'/phone_numbers';
    //     $response = Http::withToken(config('meta.token'))->get($this->graph_url);
    //     return $response->json();
    // }

    // public function getAllPhoneNumberFromWaba(string $wabaId): Response
    // {
    //     $this->graph_url .= $wabaId.'/phone_numbers';
    //     $response = Http::withToken(config('meta.token'))->get($this->graph_url);
    //     return $response->json();
    // }

    // public function getPin2faToNumber(string $phoneId): Response
    // {
    //     $this->graph_url .= $phoneId.'/register';
    //     $response = Http::withToken(config('meta.token'))->post($this->graph_url, [
    //         'messaging_product' => 'whatsapp',
    //     ]);
    //     return $response->json();
    // }
    // public function enable2faToNumber(string $phoneId, string $pin): Response
    // {
    //     $this->graph_url .= $phoneId.'/register';
    //     $response = Http::withToken(config('meta.token'))->post($this->graph_url, [
    //         'messaging_product' => 'whatsapp',
    //         'pin' => $pin
    //     ]);
    //     return $response->json();
    // }
}
