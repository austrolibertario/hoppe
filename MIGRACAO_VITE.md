# Migração Laravel Mix/Gulp → Vite

Este documento detalha a migração do sistema de build de Laravel Mix e Gulp (Laravel Elixir) para Vite, compatível com Laravel 11.

---

## Bloco 1: vite.config.js

```javascript
// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            // ===========================================
            // Entry points principais
            // ===========================================
            input: [
                // CSS
                'resources/css/app.css',           // Estilos principais (compilado de SCSS)
                'resources/css/api.css',           // Estilos da API
                'resources/css/editor.css',        // Estilos do editor

                // JavaScript
                'resources/js/app.js',             // Bundle principal
                'resources/js/api.js',             // Bundle da API
                'resources/js/editor.js',          // Bundle do editor SimpleMDE
            ],

            // ===========================================
            // Configuração de refresh
            // ===========================================
            refresh: [
                'resources/views/**/*.blade.php',
                'routes/**/*.php',
                'app/Livewire/**/*.php',           // Se usar Livewire
            ],
        }),
    ],

    // ===========================================
    // Aliases para imports mais limpos
    // ===========================================
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
            '@css': path.resolve(__dirname, 'resources/css'),
            '@components': path.resolve(__dirname, 'resources/js/components'),
            '@vendor': path.resolve(__dirname, 'resources/js/vendor'),

            // jQuery global (necessário para plugins legados)
            'jquery': path.resolve(__dirname, 'node_modules/jquery/dist/jquery.min.js'),
        },
    },

    // ===========================================
    // Build configuration
    // ===========================================
    build: {
        // Output directory
        outDir: 'public/build',

        // Manifest para Laravel
        manifest: true,

        // Rollup options
        rollupOptions: {
            output: {
                // Organização dos chunks
                manualChunks: {
                    // Vendor chunk para bibliotecas grandes
                    'vendor-jquery': ['jquery'],
                    'vendor-bootstrap': ['bootstrap'],
                    'vendor-moment': ['moment'],
                    'vendor-sweetalert': ['sweetalert2'],
                },

                // Nomes de arquivos
                chunkFileNames: 'assets/js/[name]-[hash].js',
                entryFileNames: 'assets/js/[name]-[hash].js',
                assetFileNames: (assetInfo) => {
                    // Organizar assets por tipo
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

        // Target browsers
        target: 'es2020',

        // Minification
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true,     // Remove console.log em produção
                drop_debugger: true,
            },
        },

        // Source maps para produção (opcional)
        sourcemap: false,

        // Chunk size warning
        chunkSizeWarningLimit: 1000,
    },

    // ===========================================
    // Server configuration (desenvolvimento)
    // ===========================================
    server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,

        // HMR configuration
        hmr: {
            host: 'localhost',
        },

        // Watch configuration
        watch: {
            usePolling: true,           // Necessário para Docker/WSL
        },
    },

    // ===========================================
    // CSS configuration
    // ===========================================
    css: {
        // PostCSS plugins
        postcss: './postcss.config.js',

        // SCSS configuration
        preprocessorOptions: {
            scss: {
                // Variáveis globais SCSS
                additionalData: `
                    @import "resources/css/variables";
                    @import "resources/css/mixins";
                `,
                // Silenciar deprecation warnings do Bootstrap
                silenceDeprecations: ['legacy-js-api'],
            },
        },

        // CSS modules (se necessário)
        modules: {
            localsConvention: 'camelCase',
        },
    },

    // ===========================================
    // Optimizations
    // ===========================================
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
```

### postcss.config.js (criar na raiz)

```javascript
// postcss.config.js
export default {
    plugins: {
        // Tailwind CSS (opcional, remover se não usar)
        // tailwindcss: {},

        // Autoprefixer para compatibilidade
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
```

---

## Bloco 2: Nova Estrutura de Assets

### Estrutura de Diretórios Proposta

