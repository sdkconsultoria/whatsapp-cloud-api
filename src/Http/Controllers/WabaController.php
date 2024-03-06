<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Controllers;

use Illuminate\Routing\Controller;
use Sdkconsultoria\WhatsappCloudApi\Models\Template;
use Sdkconsultoria\WhatsappCloudApi\Services\WabaManagerService;

class WabaController extends Controller
{
    public function init(string $wabaId)
    {
        resolve(WabaManagerService::class)->getWabaInfo($wabaId);
        resolve(WabaManagerService::class)->getPhoneNumbers($wabaId);
        $templates = resolve(WabaManagerService::class)->getAllTemplates($wabaId);
        $this->saveTemplates($templates, $wabaId);

        return response()->json($templates);
    }

    public function loadTemplatesFromWaba(string $wabaId)
    {
        $templates = resolve(WabaManagerService::class)->getAllTemplates($wabaId);
        $this->saveTemplates($templates, $wabaId);

        return response()->json($templates);
    }

    private function saveTemplates($templates, $wabaId)
    {
        foreach ($templates['data'] as $template) {
            $this->saveTemplate($template, $wabaId);
        }
    }

    private function saveTemplate($template, $wabaId)
    {
        $templateModel = Template::where('template_id', $template['id'])->first();

        if (! $templateModel) {
            $templateModel = new Template();
        }

        $templateModel->waba_id = $wabaId;
        $templateModel->name = $template['name'];
        $templateModel->status = $template['status'];
        $templateModel->category = $template['category'];
        $templateModel->language = $template['language'];
        $templateModel->template_id = $template['id'];
        $templateModel->content = json_encode($template);
        $templateModel->save();
    }

    public function getWabaInfoFromMeta($wabaId)
    {
        return resolve(WabaManagerService::class)->getWabaInfo($wabaId);
    }

    public function getWabaPhonesFromMeta($wabaId)
    {
        return resolve(WabaManagerService::class)->getPhoneNumbers($wabaId);
    }
}
