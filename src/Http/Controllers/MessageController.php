<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Sdkconsultoria\WhatsappCloudApi\Services\MessageService;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request = $request->all();
        resolve(MessageService::class)->sendMessage($request['phone_id'], $request['to'], $request['message']);

        return response()->json('templates');
    }
}
