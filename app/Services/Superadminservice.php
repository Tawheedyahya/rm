<?php
namespace App\Services;

use App\DTOs\Superadmin\CreatehotelDTO;
use App\Models\Hotel;
use Illuminate\Support\Facades\Cache;

class Superadminservice{
        public function create_hotel(CreateHotelDTO $dto): array
    {
        $hotel = Hotel::create($dto->toArray());
        Cache::tags('hotels')->flush();
        return [
            'status' => true,
            'message' => 'Hotel created successfully',
            'data' => $hotel
        ];
    }
        public function update_hotel(CreateHotelDTO $dto, $id): array
    {
        $hotel = Hotel::findOrFail($id);

        $hotel->update($dto->toArray());
        Cache::tags('hotels')->flush();
        return [
            'status' => true,
            'message' => 'Hotel updated successfully',
            'data' => $hotel
        ];
    }
}
?>