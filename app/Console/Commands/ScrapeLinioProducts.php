<?php

namespace App\Console\Commands;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * ─────────────────────────────────────────────────────────────
 *  php artisan scrape:linio  [opciones]
 *
 *  Opciones:
 *   --pages=5          Número de páginas a recorrer por categoría (default 5)
 *   --category=slug    Solo raspa una categoría de Linio (ej: televisores)
 *   --dry-run          Muestra los productos pero NO los inserta en la DB
 *   --download-images  Descarga las imágenes y las guarda en storage/public/products
 * ─────────────────────────────────────────────────────────────
 */
class ScrapeLinioProducts extends Command
{
    protected $signature = 'scrape:linio
                            {--pages=5 : Número de páginas a recorrer}
                            {--category= : Slug de categoría Linio específica}
                            {--dry-run : Simula sin insertar en la DB}
                            {--download-images : Descarga imágenes al storage local}';

    protected $description = 'Extrae productos de Linio Colombia y los inserta en la base de datos.';

    private array $categoryMap = [
        'computadores-y-laptops' => 'Laptops',
        'celulares-y-smartphones' => 'Smartphones',
        'televisores' => 'Televisores',
        'audio-y-sonido' => 'Audio & Sonido',
        'accesorios-tecnologia' => 'Accesorios',
        'videojuegos' => 'Gaming',
        'electrodomesticos' => 'Electrodomésticos',
        'hogar-inteligente' => 'Hogar Inteligente',
    ];

    private array $headers = [
        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
        'Accept' => 'application/json, text/html, */*',
        'Accept-Language' => 'es-CO,es;q=0.9,en;q=0.8',
        'Accept-Encoding' => 'gzip, deflate, br',
        'Referer' => 'https://www.linio.com.co/',
    ];

    private int $inserted = 0;
    private int $updated = 0;
    private int $skipped = 0;
    private int $errors = 0;

    // ─────────────────────────────────────────────────────────────────
    public function handle(): int
    {
        $this->info('');
        $this->info('╔════════════════════════════════════════╗');
        $this->info('║   Scraper Linio Colombia  →  Mi Tienda  ║');
        $this->info('╚════════════════════════════════════════╝');
        $this->info('');

        $pages = (int) $this->option('pages');
        $onlyCategory = $this->option('category');
        $dryRun = $this->option('dry-run');
        $downloadImages = $this->option('download-images');

        if ($dryRun) {
            $this->warn('⚠  Modo DRY-RUN activo — no se escribirá nada en la DB.');
        }

        $categories = $onlyCategory
            ? [$onlyCategory => $this->categoryMap[$onlyCategory] ?? Str::title(str_replace('-', ' ', $onlyCategory))]
            : $this->categoryMap;

        foreach ($categories as $linioSlug => $localName) {
            $this->info("📦  Categoría: <comment>{$localName}</comment>");
            $this->scrapeCategory($linioSlug, $localName, $pages, $dryRun, $downloadImages);
            sleep(2);
        }

        $this->info('');
        $this->info('──────────────── Resumen ────────────────');
        $this->table(
            ['✅ Insertados', '🔄 Actualizados', '⏭  Omitidos', '❌ Errores'],
            [[$this->inserted, $this->updated, $this->skipped, $this->errors]]
        );

        return self::SUCCESS;
    }

    // ─────────────────────────────────────────────────────────────────
    //  HTTP CLIENT CENTRALIZADO
    //
    //  withoutVerifying() → deshabilita validación SSL porque el
    //  certificado de linio.com.co está VENCIDO.
    //  Solo se usa para este scraper de lectura pública, nunca para
    //  operaciones con datos sensibles o pagos.
    // ─────────────────────────────────────────────────────────────────
    private function httpClient(int $timeout = 30): PendingRequest
    {
        return Http::withoutVerifying()
            ->withHeaders($this->headers)
            ->timeout($timeout);
    }

