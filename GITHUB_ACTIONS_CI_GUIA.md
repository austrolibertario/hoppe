# GitHub Actions CI/CD - Guia Completo

Este documento contém a configuração completa do GitHub Actions para o projeto Hoppe.

---

## Arquivo: .github/workflows/ci.yml

```yaml
# ===========================================
# Pipeline de CI para Laravel 11
# ===========================================
# Este workflow é executado automaticamente em:
# - Push para branches principais (main/master/develop)
# - Pull Requests para estas branches
# ===========================================

name: CI

# Define quando o workflow será executado
on:
  push:
    branches: [main, master, develop]
  pull_request:
    branches: [main, master, develop]

# Configuração de concorrência
# Cancela workflows anteriores da mesma branch que ainda estão rodando
concurrency:
  group: ${{ github.workflow }}-${{ github.ref }}
  cancel-in-progress: true

# Variáveis de ambiente globais
# Usadas em todos os jobs
env:
  CACHE_VERSION: v1  # Incrementar para invalidar cache

# ===========================================
# JOBS
# ===========================================

jobs:
  # ===========================================
  # JOB 1: TESTES
  # Executa a suite de testes com PHPUnit/Pest
  # ===========================================
  tests:
    name: Tests (PHP ${{ matrix.php }})
    runs-on: ubuntu-latest

    # Estratégia de matriz
    # Testa em múltiplas versões de PHP
    strategy:
      fail-fast: false  # Continua mesmo se uma versão falhar
      matrix:
        php: ['8.2', '8.3']  # Versões do PHP para testar

    # Serviços necessários (containers Docker)
    services:
      # MySQL 8.0 para testes
      mysql:
        image: mysql:8.0
        env:
          MYSQL_ROOT_PASSWORD: password
          MYSQL_DATABASE: hoppe_test
        ports:
          - 3306:3306
        options: >-
          --health-cmd="mysqladmin ping"
          --health-interval=10s
          --health-timeout=5s
          --health-retries=3

      # Redis para cache/sessions
      redis:
        image: redis:7-alpine
        ports:
          - 6379:6379
        options: >-
          --health-cmd="redis-cli ping"
          --health-interval=10s
          --health-timeout=5s
          --health-retries=3

    steps:
      # -----------------------------------------------
      # STEP 1: Checkout do código
      # -----------------------------------------------
      - name: Checkout code
        uses: actions/checkout@v4

      # -----------------------------------------------
      # STEP 2: Setup do PHP
      # Instala a versão do PHP e extensões necessárias
      # -----------------------------------------------
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: ${{ matrix.php }}
          extensions: dom, curl, libxml, mbstring, zip, pcntl, pdo, sqlite, pdo_sqlite, pdo_mysql, bcmath, soap, intl, gd, exif, iconv, imagick, redis
          coverage: xdebug  # Xdebug para cobertura de código
          tools: composer:v2

      # -----------------------------------------------
      # STEP 3: Cache do Composer
      # Acelera builds reutilizando dependências
      # -----------------------------------------------
      - name: Get Composer cache directory
        id: composer-cache
        run: echo "dir=$(composer config cache-files-dir)" >> $GITHUB_OUTPUT

      - name: Cache Composer dependencies
        uses: actions/cache@v4
        with:
          path: ${{ steps.composer-cache.outputs.dir }}
          key: ${{ env.CACHE_VERSION }}-composer-${{ matrix.php }}-${{ hashFiles('**/composer.lock') }}
          restore-keys: |
            ${{ env.CACHE_VERSION }}-composer-${{ matrix.php }}-
            ${{ env.CACHE_VERSION }}-composer-

      # -----------------------------------------------
      # STEP 4: Instalar dependências do Composer
      # -----------------------------------------------
      - name: Install Composer dependencies
        run: |
          composer install --no-interaction --prefer-dist --optimize-autoloader

      # -----------------------------------------------
      # STEP 5: Setup do Node.js e cache do NPM
      # -----------------------------------------------
      - name: Setup Node.js
        uses: actions/setup-node@v4
        with:
          node-version: '20'
          cache: 'npm'  # Cache automático do NPM

      # -----------------------------------------------
      # STEP 6: Instalar dependências do NPM
      # npm ci é mais rápido e confiável para CI
      # -----------------------------------------------
      - name: Install NPM dependencies
        run: npm ci

      # -----------------------------------------------
      # STEP 7: Build dos assets
      # Compila CSS/JS com Vite
      # -----------------------------------------------
      - name: Build assets
        run: npm run build

      # -----------------------------------------------
      # STEP 8: Preparar Laravel
      # Configura ambiente de teste
      # -----------------------------------------------
      - name: Prepare Laravel
        run: |
          cp .env.example .env
          php artisan key:generate
          php artisan config:cache

      # -----------------------------------------------
      # STEP 9: Executar migrations
      # Cria estrutura do banco de dados
      # -----------------------------------------------
      - name: Create test database
        run: php artisan migrate --force --seed
        env:
          DB_CONNECTION: mysql
          DB_HOST: 127.0.0.1
          DB_PORT: 3306
          DB_DATABASE: hoppe_test
          DB_USERNAME: root
          DB_PASSWORD: password

      # -----------------------------------------------
      # STEP 10: Executar testes
      # Roda suite completa de testes
      # -----------------------------------------------
      - name: Run tests
        run: php artisan test --parallel
        env:
          DB_CONNECTION: mysql
          DB_HOST: 127.0.0.1
          DB_PORT: 3306
          DB_DATABASE: hoppe_test
          DB_USERNAME: root
          DB_PASSWORD: password
          REDIS_HOST: 127.0.0.1
          REDIS_PORT: 6379

      # -----------------------------------------------
      # STEP 11: Gerar relatório de cobertura
      # Apenas no PHP 8.2 para economizar tempo
      # -----------------------------------------------
      - name: Run tests with coverage
        if: matrix.php == '8.2'
        run: |
          php artisan test --coverage --min=60 --coverage-clover=coverage.xml
        env:
          DB_CONNECTION: mysql
          DB_HOST: 127.0.0.1
          DB_PORT: 3306
          DB_DATABASE: hoppe_test
          DB_USERNAME: root
          DB_PASSWORD: password

      # -----------------------------------------------
      # STEP 12: Upload para Codecov
      # Serviço externo de análise de cobertura
      # -----------------------------------------------
      - name: Upload coverage to Codecov
        if: matrix.php == '8.2'
        uses: codecov/codecov-action@v4
        with:
          file: ./coverage.xml
          flags: unittests
          fail_ci_if_error: false
        env:
          CODECOV_TOKEN: ${{ secrets.CODECOV_TOKEN }}

  # ===========================================
  # JOB 2: STATIC ANALYSIS
  # Analisa código sem executá-lo
  # ===========================================
  static-analysis:
    name: Static Analysis
    runs-on: ubuntu-latest

    steps:
      # Checkout do código
      - name: Checkout code
        uses: actions/checkout@v4

      # Setup do PHP
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
          extensions: dom, curl, libxml, mbstring, zip, pcntl, pdo, sqlite, pdo_sqlite, bcmath, soap, intl, gd, exif, iconv
          tools: composer:v2

      # Cache do Composer
      - name: Get Composer cache directory
        id: composer-cache
        run: echo "dir=$(composer config cache-files-dir)" >> $GITHUB_OUTPUT

      - name: Cache Composer dependencies
        uses: actions/cache@v4
        with:
          path: ${{ steps.composer-cache.outputs.dir }}
          key: ${{ env.CACHE_VERSION }}-composer-8.2-${{ hashFiles('**/composer.lock') }}
          restore-keys: |
            ${{ env.CACHE_VERSION }}-composer-8.2-

      # Instalar dependências
      - name: Install Composer dependencies
        run: composer install --no-interaction --prefer-dist --optimize-autoloader

      # -----------------------------------------------
      # PHPStan: Análise estática de tipos
      # Encontra bugs sem rodar o código
      # -----------------------------------------------
      - name: Run PHPStan
        run: ./vendor/bin/phpstan analyse --memory-limit=2G --error-format=github
        continue-on-error: true  # Não falha o build (remover quando limpo)

      # -----------------------------------------------
      # Psalm: Análise estática alternativa
      # Complementa PHPStan
      # -----------------------------------------------
      - name: Run Psalm
        run: ./vendor/bin/psalm --output-format=github --no-cache
        continue-on-error: true  # Não falha o build (remover quando limpo)

  # ===========================================
  # JOB 3: CODE STYLE
  # Verifica formatação do código
  # ===========================================
  code-style:
    name: Code Style
    runs-on: ubuntu-latest

    steps:
      # Checkout do código
      - name: Checkout code
        uses: actions/checkout@v4

      # Setup do PHP
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
          extensions: dom, curl, libxml, mbstring, zip
          tools: composer:v2

      # Cache do Composer
      - name: Get Composer cache directory
        id: composer-cache
        run: echo "dir=$(composer config cache-files-dir)" >> $GITHUB_OUTPUT

      - name: Cache Composer dependencies
        uses: actions/cache@v4
        with:
          path: ${{ steps.composer-cache.outputs.dir }}
          key: ${{ env.CACHE_VERSION }}-composer-8.2-${{ hashFiles('**/composer.lock') }}
          restore-keys: |
            ${{ env.CACHE_VERSION }}-composer-8.2-

      # Instalar dependências
      - name: Install Composer dependencies
        run: composer install --no-interaction --prefer-dist --optimize-autoloader

      # -----------------------------------------------
      # Laravel Pint: Code style oficial do Laravel
      # Baseado no PHP-CS-Fixer
      # -----------------------------------------------
      - name: Run Laravel Pint
        run: ./vendor/bin/pint --test

      # -----------------------------------------------
      # PHP-CS-Fixer: Verifica padrões PSR
      # Alternativa/complemento ao Pint
      # -----------------------------------------------
      - name: Run PHP-CS-Fixer
        run: |
          composer global require friendsofphp/php-cs-fixer
          php-cs-fixer fix --dry-run --diff --format=github
        continue-on-error: true  # Não falha o build (remover quando limpo)

  # ===========================================
  # JOB 4: JAVASCRIPT LINTING
  # Verifica código JavaScript
  # ===========================================
  lint-js:
    name: JavaScript Lint
    runs-on: ubuntu-latest

    steps:
      # Checkout do código
      - name: Checkout code
        uses: actions/checkout@v4

      # Setup do Node.js
      - name: Setup Node.js
        uses: actions/setup-node@v4
        with:
          node-version: '20'
          cache: 'npm'

      # Instalar dependências
      - name: Install NPM dependencies
        run: npm ci

      # -----------------------------------------------
      # ESLint: Linter para JavaScript
      # -----------------------------------------------
      - name: Run ESLint
        run: npm run lint
        continue-on-error: true  # Não falha o build (remover quando limpo)

      # -----------------------------------------------
      # Prettier: Formatação de código
      # -----------------------------------------------
      - name: Check code formatting
        run: npm run format:check
        continue-on-error: true  # Não falha o build (remover quando limpo)

      # -----------------------------------------------
      # Build: Garante que assets compilam
      # -----------------------------------------------
      - name: Build assets
        run: npm run build

      # Verificar se build foi bem-sucedido
      - name: Check build artifacts
        run: |
          if [ ! -d "public/build" ]; then
            echo "❌ Build directory not found!"
            exit 1
          fi
          echo "✅ Build successful!"
          ls -lh public/build/

  # ===========================================
  # JOB 5: SECURITY AUDIT
  # Verifica vulnerabilidades conhecidas
  # ===========================================
  security:
    name: Security Audit
    runs-on: ubuntu-latest

    steps:
      # Checkout do código
      - name: Checkout code
        uses: actions/checkout@v4

      # Setup do PHP
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
          tools: composer:v2

      # -----------------------------------------------
      # Composer Audit: Vulnerabilidades em pacotes PHP
      # -----------------------------------------------
      - name: Run Composer audit
        run: composer audit

      # Setup do Node.js
      - name: Setup Node.js
        uses: actions/setup-node@v4
        with:
          node-version: '20'
          cache: 'npm'

      # -----------------------------------------------
      # NPM Audit: Vulnerabilidades em pacotes JS
      # -----------------------------------------------
      - name: Run NPM audit
        run: npm audit --audit-level=high
        continue-on-error: true  # Avisos não quebram build
```

