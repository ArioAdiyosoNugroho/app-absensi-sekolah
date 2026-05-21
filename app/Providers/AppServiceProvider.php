<?php

namespace App\Providers;

use App\Models\AttendanceSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useTailwind();

        View::composer('*', function ($view) {
            $settings = AttendanceSetting::first();
            if (!$settings) {
                $settings = new AttendanceSetting();
                $settings->school_name = 'Absensi Sekolah';
            }
            $view->with('settings', $settings);
        });
    }
}
