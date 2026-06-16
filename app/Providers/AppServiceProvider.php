<?php

namespace App\Providers;

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
        \Illuminate\Support\Facades\View::composer('components.admin-layout', function ($view) {
            $newOrdersCount = \App\Models\Order::where('status', 'paid')->count();
            $view->with('newOrdersCount', $newOrdersCount);
        });
    }
}
