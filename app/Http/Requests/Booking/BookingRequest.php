<?php

namespace App\Http\Requests\Booking;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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
            'training_id' => 'required|exists:trainings,id',
            'price' =>'required|numeric',
            'name' =>'required|string',
            'country_code' =>'required|regex:/^\+?[0-9]+$/',
            'phone' =>'required|string|unique:users,phone',
            'gender' =>'required|in:male,female',
            'country_id' =>'required|string|exists:countries,id',
            'city_id' =>'required|string|exists:cities,id',
            'area_id' =>'required|string|exists:areas,id',
            'birth_date' =>'required|date'
        ];
    }
}
