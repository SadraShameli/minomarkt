import dotenv from 'dotenv';
import fs from 'fs';
import path from 'path';
import { defineConfig } from 'vite';

dotenv.config();

export default defineConfig(function ({ mode }) {
    const isProd = process.env.NODE_ENV === 'production';

    if (!isProd) {
        fs.writeFileSync(path.resolve(__dirname, 'dist/hot'), '');
    }

    return {
        base: isProd
            ? `/wp-content/themes/${process.env.THEME_NAME}/dist/`
            : '/',
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
            assetsDir: 'assets',
            emptyOutDir: true,
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
            host: process.env.SITE_NAME + '.test',
            cors: true,
        },
    };
});
