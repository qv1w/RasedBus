<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Center;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'student_id' => 'STD' . date('y') . fake()->unique()->numberBetween(1000, 9999),
            'name' => fake('ar_SA')->name(),
            'national_id' => fake()->unique()->numerify('##########'),
            'birthdate' => fake()->date('Y-m-d', '-10 years'),
            'email' => fake()->unique()->safeEmail(),
            'mobile' => '05' . fake()->numerify('########'),
            'guardian_name' => fake('ar_SA')->name(),
            'guardian_mobile' => '05' . fake()->numerify('########'),
            'address' => fake('ar_SA')->address(),
            'latitude' => fake()->latitude(26.0, 27.0),
            'longitude' => fake()->longitude(44.0, 45.0),
            'preferred_schedule' => fake()->randomElement(['صباحية', 'مسائية']),
            'center' => Center::factory(),
            'status' => 'pending',
            'registration_date' => now(),
            'total_required' => 500.00,
            'total_paid' => 0.00
        ];
    }
}