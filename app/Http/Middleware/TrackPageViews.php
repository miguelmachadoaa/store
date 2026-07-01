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

        // Esto cubre tanto "admin" como "admin/usuarios", "admin/productos", etc.
        if ($request->is('admin') || $request->is('admin/*')) {
            return $response;
        }

        // Solo registrar peticiones GET exitosas y que no sean AJAX
        if ($request->isMethod('GET') && $response->getStatusCode() == 200 && !$request->ajax()) {
            
            $viewable = null;

            // Detectar automáticamente si la ruta inyectó un Producto o Categoría
            if ($request->route('product')) {
                $viewable = $request->route('product');
            } elseif ($request->route('category')) {
                $viewable = $request->route('category');
            }

            // 1. Capturar todos los parámetros de la Query String
            $queryParams = $request->query();

            // Si viene un parámetro roto/sin clave (como el '?  =IwZX...'), PHP lo mete al array.
            // Para asegurarnos de capturar todo el query crudo si falla el parseo, podemos limpiar espacios:
            if (empty($queryParams) && !empty($request->getQueryString())) {
                parse_str(str_replace(' ', '', $request->getQueryString()), $queryParams);
            }

            // 2. Extraer UTMs específicos limpiamente
            $utmData = [
                'utm_source'   => $queryParams['utm_source'] ?? null,
                'utm_medium'   => $queryParams['utm_medium'] ?? null,
                'utm_campaign' => $queryParams['utm_campaign'] ?? null,
                'utm_content'  => $queryParams['utm_content'] ?? null,
                'utm_term'     => $queryParams['utm_term'] ?? null,
            ];

            // 3. Identificar el origen principal si no vienen UTMs directos
            // Si viene fbclid (Facebook Click ID) pero no trae utm_source, asumimos que es tráfico de Meta/Instagram
            if (isset($queryParams['fbclid']) && empty($utmData['utm_source'])) {
                $utmData['utm_source'] = 'meta'; 
                $utmData['utm_medium'] = 'social';
            }

            PageView::create([
                'url'           => $request->getPathInfo(), // Guarda solo la ruta limpia (/category/pulseras) sin el chorizo de parámetros
                'session_id'    => $request->session()->getId(),
                'ip_address'    => $request->ip(),
                'user_agent'    => $request->userAgent(),
                'user_id'       => auth()->id(),
                'viewable_id'   => $viewable ? $viewable->id : null,
                'viewable_type' => $viewable ? get_class($viewable) : null,
                
                // Nuevos campos para analítica de marketing
                'utm_source'    => $utmData['utm_source'],
                'utm_medium'    => $utmData['utm_medium'],
                'utm_campaign'  => $utmData['utm_campaign'],
                'utm_content'   => $utmData['utm_content'],
                'utm_term'      => $utmData['utm_term'],
                
                // Guardamos TODO el set de parámetros en JSON para el futuro (incluye fbclid, etc.)
                'meta_data'     => !empty($queryParams) ? $queryParams : null,
            ]);
        }

        return $response;
    }
}