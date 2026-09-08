<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Student;
use Symfony\Component\HttpFoundation\Response;

class StudentAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        // التحقق من وجود جلسة الطالب
        if (!Session::has('student_id')) {
            return redirect()->route('student.login')
                ->with('error', 'يجب تسجيل الدخول أولاً');
        }

        $student = Student::find(Session::get('student_id'));

        if (!$student) {
            Session::flush();
            return redirect()->route('student.login')
                ->with('error', 'انتهت الجلسة، يرجى تسجيل الدخول مرة أخرى');
        }

        // تمرير الطالب (اختياري)
        $request->attributes->set('authenticated_student', $student);

        return $next($request);
    }
}
