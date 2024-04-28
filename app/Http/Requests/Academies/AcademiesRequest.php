<?php

namespace App\Http\Requests\Academies;

use App\Rules\UniqueTranslation;
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
        return request()->isMethod('PUT') ? $this->onUpdate() : $this->onCreate();
    }

    public function onCreate()
    {
        return [
            'commercial_name_en' => ['required', 'string', 'regex:/(^([a-zA-Z - , & \']+)(\d+)?$)/u', 'min:3', 'max:255', new UniqueTranslation('academies', 'commercial_name')],
            'commercial_name_ar' => ['required', 'regex:/\p{Arabic}/u', 'string', 'min:3', 'max:255', new UniqueTranslation('academies', 'commercial_name')],
            'email'=>'required|string|email',
            'phone'=>'required|string|unique:academies,phone',
            'password'=> $this->validatePassword(),
            'role'=>'required',
            'trade_license_number'=>'nullable|numeric',
            'trade_license_expire_date'=>'nullable|date|after_or_equal:'. now()->toDateString(),
            'tax_number'=>'nullable|numeric',
            'national_id_number'=>'nullable|string',
            'address'=>'nullable|string:min:3|max:255',
            'contract_number'=>'required|string',
            'account_manager'=>'required|string|min:3|max:255',
            'sport_id'=>'required|array',
            'sport_id.*'=>'required|exists:sports,id',
            'branch_to'=>'nullable|exists:academies,id',
            'country_id'=>'required|exists:countries,id',
            'city_id'=>'required|exists:cities,id',
            'area_id'=>'required|exists:areas,id',
        ];
    }

    public function onUpdate()
    {
        return [
            'commercial_name_en' => ['required', 'string', 'min:3', 'max:255', new UniqueTranslation('academies', 'commercial_name', request('id_unique'))],
            'commercial_name_ar' => ['required', 'regex:/\p{Arabic}/u', 'string', 'min:3', 'max:255', new UniqueTranslation('academies', 'commercial_name', request('id_unique'))],
            'email'=>'required|string|email',
            'phone'=> 'nullable|string|numeric|unique:academies,phone,'.request('id_unique'),
            'role'=>'required',
            'trade_license_number'=>'nullable|numeric',
            'trade_license_expire_date'=>'nullable|date|after_or_equal:'. now()->toDateString(),
            'tax_number'=>'nullable|numeric',
            'national_id_number'=>'nullable|string',
            'address'=>'nullable|string|min:3|max:255',
            'contract_number'=>'required|string',
            'account_manager'=>'required|string|min:3|max:255',
            'sport_id'=>'required|array',
            'sport_id.*'=>'required|exists:sports,id',
            'branch_to'=>'nullable|exists:academies,id',
            'country_id'=>'required|exists:countries,id',
            'city_id'=>'required|exists:cities,id',
            'area_id'=>'required|exists:areas,id',
        ];
    }
    private function validatePassword(): string
    {
        return request()->isMethod('POST') ? 'required|string|min:6' : 'nullable|string|min:6';
    }

}
