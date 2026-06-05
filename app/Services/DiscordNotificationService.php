<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\DiscordEmbedBuilder;

class DiscordNotificationService
{
    public function send(string $channel, array $payload): bool
    {
        if (! config('discord.enabled')) {
            return false;
        }

        $webhookUrl = config("discord.webhooks.{$channel}");

        if (! $webhookUrl) {
            Log::warning("Discord webhook no configurado para el canal: {$channel}");
            return false;
        }

        $body = json_encode(array_merge([
            'username'   => config('discord.username'),
            'avatar_url' => config('discord.avatar_url'),
        ], $payload));

        $ch = curl_init($webhookUrl);

        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $body,
            CURLOPT_SSL_VERIFYPEER => false,   // ← agrega esto
            CURLOPT_SSL_VERIFYHOST => false,   // ← y esto
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($body),
            ],
        ]);

        $responseBody = curl_exec($ch);
        $httpStatus   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError    = curl_error($ch);

        curl_close($ch);

        if ($curlError) {
            Log::error('Discord webhook error cURL', [
                'channel' => $channel,
                'error'   => $curlError,
            ]);
            return false;
        }

        if ($httpStatus < 200 || $httpStatus >= 300) {
            Log::error('Discord webhook falló', [
                'channel' => $channel,
                'status'  => $httpStatus,
                'body'    => $responseBody,
            ]);
            return false;
        }

        return true;
    }

    public function purchase(array $data): bool
    {
        return $this->send('purchases', [
            'embeds' => [
                DiscordEmbedBuilder::make()
                    ->title('🛒 Nueva compra')
                    ->color(0x57F287) // verde
                    ->field('Cliente',  $data['customer_name'], true)
                    ->field('Email',    $data['customer_email'], true)
                    ->field('RIF',      $data['customer_rif'], true)
                    ->field('Dirección', $data['customer_address'], true)
                    ->field('Teléfono', $data['customer_phone'], true)
                    ->field('Total',    '$' . number_format($data['total'], 2), true)
                    ->field('Orden #',  $data['order_id'], true)
                    ->field('Productos', $data['items_summary'])
                    ->timestamp()
                    ->build(),
            ],
        ]);
    }

    public function register(array $data): bool
    {
        return $this->send('registers', [
            'embeds' => [
                DiscordEmbedBuilder::make()
                    ->title('👤 Nuevo registro')
                    ->color(0x5865F2) // blaze blue
                    ->field('Nombre', $data['name'], true)
                    ->field('Email',  $data['email'], true)
                    ->field('Origen', $data['source'] ?? 'Orgánico', true)
                    ->timestamp()
                    ->build(),
            ],
        ]);
    }

    public function abandonedCart(array $data): bool
    {
        return $this->send('carts', [
            'embeds' => [
                DiscordEmbedBuilder::make()
                    ->title('🛒 Carrito abandonado')
                    ->color(0xFEE75C) // amarillo
                    ->field('Cliente',  $data['customer_name'] ?? 'Anónimo', true)
                    ->field('Total',    '$' . number_format($data['cart_total'], 2), true)
                    ->field('Items',    (string) $data['items_count'], true)
                    ->field('Último visto', $data['last_seen'])
                    ->timestamp()
                    ->build(),
            ],
        ]);
    }

    public function dailyReport(array $data): bool
    {
        return $this->send('reports', [
            'embeds' => [
                DiscordEmbedBuilder::make()
                    ->title('📊 Reporte diario — ' . now()->format('d/m/Y'))
                    ->color(0xEB459E) // fucsia
                    ->field('Visitas',      (string) $data['visits'],       true)
                    ->field('Ventas',       (string) $data['sales_count'],  true)
                    ->field('Ingresos',     '$' . number_format($data['revenue'], 2), true)
                    ->field('Registros',    (string) $data['new_users'],    true)
                    ->field('Carritos ab.', (string) $data['abandoned'],    true)
                    ->field('Conversión',   $data['conversion_rate'] . '%', true)
                    ->timestamp()
                    ->build(),
            ],
        ]);
    }

    public function paymentReport(array $data): bool
    {

        return $this->send('reports', [
            'embeds' => [
                DiscordEmbedBuilder::make()
                    ->title('💳 Reporte de pagos ')
                    ->color(0xED4245) // rojo
                    ->field('Cliente',  $data['customer_name'] ?? 'Desconocido', true)
                    ->field('Email',    $data['customer_email'] ?? 'N/A', true)
                    ->field('Orden #',  $data['order_id'] ?? 'N/A', true)
                    ->field('Monto',    '$' . number_format($data['amount_bs'], 2), true)
                    ->field('Banco',    $data['bank_name'] ?? 'N/A', true)
                    ->field('Fecha de pago', $data['payment_date'] ?? 'N/A', true)
                    ->field('Referencia', $data['reference_number'] ?? 'N/A', true)
                    ->field('Error',    $data['error_message'] ?? 'No disponible')
                    ->timestamp()
                    ->build(),
            ],
        ]);
    }
}