<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MigrarArchivosAR2 extends Command
{
    // El comando que ejecutarás en la consola
    protected $signature = 'storage:migrate-to-r2';

    // La descripción del comando
    protected $description = 'Sube todos los archivos del almacenamiento local a Cloudflare R2';

    public function handle()
    {
        $this->info('Iniciando la migración de archivos a Cloudflare R2...');

        // Disco de origen (cambialo a 'local' si no usas el link público)
        $discoLocal = Storage::disk('public'); 
        $discoR2 = Storage::disk('r2');

        // Obtener todos los archivos recursivamente
        $archivos = $discoLocal->allFiles();
        $total = count($archivos);

        if ($total === 0) {
            $this->warn('No se encontraron archivos para migrar.');
            return 0;
        }

        $this->info("Se encontraron {$total} archivos. Comenzando la subida...");

        // Barra de progreso para la consola
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        foreach ($archivos as $archivo) {
            // Validar si el archivo ya existe en R2 para no perder tiempo re-subiendo
            if (!$discoR2->exists($archivo)) {
                // Leer el archivo localmente y transmitirlo (stream) a R2 para cuidar la RAM
                $stream = $discoLocal->readStream($archivo);
                
                if ($stream) {
                    $discoR2->putStream($archivo, $stream);
                }
            }
            
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info('¡Migración completada con éxito!');
        return 0;
    }
}