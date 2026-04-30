<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAttendanceRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'class_id'   => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'date'       => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:present,absent,late',
        ];

        // Only admin needs teacher_id
        if (auth()->user()->hasRole('admin')) {
            $rules['teacher_id'] = 'required|exists:teachers,id';
        }

        return $rules;
    }
}
