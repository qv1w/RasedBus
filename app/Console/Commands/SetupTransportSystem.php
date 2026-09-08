<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use App\Models\Center;
use App\Models\Driver;
use App\Models\Bus;
use App\Models\Admin;

class SetupTransportSystem extends Command
{
    protected $signature = 'setup:transport-system {--reset : Reset existing data}';
    protected $description = 'إعداد نظام النقل المتكامل للباصات والسائقين والمراكز';

    public function handle()
    {
        $this->info('🚀 بدء إعداد نظام النقل المتكامل...');
        
        try {
            // خطوة 1: إعداد قاعدة البيانات
            $this->setupDatabase();
            
            // خطوة 2: إنشاء المراكز
            $this->setupCenters();
            
            // خطوة 3: إنشاء السائقين التجريبيين
            $this->setupDrivers();
            
            // خطوة 4: إنشاء الباصات التجريبية
            $this->setupBuses();
            
            // خطوة 5: إنشاء حساب الإدارة
            $this->setupAdmin();
            
            // خطوة 6: التحقق من النظام
            $this->verifySystem();
            
            $this->info('✅ تم إعداد النظام بنجاح!');
            $this->displaySystemInfo();
            
        } catch (\Exception $e) {
            $this->error('❌ حدث خطأ أثناء الإعداد: ' . $e->getMessage());
            $this->line('تفاصيل الخطأ: ' . $e->getTraceAsString());
            return 1;
        }
        
        return 0;
    }

    private function setupDatabase()
    {
        $this->info('📊 إعداد قاعدة البيانات...');
        
        if ($this->option('reset')) {
            $this->warn('🔄 إعادة تعيين قاعدة البيانات...');
            Artisan::call('migrate:fresh', ['--force' => true]);
        } else {
            Artisan::call('migrate', ['--force' => true]);
        }
        
        $this->line('✓ تم إعداد قاعدة البيانات');
    }

    private function setupCenters()
    {
        $this->info('🏢 إعداد المراكز...');
        
        if (Center::count() == 0) {
            Artisan::call('db:seed', ['--class' => 'CenterSeeder']);
            $this->line('✓ تم إنشاء ' . Center::count() . ' مراكز');
        } else {
            $this->line('ℹ️  المراكز موجودة مسبقاً (' . Center::count() . ' مراكز)');
        }
    }

    private function setupDrivers()
    {
        $this->info('👨‍💼 إعداد السائقين التجريبيين...');
        
        $driverData = [
            [
                'name' => 'أحمد محمد السالم',
                'mobile' => '0501234567',
                'email' => 'ahmed.salem@example.com',
                'license_number' => 'DL123456789',
                'license_type' => 'ثقيل',
                'status' => 'active',
                'experience_years' => 8,
                'center_id' => 'دار الفوزان',
                'hire_date' => now()->subYears(2),
                'salary' => 4500,
                'notes' => 'سائق ذو خبرة عالية في قيادة الباصات'
            ],
            [
                'name' => 'محمد علي الأحمد',
                'mobile' => '0507654321',
                'email' => 'mohammed.ali@example.com',
                'license_number' => 'DL987654321',
                'license_type' => 'ثقيل',
                'status' => 'active',
                'experience_years' => 5,
                'center_id' => 'دار البصائر',
                'hire_date' => now()->subYear(),
                'salary' => 4000,
                'emergency_contact' => 'علي الأحمد',
                'emergency_phone' => '0509876543'
            ],
            [
                'name' => 'خالد عبدالرحمن المطيري',
                'mobile' => '0551234567',
                'license_number' => 'DL456789123',
                'license_type' => 'عام',
                'status' => 'active',
                'experience_years' => 3,
                'center_id' => 'دار الفرقان',
                'hire_date' => now()->subMonths(8),
                'salary' => 3800
            ],
            [
                'name' => 'سالم فهد الزهراني',
                'mobile' => '0559876543',
                'license_number' => 'DL789123456',
                'license_type' => 'ثقيل',
                'status' => 'active',
                'experience_years' => 10,
                'center_id' => 'دار القرآن',
                'hire_date' => now()->subYears(3),
                'salary' => 5000,
                'notes' => 'سائق مخضرم وموثوق'
            ],
            [
                'name' => 'عبدالله سعد القحطاني',
                'mobile' => '0541234567',
                'status' => 'active',
                'experience_years' => 2,
                'hire_date' => now()->subMonths(6),
                'salary' => 3500,
                'notes' => 'سائق جديد - تحت التدريب'
            ]
        ];

        $createdCount = 0;
        foreach ($driverData as $data) {
            // توليد driver_id تلقائياً
            $lastDriver = Driver::orderBy('id', 'desc')->first();
            $nextNumber = $lastDriver ? ($lastDriver->id + 1) : 1;
            $data['driver_id'] = 'DRV-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            
            // التحقق من عدم وجود رقم الجوال
            if (!Driver::where('mobile', $data['mobile'])->exists()) {
                Driver::create($data);
                $createdCount++;
            }
        }
        
        $this->line("✓ تم إنشاء {$createdCount} سائقين جدد (الإجمالي: " . Driver::count() . ")");
    }

