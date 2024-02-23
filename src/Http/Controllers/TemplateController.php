<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Controllers;

use Illuminate\Routing\Controller;
use Sdkconsultoria\WhatsappCloudApi\Http\Resources\TemplateResource;
use Sdkconsultoria\WhatsappCloudApi\Models\Template;
use Sdkconsultoria\WhatsappCloudApi\Services\WabaManagerService;

class TemplateController extends APIResourceController
{
    protected $resource = Template::class;

    protected $transformer = TemplateResource::class;
}
