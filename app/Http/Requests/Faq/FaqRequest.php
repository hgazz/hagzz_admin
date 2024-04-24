<?php

namespace App\Http\Requests\Faq;

use App\Models\Faq;
use App\Services\TranslatableService;
use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
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
            'question_en' => ['required','regex:/(^([a-zA-Z 0-9 - , & \']+)(\d+)?$)/u','string','min:3','max:255'],
            'question_ar' => ['required', 'regex:/\p{Arabic}/u','string','min:3','max:255'],
            'answer_en' => ['required','regex:/(^([a-zA-Z 0-9 - , & \']+)(\d+)?$)/u','string'],
            'answer_ar' => ['required', 'regex:/\p{Arabic}/u','string'],
        ];
    }
}