```
resources/
├── css/
│   ├── app.css                    # Entry point principal (importa tudo)
│   ├── api.css                    # Estilos específicos da API
│   ├── editor.css                 # Estilos do editor
│   ├── _variables.scss            # Variáveis SCSS
│   ├── _mixins.scss               # Mixins SCSS
│   ├── base/
│   │   ├── _reset.scss            # Reset/normalize
│   │   ├── _typography.scss       # Tipografia
│   │   └── _utilities.scss        # Classes utilitárias
│   ├── components/
│   │   ├── _buttons.scss
│   │   ├── _forms.scss
│   │   ├── _cards.scss
│   │   ├── _navigation.scss
│   │   ├── _alerts.scss
│   │   └── _modals.scss
│   ├── layouts/
│   │   ├── _header.scss
│   │   ├── _footer.scss
│   │   ├── _sidebar.scss
│   │   └── _grid.scss
│   ├── pages/
│   │   ├── _home.scss
│   │   ├── _topics.scss
│   │   ├── _users.scss
│   │   └── _blog.scss
│   └── vendor/
│       ├── _bootstrap-overrides.scss
│       ├── _prism-theme.scss
│       ├── _sweetalert.scss
│       └── _simplemde.scss
│
├── js/
│   ├── app.js                     # Entry point principal
│   ├── api.js                     # Bundle da API
│   ├── editor.js                  # Bundle do editor
│   ├── bootstrap.js               # Configuração inicial (axios, echo, etc)
│   ├── config.js                  # Configurações globais
│   ├── components/
│   │   ├── Navigation.js          # Navegação e menu
│   │   ├── Notifications.js       # Sistema de notificações
│   │   ├── ImageUpload.js         # Upload de imagens
│   │   ├── Markdown.js            # Preview de markdown
│   │   ├── Emoji.js               # Seletor de emojis
│   │   ├── InfiniteScroll.js      # Scroll infinito
│   │   ├── Lightbox.js            # Visualização de imagens
│   │   └── SocialShare.js         # Compartilhamento social
│   ├── utils/
│   │   ├── http.js                # Cliente HTTP (axios wrapper)
│   │   ├── storage.js             # LocalStorage/IndexedDB wrapper
│   │   ├── dates.js               # Formatação de datas
│   │   ├── strings.js             # Manipulação de strings
│   │   └── dom.js                 # Utilitários DOM
│   ├── pages/
│   │   ├── topics/
│   │   │   ├── index.js
│   │   │   ├── show.js
│   │   │   └── create.js
│   │   ├── users/
│   │   │   ├── profile.js
│   │   │   └── settings.js
│   │   └── messages/
│   │       └── index.js
│   └── vendor/
│       └── legacy.js              # Plugins legados que não têm versão ES module
│
└── fonts/
    ├── google/                    # Fontes Google (local)
    └── icons/                     # Ícones (se não usar CDN)
```

### resources/css/app.css (Entry Point Principal)

```scss
// ===========================================
// resources/css/app.css
// Entry point principal - importa todos os estilos
// ===========================================

// --------------------------------------
// 1. Variáveis e Configuração
// --------------------------------------
@import 'variables';
@import 'mixins';

// --------------------------------------
// 2. Vendor/Terceiros
// --------------------------------------
// Bootstrap (via npm)
@import 'bootstrap/scss/bootstrap';

// Font Awesome (via npm)
@import '@fortawesome/fontawesome-free/css/all.css';

// Overrides de vendors
@import 'vendor/bootstrap-overrides';
@import 'vendor/prism-theme';
@import 'vendor/sweetalert';

// --------------------------------------
// 3. Base
// --------------------------------------
@import 'base/reset';
@import 'base/typography';
@import 'base/utilities';

// --------------------------------------
// 4. Layout
// --------------------------------------
@import 'layouts/grid';
@import 'layouts/header';
@import 'layouts/footer';
@import 'layouts/sidebar';

// --------------------------------------
// 5. Componentes
// --------------------------------------
@import 'components/buttons';
@import 'components/forms';
@import 'components/cards';
@import 'components/navigation';
@import 'components/alerts';
@import 'components/modals';

// --------------------------------------
// 6. Páginas específicas
// --------------------------------------
@import 'pages/home';
@import 'pages/topics';
@import 'pages/users';
@import 'pages/blog';
```

