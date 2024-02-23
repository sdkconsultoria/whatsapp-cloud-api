<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Controllers;

use Sdkconsultoria\WhatsappCloudApi\Http\Resources\TemplateResource;
use Sdkconsultoria\WhatsappCloudApi\Models\Template;

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
                return $query->where('name', "$value");
            },
        ];
    }
}
