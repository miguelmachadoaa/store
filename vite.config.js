import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',   // <--- Archivo 1: Para el Admin
                'resources/css/front.css', // <--- Archivo 2: Para la Tienda (¡Lo agregamos aquí!)
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});