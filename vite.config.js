import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { resolve, dirname } from 'node:path'
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/scss/app.scss', 'resources/js/app.js', 'resources/js/vue_script.js', 'resources/css/app.css'],
            refresh: true,
        }),
        vue(),
    ],
    resolve: {
        alias: {
            '~bootstrap': resolve('node_modules/bootstrap'),
            'vue': 'vue/dist/vue.esm-bundler.js',
        }
    },
    server: {
        cors: true,
    },
});
