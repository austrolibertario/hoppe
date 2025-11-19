// ===========================================
// resources/js/editor.js
// Bundle específico para o editor SimpleMDE
// ===========================================

import '../css/editor.css';

// SimpleMDE
import SimpleMDE from 'simplemde';

// Exportar para uso global
window.SimpleMDE = SimpleMDE;

// Função de inicialização do editor
export function initEditor(element, options = {}) {
    const defaultOptions = {
        element: element,
        spellChecker: false,
        autosave: {
            enabled: true,
            uniqueId: 'hoppe-editor',
            delay: 1000,
        },
        toolbar: [
            'bold', 'italic', 'heading', '|',
            'quote', 'unordered-list', 'ordered-list', '|',
            'link', 'image', 'code', '|',
            'preview', 'side-by-side', 'fullscreen', '|',
            'guide'
        ],
        placeholder: 'Escreva seu conteúdo aqui...',
        status: ['autosave', 'lines', 'words'],
    };

    return new SimpleMDE({ ...defaultOptions, ...options });
}

// Auto-inicializar editores
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-editor]').forEach(el => {
        initEditor(el);
    });
});
