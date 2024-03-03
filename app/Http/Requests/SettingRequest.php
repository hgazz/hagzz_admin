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
            'type' => 'required|string',
            'text_value' => 'required_if:type,textarea',
            'image_value' => $this->checkImage(),
            'value' => 'required_if:type,text',
        ];
    }

    protected function checkImage()
    {
        if (request()->type == 'image'){
            if(request()->isMethod('POST')){
                return 'required,image|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            }else{
                return 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            }
        }
    }

}