### resources/js/app.js (Entry Point Principal)

```javascript
// ===========================================
// resources/js/app.js
// Entry point principal - importa todos os módulos
// ===========================================

// --------------------------------------
// 1. Imports de CSS (processados pelo Vite)
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

// SweetAlert2 (substitui sweetalert)
import Swal from 'sweetalert2';
window.Swal = Swal;

// Prism para syntax highlighting
import Prism from 'prismjs';
import 'prismjs/themes/prism-tomorrow.css';
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
import { initMarkdown } from './components/Markdown';
import { initEmoji } from './components/Emoji';
import { initInfiniteScroll } from './components/InfiniteScroll';
import { initLightbox } from './components/Lightbox';
import { initSocialShare } from './components/SocialShare';

// --------------------------------------
// 5. Configuração global
// --------------------------------------
import { Config } from './config';
window.Config = Config;

// --------------------------------------
// 6. Inicialização
// --------------------------------------
document.addEventListener('DOMContentLoaded', () => {
    // Inicializar componentes
    initNavigation();
    initNotifications();
    initImageUpload();
    initMarkdown();
    initEmoji();
    initInfiniteScroll();
    initLightbox();
    initSocialShare();

    // Syntax highlighting
    Prism.highlightAll();

    // NProgress para navegação PJAX
    if (window.NProgress) {
        $(document).on('pjax:start', () => NProgress.start());
        $(document).on('pjax:end', () => NProgress.done());
    }

    console.log('Hoppe App initialized');
});

// --------------------------------------
// 7. Hot Module Replacement (HMR)
// --------------------------------------
if (import.meta.hot) {
    import.meta.hot.accept();
}
```

### resources/js/bootstrap.js

```javascript
// ===========================================
// resources/js/bootstrap.js
// Configuração inicial da aplicação
// ===========================================

import axios from 'axios';

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
// Laravel Echo (WebSockets)
// --------------------------------------
// Descomentar se usar broadcasting
/*
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});
*/

// --------------------------------------
// Lodash
// --------------------------------------
import _ from 'lodash-es';
window._ = _;
```

### resources/js/config.js

```javascript
// ===========================================
// resources/js/config.js
// Configurações injetadas do servidor
// ===========================================

// Valores default (serão sobrescritos pelo Blade)
export const Config = {
    cdnDomain: '',
    user_id: 0,
    user_avatar: '',
    user_link: '',
    user_badge: '',
    user_badge_link: '',
    routes: {
        notificationsCount: '/notifications/count',
        upload_image: '/upload/image',
    },
    token: '',
    environment: 'local',
    following_users: [],
    qa_category_id: '',
};

// Merge com configuração global se existir
if (typeof window.AppConfig !== 'undefined') {
    Object.assign(Config, window.AppConfig);
}
```

### resources/js/editor.js (Bundle do Editor)

```javascript
// ===========================================
// resources/js/editor.js
// Bundle específico para o editor SimpleMDE
// ===========================================

import '../css/editor.css';

// SimpleMDE
import SimpleMDE from 'simplemde';
import 'simplemde/dist/simplemde.min.css';

// Inline Attachment para upload de imagens
import inlineAttachment from 'inline-attachment';

// Exportar para uso global
window.SimpleMDE = SimpleMDE;
window.inlineAttachment = inlineAttachment;

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

    const editor = new SimpleMDE({ ...defaultOptions, ...options });

    // Configurar upload de imagens via drag & drop
    if (window.Config && window.Config.routes.upload_image) {
        inlineAttachment.editors.codemirror4.attach(editor.codemirror, {
            uploadUrl: window.Config.routes.upload_image,
            uploadFieldName: 'file',
            jsonFieldName: 'filename',
            extraHeaders: {
                'X-CSRF-TOKEN': window.Config.token,
            },
        });
    }

    return editor;
}

// Auto-inicializar se houver elemento com data-editor
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-editor]').forEach(el => {
        initEditor(el);
    });
});
```

### resources/js/api.js (Bundle da API)

```javascript
// ===========================================
// resources/js/api.js
// Bundle específico para views da API
// ===========================================

import '../css/api.css';

// Emojify
import emojify from 'emojify.js';
import 'emojify.js/dist/css/basic/emojify.css';

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
```

