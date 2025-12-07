<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'room_number' => $this->faker->unique()->numerify('Room ###'),
            'type' => $this->faker->randomElement(['Single', 'Double', 'Suite']),
            'price' => $this->faker->randomFloat(2, 100, 500),
            'is_available' => $this->faker->boolean(90), // 90% chance of being available
        ];
    }
}
