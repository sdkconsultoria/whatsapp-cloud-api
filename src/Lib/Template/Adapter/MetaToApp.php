<?php

namespace Sdkconsultoria\WhatsappCloudApi\Lib\Template\Adapter;

use Sdkconsultoria\WhatsappCloudApi\Models\Template;

class MetaToApp
{
    public function process(array $metaTemplate, ?string $wabaId = null)
    {
        $metaTemplate['components'] = $this->fixComponents($metaTemplate['components']);
        $template = $this->saveTemplate($metaTemplate, $wabaId);

        return $template;
    }

    private function fixComponents(array $components): array
    {
        $fixedComponents = [];

        foreach ($components as $component) {
            $fixedComponents[$component['type']] = $component;
            unset($fixedComponents[$component['type']]['type']);
        }

        return $fixedComponents;
    }

    private function saveTemplate(array $metaTemplate, ?string $wabaId = null): Template
    {
        $template = $this->findOrCreateTemplate($metaTemplate['id'], $wabaId);
        $template->status = $metaTemplate['status'];
        $template->category = $metaTemplate['category'];
        $template->name = $metaTemplate['name'];
        $template->language = $metaTemplate['language'];
        $template->content = json_encode($metaTemplate);
        $template->save();

        return $template;
    }

    private function findOrCreateTemplate(string $templateId, ?string $wabaId = null): Template
    {
        $template = Template::where('template_id', $templateId)->first();

        if (! $template) {
            $template = new Template();
            $template->template_id = $templateId;
            $template->waba_id = $wabaId;
        }

        return $template;
    }
}
