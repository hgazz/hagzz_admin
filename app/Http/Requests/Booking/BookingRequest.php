<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'training_id' => 'required|exists:trainings,id',
            'academy_student_id' => 'nullable|exists:academy_students,id',
            'name' => 'required_without:academy_student_id|nullable|string|max:255',
            'phone' => 'required_without:academy_student_id|nullable|string|max:50',
            'gender' => 'nullable|in:male,female',
            'paid_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'payment_method_other' => 'nullable|string',
        ];
    }
}
