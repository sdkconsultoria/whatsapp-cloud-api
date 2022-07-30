<?php

namespace Sdkconsultoria\WhatsappCloudApi\Waba;

class SendMessage extends BaseWhatsapp
{
    protected $endpoint = 'messages';

    public static function message(int $number)
    {
        $obj = new self();
        $obj->data['to'] = $number;

        return $obj;
    }

    public function attachText(string $text)
    {
        $this->data['text'] = [
            'body' => $text,
        ];

        return $this;
    }
}
