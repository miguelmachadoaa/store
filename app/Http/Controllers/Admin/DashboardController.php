<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Totales
        $totalOrders = Order::count();
        $totalSales = Order::sum('total');
        $totalProducts = Product::count();

        // Ventas por mes (últimos 6 meses)
        $salesByMonth = Order::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw("SUM(total) as total")
        )
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->take(6)
            ->get();

        // NUEVO: Ventas por día (Últimos 30 días)
        $salesByDay = Order::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as day"),
            DB::raw("SUM(total) as total")
        )
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('day')
            ->orderBy('day', 'ASC')
            ->get();

        // Órdenes recientes
        $recentOrders = Order::latest()->take(5)->get();

        // Productos más vendidos
        $topProducts = OrderItem::select('product_id', 'name', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('product_id', 'name')
            ->orderBy('total_qty', 'DESC')
            ->take(5)
            ->get();

        // Productos más favoritos
        $topWishlist = Product::withCount('favoritedBy')
            ->orderBy('favorited_by_count', 'DESC')
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'totalOrders',
            'totalSales',
            'totalProducts',
            'salesByMonth',
            'salesByDay', // <-- Pasamos la nueva variable a la vista
            'recentOrders',
            'topProducts',
            'topWishlist'
        ));
    }
}