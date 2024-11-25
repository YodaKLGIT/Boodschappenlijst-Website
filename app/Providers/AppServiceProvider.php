<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Invitation;
use App\Policies\InvitationPolicy;
use App\Models\Shoppinglist;
use App\Policies\ShoppinglistPolicy;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

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
        View::composer('layouts.navigation', function ($view) {
            $pendingCount = 0;
            if (Auth::check()) {
                $pendingCount = Invitation::where('recipient_id', Auth::id())
                    ->where('status', 'pending')
                    ->count();
            }
            $view->with('pendingCount', $pendingCount);
        });
    }
}
