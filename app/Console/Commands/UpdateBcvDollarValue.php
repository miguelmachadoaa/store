<?php

namespace App\Console\Commands;

use App\Models\DollarValue;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

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
    public function handle()
    {
        $this->info('Iniciando la actualización del valor del dólar desde el BCV...');

        try {
            // URL del sitio BCV (usar HTTP si HTTPS falla o desactivar verificación)
            $url = 'http://www.bcv.org.ve';

            // Realizar la petición HTTP ignorando verificación SSL por problemas comunes del sitio BCV
            $response = Http::withoutVerifying()->get($url);

            if ($response->failed()) {
                $this->error('Error al conectar con el sitio web del BCV. Código: ' . $response->status());
                return 1;
            }

            $html = $response->body();

            // 1. Extraer el valor del dólar
            // El regex busca el div id="dolar", cualquier cosa hasta encontrar strong, captura dígitos y comas, cierra strong
            // Se usa [\d,.]+ para permitir puntos si cambiaran formato, pero nos aseguramos.
            if (preg_match('/<div id="dolar".*?<strong>\s*([0-9.,]+)\s*<\/strong>/s', $html, $matches)) {
                $valueString = $matches[1];
                // Reemplazar coma por punto para formato decimal estándar
                $value = str_replace(',', '.', $valueString);

                $this->info("Valor encontrado: {$value}");
            } else {
                $this->error('No se pudo encontrar el valor del dólar en el HTML.');
                return 1;
            }

            // 2. Extraer la fecha valor (opcional, si no se encuentra se usa hoy)
            $date = now(); // Por defecto hoy
            if (preg_match('/class="date-display-single".*?content="([^"]+)"/s', $html, $matches)) {
                try {
                    $dateString = $matches[1];
                    // El formato es ISO 8601
                    $date = Carbon::parse($dateString);
                    $this->info("Fecha extraída del sitio: " . $date->format('d/m/Y'));
                } catch (\Exception $e) {
                    $this->warn('No se pudo parsear la fecha del sitio, se usará la fecha actual.');
                }
            } else {
                $this->warn('No se encontró la fecha en el sitio, se usará la fecha actual.');
            }

            // 3. Guardar o Actualizar en la base de datos
            $dollarValue = DollarValue::updateOrCreate(
                ['date' => $date->format('Y-m-d')],
                ['value' => $value]
            );

            $this->info('¡Valor del dólar actualizado correctamente!');
            $this->info("Fecha: {$dollarValue->date->format('d/m/Y')} - Valor: {$dollarValue->value}");

            return 0;

        } catch (\Exception $e) {
            $this->error('Ocurrió una excepción: ' . $e->getMessage());
            return 1;
        }
    }
}
