<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'key' => 'required',
            'type' => 'required|in:text,textarea,image',
            'text_value' => 'required_if:type,textarea',
            'value' => 'required_if:type,text',
            'image_value' => 'required_if:type,image|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    protected function checkImage()
    {
//        if (request()->type == 'image'){
            if(request()->isMethod('POST')){
                return 'required,image|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            }else{
                return 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            }
//        }
    }


}
