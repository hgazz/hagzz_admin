<?php

namespace App\Http\Requests;

use App\Models\Sport;
use App\Services\TranslatableService;
use Illuminate\Contracts\Validation\ValidationRule;
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name_en' => ['required','regex:/^[a-zA-Z 0-9\s]*$/','string','min:3','max:255'],
            'name_ar' => ['required', 'regex:/^[\p{Arabic}]+$/u','string','min:3','max:255'],
            'icon'=>$this->validateImage(),
        ];

    }

    private function validateImage(): string
    {
        return request()->isMethod('POST') ? 'required|image|mimes:svg' : 'nullable|image|mimes:svg';
    }
}
