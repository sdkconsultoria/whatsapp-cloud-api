<?php

namespace Sdkconsultoria\WhatsappCloudApi\Waba;

use Sdkconsultoria\WhatsappCloudApi\Services\FacebookService;

abstract class BaseWhatsapp
{
    public function send()
    {
        $service = resolve(FacebookService::class);

        return $service->setEndpoint($this->endpoint)->makePostRequest($this->data);
    }
}
