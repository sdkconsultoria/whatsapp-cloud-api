<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Sdkconsultoria\WhatsappCloudApi\Models\Chat;

class ConversationController extends Controller
{
    public function index(Request $request)
    {
        $request = $request->all();
        $chat = Chat::orderBy('last_message', 'desc')->get();
        return response()->json($chat);
    }
}
