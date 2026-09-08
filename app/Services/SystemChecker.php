<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Center;
use App\Models\Driver;
use App\Models\Bus;

class SystemChecker
{
    public static function checkSystemHealth()
    {
        $health = [
            'status' => 'healthy',
            'components' => [],
            'issues' => []
        ];
        
        try {
            // فحص قاعدة البيانات
            $health['components']['database'] = [
                'status' => 'healthy',
                'tables' => [
                    'centers' => Schema::hasTable('centers'),
                    'drivers' => Schema::hasTable('drivers'),
                    'buses' => Schema::hasTable('buses')
                ]
            ];
            
            // فحص البيانات
            $health['components']['data'] = [
                'centers' => Center::count(),
                'drivers' => Driver::count(),
                'buses' => Bus::count(),
                'active_buses' => Bus::where('status', 'active')->count(),
                'available_capacity' => Bus::where('status', 'active')->sum('capacity') - 
                                      Bus::where('status', 'active')->sum('current_students')
            ];
            
            // فحص العلاقات
            $health['components']['relationships'] = [
                'buses_with_drivers' => Bus::whereNotNull('driver_id')->count(),
                'buses_with_centers' => Bus::whereNotNull('center_id')->count(),
                'drivers_with_buses' => Driver::whereHas('buses')->count()
            ];
            
            // فحص المشاكل
            $invalidDrivers = Bus::whereNotNull('driver_id')
                ->whereNotExists(function($q) {
                    $q->select(DB::raw(1))->from('drivers')
                      ->whereRaw('drivers.id = buses.driver_id');
                })->count();
                
            if ($invalidDrivers > 0) {
                $health['issues'][] = "باصات مرتبطة بسائقين غير موجودين: {$invalidDrivers}";
                $health['status'] = 'warning';
            }
            
            $invalidCenters = Bus::whereNotNull('center_id')
                ->whereNotExists(function($q) {
                    $q->select(DB::raw(1))->from('centers')
                      ->whereRaw('centers.center_name = buses.center_id');
                })->count();
                
            if ($invalidCenters > 0) {
                $health['issues'][] = "باصات مرتبطة بمراكز غير موجودة: {$invalidCenters}";
                $health['status'] = 'warning';
            }
            
        } catch (\Exception $e) {
            $health['status'] = 'error';
            $health['error'] = $e->getMessage();
        }
        
        return $health;
    }
    
    public static function getSystemStats()
    {
        return [
            'centers' => [
                'total' => Center::count(),
                'active' => Center::where('status', 'active')->count(),
            ],
            'drivers' => [
                'total' => Driver::count(),
                'active' => Driver::where('status', 'active')->count(),
            ],
            'buses' => [
                'total' => Bus::count(),
                'active' => Bus::where('status', 'active')->count(),
                'maintenance' => Bus::where('status', 'maintenance')->count(),
            ],
            'capacity' => [
                'total' => Bus::where('status', 'active')->sum('capacity'),
                'used' => Bus::where('status', 'active')->sum('current_students'),
                'available' => Bus::where('status', 'active')->sum('capacity') - 
                              Bus::where('status', 'active')->sum('current_students'),
            ]
        ];
    }
}