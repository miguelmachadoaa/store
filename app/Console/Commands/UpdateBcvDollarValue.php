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
    public function handle()
    {
        $this->info('Iniciando la actualización del valor del dólar desde el BCV...');

        try {
            $url = 'https://www.bcv.org.ve';

            // Realizar la petición HTTP ignorando verificación SSL
            $response = Http::withoutVerifying()->get($url);

            if ($response->failed()) {
                $this->error('Error al conectar con el sitio web del BCV. Código: ' . $response->status());
                Log::error('BCV_SCRAPER: Falló la conexión HTTP.', ['status' => $response->status()]);
                return 1;
            }

            $html = $response->body();
            $value = null;

            // --- SISTEMA DE LOGS Y DIAGNÓSTICO DEL HTML ---
            // Guardamos un fragmento del HTML en el log de Laravel para revisar su estructura si falla
            if (strpos($html, 'id="dolar"') !== false) {
                // Si existe el contenedor, extraemos los 1000 caracteres alrededor para analizarlo
                $pos = strpos($html, 'id="dolar"');
                $fragmento = substr($html, $pos, 1000);
                Log::info('BCV_SCRAPER: Contenedor "dolar" detectado. Estructura HTML actual:', ['html_snippet' => $fragmento]);
            } else {
                Log::warning('BCV_SCRAPER: No se encontró el ID "dolar" en todo el HTML recibido.');
            }

            // --- PRUEBA DE DIFERENTES EXPRESIONES REGULARES ---
            // Lista de expresiones (de la más específica a la más flexible) para evitar caídas por cambios de diseño
            $regexPatterns = [
                '/id="dolar"[\s\S]*?<strong>\s*([0-9.,]+)\s*<\/strong>/i',          // Tradicional con strong
                '/id="dolar"[\s\S]*?class="field-content"[\s\S]*?>\s*([0-9.,]+)/i', // Si cambiaron strong por clases
                '/id="dolar"[\s\S]*?>\s*([0-9.,]+)/i',                              // Cualquier número pegado al contenedor
                '/class=".*?dolar.*?"[\s\S]*?>\s*([0-9.,]+)/i'                      // Si mutó de id="dolar" a class="dolar"
            ];

            foreach ($regexPatterns as $index => $pattern) {
                if (preg_match($pattern, $html, $matches)) {
                    $valueString = trim($matches[1]);
                    
                    // Limpieza de formato numérico
                    if (substr_count($valueString, '.') > 0 && substr_count($valueString, ',') > 0) {
                        $valueString = str_replace('.', '', $valueString);
                    }
                    $value = (float) str_replace(',', '.', $valueString);
                    
                    $this->info("Valor encontrado exitosamente con Patrón #{$index}: {$value}");
                    break; 
                }
            }

            // Si ningún patrón funcionó, abortamos y dejamos registro detallado
            if (is_null($value)) {
                $this->error('No se pudo encontrar el valor del dólar en el HTML.');
                $this->line('Revisa storage/logs/laravel.log para ver el HTML exacto que envió el BCV.');
                
                Log::error('BCV_SCRAPER: Todos los patrones de expresiones regulares fallaron.', [
                    'html_completo_vacio' => empty($html),
                    'longitud_html' => strlen($html)
                ]);
                return 1;
            }

            // 2. Extraer la fecha valor de la tasa
            $date = now(); 
            if (preg_match('/class="date-display-single"[^>]*?content="([^"]+)"/i', $html, $matches)) {
                try {
                    $date = Carbon::parse($matches[1]);
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
            
            $displayDate = $dollarValue->date instanceof Carbon ? $dollarValue->date->format('d/m/Y') : Carbon::parse($dollarValue->date)->format('d/m/Y');
            $this->info("Fecha DB: {$displayDate} - Valor: {$dollarValue->value}");

            return 0;

        } catch (\Exception $e) {
            $this->error('Ocurrió una excepción: ' . $e->getMessage());
            Log::critical('BCV_SCRAPER: Excepción grave en el comando.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return 1;
        }
    }
}