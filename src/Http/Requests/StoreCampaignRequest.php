<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCampaignRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'template_id' => 'required|integer|exists:Sdkconsultoria\WhatsappCloudApi\Models\Template,id',
            'waba_phone_id' => 'required|integer|exists:Sdkconsultoria\WhatsappCloudApi\Models\WabaPhone,id',
            'file' => 'required|extensions:csv',
            'vars' => 'nullable|array',
        ];
    }
}
