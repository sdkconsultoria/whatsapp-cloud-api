<?php

namespace Sdkconsultoria\WhatsappCloudApi\Lib\Template;

use Sdkconsultoria\WhatsappCloudApi\Lib\Template\Adapter\MetaToApp;
use Sdkconsultoria\WhatsappCloudApi\Lib\Template\Adapter\RequestToMeta;
use Sdkconsultoria\WhatsappCloudApi\Models\Template;
use Sdkconsultoria\WhatsappCloudApi\Models\Waba;
use Sdkconsultoria\WhatsappCloudApi\Services\TemplateManagerService;

class CreateTemplate
{
    public function create($request): Template
    {
        $waba = Waba::find($request->waba_id);
        $templateInMetaFormat = resolve(RequestToMeta::class)->process($request->all());
        $metaTemplateResponse = resolve(TemplateManagerService::class)->createTemplate($waba->waba_id, $templateInMetaFormat);
        $templateFromMeta = resolve(TemplateManagerService::class)->getTemplate($metaTemplateResponse['id']);

        return resolve(MetaToApp::class)->process($templateFromMeta, $waba->id);
    }
}
