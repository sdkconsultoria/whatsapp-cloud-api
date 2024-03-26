<?php

namespace Sdkconsultoria\WhatsappCloudApi\Lib\Template\Adapter;

use Sdkconsultoria\WhatsappCloudApi\Services\ResumableUploadAPI;

class RequestToApp
{
    public function process(array $template)
    {
        $processed = $template;
        unset($processed['waba_id']);

        $components = $template['components'];
        $components = array_map(function ($component, $index) {
            $component['type'] = strtoupper($index);

            if ($component['type'] === 'HEADER' && in_array($component['format'], ['IMAGE', 'VIDEO', 'DOCUMENT'])) {
                $filePath = $component['example']['header_handle']->getRealPath();
                $handler = resolve(ResumableUploadAPI::class)->uploadFile($filePath);
                $component['example']['header_handle'] = $handler->handler;
            }

            return $component;
        }, $components, array_keys($components));
        $processed['components'] = $components;

        return $processed;
    }
}
