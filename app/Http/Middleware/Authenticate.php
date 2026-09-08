<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // تحديد مسار التوجيه حسب المسار المطلوب
        if ($request->is('admin') || $request->is('admin/*')) {
            return route('login'); // صفحة دخول الإدارة
        }

        if ($request->is('student') || $request->is('student/*')) {
            return route('student.login'); // صفحة دخول الطالبات
        }

        return route('login'); // افتراضي للإدارة
    }
}

