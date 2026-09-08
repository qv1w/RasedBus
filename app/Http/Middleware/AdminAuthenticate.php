<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // التحقق من تسجيل دخول المدير
        if (!Auth::guard('admin')->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'غير مصرح'], 401);
            }
            return redirect()->route('login')->with('error', 'يرجى تسجيل الدخول أولاً');
        }

        // التحقق من حالة الحساب إذا كان يحتوي على طريقة isActive
        $admin = Auth::guard('admin')->user();
        if (method_exists($admin, 'isActive') && !$admin->isActive()) {
            Auth::guard('admin')->logout();
            return redirect()->route('login')->with('error', 'تم إيقاف حسابك، يرجى التواصل مع الإدارة');
        }

        return $next($request);
    }
}