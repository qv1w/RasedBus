<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Admin;

class AuthController extends Controller
{
    /**
     * عرض صفحة تسجيل الدخول
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * معالجة تسجيل الدخول
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'اسم المستخدم مطلوب',
            'password.required' => 'كلمة المرور مطلوبة'
        ]);

        // البحث عن المدير
        $admin = Admin::where('username', $request->username)
                      ->orWhere('email', $request->username)
                      ->first();

        if (!$admin) {
            return back()->withErrors([
                'login_error' => 'اسم المستخدم غير صحيح'
            ])->withInput();
        }

        // التحقق من حالة الحساب
        if (!$admin->isActive()) {
            return back()->withErrors([
                'login_error' => 'الحساب غير نشط، يرجى التواصل مع الإدارة'
            ])->withInput();
        }

        // التحقق من كلمة المرور
        if (!$admin->checkPassword($request->password)) {
            Log::warning('Failed login attempt', [
                'username' => $request->username,
                'ip' => $request->ip()
            ]);

            return back()->withErrors([
                'login_error' => 'كلمة المرور غير صحيحة'
            ])->withInput();
        }

        // تسجيل الدخول
        Auth::guard('admin')->login($admin);
        $admin->updateLastLogin();

        Log::info('Successful admin login', [
            'admin_id' => $admin->id,
            'username' => $admin->username,
            'ip' => $request->ip()
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'مرحباً بك ' . $admin->name);
    }

    /**
     * التحقق من تسجيل الدخول (Middleware)
     */
    public function checkAuth()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login')->with('error', 'يرجى تسجيل الدخول أولاً');
        }

        $admin = Auth::guard('admin')->user();
        if (!$admin->isActive()) {
            Auth::guard('admin')->logout();
            return redirect()->route('login')->with('error', 'تم إيقاف حسابك، يرجى التواصل مع الإدارة');
        }

        return null;
    }

    /**
     * تسجيل الخروج
     */
    public function logout()
    {
        $admin = Auth::guard('admin')->user();

        Log::info('Admin logout', [
            'admin_id' => $admin ? $admin->id : null,
            'username' => $admin ? $admin->username : null
        ]);

        Auth::guard('admin')->logout();

        return redirect()->route('login')->with('success', 'تم تسجيل الخروج بنجاح');
    }
}
