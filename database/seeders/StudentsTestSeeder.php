<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StudentsTestSeeder extends Seeder
{
    public function run(): void
    {
        $students = [];

        for ($i = 1; $i <= 10; $i++) {
            $students[] = [
                'student_id' => 'STD' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'name' => 'طالب اختبار ' . $i,
                'gender' => 'أنثى',
                'national_id' => '10' . rand(10000000, 99999999),
                'birthdate' => '2015-01-01',
                'email' => 'student' . $i . '@test.com',
                'password' => bcrypt('123456'),
                'mobile' => '05' . rand(10000000, 99999999),

                'guardian_name' => 'ولي أمر ' . $i,
                'guardian_mobile' => '05' . rand(10000000, 99999999),
                'guardian_relation' => 'أب',

                // جارالله + الدريويش
                'address' => $i <= 5 ? 'حي جارالله' : 'حي الدريويش',
                'latitude' => $i <= 5 ? 26.299500 : 26.305800,
                'longitude' => $i <= 5 ? 44.814200 : 44.820100,

                'center_id' => match (true) {
    $i <= 4  => 1, // دار جارالله
    $i <= 7  => 2, // دار الدريويش
    $i <= 9  => 3, // مركز
    default  => 4, // برنامج
},
                'preferred_schedule' => 'صباحية',

                'status' => 'approved',

                'assigned_bus_id' => null,
                'pickup_point' => 'نقطة تجريبية',
                'pickup_time' => '06:30',

                'total_paid' => 0,
                'total_required' => 200,

                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('students')->insert($students);
    }
}
