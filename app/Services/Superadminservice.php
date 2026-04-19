<?php
namespace App\Services;

use App\DTOs\Superadmin\CreatehotelDTO;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class Superadminservice{
        public function create_hotel(CreateHotelDTO $dto): array
    {
        $hotel = Hotel::create($dto->toArray());
        User::create([
            'name'=>$dto->name,
            'email'=>$dto->email,
            'password'=>Hash::make('password123'),
            'role_id'=>2,
            'hotel_id'=>$hotel->id
        ]);
        Cache::tags(['hotels'])->flush();
        return [
            'status'=>200,
            'success' => true,
            'message' => 'Hotel created successfully',
            'data' => $hotel
        ];
    }
        public function update_hotel(CreateHotelDTO $dto, $id): array
    {
        $hotel = Hotel::findOrFail($id);

        $hotel->update($dto->toArray());
        Cache::tags(['hotels'])->flush();
        Cache::tags(['hotels'])->forget("show_hotel.$id");
        return [
            'status'=>200,
            'success' => true,
            'message' => 'Hotel updated successfully',
            'data' => $hotel
        ];
    }
    public function get_hotel($id): array
    {
    try {
        $hotel = Cache::tags(['hotels'])->remember("show_hotel.$id",7600,function () use($id){
            return Hotel::select(
                'id','name','phone','email','address',
                'city','state','country','postal_code'
            )->findOrFail($id);
        });
        return [
            'success' => true,
            'message' => 'Hotel fetched successfully',
            'data' => $hotel,
            'status' => 200
        ];
    } catch (ModelNotFoundException $e) {
        return [
            'success' => false,
            'message' => 'Hotel not found',
            'data' => null,
            'status' => 404
        ];
    }
    }
}
?>