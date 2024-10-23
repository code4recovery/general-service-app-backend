<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        //
        View::share('bg_css', 'bg-black/5 dark:bg-white/10');
        View::share('border_css', 'border border-gray-300 dark:border-white/20');
        View::share('focus_css', 'focus:ring focus:ring-blue-500 focus:outline-none');
        View::share('hover_css', 'hover:bg-black/5 dark:hover:bg-white/10');
        View::share('input_css', 'w-full p-2 rounded text-black bg-white');
    }
}
