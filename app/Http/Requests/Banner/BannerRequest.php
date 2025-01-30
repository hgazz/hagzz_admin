<?php

namespace App\Http\Requests\Banner;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
            'image' => $this->checkImage(),
            'status' => 'required|in:active,inactive',
            'country' => 'required|in:eg,qa'
        ];
    }

    public function checkImage(): string
    {
       return request()->isMethod('PUT') ? 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048' : 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
    }
}
