// ===========================================
// resources/js/api.js
// Bundle específico para views da API
// ===========================================

import '../css/api.css';

// Emojify
import emojify from 'emojify.js';

// Configuração do emojify
emojify.setConfig({
    emojify_tag_type: 'div',
    only_crawl_id: null,
    img_dir: 'https://cdn.jsdelivr.net/emojione/assets/png',
    ignored_tags: {
        'SCRIPT': 1,
        'TEXTAREA': 1,
        'A': 1,
        'PRE': 1,
        'CODE': 1
    }
});

// Aplicar emojify ao carregar
document.addEventListener('DOMContentLoaded', () => {
    emojify.run();
});

// Exportar para uso global
window.emojify = emojify;
