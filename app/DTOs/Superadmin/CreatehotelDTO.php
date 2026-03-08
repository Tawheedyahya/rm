<?php

namespace App\DTOs\Superadmin;

use Illuminate\Http\Request;

class CreatehotelDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $phone,
        public ?string $address,
        public ?string $city,
        public ?string $state,
        public ?string $country,
        public ?string $postal_code
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->name,
            email: $request->email,
            phone: $request->phone,
            address: $request->address,
            city: $request->city,
            state: $request->state,
            country: $request->country,
            postal_code: $request->postal_code
        );
    }
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'postal_code' => $this->postal_code,
        ];
    }
}