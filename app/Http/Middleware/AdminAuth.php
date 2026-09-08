<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('admin_id') || !session('admin_logged_in')) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'غير مصرح'], 401);
            }
            return redirect()->route('admin.login')
                           ->with('error', 'يرجى تسجيل الدخول أولاً');
        }

        return $next($request);
    }
}