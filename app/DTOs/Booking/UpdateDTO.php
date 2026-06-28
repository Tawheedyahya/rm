<?php

namespace App\DTOs\Booking;

use App\Http\Requests\Booking\Updaterequest;

class UpdateDTO
{
    public function __construct(
        public ?string $status,
        public ?int $party_size,
        public ?string $reservation_at,
        public ?int $table_id,
    ) {}
    public static function fromRequest(Updaterequest $request): self
    {
        return new self(
            status: $request->status,
            party_size: $request->party_size,
            reservation_at: $request->reservation_at??null,
            table_id: $request->table_id??null,
        );
    }
    
}