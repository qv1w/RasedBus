<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SimpleAdminAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // تحقق بسيط من الجلسة
        if (!session()->has('admin_logged_in')) {
            // إذا كان طلب AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'غير مصرح لك بالوصول'
                ], 401);
            }
            
            // إعادة توجيه لصفحة تسجيل الدخول
            return redirect()->route('login')
                           ->with('error', 'يجب تسجيل الدخول أولاً');
        }

        return $next($request);
    }
}