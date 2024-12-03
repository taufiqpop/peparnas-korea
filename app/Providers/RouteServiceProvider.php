<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';
    public const DASHBOARD = '/dashboard';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();

        Route::middleware(['web', 'auth'])->group(function () {
            // Administrator
            $this->mapDashboardRoutes();
            $this->mapUserRoutes();
            $this->mapMenuRoutes();
            $this->mapOtoritasRoutes();
            $this->mapParticipantsRoutes();
        });
    }

    // Administrator
    protected function mapWebRoutes()
    {
        Route::middleware('web')->group(base_path('routes/web.php'));
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')->middleware('api')->group(base_path('routes/api.php'));
    }

    protected function mapDashboardRoutes()
    {
        Route::prefix('dashboard')->group(base_path('routes/panel/dashboard.php'));
    }

    protected function mapUserRoutes()
    {
        Route::prefix('users')->group(base_path('routes/panel/users.php'));
    }

    protected function mapMenuRoutes()
    {
        Route::prefix('manajemen-menu')->group(base_path('routes/panel/menu.php'));
    }

    protected function mapOtoritasRoutes()
    {
        Route::prefix('otoritas')->group(base_path('routes/panel/otoritas.php'));
    }

    protected function mapParticipantsRoutes()
    {
        Route::prefix('participants')->group(base_path('routes/panel/participants.php'));
    }
}
