<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Controllers;

use Sdkconsultoria\WhatsappCloudApi\Http\Requests\StoreCampaignRequest;
use Sdkconsultoria\WhatsappCloudApi\Lib\Template\SendTemplate;
use Sdkconsultoria\WhatsappCloudApi\Models\Campaign;

class CampaignController extends APIResourceController
{
    protected $resource = Campaign::class;

    public function store(StoreCampaignRequest $request)
    {
        $file = file_get_contents($request->file->getRealPath());
        $phones = explode(',', $file);

        $campaign = new Campaign();
        $campaign->name = $request->name;
        $campaign->template_id = $request->template_id;
        $campaign->waba_phone_id = $request->waba_phone_id;
        $campaign->total_messages = count($phones);
        $campaign->save();

        foreach ($phones as $phone) {
            resolve(SendTemplate::class)->send($campaign->wabaPhone, $campaign->template, $phone, $request->vars ?? []);
        }
    }
}
