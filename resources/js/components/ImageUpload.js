// ===========================================
// resources/js/components/ImageUpload.js
// Upload de imagens
// ===========================================

import axios from 'axios';

export function initImageUpload() {
    document.querySelectorAll('[data-image-upload]').forEach(element => {
        setupImageUpload(element);
    });
}

function setupImageUpload(element) {
    const input = element.querySelector('input[type="file"]');
    const preview = element.querySelector('.image-preview');
    const uploadUrl = element.dataset.uploadUrl || window.Config?.routes?.upload_image;

    if (!input || !uploadUrl) return;

    input.addEventListener('change', async (e) => {
        const file = e.target.files[0];
        if (!file) return;

        // Validar tipo
        if (!file.type.startsWith('image/')) {
            window.Swal?.fire('Erro', 'Por favor, selecione uma imagem válida.', 'error');
            return;
        }

        // Validar tamanho (max 5MB)
        if (file.size > 5 * 1024 * 1024) {
            window.Swal?.fire('Erro', 'A imagem deve ter no máximo 5MB.', 'error');
            return;
        }

        // Upload
        const formData = new FormData();
        formData.append('file', file);

        try {
            element.classList.add('uploading');

            const response = await axios.post(uploadUrl, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            });

            // Mostrar preview
            if (preview && response.data.url) {
                preview.innerHTML = `<img src="${response.data.url}" alt="Preview">`;
            }

            // Trigger evento customizado
            element.dispatchEvent(new CustomEvent('upload:success', {
                detail: response.data
            }));

        } catch (error) {
            console.error('Upload failed:', error);
            window.Swal?.fire('Erro', 'Falha ao enviar imagem.', 'error');
        } finally {
            element.classList.remove('uploading');
        }
    });
}
