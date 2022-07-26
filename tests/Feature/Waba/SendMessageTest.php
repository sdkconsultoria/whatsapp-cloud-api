<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Waba;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Sdkconsultoria\WhatsappCloudApi\Tests\TestCase;
use Sdkconsultoria\WhatsappCloudApi\Waba\SendMessage;

class SendMessageTest extends TestCase
{
    protected function fakeResponse()
    {
        return [
            'messaging_product' => 'whatsapp',
            'contacts' => [
                [
                    'input' => '522213428198',
                    'wa_id' => '5212213428198',
                ],
            ],
            'messages' => [
                [
                    'id' => 'wamid.HBgNNTIxMjIxMzQyODE5OBUCABEYEjA2NTJGQzA4NjEwNzQxMDRCQwA=',
                ],
            ],
        ];
    }

    public function test_send_text_message()
    {
        Http::fake(['*' => Http::response($this->fakeResponse(), 200)]);

        $text = str_replace('-', '', $this->faker->unique()->text());

        SendMessage::message('522213428198')->attachText($text)->send();

        Http::assertSent(function (Request $request) use ($text) {
            return $request['to'] == '522213428198' &&
                   $request['messaging_product'] == 'whatsapp';
            $request['text'] == [
                'body' => $text,
            ];
        });
    }
}
