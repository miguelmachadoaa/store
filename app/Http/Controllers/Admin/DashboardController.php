<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Definir fechas por defecto (últimos 30 días) o capturar las del filtro
        $startDate = $request->input('from') 
            ? Carbon::parse($request->input('from'))->startOfDay() 
            : Carbon::now()->subDays(30)->startOfDay();
            
        $endDate = $request->input('to') 
            ? Carbon::parse($request->input('to'))->endOfDay() 
            : Carbon::now()->endOfDay();

        // Totales filtrados por el rango de fechas
        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])->count();
        $totalSales = Order::whereBetween('created_at', [$startDate, $endDate])->sum('total');
        $totalProducts = Product::count(); // El total general de productos usualmente no cambia por fecha

        // Ventas por mes (Dinámico según el rango seleccionado)
        $salesByMonth = Order::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw("SUM(total) as total")
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->get();

        // Ventas por día dentro del rango seleccionado
        $salesByDay = Order::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as day"),
            DB::raw("SUM(total) as total")
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('day')
            ->orderBy('day', 'ASC')
            ->get();

        // Órdenes recientes dentro del rango
        $recentOrders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->take(5)
            ->get();

        // Productos más vendidos dentro del rango
        $topProducts = OrderItem::select('order_items.product_id', 'order_items.name', DB::raw('SUM(order_items.quantity) as total_qty'))
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->groupBy('order_items.product_id', 'order_items.name')
            ->orderBy('total_qty', 'DESC')
            ->take(5)
            ->get();

        // Productos más favoritos (Sigue siendo general)
        $topWishlist = Product::withCount('favoritedBy')
            ->orderBy('favorited_by_count', 'DESC')
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'totalOrders',
            'totalSales',
            'totalProducts',
            'salesByMonth',
            'salesByDay',
            'recentOrders',
            'topProducts',
            'topWishlist',
            'startDate',
            'endDate'
        ));
    }
}