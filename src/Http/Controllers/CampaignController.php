<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Controllers;

use Sdkconsultoria\WhatsappCloudApi\Http\Requests\StoreCampaignRequest;
use Sdkconsultoria\WhatsappCloudApi\Lib\Message\SendTemplate;
use Sdkconsultoria\WhatsappCloudApi\Models\Campaign;

class CampaignController extends APIResourceController
{
    protected $resource = Campaign::class;

    public function store(StoreCampaignRequest $request)
    {
        $campaign = new Campaign();
        $campaign->name = $request->name;
        $campaign->template_id = $request->template_id;
        $campaign->waba_phone_id = $request->waba_phone_id;
        $campaign->total_messages = count($request->phones);
        $campaign->save();

        foreach ($request->phones as $phone) {
            resolve(SendTemplate::class)->send([
                'waba_phone' => $campaign->waba_phone_id,
                'to' => $phone,
                'template' => $campaign->template_id,
            ]);
        }
    }
}
