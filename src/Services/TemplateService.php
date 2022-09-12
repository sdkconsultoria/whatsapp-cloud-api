<?php

namespace Sdkconsultoria\WhatsappCloudApi\Services;

use Illuminate\Support\Facades\Http;
use Sdkconsultoria\WhatsappCloudApi\Models\Template;

class TemplateService extends FacebookService
{
    public function sendTemplate(Template $template)
    {
        return Http::post($this->prepareQuery($template));
    }

    protected function prepareQuery(Template $template): string
    {
        $url = $this->graph_url . $template->waba_account_id . '/message_templates';
        $url .= "?name={$template->name}";
        $url .= "&language={$template->language}";
        $url .= "&category=TRANSACTIONAL";
        $url .= "&components=[{type:BODY,text:{Hola gracias por tu compra}}]";
        $url .= "&access_token={EAAFKha8XVGIBAAdEoQ68RvVneG85S26ZCtp3dxpYZCo6jwK5Gomgi81PsAEImiKxYbvTUGOZAsfhVp3janVH8g0ZChh3pR93Y9zPDFLyO2DOua3ZBZAgqt9U3XVa0LjjtFORLAAMHRddo1ft5XZCfs4GpzHsvlsZBfdqdm34dgkZCpIPVLeBo2HTj}";
dd($url);
        return $url;
    }
}
