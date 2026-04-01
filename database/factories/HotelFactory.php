<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hotel>
 */
class HotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
             'name'        => substr($this->faker->company(), 0, 150),
            'email'       => $this->faker->unique()->companyEmail(),
            'phone'       => substr($this->faker->phoneNumber(), 0, 9),
            'address'     => substr($this->faker->streetAddress(), 0, 255),
            'city'        => substr($this->faker->city(), 0, 50),
            'state'       => substr($this->faker->state(), 0, 50),
            'country'     => substr($this->faker->country(), 0, 50),
            'postal_code' => substr($this->faker->postcode(), 0, 10),
        ];
    }
}
