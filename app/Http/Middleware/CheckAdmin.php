<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdmin
{
    public function handle($request, Closure $next)
    {
        if (!session()->has('user_id') || session('role') !== 'admin') {
            return redirect()->route('admin.login')->with('error', 'يجب تسجيل الدخول كمسؤول!');
        }

        return $next($request);
    }
}
