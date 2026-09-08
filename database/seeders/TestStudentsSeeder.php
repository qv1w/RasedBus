<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Center;

class TestStudentsSeeder extends Seeder
{
    public function run(): void
    {
        $girlsNames = ['فاطمة', 'عائشة', 'مريم', 'نورة', 'سارة', 'هند', 'ريم', 'دانة', 'لمى', 'رهف', 'جود', 'سلمى', 'هيا', 'نوف', 'أمل', 'شهد', 'رغد', 'غادة', 'حصة', 'بدور'];
        $boysNames = ['محمد', 'عبدالله', 'عبدالرحمن', 'سعود', 'فهد', 'خالد', 'أحمد', 'علي', 'عمر', 'يوسف', 'إبراهيم', 'سلطان', 'ناصر', 'تركي', 'فيصل', 'سلمان', 'نواف', 'مشاري', 'ماجد', 'راشد'];
        $lastNames = ['العتيبي', 'القحطاني', 'الشمري', 'الدوسري', 'المطيري', 'الحربي', 'السبيعي', 'الزهراني', 'الغامدي', 'العنزي', 'الرشيدي', 'الجهني', 'المالكي', 'الشهري'];

        $centers = Center::where('status', 'active')->get();

        if ($centers->isEmpty()) {
            $this->command->error('لا توجد مراكز نشطة! أضف مراكز أولاً.');
            return;
        }

        $this->command->info('جاري إضافة 100 طالب/ة...');

        $year = date('Y');
        $last = Student::where('student_id', 'like', "STU-{$year}-%")->orderBy('id', 'desc')->first();
        $num = 1;
        if ($last && preg_match('/STU-\d{4}-(\d+)/', $last->student_id, $m)) {
            $num = intval($m[1]) + 1;
        }

        $maleCount = 0;
        $femaleCount = 0;

        for ($i = 0; $i < 100; $i++) {
            $center = $centers->random();
            $gender = $center->gender == 'بنات' ? 'أنثى' : 'ذكر';
            
            if ($gender == 'أنثى') {
                $femaleCount++;
                $first = $girlsNames[array_rand($girlsNames)];
            } else {
                $maleCount++;
                $first = $boysNames[array_rand($boysNames)];
            }
            
            $father = $boysNames[array_rand($boysNames)];
            $family = $lastNames[array_rand($lastNames)];

            do {
                $nid = '1' . str_pad(rand(0, 999999999), 9, '0', STR_PAD_LEFT);
            } while (Student::where('national_id', $nid)->exists());

            Student::create([
                'student_id' => 'STU-' . $year . '-' . str_pad($num++, 6, '0', STR_PAD_LEFT),
                'name' => $first . ' ' . $father . ' ' . $family,
                'gender' => $gender,
                'national_id' => $nid,
                'birthdate' => date('Y-m-d', strtotime('-' . rand(6, 20) . ' years')),
                'mobile' => '05' . str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT),
                'guardian_name' => $father . ' ' . $family,
                'guardian_mobile' => '05' . str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT),
                'preferred_schedule' => rand(0, 1) ? 'صباحية' : 'مسائية',
                'center_id' => $center->id,
                'status' => rand(1, 10) <= 7 ? 'approved' : 'pending',
                'latitude' => 26.2872 + rand(-500, 500) / 10000,
                'longitude' => 44.8036 + rand(-500, 500) / 10000,
                'total_required' => $center->transport_fee ?? 500,
            ]);
        }

        $this->command->info("✅ تم إضافة 100 طالب/ة بنجاح!");
        $this->command->info("👨 بنين: {$maleCount}");
        $this->command->info("👩 بنات: {$femaleCount}");
    }
}