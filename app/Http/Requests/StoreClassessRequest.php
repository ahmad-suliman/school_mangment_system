<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreClassessRequest extends FormRequest
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
            'class_name' => 'required|string|max:255',
            'section' => 'nullable|string|max:50',
            'academic_year' => ['required', 'regex:/^\d{4}-\d{4}$/'],
        ];
        return $rules;
    }
}
