import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    server: {
        host: '0.0.0.0',
        hmr: {
            host: '127.0.0.1'
        },
        port: 5173,
    },
    plugins: [
        laravel({
            input: [
                'src/resources/sass/app.scss',
                'src/resources/js/app.js',
            ],
            publicDirectory: 'src/public',
            refresh: false,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    }
});
