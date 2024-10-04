import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',
        port: 3000,
        strictPort: true,
        watch: {
            usePolling: true, // Useful for Docker environment
        },
        hmr: {
            host: 'backpack-project.local',  // Use your host here
            port: 3000,
        },
    },
});
