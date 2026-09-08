<?php

namespace Database\Factories;

use App\Models\Center;
use Illuminate\Database\Eloquent\Factories\Factory;

class CenterFactory extends Factory
{
    protected $model = Center::class;

    public function definition(): array
    {
        return [
            'center_name' => 'دار ' . fake('ar_SA')->word(),
            'address' => fake('ar_SA')->address(),
            'detailed_address' => fake('ar_SA')->streetAddress(),
            'latitude' => fake()->latitude(26.0, 27.0),
            'longitude' => fake()->longitude(44.0, 45.0),
            'status' => 'active',
            'morning_available' => true,
            'morning_start' => '08:00:00',
            'morning_end' => '11:00:00',
            'evening_available' => true,
            'evening_start' => '16:00:00',
            'evening_end' => '19:00:00',
            'current_students' => 0,
            'bus_count' => 0
        ];
    }
}