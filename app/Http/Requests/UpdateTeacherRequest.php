<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherRequest extends FormRequest
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
            // Users table
            'name' => 'required|string|max:255',

            // Teachers table

            'phone' => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'hire_date' => 'nullable|date',
            'address' => 'nullable|string|max:500',
        ];
        return $rule;
    }
}
