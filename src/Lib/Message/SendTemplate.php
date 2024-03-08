<?php

namespace Sdkconsultoria\WhatsappCloudApi\Lib\Message;

use Sdkconsultoria\WhatsappCloudApi\Models\Chat;
use Sdkconsultoria\WhatsappCloudApi\Models\Message;
use Sdkconsultoria\WhatsappCloudApi\Models\Template;
use Sdkconsultoria\WhatsappCloudApi\Models\WabaPhone;
use Sdkconsultoria\WhatsappCloudApi\Services\MessageService;

class SendTemplate
{
    public function Send($request)
    {
        $template = Template::find($request['template']);
        $phoneNumber = WabaPhone::where('id', $request['waba_phone'])->first();
        $message = resolve(MessageService::class)
            ->sendTemplate($phoneNumber, $request['to'], $template);

        $messageModel = new Message();
        $messageModel->direction = 'toClient';
        $messageModel->body = json_encode($template->getMessage());
        $messageModel->timestamp = time();
        $messageModel->message_id = $message['messages'][0]['id'];
        $messageModel->type = 'text';
        $messageModel->chat_id = $this->getChatId($phoneNumber, $request['to']);
        $messageModel->sended_by = 'BOT';
        $messageModel->save();
    }

    private function getChatId($phoneNumber, $to)
    {
        $chat = Chat::firstOrCreate([
            'waba_phone' => $phoneNumber->phone_number_clean,
            'waba_phone_id' => $phoneNumber->id,
            'client_phone' => $to,
        ]);

        return $chat->id;
    }
}
