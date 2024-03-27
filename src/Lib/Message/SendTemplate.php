<?php

namespace Sdkconsultoria\WhatsappCloudApi\Lib\Message;

use Sdkconsultoria\WhatsappCloudApi\Models\Chat;
use Sdkconsultoria\WhatsappCloudApi\Models\Message;
use Sdkconsultoria\WhatsappCloudApi\Models\Template;
use Sdkconsultoria\WhatsappCloudApi\Models\WabaPhone;
use Sdkconsultoria\WhatsappCloudApi\Services\MessageService;

class SendTemplate
{
    public function Send(WabaPhone $wabaPhone, Template $template, string $to, array $vars = [])
    {
        $template->vars = $vars;
        $message = resolve(MessageService::class)
            ->sendTemplate($wabaPhone, $to, $template);

        $messageModel = new Message();
        $messageModel->direction = 'toClient';
        $messageModel->body = json_encode($template->getComponentsWithVars());
        $messageModel->timestamp = time();
        $messageModel->message_id = $message['messages'][0]['id'];
        $messageModel->type = 'text';
        $messageModel->chat_id = $this->getChatId($wabaPhone, $to);
        $messageModel->sended_by = 'BOT';
        $messageModel->save();
    }

    private function getChatId($wabaPhone, $to)
    {
        $chat = Chat::firstOrCreate([
            'waba_phone' => $wabaPhone->phone_number_clean,
            'waba_phone_id' => $wabaPhone->id,
            'client_phone' => $to,
        ]);

        return $chat->id;
    }
}