### Exemplo de Componente: resources/js/components/Notifications.js

```javascript
// ===========================================
// resources/js/components/Notifications.js
// Sistema de notificações
// ===========================================

import axios from 'axios';

let notificationInterval = null;

export function initNotifications() {
    const badge = document.querySelector('.notification-badge');
    if (!badge) return;

    // Verificar notificações a cada 60 segundos
    checkNotifications();
    notificationInterval = setInterval(checkNotifications, 60000);
}

async function checkNotifications() {
    if (!window.Config || !window.Config.routes.notificationsCount) return;
    if (!window.Config.user_id) return;

    try {
        const response = await axios.get(window.Config.routes.notificationsCount);
        updateBadge(response.data.count);
    } catch (error) {
        console.error('Failed to fetch notifications:', error);
    }
}

function updateBadge(count) {
    const badge = document.querySelector('.notification-badge');
    if (!badge) return;

    if (count > 0) {
        badge.textContent = count > 99 ? '99+' : count;
        badge.style.display = 'inline-block';
    } else {
        badge.style.display = 'none';
    }
}

export function clearNotificationInterval() {
    if (notificationInterval) {
        clearInterval(notificationInterval);
    }
}
```

---

## Bloco 3: Layout Blade Atualizado

```blade
{{-- resources/views/layouts/default.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    {{-- =========================================== --}}
    {{-- Meta Tags Básicas --}}
    {{-- =========================================== --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- =========================================== --}}
    {{-- SEO Meta Tags --}}
    {{-- =========================================== --}}
    <title>@hasSection('title')@yield('title') - @endif Hans-Hermann Hoppe Brasil</title>
    <meta name="description" content="@hasSection('description')@yield('description')@else Hans-Hermann Hoppe Brasil - Debate Libertário @endif">
    <meta name="keywords" content="H³, So To Speak, por assim dizer, libertarianismo, libertarios, anarquia, Hans-Hermann Hoppe, austrolibertarios">
    <meta name="author" content="H³ So To Speak">

    {{-- =========================================== --}}
    {{-- Open Graph / Social Meta Tags --}}
    {{-- =========================================== --}}
    <meta property="og:site_name" content="Hans-Hermann Hoppe Brasil">
    <meta property="og:type" content="article">
    <meta property="og:title" content="@hasSection('title')@yield('title')@else Hans-Hermann Hoppe Brasil @endif">
    <meta property="og:description" content="@hasSection('description')@yield('description')@else Hans-Hermann Hoppe Brasil - Debate Libertário @endif">
    <meta property="og:url" content="{{ url()->current() }}">
    @hasSection('og_image')
        <meta property="og:image" content="@yield('og_image')">
    @endif
    <meta property="fb:admins" content="h3sotospeak">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@H3SoToSpeak">
    <meta name="twitter:title" content="@hasSection('title')@yield('title')@else Hans-Hermann Hoppe Brasil @endif">
    <meta name="twitter:description" content="@hasSection('description')@yield('description')@else Hans-Hermann Hoppe Brasil - Debate Libertário @endif">
    <meta name="twitter:url" content="{{ url()->current() }}">

    {{-- =========================================== --}}
    {{-- CSRF Token --}}
    {{-- =========================================== --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- =========================================== --}}
    {{-- Favicon --}}
    {{-- =========================================== --}}
    <link rel="icon" type="image/png" href="{{ asset('favicon1.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon1.png') }}">

    {{-- =========================================== --}}
    {{-- Preconnect para recursos externos --}}
    {{-- =========================================== --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- =========================================== --}}
    {{-- Vite Assets --}}
    {{-- =========================================== --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Assets específicos por página --}}
    @stack('styles')

    {{-- =========================================== --}}
    {{-- Configuração JavaScript Global --}}
    {{-- =========================================== --}}
    <script>
        window.AppConfig = {
            cdnDomain: '{{ config('app.cdn_domain', '') }}',
            user_id: {{ $currentUser?->id ?? 0 }},
            user_avatar: @json($currentUser?->present()->gravatar() ?? ''),
            user_link: @json($currentUser ? route('users.show', $currentUser->id) : ''),
            user_badge: '{{ $currentUser?->present()->hasBadge() ? $currentUser->present()->badgeName() : '' }}',
            user_badge_link: '{{ $currentUser ? route('roles.show', [$currentUser->present()->badgeID()]) : '' }}',
            routes: {
                notificationsCount: '{{ route('notifications.count') }}',
                upload_image: '{{ route('upload_image') }}'
            },
            token: '{{ csrf_token() }}',
            environment: '{{ app()->environment() }}',
            following_users: @json($currentUser?->followings ?? []),
            qa_category_id: '{{ config('phphub.qa_category_id') }}'
        };
    </script>
</head>

<body id="body" class="{{ Route::currentRouteName() ? Str::slug(Route::currentRouteName()) : '' }} @yield('body-class')">
    {{-- =========================================== --}}
    {{-- Wrapper Principal --}}
    {{-- =========================================== --}}
    <div id="app">
        {{-- Navegação --}}
        @include('layouts.partials.nav')

        {{-- Container Principal --}}
        <main class="container main-container @if(request()->is('blogs*') || request()->is('articles*'))blog-container @endif">
            {{-- Alertas de Verificação --}}
            @auth
                @unless(auth()->user()->verified)
                    @unless(request()->is('email-verification-required'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Email não verificado!</strong>
                            Verifique sua caixa de entrada em {{ auth()->user()->email }}.
                            Não recebeu? <a href="{{ route('email-verification-required') }}" class="alert-link">Reenviar email</a>.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                        </div>
                    @endunless
                @endunless

                @if(empty(auth()->user()->password))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Senha não configurada!</strong>
                        <a href="{{ route('users.edit_password', [auth()->id()]) }}" class="alert-link">Defina sua senha</a>
                        para fazer login em outros dispositivos.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                    </div>
                @endif
            @endauth

            {{-- Flash Messages --}}
            @include('flash::message')

            {{-- Conteúdo da Página --}}
            @yield('content')
        </main>

        {{-- Footer --}}
        @include('layouts.partials.footer')
    </div>

    {{-- =========================================== --}}
    {{-- Scripts específicos por página --}}
    {{-- =========================================== --}}
    @stack('scripts')

    {{-- =========================================== --}}
    {{-- Analytics (apenas produção) --}}
    {{-- =========================================== --}}
    @production
        {{-- Google Analytics --}}
        @if(config('services.google.analytics_id'))
            <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google.analytics_id') }}"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());
                gtag('config', '{{ config('services.google.analytics_id') }}');
            </script>
        @endif

        {{-- Sentry (já configurado via pacote Laravel) --}}
    @endproduction
</body>
</html>
```

