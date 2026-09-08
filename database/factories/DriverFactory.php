<?php

namespace Database\Factories;

use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

class DriverFactory extends Factory
{
    protected $model = Driver::class;

    public function definition(): array
    {
        return [
            'driver_id' => 'DRV' . fake()->unique()->numberBetween(1000, 9999),
            'name' => fake('ar_SA')->name(),
            'mobile' => '05' . fake()->numerify('########'),
            'email' => fake()->unique()->safeEmail(),
            'address' => fake('ar_SA')->address(),
            'license_number' => fake()->unique()->bothify('L-########'),
            'license_type' => 'عام',
            'status' => 'active',
            'experience_years' => fake()->numberBetween(1, 20),
            'emergency_contact' => fake('ar_SA')->name(),
            'emergency_phone' => '05' . fake()->numerify('########'),
            'hire_date' => fake()->date(),
            'salary' => fake()->numberBetween(3000, 8000)
        ];
    }
}