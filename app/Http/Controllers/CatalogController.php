<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CatalogController extends Controller
{
    public function download(Request $request)
    {
        set_time_limit(180);
        ini_set('memory_limit', '512M');

        $query = Product::query()
            ->with(['stones', 'category'])
            ->where('is_active', true);

        // Filtros opcionales: ?category=ID  ?in_stock=1
        if ($request->filled('category')) {
            $query->whereHas('categories', fn ($q) => $q->where('categories.id', $request->category));
        }

        if ($request->boolean('in_stock')) {
            $query->where('stock', '>', 0);
        }

        $products = $query->orderBy('name')->get();

        $images = [];
        foreach ($products as $product) {
            $images[$product->id] = $this->imageDataUri($product->image);
        }

        $pdf = Pdf::loadView('pdf.catalog', compact('products', 'images'))
            ->setPaper('letter', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('defaultFont', 'DejaVu Serif');

        return $pdf->download('Catalogo_Amuletos_Mary_' . now()->format('Ymd') . '.pdf');
    }

    /**
     * Devuelve la imagen como data URI (JPEG reducido). Solo cachea resultados exitosos.
     */
    private function imageDataUri(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        return Cache::remember('catalog_img_v2_' . md5($path), now()->addDay(), function () use ($path) {
            $binary = $this->fetchImageBinary($path);

            if (! $binary) {
                Log::warning("Catálogo PDF: no se pudo obtener la imagen '{$path}'");
                return null;
            }

            return $this->toDataUri($binary, $path);
        });
    }

    /**
     * Intenta obtener los bytes: URL completa -> disco R2 (API S3) -> URL pública del disco.
     */
    private function fetchImageBinary(string $path): ?string
    {
        // 1. El campo ya guarda una URL completa
        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $this->httpGet($path);
        }

        $path = ltrim($path, '/');

        // 2. Lectura directa del disco r2
        try {
            $binary = Storage::disk('r2')->get($path);
            if ($binary) {
                return $binary;
            }
        } catch (\Throwable $e) {
            Log::warning("Catálogo PDF: Storage r2->get falló para '{$path}': " . $e->getMessage());
        }

        // 3. URL pública del disco (la misma que usas en inlineUpdate)
        try {
            return $this->httpGet(Storage::disk('r2')->url($path));
        } catch (\Throwable $e) {
            Log::warning("Catálogo PDF: URL pública r2 falló para '{$path}': " . $e->getMessage());
        }

        return null;
    }

    private function httpGet(string $url): ?string
    {
        try {
            $response = Http::timeout(20)->get($url);
            return $response->successful() ? $response->body() : null;
        } catch (\Throwable $e) {
            Log::warning("Catálogo PDF: HTTP falló para '{$url}': " . $e->getMessage());
            return null;
        }
    }

    /**
     * Reduce con GD a ~700px y convierte a JPEG. Si GD no puede leerla (p. ej. WEBP sin soporte),
     * usa los bytes originales cuando sea JPEG/PNG/GIF.
     */
    private function toDataUri(string $binary, string $path): ?string
    {
        $src = @imagecreatefromstring($binary);

        if ($src) {
            $w = imagesx($src);
            $h = imagesy($src);
            $newW = min(700, $w);
            $newH = (int) round($h * ($newW / $w));

            $dst = imagecreatetruecolor($newW, $newH);
            imagefill($dst, 0, 0, imagecolorallocate($dst, 255, 255, 255));
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $w, $h);

            ob_start();
            imagejpeg($dst, null, 82);
            $jpeg = ob_get_clean();

            imagedestroy($src);
            imagedestroy($dst);

            return 'data:image/jpeg;base64,' . base64_encode($jpeg);
        }

        $mime = (new \finfo(FILEINFO_MIME_TYPE))->buffer($binary);
        if (in_array($mime, ['image/jpeg', 'image/png', 'image/gif'], true)) {
            return "data:{$mime};base64," . base64_encode($binary);
        }

        Log::warning("Catálogo PDF: formato no soportado ({$mime}) para '{$path}'. Si es WEBP, habilita soporte WEBP en GD.");
        return null;
    }
}