// ===========================================
// vite.config.js
// Configuração Vite para Laravel 11
// ===========================================

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            // Entry points principais
            input: [
                'resources/css/app.css',
                'resources/css/api.css',
                'resources/css/editor.css',
                'resources/js/app.js',
                'resources/js/api.js',
                'resources/js/editor.js',
            ],

            // Refresh em alterações de arquivos
            refresh: [
                'resources/views/**/*.blade.php',
                'routes/**/*.php',
                'app/Livewire/**/*.php',
            ],
        }),
    ],

    // Aliases para imports
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
            '@css': path.resolve(__dirname, 'resources/css'),
            '@components': path.resolve(__dirname, 'resources/js/components'),
            '@vendor': path.resolve(__dirname, 'resources/js/vendor'),
            'jquery': path.resolve(__dirname, 'node_modules/jquery/dist/jquery.min.js'),
        },
    },

    // Configuração de build
    build: {
        outDir: 'public/build',
        manifest: true,
        rollupOptions: {
            output: {
                manualChunks: {
                    'vendor-jquery': ['jquery'],
                    'vendor-bootstrap': ['bootstrap'],
                    'vendor-moment': ['moment'],
                },
                chunkFileNames: 'assets/js/[name]-[hash].js',
                entryFileNames: 'assets/js/[name]-[hash].js',
                assetFileNames: (assetInfo) => {
                    if (/\.(css)$/.test(assetInfo.name)) {
                        return 'assets/css/[name]-[hash][extname]';
                    }
                    if (/\.(woff|woff2|eot|ttf|otf)$/.test(assetInfo.name)) {
                        return 'assets/fonts/[name]-[hash][extname]';
                    }
                    if (/\.(png|jpg|jpeg|gif|svg|webp)$/.test(assetInfo.name)) {
                        return 'assets/images/[name]-[hash][extname]';
                    }
                    return 'assets/[name]-[hash][extname]';
                },
            },
        },
        target: 'es2020',
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true,
                drop_debugger: true,
            },
        },
        sourcemap: false,
        chunkSizeWarningLimit: 1000,
    },

    // Servidor de desenvolvimento
    server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        hmr: {
            host: 'localhost',
        },
        watch: {
            usePolling: true,
        },
    },

    // Configuração CSS
    css: {
        postcss: './postcss.config.js',
        preprocessorOptions: {
            scss: {
                additionalData: `
                    @use "resources/css/variables" as *;
                    @use "resources/css/mixins" as *;
                `,
                silenceDeprecations: ['legacy-js-api'],
            },
        },
    },

    // Otimizações
    optimizeDeps: {
        include: [
            'jquery',
            'bootstrap',
            'moment',
            'sweetalert2',
            'axios',
            'lodash-es',
        ],
    },
});
