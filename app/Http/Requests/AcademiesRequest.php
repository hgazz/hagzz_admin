<?php

namespace App\Http\Requests;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name'=>'required|string|min:3|max:255',
            'last_name'=>'required|string|min:3|max:255',
            'email'=>'required|string|email',
            'full_name_arabic'=>'required|string|min:3|max:3|regex:/^[\p{L}\s\p{P}]+$/u',

        ];
    }
}
