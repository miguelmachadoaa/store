<?php

namespace App\Console\Commands;

use App\Services\DiscordNotificationService;
use Illuminate\Console\Command;
use App\Models\PageView;
use App\Models\Order;
use App\Models\User;
use App\Models\Cart; 

class SendDailyDiscordReport extends Command
{
    protected $signature   = 'discord:daily-report';
    protected $description = 'Envía el reporte diario a Discord';

    public function handle(DiscordNotificationService $discord): void
    {
        $yesterday = now()->subDay();

        $discord->dailyReport([
            'visits'          => PageView::whereDate('created_at', $yesterday)->count(),
            'sales_count'     => Order::whereDate('created_at', $yesterday)->count(),
            'revenue'         => Order::whereDate('created_at', $yesterday)->sum('total'),
            'new_users'       => User::whereDate('created_at', $yesterday)->count(),
            'abandoned'       => Cart::whereDate('created_at', $yesterday)->count(),
            'conversion_rate' => $this->calcConversion($yesterday),
        ]);

        $this->info('Reporte enviado.');
    }

    private function calcConversion($date): float
    {
        $visits = PageView::whereDate('created_at', $date)->count();
        $sales  = Order::whereDate('created_at', $date)->count();
        return $visits > 0 ? round(($sales / $visits) * 100, 2) : 0;
    }
}