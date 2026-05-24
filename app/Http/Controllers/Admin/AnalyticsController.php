<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        // Filtro por tipo de reporte (urls, productos, categorias)
        $type = $request->get('type', 'urls');

        $query = PageView::query();

        // Filtro de búsqueda básico
        if ($request->filled('search')) {
            $query->where('url', 'like', '%' . $request->search . '%');
        }

        if ($type === 'products') {
            // Filtrar y agrupar solo visitas que tengan un Producto asociado polimórficamente
            $analytics = $query->where('viewable_type', 'App\Models\Product')
                ->select('viewable_id', 'viewable_type', DB::raw('count(*) as total_views'), DB::raw('MAX(created_at) as last_view'))
                ->with('viewable')
                ->groupBy('viewable_id', 'viewable_type')
                ->orderByDesc('total_views')
                ->paginate(10);
        } elseif ($type === 'categories') {
            // Filtrar y agrupar solo visitas de Categorías
            $analytics = $query->where('viewable_type', 'App\Models\Category')
                ->select('viewable_id', 'viewable_type', DB::raw('count(*) as total_views'), DB::raw('MAX(created_at) as last_view'))
                ->with('viewable')
                ->groupBy('viewable_id', 'viewable_type')
                ->orderByDesc('total_views')
                ->paginate(10);
        } else {
            // Por defecto: Las URLs generales más vistas de la App
            $analytics = $query->select('url', DB::raw('count(*) as total_views'), DB::raw('MAX(created_at) as last_view'))
                ->groupBy('url')
                ->orderByDesc('total_views')
                ->paginate(10);
        }

        return view('admin.analytics.index', compact('analytics', 'type'));
    }
}