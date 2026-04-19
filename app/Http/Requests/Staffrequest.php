<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Staffrequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role_id == 2;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id=$this->route('id');
        return [
            'name' => 'required|string|max:255',
            'email' => ['required','email',Rule::unique('users')->ignore($id)],
            'password' => 'required|string|min:6',
            'role_id' => 'required|exists:roles,id',
        ];
    }
        public function messages(): array
    {
        return [
            'name.required' => 'Staff name is required.',
            'name.string' => 'Name must be a valid string.',
            'name.max' => 'Name cannot exceed 255 characters.',

            'email.required' => 'Email is required.',
            'email.email' => 'Enter a valid email address.',
            'email.unique' => 'This email is already registered.',

            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',

            'role_id.required' => 'Role is required.',
            'role_id.exists' => 'Selected role is invalid.',
        ];
    }
}
