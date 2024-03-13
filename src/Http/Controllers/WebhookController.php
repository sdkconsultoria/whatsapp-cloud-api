<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Sdkconsultoria\WhatsappCloudApi\Lib\Message\ProcessMessageWebhook;

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
        $this->redirectRequestIfNeeded($request);

        switch ($data['field']) {
            case 'messages':
                resolve(ProcessMessageWebhook::class)->process($data['value']);
                break;
        }
    }

    private function redirectRequestIfNeeded(Request $request)
    {
        if (! config('meta.webhook_redirect')) {
            return;
        }

        Http::post(config('meta.webhook_redirect'), $request->all());
    }
}
