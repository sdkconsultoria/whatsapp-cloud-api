<?php

namespace Sdkconsultoria\WhatsappCloudApi\Waba;

use Sdkconsultoria\WhatsappCloudApi\Services\FacebookService;

class SendMessage
{
    protected $data = [];

    public static function message(string $number)
    {
        $obj = new self();
        $obj->data['to'] = $number;

        return $obj;
    }

    public function attachText(string $text)
    {
        $this->data['text'] = [
            'body'=> $text,
        ];

        return $this;
    }

    public function send()
    {
        $service = resolve(FacebookService::class);

        return $service->makePostRequest(array_merge($this->data, [
            'messaging_product' => 'whatsapp',
        ]));
    }
}