    private function setupBuses()
    {
        $this->info('🚌 إعداد الباصات التجريبية...');
        
        $centers = Center::where('status', 'active')->get();
        $drivers = Driver::where('status', 'active')->get();
        
        $busData = [
            [
                'number' => 'BUS-001',
                'plate_number' => 'ر س س 1234',
                'model' => 'هيونداي كاونتي 2023',
                'capacity' => 35,
                'center_id' => 'دار الفوزان',
                'driver_id' => $drivers->where('center_id', 'دار الفوزان')->first()?->id,
                'status' => 'active',
                'current_students' => 12,
                'notes' => 'باص جديد - حالة ممتازة'
            ],
            [
                'number' => 'BUS-002',
                'plate_number' => 'أ ب ج 5678',
                'model' => 'مرسيدس سبرينتر 2022',
                'capacity' => 28,
                'center_id' => 'دار البصائر',
                'driver_id' => $drivers->where('center_id', 'دار البصائر')->first()?->id,
                'status' => 'active',
                'current_students' => 20,
                'notes' => 'باص مريح للمسافات الطويلة'
            ],
            [
                'number' => 'BUS-003',
                'plate_number' => 'م ن ه 9012',
                'model' => 'تويوتا كوستر 2021',
                'capacity' => 25,
                'center_id' => 'دار الفرقان',
                'driver_id' => $drivers->where('center_id', 'دار الفرقان')->first()?->id,
                'status' => 'active',
                'current_students' => 18
            ],
            [
                'number' => 'BUS-004',
                'plate_number' => 'س ع د 3456',
                'model' => 'إيفيكو ديلي 2022',
                'capacity' => 30,
                'center_id' => 'دار القرآن',
                'driver_id' => $drivers->where('center_id', 'دار القرآن')->first()?->id,
                'status' => 'active',
                'current_students' => 15
            ],
            [
                'number' => 'BUS-005',
                'plate_number' => 'ل م ن 7890',
                'model' => 'هيونداي كاونتي 2020',
                'capacity' => 32,
                'center_id' => 'دار البيان',
                'status' => 'maintenance',
                'current_students' => 0,
                'notes' => 'في الصيانة الدورية - سيعود للخدمة قريباً'
            ],
            [
                'number' => 'BUS-006',
                'plate_number' => 'ط ي ك 2468',
                'model' => 'فولكس واجن كرافتر 2021',
                'capacity' => 22,
                'center_id' => 'دار الهدى',
                'status' => 'active',
                'current_students' => 8
            ]
        ];

        $createdCount = 0;
        foreach ($busData as $data) {
            // التحقق من عدم وجود الباص
            if (!Bus::where('number', $data['number'])->exists() && 
                !Bus::where('plate_number', $data['plate_number'])->exists()) {
                
                Bus::create($data);
                $createdCount++;
                
                // تحديث عداد الباصات في المركز
                if ($data['center_id']) {
                    $center = Center::where('center_name', $data['center_id'])->first();
                    if ($center) {
                        $center->increment('bus_count');
                        if ($data['status'] === 'active') {
                            $center->increment('current_students', $data['current_students']);
                        }
                    }
                }
            }
        }
        
        $this->line("✓ تم إنشاء {$createdCount} باصات جديدة (الإجمالي: " . Bus::count() . ")");
    }

    private function setupAdmin()
    {
        $this->info('👤 إعداد حساب الإدارة...');
        
        try {
            if (class_exists('\App\Models\Admin')) {
                $admin = Admin::where('username', 'admin')->first();
                if (!$admin) {
                    Admin::create([
                        'username' => 'admin',
                        'password' => bcrypt('123456'),
                        'name' => 'مدير النظام',
                        'email' => 'admin@transport.local',
                        'role' => 'super_admin',
                        'status' => 'active'
                    ]);
                    $this->line('✓ تم إنشاء حساب الإدارة');
                } else {
                    $this->line('ℹ️  حساب الإدارة موجود مسبقاً');
                }
            } else {
                $this->warn('⚠️ نموذج Admin غير موجود - تخطي إنشاء حساب الإدارة');
            }
        } catch (\Exception $e) {
            $this->warn('⚠️ لم يتم إنشاء حساب الإدارة: ' . $e->getMessage());
        }
    }

