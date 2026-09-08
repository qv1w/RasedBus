<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * المصفوفات الخاصة بالسياسات للتطبيق.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * تسجيل أي خدمات خاصة بالتحقق من الهوية أو التفويض.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
