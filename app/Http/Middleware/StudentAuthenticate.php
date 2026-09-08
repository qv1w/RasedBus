<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentAuthenticate
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // التحقق من تسجيل دخول الطالبة
        if (!Auth::guard('student')->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'غير مصرح'], 401);
            }
            return redirect()->route('student.login')->with('error', 'يرجى تسجيل الدخول أولاً');
        }

        // التحقق من حالة الطالبة
        $student = Auth::guard('student')->user();
        if ($student->status === 'suspended') {
            Auth::guard('student')->logout();
            return redirect()->route('student.login')->with('error', 'تم تعليق حسابك، يرجى التواصل مع الإدارة');
        }

        if ($student->status === 'rejected') {
            Auth::guard('student')->logout();
            return redirect()->route('student.login')->with('error', 'تم رفض طلبك');
        }

        return $next($request);
    }
}