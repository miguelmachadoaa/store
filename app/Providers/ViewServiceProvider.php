<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            // Compartir configuración globalmente, cacheando si es posible
            static $setting = null;
            if ($setting === null) {
                // Intentar obtener setting, si falla (ej. durante migración inicial), retornar null o default
                try {
                    $setting = Setting::first() ?? new Setting(['currency_preference' => 'both']);
                } catch (\Exception $e) {
                    $setting = new Setting(['currency_preference' => 'both']);
                }
            }
            $view->with('storeSettings', $setting);
        });
    }
}
