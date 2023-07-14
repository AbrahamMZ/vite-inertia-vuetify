<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Schema::defaultStringLength(191);
        // DB::connection()->getPdo()->exec('PRAGMA encoding = "UTF-8"');
        // DB::connection()->getPdo()->exec('PRAGMA foreign_keys = ON');
        // DB::connection()->getPdo()->exec('PRAGMA case_sensitive_like = OFF');
    }
}