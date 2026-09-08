<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Admin;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        $adminId = session('admin_id');
        
        if (!$adminId) {
            return redirect()->route('admin.login')->with('error', 'يرجى تسجيل الدخول');
        }
        
        $admin = Admin::find($adminId);
        
        if (!$admin) {
            session()->flush();
            return redirect()->route('admin.login')->with('error', 'جلسة غير صالحة');
        }
        
        if (!$admin->hasPermission($permission)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'ليس لديك صلاحية'], 403);
            }
            
            return redirect()->route('admin.dashboard')
                ->with('error', 'ليس لديك صلاحية للوصول لهذه الصفحة');
        }
        
        return $next($request);
    }
}