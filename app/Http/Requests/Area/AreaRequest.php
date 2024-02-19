<?php

namespace App\Http\Requests\Area;

use App\Models\Area;
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
        $rule = [
            'city_id' => 'required|exists:cities,id'
        ];
        return array_merge($rule, TranslatableService::validateTranslatableFields(Area::$translatableColumns));
    }
}
