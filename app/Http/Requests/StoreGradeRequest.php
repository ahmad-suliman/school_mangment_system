<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreGradeRequest extends FormRequest
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
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'marks'      => 'required|numeric|min:0|max:100',
        ];

        // Only admin must send teacher_id
        if (auth()->user()->hasRole('admin')) {
            $rules['teacher_id'] = 'required|exists:teachers,id';
        }

        return $rules;
    }
}
