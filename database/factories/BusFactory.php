<?php

namespace Database\Factories;

use App\Models\Bus;
use App\Models\Center;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusFactory extends Factory
{
    protected $model = Bus::class;

    public function definition(): array
    {
        return [
            'number' => 'BUS' . fake()->unique()->numberBetween(100, 999),
            'plate_number' => fake()->unique()->bothify('???-####'),
            'model' => fake()->randomElement(['Mercedes 2023', 'Toyota 2022', 'Hyundai 2024']),
            'capacity' => fake()->numberBetween(20, 40),
            'center_id' => Center::factory(),
            'driver_id' => null,
            'current_students' => 0,
            'status' => 'active',
            'notes' => fake()->optional()->sentence()
        ];
    }
}