<?php

namespace Sdkconsultoria\WhatsappCloudApi\Services;

use Illuminate\Support\Facades\Http;

class FacebookService
{
    private string $graph_url = 'https://graph.facebook.com/';

    public function __construct()
    {
        $this->graph_url .= config('whatsappcloudapi.api_version') . '/';
    }

    public function makePostRequest(array $data)
    {
        $this->graph_url .= config('whatsappcloudapi.phone_number_id') . '/messages';

        return Http::withToken(config('whatsappcloudapi.token'))->post($this->graph_url, $data);
    }
}