    // ─────────────────────────────────────────────────────────────────
    private function scrapeCategory(
        string $linioSlug,
        string $localName,
        int $pages,
        bool $dryRun,
        bool $downloadImages
    ): void {
        $baseUrl = "https://www.linio.com.co/api/catalog/v2/category/{$linioSlug}";

        for ($page = 1; $page <= $pages; $page++) {
            $this->line("  → Página {$page}/{$pages}");

            try {
                $products = $this->fetchPage($baseUrl, $linioSlug, $page);
            } catch (\Throwable $e) {
                $this->errors++;
                $this->warn("  ⚠  Error en página {$page}: " . $e->getMessage());
                Log::error('ScrapeLinio fetch error', ['page' => $page, 'msg' => $e->getMessage()]);
                continue;
            }

            if (empty($products)) {
                $this->line("  ℹ  Sin más productos en página {$page}. Deteniendo categoría.");
                break;
            }

            foreach ($products as $raw) {
                try {
                    $this->processProduct($raw, $localName, $dryRun, $downloadImages);
                } catch (\Throwable $e) {
                    $this->errors++;
                    $this->warn("  ⚠  Error procesando producto: " . $e->getMessage());
                    Log::error('ScrapeLinio product error', ['msg' => $e->getMessage(), 'product' => $raw]);
                }
            }

            usleep(800_000);
        }
    }

    // ─────────────────────────────────────────────────────────────────
    private function fetchPage(string $baseUrl, string $linioSlug, int $page): array
    {
        $apiUrl = "{$baseUrl}?page={$page}&limit=40&country=co";
        $response = $this->httpClient()->get($apiUrl);

        if ($response->successful()) {
            $json = $response->json();

            $products = $json['data']['products']
                ?? $json['payload']['products']
                ?? $json['products']
                ?? [];

            if (!empty($products)) {
                return $this->normalizeApiProducts($products);
            }
        }

        $this->line("  ℹ  API sin datos. Intentando HTML...");
        return $this->scrapeHtmlPage($linioSlug, $page);
    }

    // ─────────────────────────────────────────────────────────────────
    private function normalizeApiProducts(array $rawProducts): array
    {
        $normalized = [];

        foreach ($rawProducts as $p) {
            $price = (float) ($p['price'] ?? $p['special_price'] ?? 0);
            $comparePrice = (float) ($p['original_price'] ?? $p['max_saving_price'] ?? 0);

            if ($price <= 0) {
                continue;
            }

            $normalized[] = [
                'name' => trim($p['name'] ?? $p['title'] ?? ''),
                'sku' => $p['sku'] ?? $p['seller_sku'] ?? $p['id'] ?? null,
                'price' => $price,
                'compare_price' => $comparePrice > $price ? $comparePrice : null,
                'description' => $p['description'] ?? $p['short_description'] ?? null,
                'image_url' => $p['image'] ?? $p['main_image'] ?? $p['thumbnail'] ?? null,
                'brand' => $p['brand'] ?? $p['seller_name'] ?? null,
            ];
        }

        return $normalized;
    }

    // ─────────────────────────────────────────────────────────────────
    private function scrapeHtmlPage(string $linioSlug, int $page): array
    {
        $htmlUrl = "https://www.linio.com.co/{$linioSlug}?page={$page}";
        $response = $this->httpClient()->get($htmlUrl);

        if (!$response->successful()) {
            $this->warn("  ⚠  HTTP {$response->status()} al obtener {$htmlUrl}");
            return [];
        }

        return $this->parseHtml($response->body());
    }

    // ─────────────────────────────────────────────────────────────────
    private function parseHtml(string $html): array
    {
        $products = [];

        $dom = new \DOMDocument();
        @$dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
        $xpath = new \DOMXPath($dom);

        $items = $xpath->query(
            '//*[@data-sku] | //article[contains(@class,"catalogue-product")]'
        );

        foreach ($items as $item) {
            $name = $this->xpathText(
                $xpath,
                $item,
                './/*[contains(@class,"catalogue-product-title")] | .//*[@class="title"]'
            );

            $price = $this->xpathText(
                $xpath,
                $item,
                './/*[contains(@class,"price-current")] | .//*[contains(@class,"special-price")]'
            );

            $compare = $this->xpathText(
                $xpath,
                $item,
                './/*[contains(@class,"price-original")] | .//*[contains(@class,"was-price")]'
            );

            $imageNode = $xpath->query('.//*[self::img]', $item)->item(0);
            $imageUrl = null;
            if ($imageNode) {
                $imageUrl = $imageNode->getAttribute('data-src')
                    ?: $imageNode->getAttribute('src');
            }

            $sku = $item->getAttribute('data-sku') ?: $item->getAttribute('data-product-id');
            $name = trim($name ?? '');
            $price = (float) preg_replace('/[^\d.]/', '', $price ?? '0');

            if (empty($name) || $price <= 0) {
                continue;
            }

            $comparePrice = (float) preg_replace('/[^\d.]/', '', $compare ?? '0');

            $products[] = [
                'name' => $name,
                'sku' => $sku ?: null,
                'price' => $price,
                'compare_price' => $comparePrice > $price ? $comparePrice : null,
                'description' => null,
                'image_url' => $imageUrl,
                'brand' => null,
            ];
        }

        return $products;
    }

