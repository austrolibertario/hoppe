// ===========================================
// resources/js/bootstrap.js
// Configuração inicial da aplicação
// ===========================================

import axios from 'axios';
import _ from 'lodash-es';

// --------------------------------------
// Axios Configuration
// --------------------------------------
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// CSRF Token
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found');
}

// --------------------------------------
// Lodash
// --------------------------------------
window._ = _;

// --------------------------------------
// Laravel Echo (WebSockets)
// --------------------------------------
// Descomentar e configurar se usar broadcasting
/*
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    forceTLS: true
});
*/
