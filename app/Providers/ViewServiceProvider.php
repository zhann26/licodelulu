<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Allocate;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // No need to register services here for this case
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share data with all views
        View::composer('*', function ($view) {
            // Share totalOccupants with all views
            $view->with('totalOccupants', Allocate::count());
            $view->with('totalRevenue', Allocate::sum('payment')); // Share total revenue (sum of payments)

            // Fetch allocations sorted by created_at in descending order (oldest to latest)
            $allocations = Allocate::orderBy('created_at', 'desc')->get(); 
            $view->with('allocations', $allocations); // Share allocations with all views
        });
    }
}