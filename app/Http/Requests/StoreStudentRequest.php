<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            //user table
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'status' => 'required|in:0,1',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            // Student table
            'student_id' => 'required|string|max:50|unique:students,student_id',
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