### Exemplo de View usando Stacks

```blade
{{-- resources/views/topics/create.blade.php --}}
@extends('layouts.default')

@section('title', 'Criar Tópico')

@section('content')
    <div class="topic-create">
        <form action="{{ route('topics.store') }}" method="POST">
            @csrf
            <textarea data-editor name="body"></textarea>
            <button type="submit">Publicar</button>
        </form>
    </div>
@endsection

{{-- Incluir o bundle do editor apenas nesta página --}}
@push('scripts')
    @vite('resources/js/editor.js')
@endpush
```

---

## Bloco 4: Comandos NPM/PNPM

### package.json Atualizado

```json
{
    "name": "hoppe",
    "private": true,
    "type": "module",
    "scripts": {
        "dev": "vite",
        "build": "vite build",
        "preview": "vite preview"
    },
    "devDependencies": {
        "@fortawesome/fontawesome-free": "^6.5.1",
        "autoprefixer": "^10.4.18",
        "axios": "^1.6.7",
        "bootstrap": "^5.3.3",
        "cssnano": "^6.0.5",
        "laravel-vite-plugin": "^1.0.2",
        "lodash-es": "^4.17.21",
        "postcss": "^8.4.35",
        "sass": "^1.71.1",
        "vite": "^5.1.4"
    },
    "dependencies": {
        "emojify.js": "^1.1.0",
        "inline-attachment": "^2.0.3",
        "jquery": "^3.7.1",
        "laravel-echo": "^1.15.3",
        "moment": "^2.30.1",
        "prismjs": "^1.29.0",
        "pusher-js": "^8.4.0-rc2",
        "simplemde": "^1.11.2",
        "sweetalert2": "^11.10.5"
    }
}
```

