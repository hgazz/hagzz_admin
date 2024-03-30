<?php

namespace App\Http\Requests;

use App\Models\Sport;
use App\Services\TranslatableService;
use Illuminate\Foundation\Http\FormRequest;

class SportRequest extends FormRequest
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
        $rules = [
            'icon'=>$this->validateImage(),
        ];
        return TranslatableService::validateTranslatableFields(Sport::$translatableColumns) + $rules;
    }

    private function validateImage(): string
    {
        return request()->isMethod('POST') ? 'required|image|mimes:jpg,png,gif,webp,svg,jpeg' : 'nullable|image|mimes:jpg,png,gif,webp,svg,jpeg';
    }
}
