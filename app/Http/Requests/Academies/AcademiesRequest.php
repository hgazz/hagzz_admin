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
            'commercial_name_en' => ['required', 'string', 'min:3', 'max:255'],
            'commercial_name_ar' => ['required', 'string', 'min:3', 'max:255'],
            'first_name' => ['required', 'string', 'min:3', 'max:255'],
            'last_name' => ['required', 'string', 'min:3', 'max:255'],
            'app_name_en' => ['required', 'string', 'min:3', 'max:255'],
            'app_name_ar' => ['required', 'string', 'min:3', 'max:255'],
            'facebook' => ['nullable', 'string','min:3', 'url'],
            'instagram' => ['nullable', 'string','min:3', 'url'],
            'website' => ['nullable', 'string','min:3', 'url'],
            'linkedin' => ['nullable', 'string','min:3'],
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'commission_percentage'=>['required','numeric'],
            'email'=>'required|string|email|unique:academies,email',
            'phone'=>'required|string|unique:academies,phone',
            'password'=> $this->validatePassword(),
            'role'=>'required|in:manager,owner,partner',
            'trade_license_number'=>'nullable|numeric',
            'trade_license_expire_date'=>'nullable|date|after_or_equal:'. now()->toDateString(),
            'tax_number'=>'nullable|numeric',
            'contract_number'=>'required|string',
            'account_manager'=>'required|string|min:3|max:255',
            'business_type' => 'required|in:academy,venue,hybrid',
            'sport_id' => 'required_unless:business_type,venue|nullable|array',
            'sport_id.*'=>'exists:sports,id',
            'saas_plan_id' => 'nullable|exists:saas_plans,id',
            'billing_cycle' => 'required_with:saas_plan_id|nullable|in:monthly,annual',
            'custom_price' => 'nullable|numeric|min:0',
            'subscription_starts_at' => 'required_with:saas_plan_id|nullable|date',
            'subscription_ends_at' => 'nullable|date|after:subscription_starts_at',
            'trial_ends_at' => 'nullable|date|after_or_equal:subscription_starts_at',
            'branch_to'=>'nullable|exists:academies,id',
            'bank_account_type'=>'required|string|min:3|max:255',
            'bank_name'=>'required|string|min:3|max:255',
            'beneficiary_name'=>'required|string|min:3|max:255',
            'bank_account_number'=>'required|numeric',
            'start_date'=>'required|date|after_or_equal:'. now()->toDateString(),
            'end_date'=>'required|date|after:start_date',
            'contract_date'=>'required|date|after_or_equal:'. now()->toDateString(),
            'image'=>'nullable|image|mimes:png,jpg,jpeg,svg,webp',
            'status'=>'required|in:active,inactive,pending'
        ];
    }

    public function onUpdate()
    {
        return [
            'commercial_name_en' => ['required', 'string', 'min:3', 'max:255'],
            'commercial_name_ar' => ['required', 'string', 'min:3', 'max:255'],
            'first_name' => ['required', 'string', 'min:3', 'max:255'],
            'last_name' => ['required', 'string', 'min:3', 'max:255'],
            'app_name_en' => ['required', 'string', 'min:3', 'max:255'],
            'app_name_ar' => ['required', 'string', 'min:3', 'max:255'],
            'facebook' => ['nullable', 'string','min:3', 'url'],
            'instagram' => ['nullable', 'string','min:3', 'url'],
            'website' => ['nullable', 'string','min:3', 'url'],
            'linkedin' => ['nullable', 'string','min:3', 'url'],
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'commission_percentage'=>['required','numeric'],
            'email'=>'required|string|email|unique:academies,phone,'.request('id_unique'),
            'phone'=> 'nullable|string|numeric|unique:academies,phone,'.request('id_unique'),
            'password'=> $this->validatePassword(),
            'role'=>'required|in:manager,owner,partner',
            'trade_license_number'=>'nullable|numeric',
            'trade_license_expire_date'=>'nullable|date|after_or_equal:'. now()->toDateString(),
            'tax_number'=>'nullable|numeric',
            'contract_number'=>'required|string',
            'account_manager'=>'required|string|min:3|max:255',
            'business_type' => 'required|in:academy,venue,hybrid',
            'sport_id' => 'required_unless:business_type,venue|nullable|array',
            'sport_id.*'=>'exists:sports,id',
            'saas_plan_id' => 'nullable|exists:saas_plans,id',
            'billing_cycle' => 'required_with:saas_plan_id|nullable|in:monthly,annual',
            'custom_price' => 'nullable|numeric|min:0',
            'subscription_starts_at' => 'required_with:saas_plan_id|nullable|date',
            'subscription_ends_at' => 'nullable|date|after:subscription_starts_at',
            'trial_ends_at' => 'nullable|date|after_or_equal:subscription_starts_at',
            'branch_to'=>'nullable|exists:academies,id',
            'bank_account_type'=>'required|string|min:3|max:255',
            'bank_name'=>'required|string|min:3|max:255',
            'beneficiary_name'=>'required|string|min:3|max:255',
            'bank_account_number'=>'required|numeric',
            'start_date'=>'required|date|before:end_date',
            'end_date'=>'required|date|after:start_date',
            'contract_date'=>'required|date',
            'image'=>'nullable|image|mimes:png,jpg,jpeg,svg,webp',
            'status'=>'required|in:active,inactive,pending'
        ];
    }
    private function validatePassword(): string
    {
        return request()->isMethod('POST') ? 'required|string|min:6' : 'nullable|string|min:6';
    }

}