### Comandos Disponíveis

```bash
# ===============================================
# DESENVOLVIMENTO
# ===============================================

# Iniciar servidor de desenvolvimento com HMR
npm run dev
# ou
pnpm dev

# O Vite vai:
# - Iniciar servidor em http://localhost:5173
# - Hot Module Replacement (atualização instantânea)
# - Source maps para debugging
# - Compilação ultra-rápida

# ===============================================
# PRODUÇÃO
# ===============================================

# Build para produção
npm run build
# ou
pnpm build

# O Vite vai:
# - Minificar CSS e JS
# - Tree-shaking (remover código não usado)
# - Gerar hashes nos nomes dos arquivos
# - Criar manifest.json para Laravel
# - Output em public/build/

# ===============================================
# PREVIEW
# ===============================================

# Visualizar build de produção localmente
npm run preview
# ou
pnpm preview

# Útil para testar o build antes de deploy

# ===============================================
# INSTALAÇÃO
# ===============================================

# Instalar dependências (primeira vez ou após pull)
npm install
# ou
pnpm install

# Limpar e reinstalar
rm -rf node_modules package-lock.json
npm install
# ou
rm -rf node_modules pnpm-lock.yaml
pnpm install

# ===============================================
# DICAS
# ===============================================

# Ver tamanho do bundle
npm run build -- --report

# Limpar cache do Vite
rm -rf node_modules/.vite

# Atualizar dependências
npm update
# ou
pnpm update
```

### Integração com Laravel

```bash
# No .env, adicione para desenvolvimento:
VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

# Para produção (após build):
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Docker/Sail Integration

```yaml
# docker-compose.yml
services:
    vite:
        image: node:20-alpine
        working_dir: /var/www/html
        volumes:
            - .:/var/www/html
        ports:
            - "5173:5173"
        command: npm run dev -- --host
```

---

## Notas de Migração

### Passos para Migração

1. **Backup**: Faça backup dos arquivos antigos
2. **Limpar**: Remova `node_modules`, `package-lock.json`
3. **Substituir**: Substitua `package.json` pela versão nova
4. **Instalar**: Execute `npm install`
5. **Criar estrutura**: Reorganize os assets conforme proposto
6. **Configurar**: Crie `vite.config.js` e `postcss.config.js`
7. **Atualizar Blade**: Atualize layouts para usar `@vite`
8. **Testar dev**: Execute `npm run dev` e teste
9. **Testar build**: Execute `npm run build` e teste
10. **Deploy**: Deploy para produção

### Compatibilidade com Plugins jQuery Legados

Para plugins que precisam de jQuery global:

```javascript
// resources/js/vendor/legacy.js

// NProgress
import NProgress from 'nprogress';
import 'nprogress/nprogress.css';
window.NProgress = NProgress;

// jQuery PJAX
import 'jquery-pjax';

// Outros plugins legados...
```

### Removendo Arquivos Antigos

Após a migração bem-sucedida, remova:

```bash
rm webpack.mix.js
rm gulpfile.js
rm -rf public/assets/     # assets antigos
rm -rf public/build/      # será recriado pelo Vite
```

---

## Troubleshooting

### Vite não encontra os arquivos

```javascript
// Verifique se os paths no vite.config.js estão corretos
// Use paths relativos à raiz do projeto
```

### CORS errors no dev

```javascript
// vite.config.js
server: {
    cors: true,
}
```

### HMR não funciona

```javascript
// vite.config.js
server: {
    hmr: {
        host: 'localhost',
        port: 5173,
    },
}
```

### Build muito grande

```javascript
// Analise o bundle
npm run build -- --report

// Use code splitting
// Configure manualChunks no vite.config.js
```

---

*Documento gerado em: 2025-11-19*
*Versão: 1.0*
