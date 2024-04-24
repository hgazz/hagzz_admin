<?php

namespace App\Http\Requests\Country;

use App\Models\Country;
use App\Rules\UniqueTranslation;
use App\Services\TranslatableService;
use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
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
        return  request()->isMethod('PUT') ? $this->onUpdate() :  $this->onCreate();
    }

    protected function onCreate(): array
    {
        return [
            'name_en' => ['required', 'string', 'min:3', 'max:255', new UniqueTranslation('countries', 'name')],
            'name_ar' => ['required', 'string', 'min:3', 'max:255', new UniqueTranslation('countries', 'name')],
        ];
    }

    protected function onUpdate(): array
    {
        return [
            'name_en' => ['required', 'string', 'min:3', 'max:255', new UniqueTranslation('countries', 'name', request('id_unique'))],
            'name_ar' => ['required', 'regex:/\p{Arabic}/u', 'string', 'min:3', 'max:255', new UniqueTranslation('countries', 'name', request('id_unique'))],
        ];
    }
}
