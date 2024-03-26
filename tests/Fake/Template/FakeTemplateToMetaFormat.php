<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Fake\Template;

class FakeTemplateToMetaFormat
{
    public static function convert(array $templateRequest, string $templateId)
    {
        $templateRequest['id'] = $templateId;
        $templateRequest['status'] = 'PENDING';
        $templateRequest['components'] = self::convertComponents($templateRequest['components']);

        return $templateRequest;
    }

    private static function convertComponents(array $components)
    {
        $convertedComponents = [];

        foreach ($components as $index => $componentData) {
            $componentData['type'] = $index;
            $convertedComponents[] = $componentData;
        }

        return $convertedComponents;
    }
}
