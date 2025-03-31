import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import {nodePolyfills} from 'vite-plugin-node-polyfills'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/topBarMenu.js'],
            refresh: true,
        }),
        nodePolyfills(),
    ],
    alias: {
        "source-map-js": "source-map"
    }
});
