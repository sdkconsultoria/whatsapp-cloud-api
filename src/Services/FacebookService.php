<?php

namespace Sdkconsultoria\WhatsappCloudApi\Services;

use Illuminate\Support\Facades\Http;

class FacebookService
{
    protected string $graph_url = 'https://graph.facebook.com/';

    public function __construct()
    {
        $this->graph_url .= config('facebook.api_version').'/';
    }
}
