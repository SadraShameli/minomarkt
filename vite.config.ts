import laravel from 'laravel-vite-plugin';
import path from 'path';
import { defineConfig } from 'vite';

export default defineConfig({
    build: {
        manifest: true,
    },
    server: {
        port: 3000,
    },
    resolve: {
        alias: {
            '~bootstrap': path.resolve('node_modules/bootstrap'),
            '~swiper': path.resolve('node_modules/swiper'),
        },
    },
    css: {
        preprocessorOptions: {
            scss: {
                api: 'modern-compiler',
                quietDeps: true,
                silenceDeprecations: [
                    'mixed-decls',
                    'color-functions',
                    'global-builtin',
                    'import',
                ],
            },
        },
    },
    plugins: [
        laravel({
            publicDirectory: './',
            input: {
                appScripts: `assets/scripts/app.ts`,
                appStyles: `assets/styles/app.scss`,
                adminScripts: `assets/admin/admin-script.ts`,
                adminStyles: `assets/admin/admin-style.scss`,
            },
        }),
        {
            name: 'php',
            handleHotUpdate({ file, server }) {
                if (file.endsWith('.php')) {
                    server.ws.send({ type: 'full-reload', path: '*' });
                }
            },
        },
    ],
});
