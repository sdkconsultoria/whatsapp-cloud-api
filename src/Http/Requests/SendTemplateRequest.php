<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Sdkconsultoria\WhatsappCloudApi\Models\Template;

class SendTemplateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $this->getValidationsComponents();

        return array_merge([
            'waba_phone' => 'required',
            'to' => 'required',
            'template' => 'required|integer|exists:Sdkconsultoria\WhatsappCloudApi\Models\Template,id',
            'vars' => 'nullable|array',
        ], $this->getValidationsComponents());
    }

    private function getValidationsComponents(): array|false
    {
        $validations = [];
        $template = Template::find($this->template);

        if (! $template) {
            return [];
        }

        foreach ($template->getComponents() as $index => $component) {
            switch (strtoupper($index)) {
                case 'BODY':
                    $this->getComponentVarsValidations($component, $validations, 'body');
                    break;
                case 'HEADER':
                    $this->getHeaderValidations($component, $validations);
                    break;

                default:
                    break;
            }
        }

        return $validations;
    }

    private function getComponentVarsValidations(array $component, array &$validations, $type): void
    {
        $uniques = $this->countUniqueVars($component['text']);

        if ($uniques === 0) {
            $validations["vars.$type.parameters"] = 'nullable';

            return;
        }

        $validations["vars.$type.parameters"] = 'required|array|size:'.$uniques;

        for ($i = 0; $i < $uniques; $i++) {
            $validations["vars.$type.parameters.$i.text"] = 'required|string';
            $validations["vars.$type.parameters.$i.type"] = 'required|string';
        }
    }

    private function countUniqueVars(string $text): int
    {
        preg_match_all('/{{([0-9]{1,2})}}/', $text, $matches);
        $uniques = array_unique(array_map('intval', $matches[1]));

        return count($uniques);
    }

    private function getHeaderValidations(array $component, array &$validations): void
    {
        switch ($component['format']) {
            case 'text':
                $this->getComponentVarsValidations($component, $validations, 'header');
                break;
            case 'document':
            case 'video':
            case 'image':
                $validations['vars.header.parameters.0.type'] = 'required|string';
                $validations['vars.header.parameters.0.'.$component['format'].'.link'] = 'required|string';
                break;
        }
    }
}
