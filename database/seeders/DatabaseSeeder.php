<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // Hotel::factory(10000)->create();

        User::factory()->create([
            'name' => 'yahi',
            'email' => 'y@gmail.com',
            'password'=>Hash::make('yahiyahi'),
            'role_id'=>1,
        ]);
    }
}
