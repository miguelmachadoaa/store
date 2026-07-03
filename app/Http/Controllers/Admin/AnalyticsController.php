<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'urls');
        
        // 1. Rango de fechas (Por defecto: últimos 7 días)
        $fromDate = $request->get('from_date', Carbon::today()->subDays(6)->toDateString());
        $toDate = $request->get('to_date', Carbon::today()->toDateString());
        
        // Asegurar que el rango incluya todo el día "hasta" (23:59:59)
        $start = Carbon::parse($fromDate)->startOfDay();
        $end = Carbon::parse($toDate)->endOfDay();

        // Base query para las fichas de totales dentro del rango (Se mantiene igual)
        $statsQuery = PageView::whereBetween('created_at', [$start, $end]);

        // 2. Cálculo de métricas para las fichas
        $cards = [
            'total_views' => (clone $statsQuery)->count(),
            'unique_visitors' => (clone $statsQuery)->distinct('session_id')->count('session_id'),
            'most_visited' => (clone $statsQuery)->select('url', DB::raw('count(*) as total'))
                                ->groupBy('url')
                                ->orderByDesc('total')
                                ->first()?->url ?? 'Ninguna',
        ];

        // 3. Query principal para el listado COMPLETO (Sin agrupar)
        $query = PageView::whereBetween('created_at', [$start, $end]);

        // Filtro de búsqueda básico
        if ($request->filled('search')) {
            if ($type === 'products' || $type === 'categories') {
                $modelClass = $type === 'products' ? 'App\Models\Product' : 'App\Models\Category';
                $query->where('viewable_type', $modelClass)
                      ->whereHasMorph('viewable', [$modelClass], function($q) use ($request) {
                          $q->where('name', 'like', '%' . $request->search . '%');
                      });
            } else {
                $query->where('url', 'like', '%' . $request->search . '%');
            }
        }

        // Ejecutar consultas trayendo el listado plano e individual
        if ($type === 'products') {
            $analytics = $query->where('viewable_type', 'App\Models\Product')
                ->with('viewable')
                ->latest() // Ordena por created_at desc de forma automática
                ->paginate(15);
        } elseif ($type === 'categories') {
            $analytics = $query->where('viewable_type', 'App\Models\Category')
                ->with('viewable')
                ->latest()
                ->paginate(15);
        } else {
            // Para URLs/Páginas generales
            $analytics = $query->latest()
                ->paginate(15);
        }

        return view('admin.analytics.index', compact('analytics', 'type', 'cards', 'fromDate', 'toDate'));
    }
}