    // ─────────────────────────────────────────────────────────────────
    private function processProduct(
        array $data,
        string $categoryName,
        bool $dryRun,
        bool $downloadImages
    ): void {
        if (empty($data['name'])) {
            $this->skipped++;
            return;
        }

        $category = $this->firstOrCreateCategory($categoryName);
        $brand = !empty($data['brand']) ? $this->firstOrCreateBrand($data['brand']) : null;

        $imagePath = null;
        if (!empty($data['image_url'])) {
            $imagePath = $downloadImages
                ? $this->downloadImage($data['image_url'], $data['name'])
                : $data['image_url'];
        }

        $slug = $this->uniqueSlug($data['name'], $data['sku'] ?? null);
        $sku = $this->uniqueSku($data['sku'] ?? null, $slug);
        $price = round($data['price'], 2);
        $comparePrice = isset($data['compare_price']) ? round($data['compare_price'], 2) : null;

        if ($dryRun) {
            $this->line("  [DRY] {$data['name']} — \${$price}");
            $this->skipped++;
            return;
        }

        $existing = Product::where('sku', $sku)
            ->orWhere('slug', $slug)
            ->first();

        $payload = [
            'category_id' => $category?->id,
            'brand_id' => $brand?->id,
            'name' => $data['name'],
            'slug' => $slug,
            'description' => $data['description'] ?? null,
            'price' => $price,
            'compare_price' => $comparePrice,
            'stock' => rand(5, 100),
            'sku' => $sku,
            'image' => $imagePath,
            'is_active' => 1,
            'is_featured' => 0,
            'meta_title' => Str::limit($data['name'], 60),
            'meta_description' => isset($data['description'])
                ? Str::limit(strip_tags($data['description']), 155)
                : null,
        ];

        if ($existing) {
            $existing->update($payload);
            $this->updated++;
            $this->line("  🔄  Actualizado: {$data['name']}");
        } else {
            Product::create($payload);
            $this->inserted++;
            $this->line("  ✅  Insertado:   {$data['name']}");
        }
    }

    // ─────────────────────────────────────────────────────────────────
    //  HELPERS
    // ─────────────────────────────────────────────────────────────────

    private function firstOrCreateCategory(string $name): Category
    {
        return Category::firstOrCreate(
            ['slug' => Str::slug($name)],
            ['name' => $name, 'slug' => Str::slug($name), 'is_active' => 1]
        );
    }

    private function firstOrCreateBrand(string $name): Brand
    {
        return Brand::firstOrCreate(
            ['slug' => Str::slug($name)],
            ['name' => $name, 'slug' => Str::slug($name), 'is_active' => 1]
        );
    }

    private function uniqueSlug(string $name, ?string $sku): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $base . '-' . ($sku ? Str::slug($sku) : $i++);
            if ($i > 10) {
                $slug = $base . '-' . Str::random(5);
                break;
            }
        }

        return $slug;
    }

    private function uniqueSku(?string $sku, string $slugFallback): string
    {
        $base = strtoupper('LIN-' . ($sku ?? Str::upper(Str::random(8))));
        $s = $base;
        $i = 1;

        while (Product::where('sku', $s)->exists()) {
            $s = $base . '-' . $i++;
        }

        return $s;
    }

    private function downloadImage(string $url, string $productName): ?string
    {
        try {
            $response = $this->httpClient(15)->get($url);

            if (!$response->successful()) {
                return $url;
            }

            $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
            $filename = 'products/' . Str::slug($productName) . '-' . Str::random(6) . '.' . $ext;

            Storage::disk('public')->put($filename, $response->body());

            return $filename;
        } catch (\Throwable) {
            return $url;
        }
    }

    private function xpathText(\DOMXPath $xpath, \DOMNode $context, string $query): ?string
    {
        $node = $xpath->query($query, $context)?->item(0);
        return $node ? trim($node->textContent) : null;
    }
}