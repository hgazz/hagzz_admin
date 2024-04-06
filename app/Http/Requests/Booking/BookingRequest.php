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
            'phone' =>'required|string',
            'gender' =>'required|in:male,female',
            'country_id' =>'required|exists:countries,id',
            'city_id' =>'required|exists:cities,id',
            'area_id' =>'required|exists:areas,id'
        ];
    }
}
