<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Sdkconsultoria\WhatsappCloudApi\Lib\Message\ReceivedMessage;

class WebhookController extends Controller
{
    public function subscribe(Request $request)
    {
        if ($request->hub_verify_token === config('meta.webhook_token')) {
            return $request->hub_challenge;
        }

        return response()->json(['error' => 'Invalid verify token'], 400);
    }

    public function webhook(Request $request)
    {
        $data = $request->all()['entry'][0]['changes'][0];
        \Log::debug('message debug', $data);
        switch ($data['field']) {
            case 'messages':
                resolve(ReceivedMessage::class)->processMessage($data['value']);
                break;
        }
    }
}
