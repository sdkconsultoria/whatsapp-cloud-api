<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Controllers;

use Illuminate\Routing\Controller;
use Sdkconsultoria\WhatsappCloudApi\Services\WabaManagerService;

class WabaController extends Controller
{
    public function loadTemplatesFromWaba(string $wabaId)
    {
        $templates = resolve(WabaManagerService::class)->getAllTemplates($wabaId);
        return response()->json($templates);
    }
}
