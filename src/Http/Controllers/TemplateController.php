<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Controllers;

use Sdkconsultoria\WhatsappCloudApi\Http\Requests\SendTemplateRequest;
use Sdkconsultoria\WhatsappCloudApi\Http\Requests\StoreTemplateRequest;
use Sdkconsultoria\WhatsappCloudApi\Http\Resources\TemplateResource;
use Sdkconsultoria\WhatsappCloudApi\Lib\Template\CreateTemplate;
use Sdkconsultoria\WhatsappCloudApi\Lib\Template\SendTemplate;
use Sdkconsultoria\WhatsappCloudApi\Models\Template;
use Sdkconsultoria\WhatsappCloudApi\Models\WabaPhone;

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
        $template = resolve(CreateTemplate::class)->create($request);

        return response()->json([
            'message' => 'Template created successfully',
            'template' => new TemplateResource($template),
        ], 201);
    }

    public function sendTemplate(SendTemplateRequest $request)
    {
        $template = Template::find($request->template);
        $wabaPhone = WabaPhone::find($request->waba_phone);

        try {
            $message = resolve(SendTemplate::class)->send($wabaPhone, $template, $request->to, $request->vars ?? []);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

        return response()->json($message);
    }
}
