<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand', 'tax']);

        // 1. Filtrado por texto (Nombre, SKU o Descripción)
        if ($request->filled('search')) {
            $searchTerms = array_filter(explode(' ', trim($request->search)));
            $query->where(function ($q) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $q->where(function ($subQ) use ($term) {
                        $subQ->where('name', 'LIKE', "%{$term}%")
                             ->orWhere('sku', 'LIKE', "%{$term}%")
                             ->orWhere('description', 'LIKE', "%{$term}%");
                    });
                }
            });
        }

        // 2. Filtro por Categoría
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 3. Filtro por Marca
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        // 4. Filtro por Estado de Stock
        if ($request->filled('stock_status')) {
            match ($request->stock_status) {
                'out_of_stock' => $query->where('stock', '<=', 0),
                'low_stock'    => $query->whereBetween('stock', [1, 5]),
                'in_stock'     => $query->where('stock', '>', 5),
                default        => null
            };
        }

        // 5. Filtro por Estado Activo/Inactivo
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        // Accion de Exportar a CSV/Excel
        if ($request->has('export') && $request->export === 'csv') {
            return $this->exportToCsv($query);
        }

        // Paginación y preservación de query strings
        $products = $query->orderBy('stock', 'asc')->paginate(15)->withQueryString();

        // Métrica rápida para la vista
        $rate = Product::getDollarRate();
        $totalStockUnits = (clone $query)->sum('stock');
        $lowStockCount = Product::where('stock', '>', 0)->where('stock', '<=', 5)->count();
        $outOfStockCount = Product::where('stock', '<=', 0)->count();

        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.inventory.index', compact(
            'products', 
            'categories', 
            'brands', 
            'rate', 
            'totalStockUnits', 
            'lowStockCount', 
            'outOfStockCount'
        ));
    }

    /**
     * Descargar reporte CSV filtrado
     */
    private function exportToCsv($query): StreamedResponse
    {
        $fileName = 'inventario_zolum_' . date('Y-m-d_H-i') . '.csv';
        $rate = Product::getDollarRate();

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        return response()->stream(function () use ($query, $rate) {
            $file = fopen('php://output', 'w');
            
            // BOM para compatibilidad con caracteres en Excel (UTF-8)
            fputs($file, "\xEF\xBB\xBF");

            // Encabezados de columnas
            fputcsv($file, [
                'ID',
                'SKU',
                'Nombre del Producto',
                'Categoría',
                'Marca',
                'Stock Actual',
                'Estado Stock',
                'Precio ($)',
                'Precio (Bs.)',
                'Estatus',
                'Tasa BCV Aplicada'
            ], ';');

            // Recorrer los registros filtrados en lotes de 100
            $query->chunk(100, function ($products) use ($file, $rate) {
                foreach ($products as $product) {
                    $stockStatus = 'Normal';
                    if ($product->stock <= 0) {
                        $stockStatus = 'Agotado';
                    } elseif ($product->stock <= 5) {
                        $stockStatus = 'Bajo Stock';
                    }

                    fputcsv($file, [
                        $product->id,
                        $product->sku ?? 'N/A',
                        $product->name,
                        $product->category->name ?? 'Sin Categoría',
                        $product->brand->name ?? 'Sin Marca',
                        $product->stock,
                        $stockStatus,
                        number_format($product->price, 2, ',', '.'),
                        number_format($product->price_bs, 2, ',', '.'),
                        $product->is_active ? 'Activo' : 'Inactivo',
                        number_format($rate, 2, ',', '.')
                    ], ';');
                }
            });

            fclose($file);
        }, 200, $headers);
    }
}