<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Controllers;

use Illuminate\Routing\Controller;
use Sdkconsultoria\WhatsappCloudApi\Services\WabaManagerService;

class TemplateController extends Controller
{
    public function index()
    {
        // $templates = resolve(WabaManagerService::class)->getAllTemplates();

        return response()->json('templates');
    }
}
