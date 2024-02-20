<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'key' => 'required|string|min:3|max:255',
            'type' =>'required|string|min:3|max:255',
            'value' => $this->checkValue(),
        ];
    }

    private function checkValue(){
        if (request('type') =='text'){
            return 'required|string|min:3|max:255';
        }else{
            if (request()->method() == 'POST'){
                return 'required|image|mimes:jpg,png,gif,webp,svg,jpeg';
            }else{
                return 'nullable|image|mimes:jpg,png,gif,webp,svg,jpeg';
            }
        }
    }
}
