<?php

namespace App\Console\Commands;

use App\Mail\AbandonedCartMail;
use App\Models\Cart;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendAbandonedCartReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-abandoned-cart-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminders to users with abandoned carts';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Find carts updated more than 24 hours ago but less than 48 hours ago
        // to avoid spamming.
        $abandonedCarts = Cart::where('updated_at', '<=', Carbon::now()->subHours(24))
            ->where('updated_at', '>=', Carbon::now()->subHours(48))
            ->whereNotNull('user_id')
            ->whereHas('items')
            ->get();

        foreach ($abandonedCarts as $cart) {
            /** @var \App\Models\Cart $cart */
            // Here you could check if an email was already sent for this cart session
            // For simplicity, we just send it.
            Mail::to($cart->user->email)->send(new AbandonedCartMail($cart));

            $this->info("Reminder sent to: {$cart->user->email}");
        }

        $this->info('Abandoned cart reminders process completed.');
    }
}
