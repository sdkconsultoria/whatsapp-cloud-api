<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WebhookController extends Controller
{
    public function subscribe(Request $request)
    {
        if ($request->hub_verify_token === config('cloudapi.webhook_token')) {
            return $request->hub_challenge;
        }

        return response()->json(['error' => 'Invalid verify token'], 400);
    }

    public function webhook(Request $request)
    {
        $data = $request->all()['entry'][0]['changes'][0];

        switch ($data['field']) {
            case 'messages':
                $this->processMessageHook($data['value']);
                break;
        }
    }

    private function processMessageHook($message)
    {
        \Log::info($message);
    }

}
