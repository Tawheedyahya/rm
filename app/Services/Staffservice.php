<?php
namespace App\Services;

use App\DTOs\Hoteladmin\RegisterDTO;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class Staffservice{
    public function store(RegisterDTO $registerDTO){
        $user = User::create($registerDTO->toArray());
        $user->load('role');

        Cache::tags(['staffs'])->forget("staffs_{$user->hotel_id}");

        return [
            'data' => $user,
            'success' => true,
            'status' => 201,
            'message' => $user->role->name . ' created'
        ];
    }

    public function index()
    {
        $hotelId = auth('api')->user()->hotel_id;

        $staffs = Cache::tags(['staffs'])->remember(
            "staffs_{$hotelId}",
            now()->addHour(),
            function () use ($hotelId) {
                return User::with('role')
                    ->where('hotel_id', $hotelId)
                    ->whereHas('role', function ($q) {
                        $q->where('name', '!=', 'hotel_admin');
                    })
                    ->get();
            }
        );

        return [
            'data' => $staffs,
            'success' => true,
            'status' => 200,
            'message' => 'staffs retrieved'
        ];
    }
}