    private function verifySystem()
    {
        $this->info('🔍 التحقق من سلامة النظام...');
        
        $issues = [];
        
        // التحقق من المراكز
        $centersCount = Center::count();
        if ($centersCount == 0) {
            $issues[] = 'لا توجد مراكز في النظام';
        }
        
        // التحقق من الباصات والسائقين
        $busesCount = Bus::count();
        $driversCount = Driver::count();
        $activeBuses = Bus::where('status', 'active')->count();
        $activeDrivers = Driver::where('status', 'active')->count();
        
        // التحقق من الربط
        $busesWithDrivers = Bus::whereNotNull('driver_id')->count();
        $busesWithCenters = Bus::whereNotNull('center_id')->count();
        
        if ($busesCount == 0) {
            $issues[] = 'لا توجد باصات في النظام';
        }
        
        if ($driversCount == 0) {
            $issues[] = 'لا توجد سائقين في النظام';
        }
        
        // التحقق من foreign keys والربط
        try {
            // التحقق من ربط الباصات بالسائقين
            $invalidDriverLinks = DB::table('buses')
                ->whereNotNull('driver_id')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('drivers')
                          ->whereRaw('drivers.id = buses.driver_id');
                })
                ->count();
                
            if ($invalidDriverLinks > 0) {
                $issues[] = "يوجد {$invalidDriverLinks} باص مرتبط بسائق غير موجود";
            }
            
            // التحقق من ربط الباصات بالمراكز
            $invalidCenterLinks = DB::table('buses')
                ->whereNotNull('center_id')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('centers')
                          ->whereRaw('centers.center_name = buses.center_id');
                })
                ->count();
                
            if ($invalidCenterLinks > 0) {
                $issues[] = "يوجد {$invalidCenterLinks} باص مرتبط بمركز غير موجود";
            }
            
        } catch (\Exception $e) {
            $issues[] = 'خطأ في التحقق من العلاقات: ' . $e->getMessage();
        }
        
        if (empty($issues)) {
            $this->line('✓ النظام سليم ولا توجد مشاكل');
        } else {
            $this->warn('⚠️ تم اكتشاف المشاكل التالية:');
            foreach ($issues as $issue) {
                $this->line("  - {$issue}");
            }
        }
    }

    private function displaySystemInfo()
    {
        $this->newLine();
        $this->info('📋 ملخص النظام:');
        $this->newLine();
        
        // إحصائيات النظام
        $centers = Center::count();
        $activeCenters = Center::where('status', 'active')->count();
        $drivers = Driver::count();
        $activeDrivers = Driver::where('status', 'active')->count();
        $buses = Bus::count();
        $activeBuses = Bus::where('status', 'active')->count();
        $totalCapacity = Bus::where('status', 'active')->sum('capacity');
        $currentStudents = Bus::where('status', 'active')->sum('current_students');
        
        $this->table(
            ['المكون', 'الإجمالي', 'النشط', 'تفاصيل إضافية'],
            [
                ['المراكز', $centers, $activeCenters, 'دور تحفيظ القرآن'],
                ['السائقين', $drivers, $activeDrivers, 'سائقي الباصات'],
                ['الباصات', $buses, $activeBuses, "السعة: {$totalCapacity} مقعد"],
                ['الطالبات', $currentStudents, $currentStudents, "متاح: " . ($totalCapacity - $currentStudents)],
            ]
        );
        
        $this->newLine();
        $this->info('🔗 روابط النظام:');
        $this->line('  • لوحة التحكم: /admin/dashboard');
        $this->line('  • إدارة الباصات: /admin/buses');
        $this->line('  • إدارة السائقين: /admin/drivers');
        $this->line('  • إدارة المراكز: /admin/centers');
        
        $this->newLine();
        $this->info('👤 بيانات تسجيل الدخول:');
        $this->line('  • اسم المستخدم: admin');
        $this->line('  • كلمة المرور: 123456');
        
        $this->newLine();
        $this->info('🧪 اختبار النظام:');
        $this->line('  • الرابط: /test-system');
        $this->line('  • API النظام: /api/centers/available');
        
        $this->newLine();
        $this->line('🎉 النظام جاهز للاستخدام!');
    }
}