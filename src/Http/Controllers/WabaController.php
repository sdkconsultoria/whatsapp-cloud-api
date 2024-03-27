<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Controllers;

use Sdkconsultoria\WhatsappCloudApi\Lib\Template\Adapter\MetaToApp;
use Sdkconsultoria\WhatsappCloudApi\Models\Waba;
use Sdkconsultoria\WhatsappCloudApi\Services\WabaManagerService;

class WabaController extends APIResourceController
{
    protected $resource = Waba::class;

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
            resolve(MetaToApp::class)->process($template, $wabaId);
        }
    }

    public function getWabaInfoFromMeta(string $wabaId)
    {
        return resolve(WabaManagerService::class)->getWabaInfo($wabaId);
    }

    public function getWabaPhonesFromMeta(string $wabaId)
    {
        return resolve(WabaManagerService::class)->getPhoneNumbers($wabaId);
    }
}
