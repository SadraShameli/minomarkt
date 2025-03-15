import fs from 'fs';
import path from 'path';
import { defineConfig, loadEnv } from 'vite';

export default defineConfig(function ({ mode }) {
    const env = loadEnv(mode, process.cwd());

    if (env.NODE_ENV !== 'production') {
        fs.writeFileSync(path.resolve(__dirname, 'dist/hot'), '');
    }

    return {
        build: {
            manifest: true,
            rollupOptions: {
                input: {
                    appScripts: `assets/scripts/app.ts`,
                    appStyles: `assets/styles/app.scss`,
                    adminScripts: `assets/admin/admin-script.ts`,
                    adminStyles: `assets/admin/admin-style.scss`,
                },
            },
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
        server: {
            host: env.VITE_WP_SITEURL,
        },
    };
});
