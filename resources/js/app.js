// ===========================================
// resources/js/app.js
// Entry point principal
// ===========================================

// --------------------------------------
// 1. Imports de CSS
// --------------------------------------
import '../css/app.css';

// --------------------------------------
// 2. Bootstrap da aplicação
// --------------------------------------
import './bootstrap';

// --------------------------------------
// 3. Bibliotecas de terceiros
// --------------------------------------
// jQuery (necessário para plugins legados)
import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

// Bootstrap JS
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

// Moment.js para datas
import moment from 'moment';
import 'moment/locale/pt-br';
moment.locale('pt-br');
window.moment = moment;

// SweetAlert2
import Swal from 'sweetalert2';
window.Swal = Swal;

// NProgress para loading
import NProgress from 'nprogress';
window.NProgress = NProgress;

// Prism para syntax highlighting
import Prism from 'prismjs';
import 'prismjs/components/prism-javascript';
import 'prismjs/components/prism-php';
import 'prismjs/components/prism-bash';
window.Prism = Prism;

// --------------------------------------
// 4. Componentes da aplicação
// --------------------------------------
import { initNavigation } from './components/Navigation';
import { initNotifications } from './components/Notifications';
import { initImageUpload } from './components/ImageUpload';

// --------------------------------------
// 5. Configuração global
// --------------------------------------
// Config será definido inline no Blade
window.Config = window.AppConfig || {};

// --------------------------------------
// 6. Inicialização
// --------------------------------------
document.addEventListener('DOMContentLoaded', () => {
    // Inicializar componentes
    initNavigation();
    initNotifications();
    initImageUpload();

    // Syntax highlighting
    Prism.highlightAll();

    // NProgress para navegação
    NProgress.configure({ showSpinner: false });

    console.log('Hoppe App initialized');
});

// --------------------------------------
// 7. Hot Module Replacement
// --------------------------------------
if (import.meta.hot) {
    import.meta.hot.accept();
}
