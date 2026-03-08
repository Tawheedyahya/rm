<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Createhotelrequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'name' => 'required|string|max:255',

            'email' => 'required|email|unique:hotels,email,' . $id,

            'phone' => 'required|unique:hotels,phone,' . $id,

            'address' => 'required|string|max:500',

            'city' => 'required|string|max:100',

            'state' => 'required|string|max:100',

            'country' => 'required|string|max:100',

            'postal_code' => 'required|string|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Hotel name is required.',

            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered with another hotel.',

            'phone.required' => 'Phone number is required.',
            'phone.unique' => 'This phone number is already used.',

            'address.required' => 'Address is required.',

            'city.required' => 'City is required.',

            'state.required' => 'State is required.',

            'country.required' => 'Country is required.',

            'postal_code.required' => 'Postal code is required.',
        ];
    }
}