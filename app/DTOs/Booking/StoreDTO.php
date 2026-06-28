<?php

namespace App\DTOs\Booking;

use App\Http\Requests\Booking\Createrequest;

class StoreDTO
{
    public function __construct(
        public ?int $customer_id,
        public ?string $name,
        public string $phone,
        public string $email,
        public int $party_size,
        public string $status,
        public string $booking_type,
        public ?string $reservation_at,
    ) {}

    public static function fromRequest(Createrequest $request): self
    {
        return new self(
            customer_id: $request->customer_id??null,
            name: $request->name,
            phone: $request->phone,
            email: $request->email,
            party_size: $request->party_size,
            status: $request->status,
            booking_type: $request->booking_type,
            reservation_at: $request->reservation_at??null,
        );
    }
}