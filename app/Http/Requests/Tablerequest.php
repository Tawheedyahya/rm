<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class Tablerequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
       
            $user = auth('api')->user();

            return $user &&
                    $user->role &&
                    in_array($user->role->name, ['hotel_admin', 'waiter']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'table_number'=>'required|string|min:1',
            'capacity'=>'required|integer|min:1',
            'description'=>'nullable|string',
        ];
    }
    public function messages(): array
    {
        return [
            'table_number.required'=>'Table number is required',
            'table_number.string'=>'Table number must be string',
            'capacity.required'=>'Capacity is required',
            'capacity.integer'=>'capacity must be a number',
            'capacity.min'=>'Capacity must be atleast 1'
        ];
    }
    
}
