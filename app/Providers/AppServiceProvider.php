<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        // Directiva @hasPermission
        Blade::if('hasPermission', function ($permission) {
            return auth()->check() && auth()->user()->hasPermission($permission);
        });
        
        // Directiva @hasAnyPermission
        Blade::if('hasAnyPermission', function (...$permissions) {
            if (!auth()->check()) {
                return false;
            }
            
            foreach ($permissions as $permission) {
                if (auth()->user()->hasPermission($permission)) {
                    return true;
                }
            }
            
            return false;
        });
        
        // Directiva @hasAllPermissions
        Blade::if('hasAllPermissions', function (...$permissions) {
            if (!auth()->check()) {
                return false;
            }
            
            foreach ($permissions as $permission) {
                if (!auth()->user()->hasPermission($permission)) {
                    return false;
                }
            }
            
            return true;
        });
    }
}
