<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\ListServiceInterface;
use App\Services\ListService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ListServiceInterface::class, ListService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        View::composer('layouts.navigation', function ($view) {
            $view->with('invitations', Auth::user() ? Auth::user()->invitations : []);
        });
    }
}
