<?php

namespace App\Http\Requests\Booking;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class Createrequest extends FormRequest
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
        $status = [ 'pending',
                'confirmed',
                'seated',
                'completed',
                'cancelled',
                'no_show'];
        return [
            'table_id' => 'nullable|exists:tables,id',
            'pqueue_id' => 'nullable|exists:pqueues,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'party_size' => 'required|integer|min:1',
            'status' => 'required|in:' . implode(',', $status),
            'booking_type' => 'required|in:reservation,walk_in',
            'reservation_at'=>'required_if:booking_type,reservation|nullable|date',   
        ];
    }
   public function messages(): array
{
    return [

        'name.required' => 'Please enter the name.',
        'name.string' => 'Name must be a string.',
        'name.max' => 'Name must not exceed 255 characters.',

        'email.required' => 'Please enter the email.',
        'email.email' => 'Please enter a valid email.',

    
        'phone.required'=>'Please enter the phone number.',
        'phone.regex'=>'Please enter a valid phone number.',

        'party_size.required' => 'Please enter the party size.',
        'party_size.integer' => 'Party size must be a number.',
        'party_size.min' => 'Party size must be at least 1.',

        'status.required' => 'Please select the booking status.',
        'status.in' => 'Please select a valid booking status.',

        'booking_type.required' => 'Please select the booking type.',
        'booking_type.in' => 'Booking type must be either walk_in or reservation.',

        'reservation_at.required_if' => 'Please select the reservation date and time.',
        'reservation_at.date' => 'Please enter a valid reservation date and time.',
    ];
}
}
