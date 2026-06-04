<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\Category; // Importamos el modelo de Categoría
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
            // 1. Compartir configuración globalmente
            static $setting = null;
            if ($setting === null) {
                try {
                    $setting = Setting::first() ?? new Setting(['currency_preference' => 'both']);
                } catch (\Exception $e) {
                    $setting = new Setting(['currency_preference' => 'both']);
                }
            }
            $view->with('storeSettings', $setting);

            // 2. Compartir Categorías Globales para el Menú Lateral
            static $globalCategories = null;
            if ($globalCategories === null) {
                try {
                    // Traemos solo las categorías activas
                    $globalCategories = Category::where('is_active', true)->get();
                } catch (\Exception $e) {
                    $globalCategories = collect(); // Colección vacía por si falla en migraciones
                }
            }
            $view->with('globalCategories', $globalCategories);

            // 3. Compartir items del carrito
            if (! app()->runningInConsole()) {
                try {
                    $cartItems = app()->make(\App\Http\Controllers\CartController::class)->getCartItems();
                    $view->with('cartItems', $cartItems);
                } catch (\Exception $e) {
                    $view->with('cartItems', []);
                }
            } else {
                $view->with('cartItems', []);
            }
        });
    }
}