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

        // Órdenes recientes
        $recentOrders = Order::latest()->take(5)->get();

        // Productos más vendidos
        $topProducts = OrderItem::select('product_id', 'name', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('product_id', 'name')
            ->orderBy('total_qty', 'DESC')
            ->take(5)
            ->get();

        // Productos más favoritedos
        $topWishlist = Product::withCount('favoritedBy')
            ->orderBy('favorited_by_count', 'DESC')
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'totalOrders',
            'totalSales',
            'totalProducts',
            'salesByMonth',
            'recentOrders',
            'topProducts',
            'topWishlist'
        ));
    }
}