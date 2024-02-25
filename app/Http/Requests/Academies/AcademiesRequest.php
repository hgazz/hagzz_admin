<?php

namespace App\Http\Requests\Academies;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AcademiesRequest extends FormRequest
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
            'first_name'=>'required|string|min:3|max:255',
            'last_name'=>'required|string|min:3|max:255',
            'email'=>'required|string|email',
            'full_name_arabic'=>'nullable|string|min:3|max:255|regex:/\p{Arabic}/u',
            'phone'=>'required|string|min:7',
            'password'=> $this->validatePassword(),
            'role'=>'required',
            'commercial_name'=>'required|string|min:3|max:255',
            'trade_license_number'=>'nullable|numeric',
            'trade_license_expire_date'=>'nullable|date|after_or_equal:'. now()->toDateString(),
            'tax_number'=>'nullable|numeric',
            'national_id_number'=>'nullable|string',
            'address'=>'nullable|string:min:3|max:255',
            'contract_number'=>'required|string',
            'account_manager'=>'required|string|min:3|max:255',
        ];
    }

    private function validatePassword(): string
    {
        return request()->isMethod('POST') ? 'required|string|min:6' : 'nullable|string|min:6';
    }
}
