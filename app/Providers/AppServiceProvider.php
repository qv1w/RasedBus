<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Services\BusService;
use App\Services\DriverService;
use App\Services\StudentService;
use App\Services\PaymentService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(BusService::class);
        $this->app->singleton(DriverService::class);
        $this->app->singleton(StudentService::class);
        $this->app->singleton(PaymentService::class);
    }

    public function boot(): void
    {
        Paginator::defaultView('vendor.pagination.bootstrap-5');
    }
}