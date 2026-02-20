<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class Registerrequest extends FormRequest
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
        $id=$this->route('id');
        return [
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email,'.$id,
            "password"=>'required|min:8|confirmed'
        ];
    }
        public function messages(): array
    {
        return [
            'name.required'      => 'Name is required.',
            'name.string'        => 'Name must be a valid string.',
            'name.max'           => 'Name may not be greater than 255 characters.',

            'email.required'     => 'Email is required.',
            'email.email'        => 'Email must be a valid email address.',
            'email.unique'       => 'This email is already registered.',

            'password.required'  => 'Password is required.',
            'password.min'       => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Force JSON Response (Prevent 302 Redirect)
    |--------------------------------------------------------------------------
    */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status'  => false,
                'message' => 'Validation failed.',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }
}
