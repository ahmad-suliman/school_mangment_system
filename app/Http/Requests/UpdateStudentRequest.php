<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rule = [
            //user
             'name' => 'required|string|max:255',
            //student
            'class_id' => 'required|exists:classes,id',
            'phone' => 'required|string|max:20',
            'birth_date'=>'required|date',
            'address' => 'required|nullable|string|max:500',
            'guardian_name' => 'required|nullable|string|max:255',
            'guardian_phone' => 'required|nullable|string|max:255',
        ];
        return $rule;
    }
}
