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
            'template' => 'required',
            'vars' => 'nullable|array',
        ], $this->getValidationsComponents());
    }

    private function getValidationsComponents(): array|false
    {
        $validations = [];
        $template = Template::find($this->template);

        if (! $template) {
            return false;
        }

        foreach ($template->getComponents() as $index => $component) {
            switch (strtoupper($index)) {
                case 'BODY':
                    $this->getValidationOfTextVars($component['text'], $validations);
                    break;

                default:
                    break;
            }
        }

        return $validations;
    }

    private function getValidationOfTextVars(string $text, array &$validations): void
    {
        $uniques = $this->countUniqueVars($text);

        if ($uniques === 0) {
            $validations['vars.body.parameters'] = 'nullable';
        }

        $validations['vars.body.parameters'] = 'required|array|size:'.$uniques;

        for ($i = 0; $i < $uniques; $i++) {
            $validations["vars.body.parameters.$i.text"] = 'required';
        }
    }

    private function countUniqueVars(string $text): int
    {
        preg_match_all('/{{([0-9]{1,2})}}/', $text, $matches);
        $uniques = array_unique(array_map('intval', $matches[1]));

        return count($uniques);
    }
}
