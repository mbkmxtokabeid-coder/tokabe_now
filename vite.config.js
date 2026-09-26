import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/circular-gallery.js'],
            refresh: true,
        }),
    ],
    // server: {
    //     host: '0.0.0.0',
    //     hmr: {
    //         host: '192.168.3.4', // Ganti dengan IP lokal laptopmu
    //     },
    //     cors: true
    // },
});
