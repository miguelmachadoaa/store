<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PageView;
use Symfony\Component\HttpFoundation\Response;

class TrackPageViews
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Solo registrar peticiones GET exitosas y que no sean AJAX
        if ($request->isMethod('GET') && $response->getStatusCode() == 200 && !$request->ajax()) {
            
            $viewable = null;

            // Detectar automáticamente si la ruta inyectó un Producto o Categoría
            // (Asume que tus parámetros de ruta se llaman 'product' o 'category')
            if ($request->route('product')) {
                $viewable = $request->route('product');
            } elseif ($request->route('category')) {
                $viewable = $request->route('category');
            }

            PageView::create([
                'url' => $request->getRequestUri(),
                'session_id' => $request->session()->getId(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'user_id' => auth()->id(),
                'viewable_id' => $viewable ? $viewable->id : null,
                'viewable_type' => $viewable ? get_class($viewable) : null,
            ]);
        }

        return $response;
    }
}