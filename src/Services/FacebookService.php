<?php

namespace Sdkconsultoria\WhatsappCloudApi\Services;

abstract class FacebookService
{
    protected string $graph_url = 'https://graph.facebook.com/';

    public function __construct()
    {
        $this->graph_url .= config('meta.api_version').'/';
    }
}
