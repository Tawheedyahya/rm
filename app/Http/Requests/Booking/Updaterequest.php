<?php

namespace App\Http\Requests\Booking;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class Updaterequest extends FormRequest
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
            'status' => 'required|in:' . implode(',', $status),
            'party_size'=>'nullable|integer|min:1',
            'table_id'=>'nullable|exists:tables,id',
            'reservation_at'=>'nullable|date',
        ];
    }
}
