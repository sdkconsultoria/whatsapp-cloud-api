<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTemplateRequest extends FormRequest
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
        $rules = [];
        $rules = array_merge($rules, $this->basicRules());

        return $rules;
    }

    private function basicRules(): array
    {
        return [
            'waba_id' => 'required',
            'name' => 'required|string|alpha_dash:ascii',
            'category' => ['required', 'string'],
            'language' => 'required|string',
            // 'allow_category_change' => 'required|boolean',
            'components' => 'required|array',
        ];
    }
}
