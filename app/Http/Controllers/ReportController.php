<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Bus;
use App\Models\Driver;
use App\Models\Center;
use App\Models\Payment;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * جمع بيانات التقرير
     */
    private function gatherReportData()
    {
        // إحصائيات الطلاب
        $studentStats = [
            'total' => Student::count(),
            'approved' => Student::where('status', 'approved')->count(),
            'pending' => Student::where('status', 'pending')->count(),
            'rejected' => Student::where('status', 'rejected')->count(),
            'suspended' => Student::where('status', 'suspended')->count(),
            'male' => Student::where('gender', 'ذكر')->count(),
            'female' => Student::where('gender', 'أنثى')->count(),
            'morning' => Student::where('preferred_schedule', 'صباحية')->count(),
            'evening' => Student::where('preferred_schedule', 'مسائية')->count(),
            'with_bus' => Student::whereNotNull('assigned_bus_id')->count(),
            'without_bus' => Student::whereNull('assigned_bus_id')->count(),
            'dour' => Student::whereHas('center', fn($q) => $q->where('type', 'دار'))->count(),
            'markaz' => Student::whereHas('center', fn($q) => $q->where('type', 'مركز'))->count(),
            'riyaheen' => Student::whereHas('center', fn($q) => $q->where('type', 'برنامج'))->count(),
        ];

        // إحصائيات الباصات
        $busStats = [
            'total' => Bus::count(),
            'active' => Bus::where('status', 'active')->count(),
            'inactive' => Bus::where('status', 'inactive')->count(),
            'maintenance' => Bus::where('status', 'maintenance')->count(),
            'total_capacity' => Bus::sum('capacity'),
            'occupied_seats' => Bus::sum('current_students'),
            'available_seats' => Bus::sum('capacity') - Bus::sum('current_students'),
            'with_driver' => Bus::whereNotNull('driver_id')->count(),
            'without_driver' => Bus::whereNull('driver_id')->count(),
        ];
        $busStats['occupancy_rate'] = $busStats['total_capacity'] > 0 
            ? round(($busStats['occupied_seats'] / $busStats['total_capacity']) * 100, 1) 
            : 0;

        // إحصائيات السائقين
        $driverStats = [
            'total' => Driver::count(),
            'active' => Driver::where('status', 'active')->count(),
            'inactive' => Driver::where('status', 'inactive')->count(),
            'on_leave' => Driver::where('status', 'on_leave')->count(),
            'with_bus' => Driver::whereHas('buses', fn($q) => $q->where('status', 'active'))->count(),
            'without_bus' => Driver::whereDoesntHave('buses', fn($q) => $q->where('status', 'active'))->count(),
            'total_salary' => Driver::sum('salary'),
            'avg_experience' => round(Driver::avg('experience_years') ?? 0, 1),
        ];

        // إحصائيات الجهات
        $centerStats = [
            'total' => Center::count(),
            'active' => Center::where('status', 'active')->count(),
            'inactive' => Center::where('status', 'inactive')->count(),
            'dour' => Center::where('type', 'دار')->count(),
            'markaz' => Center::where('type', 'مركز')->count(),
            'riyaheen' => Center::where('type', 'برنامج')->count(),
            'boys' => Center::where('gender', 'بنين')->count(),
            'girls' => Center::where('gender', 'بنات')->count(),
        ];

        // إحصائيات المدفوعات
        $paymentStats = [
            'total_payments' => Payment::count(),
            'approved_payments' => Payment::where('status', 'approved')->count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'rejected_payments' => Payment::where('status', 'rejected')->count(),
            'awaiting_receipt' => Payment::where('status', 'awaiting_receipt')->count(),
            'total_required' => Student::sum('total_required'),
            'total_paid' => Payment::where('status', 'approved')->sum('amount'),
            'total_pending' => Payment::where('status', 'pending')->sum('amount'),
        ];
        $paymentStats['total_remaining'] = $paymentStats['total_required'] - $paymentStats['total_paid'];
        $paymentStats['collection_rate'] = $paymentStats['total_required'] > 0 
            ? round(($paymentStats['total_paid'] / $paymentStats['total_required']) * 100, 1) 
            : 0;

        // إحصائيات المشرفين
        $adminStats = [
            'total' => Admin::count(),
            'super_admin' => Admin::where('role', 'super_admin')->count(),
            'admin' => Admin::where('role', 'admin')->count(),
            'accountant' => Admin::where('role', 'accountant')->count(),
            'supervisor' => Admin::where('role', 'supervisor')->count(),
            'data_entry' => Admin::where('role', 'data_entry')->count(),
            'total_activities' => AdminActivity::count(),
            'today_activities' => AdminActivity::whereDate('created_at', today())->count(),
        ];

        // تفاصيل الجهات
        $centersDetails = Center::withCount(['students', 'buses'])
            ->with(['buses:id,center_id,capacity,current_students,status'])
            ->get()
            ->map(function($center) {
                $totalCapacity = $center->buses->sum('capacity');
                $occupiedSeats = $center->buses->sum('current_students');
                return [
                    'id' => $center->id,
                    'name' => $center->center_name,
                    'type' => $center->type,
                    'gender' => $center->gender,
                    'students_count' => $center->students_count,
                    'buses_count' => $center->buses_count,
                    'total_capacity' => $totalCapacity,
                    'occupied_seats' => $occupiedSeats,
                    'occupancy_rate' => $totalCapacity > 0 ? round(($occupiedSeats / $totalCapacity) * 100, 1) : 0,
                    'transport_fee' => $center->transport_fee,
                    'approved_students' => $center->students()->where('status', 'approved')->count(),
                    'pending_students' => $center->students()->where('status', 'pending')->count(),
                    'morning_students' => $center->students()->where('preferred_schedule', 'صباحية')->count(),
                    'evening_students' => $center->students()->where('preferred_schedule', 'مسائية')->count(),
                ];
            })->toArray();

        // تفاصيل الباصات
        $busesDetails = Bus::with(['driver:id,name,mobile', 'center:id,center_name'])
            ->withCount('students')
            ->get()
            ->map(function($bus) {
                return [
                    'id' => $bus->id,
                    'number' => $bus->number,
                    'plate_number' => $bus->plate_number,
                    'model' => $bus->model,
                    'capacity' => $bus->capacity,
                    'current_students' => $bus->students_count,
                    'available_seats' => $bus->capacity - $bus->students_count,
                    'occupancy_rate' => $bus->capacity > 0 ? round(($bus->students_count / $bus->capacity) * 100, 1) : 0,
                    'status' => $bus->status,
                    'status_text' => $bus->status_text,
                    'driver_name' => $bus->driver->name ?? 'غير محدد',
                    'driver_mobile' => $bus->driver->mobile ?? '-',
                    'center_name' => $bus->center->center_name ?? 'غير محدد',
                ];
            })->toArray();

        // تفاصيل السائقين
        $driversDetails = Driver::with(['center:id,center_name', 'activeBus:id,driver_id,number'])
            ->get()
            ->map(function($driver) {
                return [
                    'id' => $driver->id,
                    'driver_id' => $driver->driver_id,
                    'name' => $driver->name,
                    'mobile' => $driver->mobile,
                    'status' => $driver->status,
                    'status_name' => $driver->status_name,
                    'license_number' => $driver->license_number ?? '-',
                    'experience_years' => $driver->experience_years ?? 0,
                    'salary' => $driver->salary ?? 0,
                    'center_name' => $driver->center->center_name ?? 'غير محدد',
                    'bus_number' => $driver->activeBus->number ?? 'غير مخصص',
                ];
            })->toArray();

        // المدفوعات حسب الجهة
        $paymentsByCenter = Center::with(['students:id,center_id,total_required,total_paid'])
            ->get()
            ->map(function($center) {
                $totalRequired = $center->students->sum('total_required');
                $totalPaid = Payment::whereIn('student_id', $center->students->pluck('id'))
                    ->where('status', 'approved')
                    ->sum('amount');
                return [
                    'name' => $center->center_name,
                    'type' => $center->type,
                    'students_count' => $center->students->count(),
                    'total_required' => $totalRequired,
                    'total_paid' => $totalPaid,
                    'total_remaining' => $totalRequired - $totalPaid,
                    'collection_rate' => $totalRequired > 0 ? round(($totalPaid / $totalRequired) * 100, 1) : 0,
                ];
            })->toArray();

        // آخر التسجيلات
        $recentStudents = Student::with('center:id,center_name')
            ->latest()
            ->take(10)
            ->get(['id', 'student_id', 'name', 'gender', 'status', 'center_id', 'created_at'])
            ->map(function($student) {
                return [
                    'id' => $student->id,
                    'student_id' => $student->student_id,
                    'name' => $student->name,
                    'gender' => $student->gender,
                    'status' => $student->status,
                    'status_name' => $student->status_name,
                    'center_name' => $student->center->center_name ?? '-',
                    'created_at' => $student->created_at->format('Y-m-d'),
                ];
            })->toArray();

        // آخر المدفوعات
        $recentPayments = Payment::with('student:id,name,student_id')
            ->latest()
            ->take(10)
            ->get(['id', 'payment_number', 'student_id', 'amount', 'payment_method', 'status', 'created_at'])
            ->map(function($payment) {
                return [
                    'id' => $payment->id,
                    'payment_number' => $payment->payment_number,
                    'student_name' => $payment->student->name ?? '-',
                    'amount' => $payment->amount,
                    'payment_method' => $payment->payment_method ?? '-',
                    'status' => $payment->status,
                    'status_text' => $payment->status_text,
                    'created_at' => $payment->created_at->format('Y-m-d'),
                ];
            })->toArray();

        return [
            'studentStats' => $studentStats,
            'busStats' => $busStats,
            'driverStats' => $driverStats,
            'centerStats' => $centerStats,
            'paymentStats' => $paymentStats,
            'adminStats' => $adminStats,
            'centersDetails' => $centersDetails,
            'busesDetails' => $busesDetails,
            'driversDetails' => $driversDetails,
            'paymentsByCenter' => $paymentsByCenter,
            'recentStudents' => $recentStudents,
            'recentPayments' => $recentPayments,
            'generated_at' => now()->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * عرض صفحة التقارير الشاملة (الحية)
     */
    public function index()
    {
        $data = $this->gatherReportData();
        
        $studentStats = $data['studentStats'];
        $busStats = $data['busStats'];
        $driverStats = $data['driverStats'];
        $centerStats = $data['centerStats'];
        $paymentStats = $data['paymentStats'];
        $adminStats = $data['adminStats'];
        $centersDetails = collect($data['centersDetails']);
        $busesDetails = collect($data['busesDetails']);
        $driversDetails = collect($data['driversDetails']);
        $paymentsByCenter = collect($data['paymentsByCenter']);
        $recentStudents = collect($data['recentStudents']);
        $recentPayments = collect($data['recentPayments']);

        return view('admin.reports.index', compact(
            'studentStats',
            'busStats',
            'driverStats',
            'centerStats',
            'paymentStats',
            'adminStats',
            'centersDetails',
            'busesDetails',
            'driversDetails',
            'paymentsByCenter',
            'recentStudents',
            'recentPayments'
        ));
    }

    /**
     * حفظ التقرير في الأرشيف
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        $data = $this->gatherReportData();

        $report = Report::create([
            'report_number' => Report::generateReportNumber(),
            'title' => $request->title ?? 'تقرير شامل - ' . now()->format('Y-m-d'),
            'type' => 'comprehensive',
            'data' => $data,
            'notes' => $request->notes,
            'created_by' => session('admin_id'),
        ]);

        return redirect()->route('admin.reports.archive')
            ->with('success', 'تم حفظ التقرير بنجاح برقم: ' . $report->report_number);
    }

    /**
     * عرض صفحة الأرشيف
     */
    public function archive(Request $request)
    {
        $query = Report::with('creator:id,name')
            ->latest();

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $reports = $query->paginate(15);

        return view('admin.reports.archive', compact('reports'));
    }

    /**
     * عرض تقرير محفوظ
     */
    public function show(Report $report)
    {
        $data = $report->data;
        
        $studentStats = $data['studentStats'];
        $busStats = $data['busStats'];
        $driverStats = $data['driverStats'];
        $centerStats = $data['centerStats'];
        $paymentStats = $data['paymentStats'];
        $adminStats = $data['adminStats'];
        $centersDetails = collect($data['centersDetails']);
        $busesDetails = collect($data['busesDetails']);
        $driversDetails = collect($data['driversDetails']);
        $paymentsByCenter = collect($data['paymentsByCenter']);
        $recentStudents = collect($data['recentStudents']);
        $recentPayments = collect($data['recentPayments']);
        $generatedAt = $data['generated_at'] ?? $report->created_at->format('Y-m-d H:i:s');

        return view('admin.reports.show', compact(
            'report',
            'studentStats',
            'busStats',
            'driverStats',
            'centerStats',
            'paymentStats',
            'adminStats',
            'centersDetails',
            'busesDetails',
            'driversDetails',
            'paymentsByCenter',
            'recentStudents',
            'recentPayments',
            'generatedAt'
        ));
    }

    /**
     * حذف تقرير
     */
    public function destroy(Report $report)
    {
        $reportNumber = $report->report_number;
        $report->delete();

        return redirect()->route('admin.reports.archive')
            ->with('success', 'تم حذف التقرير رقم: ' . $reportNumber);
    }
}
