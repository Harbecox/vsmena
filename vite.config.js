import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import { resolve, dirname } from 'node:path'
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/scss/app.scss', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '~bootstrap': resolve('node_modules/bootstrap'),
        }
    },
    server: {
        cors: true,
    },
});
