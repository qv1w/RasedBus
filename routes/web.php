<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;

// ==================== الصفحة الرئيسية ====================
Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');


Route::get('/students/create', function () {
    return redirect()->route('student.register');
})->name('students.create');

// ==================== الطالبات - الواجهة العامة ====================
Route::prefix('student')->name('student.')->group(function () {
    
    // التسجيل ونوعه 
    Route::get('register', [StudentController::class, 'selectType'])->name('register');
    Route::get('register/form', [StudentController::class, 'create'])->name('register.form');
    Route::post('register', [StudentController::class, 'store'])->name('register.submit');
    Route::get('success/{nationalId}', [StudentController::class, 'success'])->name('success');
    
    // تسجيل الدخول
    Route::get('login', [StudentController::class, 'showLoginForm'])->name('login');
    Route::post('login', [StudentController::class, 'login'])->name('login.submit');
    Route::post('logout', [StudentController::class, 'logout'])->name('logout');
    
    // الصفحات المحمية
    Route::middleware('student.auth')->group(function () {
        Route::get('dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
        
        // الدفعات
        Route::get('payments', [StudentController::class, 'payments'])->name('payments');
        Route::post('payments/{payment}/upload', [StudentController::class, 'uploadReceipt'])->name('payments.upload');
    });
});

// ==================== الإدارة ====================
Route::prefix('admin')->name('admin.')->group(function () {
    
    // تسجيل الدخول
    Route::get('login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminController::class, 'login'])->name('login.submit');
    Route::post('logout', [AdminController::class, 'logout'])->name('logout');
    
    // إنشاء مدير افتراضي
    Route::get('create-default', [AdminController::class, 'createDefaultAdmin'])->name('create.default');
    Route::get('test-login', [AdminController::class, 'testLogin'])->name('test.login');
    
    // الصفحات المحمية
    Route::middleware('admin.auth')->group(function () {
        
        // لوحة التحكم
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // التقارير الشاملة
        Route::get('reports', [ReportController::class, 'index'])->name('reports');
        Route::post('reports', [ReportController::class, 'store'])->name('reports.store');
        Route::get('reports/archive', [ReportController::class, 'archive'])->name('reports.archive');
        Route::get('reports/{report}', [ReportController::class, 'show'])->name('reports.show');
        Route::delete('reports/{report}', [ReportController::class, 'destroy'])->name('reports.destroy');
        Route::get('reports/export', [ReportController::class, 'export'])->name('reports.export');
        
        Route::get('api/stats', [AdminController::class, 'quickStats'])->name('api.stats');
        
        // الملف الشخصي
        Route::get('profile', [AdminController::class, 'profile'])->name('profile');
        Route::put('profile', [AdminController::class, 'updateProfile'])->name('profile.update');
        Route::put('password', [AdminController::class, 'changePassword'])->name('password.change');
        Route::put('settings', [AdminController::class, 'updateSettings'])->name('profile.settings');
        
        // ==================== إدارة الموظفين ====================
        Route::prefix('admins')->name('admins.')->group(function () {
            Route::get('/', [AdminController::class, 'adminsIndex'])->name('index');
            Route::get('/create', [AdminController::class, 'adminsCreate'])->name('create');
            Route::post('/', [AdminController::class, 'adminsStore'])->name('store');
            Route::get('/{admin}/edit', [AdminController::class, 'adminsEdit'])->name('edit');
            Route::put('/{admin}', [AdminController::class, 'adminsUpdate'])->name('update');
            Route::delete('/{admin}', [AdminController::class, 'adminsDestroy'])->name('destroy');
            Route::post('/{admin}/toggle-status', [AdminController::class, 'adminsToggleStatus'])->name('toggle-status');
            Route::post('/{admin}/reset-password', [AdminController::class, 'adminsResetPassword'])->name('reset-password');
        });

        
        // ==================== الطالبات ====================
        Route::prefix('students')->name('students.')->group(function () {
            Route::get('/', [StudentController::class, 'adminIndex'])->name('index');
            Route::get('create', [StudentController::class, 'adminCreate'])->name('create');
            Route::post('/', [StudentController::class, 'adminStore'])->name('store');
            Route::delete('delete-all', [StudentController::class, 'deleteAll'])->name('deleteAll');
            Route::post('bulk-action', [StudentController::class, 'bulkAction'])->name('bulk-action');
            Route::get('{student}', [StudentController::class, 'adminShow'])->name('show');
            Route::get('{student}/edit', [StudentController::class, 'adminEdit'])->name('edit');
            Route::put('{student}', [StudentController::class, 'adminUpdate'])->name('update');
            Route::delete('{student}', [StudentController::class, 'adminDestroy'])->name('destroy');
            Route::put('{student}/update-pickup', [StudentController::class, 'updatePickup'])->name('update-pickup');
            
            // إجراءات الطالبات
            Route::post('{student}/approve', [StudentController::class, 'approve'])->name('approve');
            Route::post('{student}/reject', [StudentController::class, 'reject'])->name('reject');
            Route::post('{student}/suspend', [StudentController::class, 'suspend'])->name('suspend');
            Route::post('{student}/unsuspend', [StudentController::class, 'unsuspend'])->name('unsuspend');
            Route::post('{student}/assign-bus', [StudentController::class, 'assignBus'])->name('assign.bus');
            Route::post('{student}/unassign-bus', [StudentController::class, 'unassignBus'])->name('unassign.bus');
        });
        
        // ==================== الباصات ====================
        Route::prefix('buses')->name('buses.')->group(function () {
            Route::get('/', [BusController::class, 'index'])->name('index');
            Route::get('create', [BusController::class, 'create'])->name('create');
            Route::post('/', [BusController::class, 'store'])->name('store');
            Route::post('bulk-action', [BusController::class, 'bulkAction'])->name('bulk-action');
            Route::get('{bus}', [BusController::class, 'show'])->name('show');
            Route::get('{bus}/edit', [BusController::class, 'edit'])->name('edit');
            Route::put('{bus}', [BusController::class, 'update'])->name('update');
            Route::delete('{bus}', [BusController::class, 'destroy'])->name('destroy');
            Route::post('{bus}/status', [BusController::class, 'updateStatus'])->name('update-status');
            
            // إدارة الطالبات في الباص
            Route::get('{bus}/assign-students', [BusController::class, 'showAssignStudents'])->name('assign-students');
            Route::post('{bus}/assign-students', [BusController::class, 'assignStudents'])->name('store-students');
            Route::delete('{bus}/students/{student}', [BusController::class, 'removeStudent'])->name('remove-student');
            Route::delete('{bus}/students', [BusController::class, 'removeAllStudents'])->name('remove-all-students');
        });
        
        // ==================== السائقين ====================
        Route::prefix('drivers')->name('drivers.')->group(function () {
            Route::get('/', [DriverController::class, 'index'])->name('index');
            Route::get('create', [DriverController::class, 'create'])->name('create');
            Route::post('/', [DriverController::class, 'store'])->name('store');
            Route::get('available/{centerName}', [DriverController::class, 'availableForCenter'])->name('available');
            Route::get('{driver}', [DriverController::class, 'show'])->name('show');
            Route::get('{driver}/edit', [DriverController::class, 'edit'])->name('edit');
            Route::put('{driver}', [DriverController::class, 'update'])->name('update');
            Route::delete('{driver}', [DriverController::class, 'destroy'])->name('destroy');
            Route::post('{driver}/status', [DriverController::class, 'updateStatus'])->name('update-status');
        });
        
        // ==================== الجهات (المراكز/الدور/البرامج) ====================
        Route::prefix('centers')->name('centers.')->group(function () {
            Route::get('/', [CenterController::class, 'index'])->name('index');
            Route::get('create', [CenterController::class, 'create'])->name('create');
            Route::post('/', [CenterController::class, 'store'])->name('store');
            Route::get('{center}', [CenterController::class, 'show'])->name('show');
            Route::get('{center}/edit', [CenterController::class, 'edit'])->name('edit');
            Route::put('{center}', [CenterController::class, 'update'])->name('update');
            Route::delete('{center}', [CenterController::class, 'destroy'])->name('destroy');
            Route::get('{center}/students', [CenterController::class, 'students'])->name('students');
            Route::get('{center}/buses', [CenterController::class, 'buses'])->name('buses');
            Route::get('{center}/statistics', [CenterController::class, 'statistics'])->name('statistics');
            Route::post('{center}/toggle-status', [CenterController::class, 'toggleStatus'])->name('toggle-status');
            Route::post('{center}/update-counts', [CenterController::class, 'updateCounts'])->name('update-counts');
        });
        
        // ==================== الدفعات ====================
        Route::prefix('payments')->name('payments.')->group(function () {
            Route::get('/', [PaymentController::class, 'index'])->name('index');
            Route::get('create', [PaymentController::class, 'create'])->name('create');
            Route::get('bulk-create', [PaymentController::class, 'bulkCreate'])->name('bulk-create');
            Route::get('missing-students', [PaymentController::class, 'missingStudents'])->name('missing');
            Route::get('settings', [PaymentController::class, 'settings'])->name('settings');
            Route::post('/', [PaymentController::class, 'store'])->name('store');
            Route::post('bulk-store', [PaymentController::class, 'bulkStore'])->name('bulk-store');
            Route::post('create-missing', [PaymentController::class, 'createMissingPayments'])->name('create-missing');
            Route::put('settings', [PaymentController::class, 'updateSettings'])->name('settings.update');
            Route::post('bulk-action', [PaymentController::class, 'bulkAction'])->name('bulk');
            Route::get('{payment}', [PaymentController::class, 'show'])->name('show');
            Route::get('{payment}/edit', [PaymentController::class, 'edit'])->name('edit');
            Route::put('{payment}', [PaymentController::class, 'update'])->name('update');
            Route::delete('{payment}', [PaymentController::class, 'destroy'])->name('destroy');
            Route::post('{payment}/approve', [PaymentController::class, 'approve'])->name('approve');
            Route::post('{payment}/reject', [PaymentController::class, 'reject'])->name('reject');
        });
    });
    Route::middleware('admin.auth')->group(function () {
    
    // ... الراوتات الموجودة ...
    
    // ⬇️ أضف هذا هنا ⬇️
    Route::get('seed-students', function () {
        if (session('admin_role') != 'super_admin') {
            return redirect()->route('admin.dashboard')->with('error', 'غير مصرح!');
        }
        
        $girlsNames = ['فاطمة', 'عائشة', 'مريم', 'نورة', 'سارة', 'هند', 'ريم', 'دانة', 'لمى', 'رهف', 'جود', 'سلمى', 'هيا', 'نوف', 'أمل', 'شهد', 'رغد', 'غادة', 'حصة', 'بدور'];
        $boysNames = ['محمد', 'عبدالله', 'عبدالرحمن', 'سعود', 'فهد', 'خالد', 'أحمد', 'علي', 'عمر', 'يوسف', 'إبراهيم', 'سلطان', 'ناصر', 'تركي', 'فيصل', 'سلمان', 'نواف', 'مشاري', 'ماجد', 'راشد'];
        $lastNames = ['العتيبي', 'القحطاني', 'الشمري', 'الدوسري', 'المطيري', 'الحربي', 'السبيعي', 'الزهراني', 'الغامدي', 'العنزي', 'الرشيدي', 'الجهني', 'المالكي', 'الشهري'];
        
        $centers = \App\Models\Center::where('status', 'active')->get();
        if ($centers->isEmpty()) {
            return back()->with('error', 'لا توجد مراكز نشطة!');
        }
        
        $year = date('Y');
        $last = \App\Models\Student::where('student_id', 'like', "STU-{$year}-%")->orderBy('id', 'desc')->first();
        $num = 1;
        if ($last && preg_match('/STU-\d{4}-(\d+)/', $last->student_id, $m)) {
            $num = intval($m[1]) + 1;
        }
        
        for ($i = 0; $i < 100; $i++) {
            $center = $centers->random();
            $gender = $center->gender == 'بنات' ? 'أنثى' : 'ذكر';
            $first = $gender == 'أنثى' ? $girlsNames[array_rand($girlsNames)] : $boysNames[array_rand($boysNames)];
            $father = $boysNames[array_rand($boysNames)];
            $family = $lastNames[array_rand($lastNames)];
            
            do {
                $nid = '1' . str_pad(rand(0, 999999999), 9, '0', STR_PAD_LEFT);
            } while (\App\Models\Student::where('national_id', $nid)->exists());
            
            \App\Models\Student::create([
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
        
        return redirect()->route('admin.students.index')->with('success', 'تم إضافة 100 طالب/ة بنجاح!');
    })->name('seed-students');
    
});
});