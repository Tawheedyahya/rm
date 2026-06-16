<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Hotel::factory()->count(10)->create()->each(function ($hotel) {
            User::factory()->create([
                'hotel_id' => $hotel->id,
                'role_id' => 2,
            ]);
        });
    }
}
