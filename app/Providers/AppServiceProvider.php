<?php

namespace App\Providers;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::if('role', function ($roles) {
    $roles = is_array($roles) ? $roles : [$roles];

    return auth()->check() && collect($roles)->contains(fn($role) => auth()->user()->hasRole($role));
});

    }
}
