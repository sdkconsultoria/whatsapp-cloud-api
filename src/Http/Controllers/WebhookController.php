<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WebhookController extends Controller
{
    public function subscribe(Request $request)
    {
        if ($request->hub_verify_token === config('whatsappcloudapi.verification_token')) {
            return $request->hub_challenge;
        }
    }

    public function webhook(Request $request)
    {
    }
}
