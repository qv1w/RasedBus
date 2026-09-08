<?php

namespace App\Services;

use App\Models\Driver;
use App\Models\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DriverService
{
    public function create(array $data): Driver
    {
        return DB::transaction(function () use ($data) {
            // توليد driver_id تلقائياً
            $lastDriver = Driver::orderBy('id', 'desc')->first();
            $nextNumber = $lastDriver ? ($lastDriver->id + 1) : 1;
            $driverId = 'DRV-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            $driver = Driver::create(array_merge($data, [
                'driver_id' => $driverId,
                'license_type' => $data['license_type'] ?? 'عام'
            ]));

            Log::info('تم إنشاء سائق جديد', [
                'driver_id' => $driver->id,
                'driver_number' => $driverId,
                'admin_id' => session('admin_id')
            ]);

            return $driver;
        });
    }

    public function update(Driver $driver, array $data): Driver
    {
        return DB::transaction(function () use ($driver, $data) {
            // التحقق من وجود باص نشط عند تغيير الحالة إلى غير نشط
            if (isset($data['status']) && $data['status'] !== 'active' && $driver->hasActiveBus()) {
                throw new \Exception('لا يمكن تغيير حالة السائق - يوجد باص نشط مخصص له');
            }

            $driver->update(array_merge($data, [
                'license_type' => $data['license_type'] ?? 'عام'
            ]));

            Log::info('تم تحديث سائق', [
                'driver_id' => $driver->id,
                'changes' => $driver->getChanges(),
                'admin_id' => session('admin_id')
            ]);

            return $driver->fresh();
        });
    }

    public function delete(Driver $driver): bool
    {
        $busesCount = Bus::where('driver_id', $driver->id)->count();
        
        if ($busesCount > 0) {
            throw new \Exception('لا يمكن حذف السائق لأنه مرتبط بباصات. يرجى إلغاء الارتباط أولاً.');
        }

        $driverName = $driver->name;
        $driver->delete();

        Log::info('تم حذف سائق', [
            'driver_name' => $driverName,
            'admin_id' => session('admin_id')
        ]);

        return true;
    }

    public function updateStatus(Driver $driver, string $status): Driver
    {
        if ($status !== 'active' && $driver->hasActiveBus()) {
            throw new \Exception('لا يمكن تغيير حالة السائق - يوجد باص نشط مخصص له');
        }

        $oldStatus = $driver->status;
        $driver->update(['status' => $status]);

        Log::info('تم تحديث حالة سائق', [
            'driver_id' => $driver->id,
            'old_status' => $oldStatus,
            'new_status' => $status,
            'admin_id' => session('admin_id')
        ]);

        return $driver;
    }

    public function getAvailableDrivers(?string $centerName = null, ?int $currentDriverId = null)
    {
        $query = Driver::where('status', 'active');

        // إما السائقين بدون باص نشط أو السائق الحالي
        $query->where(function($q) use ($currentDriverId) {
            $q->whereDoesntHave('buses', function($busQuery) {
                $busQuery->where('status', 'active');
            });
            
            if ($currentDriverId) {
                $q->orWhere('id', $currentDriverId);
            }
        });

        // تصفية حسب المركز إذا كان محدد
        if ($centerName && $centerName !== 'all') {
            $query->where(function($q) use ($centerName) {
                $q->where('center_id', $centerName)
                  ->orWhereNull('center_id');
            });
        }

        return $query->select(['id', 'name', 'mobile', 'license_number', 'center_id'])
                    ->orderBy('name')
                    ->get();
    }
}