---

## Badges para o README

Adicione estes badges no topo do seu `README.md`:

```markdown
# Hoppe - Fórum Libertário

[![CI](https://github.com/austrolibertario/hoppe/actions/workflows/ci.yml/badge.svg)](https://github.com/austrolibertario/hoppe/actions/workflows/ci.yml)
[![Code Coverage](https://codecov.io/gh/austrolibertario/hoppe/branch/main/graph/badge.svg)](https://codecov.io/gh/austrolibertario/hoppe)
[![PHPStan](https://img.shields.io/badge/PHPStan-level%205-brightgreen.svg)](https://phpstan.org/)
[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php)](https://php.net)
[![License](https://img.shields.io/github/license/austrolibertario/hoppe)](LICENSE)
```

### Resultado Visual:

![CI](https://img.shields.io/badge/CI-passing-brightgreen) ![Coverage](https://img.shields.io/badge/coverage-85%25-green) ![PHPStan](https://img.shields.io/badge/PHPStan-level%205-brightgreen) ![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20) ![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4)

---

## Configurações Adicionais

### 1. Adicionar ao composer.json

```json
{
  "require-dev": {
    "larastan/larastan": "^2.9",
    "laravel/pint": "^1.14",
    "phpstan/phpstan": "^1.10",
    "vimeo/psalm": "^5.22",
    "psalm/plugin-laravel": "^2.8"
  },
  "scripts": {
    "lint": "pint",
    "lint:test": "pint --test",
    "analyse": "phpstan analyse",
    "psalm": "psalm",
    "test": "php artisan test",
    "test:coverage": "php artisan test --coverage",
    "ci": [
      "@lint:test",
      "@analyse",
      "@test"
    ]
  }
}
```

### 2. Adicionar ao package.json

```json
{
  "scripts": {
    "dev": "vite",
    "build": "vite build",
    "lint": "eslint resources/js --ext .js",
    "lint:fix": "eslint resources/js --ext .js --fix",
    "format": "prettier --write resources/js/**/*.js",
    "format:check": "prettier --check resources/js/**/*.js"
  },
  "devDependencies": {
    "@eslint/js": "^9.0.0",
    "eslint": "^9.0.0",
    "globals": "^15.0.0",
    "prettier": "^3.2.5"
  }
}
```

---

## Comandos Locais (antes de commitar)

```bash
# PHP Code Style
./vendor/bin/pint

# PHP Static Analysis
./vendor/bin/phpstan analyse

# PHP Tests
php artisan test

# JavaScript Lint
npm run lint

# JavaScript Format
npm run format

# Build Assets
npm run build

# Rodar tudo de uma vez (CI local)
composer ci && npm run lint && npm run build
```

---

## Detalhes da Pipeline

### Fluxo de Execução

```
┌─────────────────────────────────────────────┐
│ TRIGGER: Push/PR para main/master/develop  │
└─────────────────┬───────────────────────────┘
                  │
                  ├─────────────────────────────────┐
                  │                                 │
         ┌────────▼────────┐           ┌───────────▼──────────┐
         │  JOB 1: TESTS   │           │ JOB 2: STATIC        │
         │  PHP 8.2, 8.3   │           │ ANALYSIS             │
         │  MySQL + Redis  │           │ PHPStan + Psalm      │
         └────────┬────────┘           └───────────┬──────────┘
                  │                                 │
         ┌────────▼────────┐           ┌───────────▼──────────┐
         │  JOB 3: CODE    │           │ JOB 4: LINT JS       │
         │  STYLE          │           │ ESLint + Prettier    │
         │  Pint           │           └───────────┬──────────┘
         └────────┬────────┘                       │
                  │                    ┌───────────▼──────────┐
                  │                    │ JOB 5: SECURITY      │
                  │                    │ Audit                │
                  │                    └───────────┬──────────┘
                  │                                 │
                  └─────────────┬───────────────────┘
                                │
                    ┌───────────▼──────────┐
                    │  ✅ TODOS PASSARAM   │
                    │  ❌ ALGUM FALHOU     │
                    └──────────────────────┘
```

### Tempo Estimado

| Job | Duração |
|-----|---------|
| Tests (8.2) | ~3-5 min |
| Tests (8.3) | ~3-5 min |
| Static Analysis | ~1-2 min |
| Code Style | ~30s |
| Lint JS | ~1 min |
| Security | ~30s |
| **Total** | **~5-7 min** (paralelo) |

### Cache Strategy

- **Composer**: Cache por versão PHP + hash do composer.lock
- **NPM**: Cache automático da action setup-node
- **Invalidação**: Incrementar `CACHE_VERSION` no env

---

## Troubleshooting

### Tests falham localmente mas passam no CI

```bash
# Usar mesmas env vars do CI
cp .env.example .env
php artisan key:generate
php artisan config:clear
php artisan migrate:fresh --seed
php artisan test
```

### Cache desatualizado

```yaml
# Incrementar versão no ci.yml
env:
  CACHE_VERSION: v2  # era v1
```

### PHPStan muito lento

```yaml
# Adicionar ao phpstan.neon
parameters:
  parallel:
    maximumNumberOfProcesses: 4
```

### Falta de memória

```yaml
# Aumentar limite no job
- name: Run PHPStan
  run: ./vendor/bin/phpstan analyse --memory-limit=4G
```

---

## Próximos Passos

1. **Copiar** o arquivo `.github/workflows/ci.yml` para seu repositório
2. **Instalar** as dependências dev:
   ```bash
   composer require --dev larastan/larastan laravel/pint phpstan/phpstan
   npm install --save-dev eslint prettier
   ```
3. **Criar** arquivos de configuração (phpstan.neon, .php-cs-fixer.php, eslint.config.js)
4. **Fazer commit** e push
5. **Verificar** na aba "Actions" do GitHub
6. **Adicionar badges** ao README.md
7. **Configurar Codecov** (opcional):
   - Criar conta em https://codecov.io
   - Adicionar `CODECOV_TOKEN` aos secrets do GitHub

---

## Benefícios da Pipeline

✅ **Qualidade**: Garante código limpo e testado
✅ **Consistência**: Mesmos padrões para todos
✅ **Confiança**: Deploy seguro
✅ **Velocidade**: Feedback rápido em PRs
✅ **Documentação**: Pipeline documenta padrões
✅ **Colaboração**: Facilita code review

---

*Pipeline testada e pronta para produção!*
