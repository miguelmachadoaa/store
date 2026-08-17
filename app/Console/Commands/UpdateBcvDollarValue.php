<?php

namespace App\Console\Commands;

use App\Models\DollarValue;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateBcvDollarValue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-bcv-dollar-value';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the dollar value from the BCV website.';

    /**
     * Execute the console command.
     */
   public function handle(): int
    {
        $apiKey = config('services.cotizave.api_key');

        if (!$apiKey) {
            $this->error('La API Key de Cotizave no está configurada en .env');
            return Command::FAILURE;
        }

        $this->info('Consultando API de Cotizave...');

        $response = Http::withHeaders([
            'X-API-Key' => $apiKey,
            'Accept'    => 'application/json',
        ])->timeout(10)->get('https://api.cotizave.com/v1/fx/index');

        if ($response->successful()) {
            $data = $response->json();

            // Prioriza la tasa del BCV oficial; si no existe, toma el valor ponderado del índice 'value'
            $tasa = $data['components']['bcv'] ?? $data['value'] ?? null;

            if ($tasa === null) {
                $this->error('No se pudo extraer el valor del dólar en la respuesta de Cotizave.');
                return Command::FAILURE;
            }

            // Fecha actual del sistema (YYYY-MM-DD)
            $today = now()->toDateString();

            // Guardar o actualizar en el modelo DollarValue
            $dollarRecord = DollarValue::updateOrCreate(
                ['date' => $today],
                ['value' => $tasa]
            );

            $this->info("Tasa registrada exitosamente: Fecha [{$dollarRecord->date->format('Y-m-d')}] | Valor [{$dollarRecord->value}]");

            Log::info('Tasa BCV/Cotizave registrada en BD', [
                'date'  => $dollarRecord->date,
                'value' => $dollarRecord->value,
            ]);

            return Command::SUCCESS;
        }

        $this->error('Error al consultar la API. Código HTTP: ' . $response->status());
        $this->error('Respuesta: ' . $response->body());

        return Command::FAILURE;
    }
}