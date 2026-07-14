<?php

namespace App\Console\Commands;

use App\Services\DiscordNotificationService;
use Illuminate\Console\Command;
use App\Models\Order;

class SendAllDailyOrdersReport extends Command
{
    // Le asignamos una firma distinta para no chocar con el otro
    protected $signature   = 'discord:all-orders-report';
    protected $description = 'Envía el reporte detallado de todas las órdenes creadas hoy (cualquier estatus) a Discord';

    public function handle(DiscordNotificationService $discord): void
    {
        $date = now();

        // Cargamos todas las órdenes de hoy quitando el filtro de 'status'
        $orders = Order::with(['items', 'user'])
            ->whereDate('created_at', $date)
            ->get();

        if ($orders->isEmpty()) {
            $discord->allOrdersReport([
                'date'           => $date->format('d/m/Y'),
                'total_sales'    => 0,
                'total_usd'      => 0,
                'total_bs'       => 0,
                'orders_details' => []
            ]);

            $this->info('Reporte de órdenes vacío enviado.');
            return;
        }

        $reportData = [
            'date'           => $date->format('d/m/Y'),
            'total_sales'    => $orders->count(),
            'total_usd'      => $orders->sum('total'),
            'total_bs'       => $orders->sum('total_bs'),
            'orders_details' => []
        ];

        foreach ($orders as $order) {
            $productsList = [];
            
            foreach ($order->items as $item) {
                $productsList[] = [
                    'name'     => $item->name,
                    'quantity' => $item->quantity,
                    'price'    => $item->price, 
                    'total_bs' => $item->total_bs,
                ];
            }

            $reportData['orders_details'][] = [
                'status' => strtoupper($order->status), // Guardamos el estatus (PENDIENTE, PAGADA, etc.)
                'client' => [
                    'name'    => $order->customer_name,
                    'rif'     => $order->customer_rif,
                    'address' => $order->address,
                    'phone'   => $order->user ? $order->user->phone : 'No Posee', 
                    'email'   => $order->customer_email,
                ],
                'payment' => [
                    'method'   => $order->payment_method,
                    'total'    => $order->total,
                    'total_bs' => $order->total_bs,
                ],
                'products' => $productsList
            ];
        }

        $discord->allOrdersReport($reportData);

        $this->info('Reporte global de órdenes enviado.');
    }
}