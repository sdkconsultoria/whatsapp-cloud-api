<?php

namespace Sdkconsultoria\WhatsappCloudApi\Services;

use Illuminate\Support\Facades\Http;

class FacebookService
{
    private string $graph_url = 'https://graph.facebook.com/';
    public string $endpoint = '';

    public function __construct()
    {
        $this->graph_url .= config('whatsappcloudapi.api_version').'/';
    }

    public function makePostRequest(array $data)
    {
        $this->graph_url .= config('whatsappcloudapi.phone_number_id').'/'.$this->endpoint;

        return Http::withToken(config('whatsappcloudapi.token'))
            ->withHeaders([
                'Content-Type' => 'application/json'
            ])
            ->post($this->graph_url, array_merge($data, [
                'messaging_product' => 'whatsapp',
            ]));
    }

    public function setEndpoint(string $endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }
}
