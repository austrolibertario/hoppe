// ===========================================
// postcss.config.js
// Configuração PostCSS para Vite
// ===========================================

export default {
    plugins: {
        // Autoprefixer para compatibilidade de browsers
        autoprefixer: {},

        // CSS Nano para minificação em produção
        ...(process.env.NODE_ENV === 'production' ? {
            cssnano: {
                preset: ['default', {
                    discardComments: { removeAll: true },
                }],
            },
        } : {}),
    },
};
