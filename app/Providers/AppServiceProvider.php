<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // 1. Tambahkan baris ini

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // 2. Tambahkan baris ini biar pagination pakai style Bootstrap 5
        Paginator::useBootstrapFive();
    }
}