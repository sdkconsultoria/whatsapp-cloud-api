<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Controllers;

use Sdkconsultoria\WhatsappCloudApi\Http\Requests\StoreTemplateRequest;
use Sdkconsultoria\WhatsappCloudApi\Http\Resources\TemplateResource;
use Sdkconsultoria\WhatsappCloudApi\Models\Template;
use Sdkconsultoria\WhatsappCloudApi\Models\Waba;
use Sdkconsultoria\WhatsappCloudApi\Services\ResumableUploadAPI;
use Sdkconsultoria\WhatsappCloudApi\Services\TemplateManagerService;

class TemplateController extends APIResourceController
{
    protected $resource = Template::class;

    protected $transformer = TemplateResource::class;

    protected function filters(): array
    {
        return [
            'status' => function ($query, $value) {
                return $query->where('status', "$value");
            },
            'name' => function ($query, $value) {
                return $query->where('name', 'like', "%$value%");
            },
        ];
    }

    public function store(StoreTemplateRequest $request)
    {
        $waba = Waba::find($request->waba_id);
        $processTemplate = $this->processTemplate($request->all());
        $template = resolve(TemplateManagerService::class)->createTemplate($waba->waba_id, $processTemplate);

        $this->saveTemplate($template, $processTemplate, $waba);
    }

    private function processTemplate(array $request)
    {
        $processed = $request;
        unset($processed['waba_id']);

        $components = $request['components'];
        $components = array_map(function ($component) {
            if ($component['type'] === 'header' && $component['format'] === 'IMAGE') {
                $filePath = $component['example']['header_handle']->getRealPath();
                $handler = resolve(ResumableUploadAPI::class)->uploadFile($filePath);
                $component['example']['header_handle'] = $handler->handler;
            }

            return $component;
        }, $components);
        $processed['components'] = $components;

        return $processed;
    }

    private function saveTemplate(array $templateResponse, array $processTemplate, Waba $waba)
    {
        $template = new Template();
        $template->waba_id = $waba->id;
        $template->template_id = $templateResponse['id'];
        $template->status = $templateResponse['status'];
        $template->category = $templateResponse['category'];
        $template->name = $processTemplate['name'];
        $template->language = $processTemplate['language'];
        $template->content = json_encode($processTemplate);
        $template->save();
    }
}
