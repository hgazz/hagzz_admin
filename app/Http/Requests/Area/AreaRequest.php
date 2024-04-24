<?php

namespace App\Http\Requests\Area;

use App\Models\Area;
use App\Rules\UniqueTranslation;
use App\Services\TranslatableService;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AreaRequest extends FormRequest
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
        return  request()->isMethod('PUT') ? $this->onUpdate() :  $this->onCreate();
    }

    protected function onCreate()
    {
        return  [
            'name_en' => ['required', 'string', 'min:3', 'max:255', new UniqueTranslation('areas', 'name')],
            'name_ar' => ['required','string', 'min:3', 'max:255', new UniqueTranslation('areas', 'name')],
            'city_id' => 'required|exists:cities,id'
        ];
    }

    protected function onUpdate()
    {
        return  [
            'name_en' => ['required', 'string', 'min:3', 'max:255', new UniqueTranslation('areas', 'name', request('id_unique'))],
            'name_ar' => ['required', 'regex:/\p{Arabic}/u','string', 'min:3', 'max:255', new UniqueTranslation('areas', 'name', request('id_unique'))],
            'city_id' => 'required|exists:cities,id'
        ];
    }
}
