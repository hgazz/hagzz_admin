<?php

namespace App\Http\Requests\City;

use App\Models\City;
use App\Rules\UniqueTranslation;
use App\Services\TranslatableService;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
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
      return  [
            'name_en' => ['required', 'string', 'min:3', 'max:255', new UniqueTranslation('cities', 'name')],
            'name_ar' => ['required', 'string', 'min:3', 'max:255', new UniqueTranslation('cities', 'name')],
            'country_id' => 'required|exists:countries,id',
      ];
    }

    protected function onCreate()
    {
        return  request()->isMethod('PUT') ? $this->onUpdate() :  $this->onCreate();
    }

    protected function onUpdate()
    {
        return  [
            'name_en' => ['required', 'string', 'min:3', 'max:255', new UniqueTranslation('cities', 'name', request('id_unique'))],
            'name_ar' => ['required', 'string', 'min:3', 'max:255', new UniqueTranslation('cities', 'name', request('id_unique'))],
            'country_id' => 'required|exists:countries,id',
        ];
    }
}
