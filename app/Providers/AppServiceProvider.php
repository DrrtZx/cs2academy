<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Gate sederhana: hanya admin yang boleh akses
        Gate::define('admin-only', function ($user) {
            return $user->isAdmin();
        });
    }
}