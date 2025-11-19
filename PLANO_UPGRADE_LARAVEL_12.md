# Plano de Upgrade: Laravel 5.8 → 12

## Bloco 1: composer.json Sugerido (Laravel 12 + PHP 8.2+)

```json
{
    "name": "austrolibertario/hoppe",
    "description": "Libertarian Forum. Ancapistão é aqui!",
    "keywords": ["forum", "Ancapistão", "libertarian"],
    "license": "MIT",
    "type": "project",
    "require": {
        "php": "^8.2",
        "laravel/framework": "^12.0",
        "laravel/tinker": "^2.9",

        "// === AUTENTICAÇÃO E AUTORIZAÇÃO ===": "",
        "laravel/passport": "^12.0",
        "laravel/socialite": "^5.12",
        "spatie/laravel-permission": "^6.4",
        "socialiteproviders/discord": "^4.2",
        "socialiteproviders/twitter": "^4.1",
        "socialiteproviders/manager": "^4.6",

        "// === API ===": "",
        "laravel/sanctum": "^4.0",

        "// === UTILIDADES CORE ===": "",
        "guzzlehttp/guzzle": "^7.8",
        "nesbot/carbon": "^3.0",
        "predis/predis": "^2.2",

        "// === MANIPULAÇÃO DE CONTEÚDO ===": "",
        "erusev/parsedown": "^1.7",
        "league/html-to-markdown": "^5.1",
        "mews/purifier": "^3.4",
        "cviebrock/eloquent-sluggable": "^11.0",

        "// === IMAGENS E MÍDIA ===": "",
        "intervention/image-laravel": "^1.2",
        "spatie/laravel-medialibrary": "^11.4",

        "// === STORAGE ===": "",
        "league/flysystem-aws-s3-v3": "^3.24",

        "// === MENSAGENS E NOTIFICAÇÕES ===": "",
        "pusher/pusher-php-server": "^7.2",
        "laravel-notification-channels/telegram": "^5.0",

        "// === UI E FRONTEND ===": "",
        "laracasts/flash": "^3.2",

        "// === BUSCA E DADOS ===": "",
        "laravel/scout": "^10.8",
        "league/csv": "^9.15",

        "// === ADMIN E BACKOFFICE ===": "",
        "filament/filament": "^3.2",

        "// === TAGS E CATEGORIAS ===": "",
        "spatie/laravel-tags": "^4.6",

        "// === FOLLOW/SOCIAL ===": "",
        "overtrue/laravel-follow": "^5.1",

        "// === AUDITORIA ===": "",
        "spatie/laravel-activitylog": "^4.8",
        "owen-it/laravel-auditing": "^13.6",

        "// === SEO E SITEMAP ===": "",
        "spatie/laravel-sitemap": "^7.2",

        "// === BACKUP ===": "",
        "spatie/laravel-backup": "^9.0",

        "// === MONITORAMENTO ===": "",
        "sentry/sentry-laravel": "^4.4",

        "// === CAPTCHA ===": "",
        "google/recaptcha": "^1.3",

        "// === QR CODE ===": "",
        "simplesoftwareio/simple-qrcode": "^4.2",

        "// === HTTP CLIENT (substitui Zend) ===": "",
        "laminas/laminas-diactoros": "^3.3"
    },
    "require-dev": {
        "fakerphp/faker": "^1.23",
        "laravel/pint": "^1.14",
        "laravel/sail": "^1.28",
        "mockery/mockery": "^1.6",
        "nunomaduro/collision": "^8.1",
        "phpunit/phpunit": "^11.0",
        "spatie/laravel-ignition": "^2.4",
        "laravel/dusk": "^8.2"
    },
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests/"
        }
    },
    "scripts": {
        "post-autoload-dump": [
            "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
            "@php artisan package:discover --ansi",
            "@php artisan filament:upgrade"
        ],
        "post-update-cmd": [
            "@php artisan vendor:publish --tag=laravel-assets --ansi --force"
        ],
        "post-root-package-install": [
            "@php -r \"file_exists('.env') || copy('.env.example', '.env');\""
        ],
        "post-create-project-cmd": [
            "@php artisan key:generate --ansi",
            "@php artisan storage:link"
        ]
    },
    "extra": {
        "laravel": {
            "dont-discover": []
        }
    },
    "config": {
        "optimize-autoloader": true,
        "preferred-install": "dist",
        "sort-packages": true,
        "allow-plugins": {
            "pestphp/pest-plugin": true,
            "php-http/discovery": true
        }
    },
    "minimum-stability": "stable",
    "prefer-stable": true
}
```

### Mapeamento de Pacotes: Antigo → Novo

| Pacote Antigo | Pacote Novo | Motivo |
|---------------|-------------|--------|
| `zizaco/entrust` | `spatie/laravel-permission` | Entrust abandonado em 2017 |
| `dingo/api` | `laravel/sanctum` + API Resources | Dingo não suporta Laravel 10+ |
| `summerblue/administrator` | `filament/filament` | Administrator abandonado |
| `fzaninotto/faker` | `fakerphp/faker` | Fork oficial mantido |
| `intervention/image` + `imagecache` | `intervention/image-laravel` | Nova versão unificada |
| `zendframework/*` | `laminas/laminas-*` | Zend renomeado para Laminas |
| `venturecraft/revisionable` | `owen-it/laravel-auditing` | Mais moderno e mantido |
| `laravelium/sitemap` | `spatie/laravel-sitemap` | Melhor manutenção |
| `estgroupe/laravel-taggable` | `spatie/laravel-tags` | Mais robusto |
| `longman/telegram-bot` | `laravel-notification-channels/telegram` | Integração Laravel nativa |
| `nicolaslopezj/searchable` | `laravel/scout` | Solução oficial |
| `laracasts/presenter` | Accessors/Casts nativos | Laravel 11+ tem recursos nativos |
| `cmgmyr/messenger` | Custom ou `musonza/chat` | Avaliar necessidade |

### Pacotes Removidos (Justificativa)

| Pacote | Motivo da Remoção |
|--------|-------------------|
| `botman/botman` | Avaliar se ainda necessário; implementar via webhooks se sim |
| `devfactory/minify` | Usar Vite para minificação |
| `devster/ubench` | Usar Laravel Telescope ou Debugbar |
| `hieu-le/active` | Helper simples, implementar manualmente |
| `inani/larapoll` | Implementar sistema próprio ou usar Filament |
| `jaeger/querylist` | Web scraping específico, avaliar necessidade |
| `jpush/jpush` | Avaliar alternativa (Firebase, OneSignal) |
| `jrean/laravel-user-verification` | Laravel tem verificação nativa |
| `league/climate` | Usar comandos Artisan nativos |
| `league/plates` | Usar Blade |
| `naux/auto-correct` | Implementar via middleware se necessário |
| `nicmart/string-template` | Usar Blade ou Str helpers |
| `orangehill/iseed` | Usar para desenvolvimento apenas se necessário |
| `overtrue/laravel-filesystem-qiniu` | Implementar driver customizado se necessário |
| `pda/pheanstalk` | Laravel suporta Beanstalkd nativamente |
| `phpdocumentor/reflection` | Dev dependency apenas |
| `rap2hpoutre/laravel-log-viewer` | Usar Laravel Telescope |
| `ricardosierra/*` | Pacotes dev-master sem manutenção |
| `spatie/laravel-pjax` | Usar Livewire ou Inertia |
| `waavi/translation` | Usar sistema nativo ou spatie/laravel-translatable |

---

## Bloco 2: Breaking Changes por Versão

### Laravel 5.8 → 6.0
**Release Date**: Setembro 2019
**Docs**: https://laravel.com/docs/6.x/upgrade

#### Breaking Changes Relevantes:

1. **String e Array Helpers Removidos**
   ```php
   // ANTES
   str_slug('Laravel Framework');
   array_get($array, 'key');

   // DEPOIS
   use Illuminate\Support\Str;
   use Illuminate\Support\Arr;

   Str::slug('Laravel Framework');
   Arr::get($array, 'key');
   ```

2. **Carbon 2.0**
   - `diffInSeconds()` agora retorna valores negativos
   - Serialização JSON mudou
   ```php
   // Adicionar em AppServiceProvider::boot()
   \Carbon\Carbon::serializeUsing(function ($carbon) {
       return $carbon->format('Y-m-d H:i:s');
   });
   ```

3. **Authorization (Gates/Policies)**
   ```php
   // ANTES - retornava true para admins
   Gate::before(function ($user) {
       if ($user->isAdmin()) {
           return true;
       }
   });

   // DEPOIS - deve retornar null para continuar checagem
   Gate::before(function ($user, $ability) {
       if ($user->isAdmin()) {
           return true;
       }
       // return null implícito
   });
   ```

4. **Input Facade Removido**
   ```php
   // ANTES
   Input::get('key');

   // DEPOIS
   request()->input('key');
   // ou
   $request->input('key');
   ```

---

### Laravel 6.0 → 7.0
**Release Date**: Março 2020
**Docs**: https://laravel.com/docs/7.x/upgrade

#### Breaking Changes Relevantes:

1. **Symfony 5 Components**
   - Todas dependências Symfony atualizadas para 5.x

2. **Authentication Scaffolding**
   ```bash
   # ANTES
   php artisan make:auth

   # DEPOIS
   composer require laravel/ui
   php artisan ui vue --auth
   ```

3. **Blade Component Tags**
   ```php
   // Nova sintaxe (opcional mas recomendada)
   <x-alert type="error" :message="$message"/>
   ```

4. **HTTP Client (Guzzle Wrapper)**
   ```php
   use Illuminate\Support\Facades\Http;

   $response = Http::get('https://api.example.com');
   ```

5. **Multiple Mail Drivers**
   - `MAIL_DRIVER` → `MAIL_MAILER`

6. **CORS Middleware**
   - Agora incluído por padrão
   - Configurar em `config/cors.php`

---

### Laravel 7.0 → 8.0
**Release Date**: Setembro 2020
**Docs**: https://laravel.com/docs/8.x/upgrade

#### Breaking Changes Relevantes:

1. **Model Factories (CRÍTICO)**
   ```php
   // ANTES (database/factories/UserFactory.php)
   $factory->define(User::class, function (Faker $faker) {
       return [
           'name' => $faker->name,
           'email' => $faker->unique()->safeEmail,
       ];
   });

   // Uso
   factory(User::class, 50)->create();

   // DEPOIS (database/factories/UserFactory.php)
   namespace Database\Factories;

   use App\Models\User;
   use Illuminate\Database\Eloquent\Factories\Factory;

   class UserFactory extends Factory
   {
       protected $model = User::class;

       public function definition(): array
       {
           return [
               'name' => fake()->name(),
               'email' => fake()->unique()->safeEmail(),
           ];
       }
   }

   // Uso
   User::factory()->count(50)->create();
   ```

2. **Seeders Namespace**
   ```php
   // ANTES
   class DatabaseSeeder extends Seeder

   // DEPOIS
   namespace Database\Seeders;

   class DatabaseSeeder extends Seeder
   ```

3. **Models Directory**
   - Models agora em `app/Models/` (já está assim no Hoppe)
   - Adicionar `HasFactory` trait:
   ```php
   use Illuminate\Database\Eloquent\Factories\HasFactory;

   class User extends Model
   {
       use HasFactory;
   }
   ```

4. **Pagination Views**
   - Bootstrap 4 não é mais default
   ```php
   // AppServiceProvider::boot()
   use Illuminate\Pagination\Paginator;

   Paginator::useBootstrapFive(); // ou useBootstrapFour()
   ```

5. **Queueable Anonymous Event Listeners**
   ```php
   Event::listen(queueable(function (PodcastProcessed $event) {
       // ...
   }));
   ```

6. **Maintenance Mode**
   ```bash
   php artisan down --secret="bypass-token"
   ```

---

### Laravel 8.0 → 9.0
**Release Date**: Fevereiro 2022
**Docs**: https://laravel.com/docs/9.x/upgrade

#### Breaking Changes Relevantes:

1. **PHP 8.0+ Obrigatório**
   - Constructor property promotion
   - Named arguments
   - Match expressions

2. **Symfony 6 Components**
   - Todas dependências Symfony 6.x

3. **Flysystem 3.x**
   ```php
   // ANTES
   Storage::put('file.txt', 'contents', 'public');

   // DEPOIS
   Storage::put('file.txt', 'contents', ['visibility' => 'public']);
   ```

4. **Custom Casts `set` Method**
   ```php
   // ANTES
   public function set($model, $key, $value, $attributes)
   {
       return $value;
   }

   // DEPOIS - deve retornar array
   public function set($model, $key, $value, $attributes)
   {
       return [$key => $value];
   }
   ```

5. **Trusted Proxies**
   - `fideloper/proxy` removido
   - Usar middleware nativo `TrustProxies`

6. **Accessors/Mutators**
   ```php
   // Nova sintaxe (recomendada)
   use Illuminate\Database\Eloquent\Casts\Attribute;

   protected function firstName(): Attribute
   {
       return Attribute::make(
           get: fn ($value) => ucfirst($value),
           set: fn ($value) => strtolower($value),
       );
   }
   ```

7. **`lang` Directory**
   - Movido para raiz do projeto: `lang/`

---

### Laravel 9.0 → 10.0
**Release Date**: Fevereiro 2023
**Docs**: https://laravel.com/docs/10.x/upgrade

#### Breaking Changes Relevantes:

1. **PHP 8.1+ Obrigatório**
   - Enums
   - Fibers
   - `readonly` properties

2. **Invokable Validation Rules**
   ```php
   // ANTES
   use Illuminate\Contracts\Validation\Rule;

   class Uppercase implements Rule
   {
       public function passes($attribute, $value)
       {
           return strtoupper($value) === $value;
       }

       public function message()
       {
           return 'The :attribute must be uppercase.';
       }
   }

   // DEPOIS
   use Illuminate\Contracts\Validation\ValidationRule;

   class Uppercase implements ValidationRule
   {
       public function validate(string $attribute, mixed $value, Closure $fail): void
       {
           if (strtoupper($value) !== $value) {
               $fail('The :attribute must be uppercase.');
           }
       }
   }
   ```

3. **`$dates` Property Removida**
   ```php
   // ANTES
   protected $dates = ['created_at', 'updated_at', 'deleted_at'];

   // DEPOIS
   protected $casts = [
       'created_at' => 'datetime',
       'updated_at' => 'datetime',
       'deleted_at' => 'datetime',
   ];
   ```

4. **Monolog 3.0**
   - Algumas classes renomeadas
   - Configuração de handlers atualizada

5. **Minimum Versions**
   - Redis 6.0+
   - PostgreSQL 11.0+
   - SQLite 3.35.0+

---

### Laravel 10.0 → 11.0
**Release Date**: Março 2024
**Docs**: https://laravel.com/docs/11.x/upgrade

#### Breaking Changes Relevantes:

1. **PHP 8.2+ Obrigatório**
   - `readonly` classes
   - DNF types
   - Constants in traits

2. **Nova Estrutura de Aplicação**
   ```
   // config/app.php providers removido
   // Usar bootstrap/providers.php

   return [
       App\Providers\AppServiceProvider::class,
   ];
   ```

3. **Casts como Método**
   ```php
   // ANTES
   protected $casts = [
       'email_verified_at' => 'datetime',
       'options' => 'array',
   ];

   // DEPOIS (Laravel 11)
   protected function casts(): array
   {
       return [
           'email_verified_at' => 'datetime',
           'options' => 'array',
       ];
   }
   ```

4. **Scheduling no Console Routes**
   ```php
   // routes/console.php
   use Illuminate\Support\Facades\Schedule;

   Schedule::command('emails:send')->daily();
   ```

5. **Middleware Simplificado**
   - Kernel.php removido
   - Middleware global em `bootstrap/app.php`
   ```php
   ->withMiddleware(function (Middleware $middleware) {
       $middleware->append(MyMiddleware::class);
   })
   ```

6. **Service Providers Consolidados**
   - Apenas `AppServiceProvider` por padrão
   - Outros providers opcionais

7. **SQLite Default**
   - Novo padrão para desenvolvimento

8. **Health Check Route**
   ```php
   // routes/web.php (incluído por padrão)
   Route::get('/up', function () {
       return response('OK');
   });
   ```

---

### Laravel 11.0 → 12.0
**Release Date**: Fevereiro 2025
**Docs**: https://laravel.com/docs/12.x/upgrade

#### Breaking Changes Relevantes:

1. **PHP 8.2+ Continua Obrigatório**

2. **Carbon 3.0**
   ```php
   // Mudanças em métodos de comparação
   // Verificar serialização de datas
   ```

3. **Concurrent Testing Padrão**
   - PHPUnit 11 obrigatório
   - Testes rodam em paralelo por padrão

4. **React/Vue Starter Kits Atualizados**
   - Novos presets com Inertia 2.0

5. **Consolidação de Features do 11.x**
   - Verificar release notes específicas

---

## Bloco 3: Checklist de Refactors

### Fase 0: Preparação
- [ ] Criar branch de migração
- [ ] Backup completo do banco de dados
- [ ] Documentar todas as rotas atuais (`php artisan route:list`)
- [ ] Documentar todos os comandos Artisan customizados
- [ ] Listar todos os Jobs, Events, Listeners, Notifications
- [ ] Aumentar cobertura de testes (mínimo 60%)

### Fase 1: Código Base (Antes de atualizar Laravel)

#### Helpers Globais
- [ ] Substituir `str_slug()` por `Str::slug()`
- [ ] Substituir `str_contains()` por `Str::contains()`
- [ ] Substituir `str_limit()` por `Str::limit()`
- [ ] Substituir `str_plural()` por `Str::plural()`
- [ ] Substituir `str_random()` por `Str::random()`
- [ ] Substituir `str_singular()` por `Str::singular()`
- [ ] Substituir `str_start()` por `Str::start()`
- [ ] Substituir `snake_case()` por `Str::snake()`
- [ ] Substituir `studly_case()` por `Str::studly()`
- [ ] Substituir `camel_case()` por `Str::camel()`
- [ ] Substituir `title_case()` por `Str::title()`
- [ ] Substituir `kebab_case()` por `Str::kebab()`
- [ ] Substituir `array_get()` por `Arr::get()`
- [ ] Substituir `array_set()` por `Arr::set()`
- [ ] Substituir `array_first()` por `Arr::first()`
- [ ] Substituir `array_last()` por `Arr::last()`
- [ ] Substituir `array_flatten()` por `Arr::flatten()`
- [ ] Substituir `array_pluck()` por `Arr::pluck()`
- [ ] Substituir `array_except()` por `Arr::except()`
- [ ] Substituir `array_only()` por `Arr::only()`
- [ ] Substituir `array_add()` por `Arr::add()`
- [ ] Substituir `array_pull()` por `Arr::pull()`
- [ ] Substituir `array_prepend()` por `Arr::prepend()`
- [ ] Substituir `array_sort()` por `Arr::sort()`
- [ ] Substituir `array_where()` por `Arr::where()`
- [ ] Substituir `array_wrap()` por `Arr::wrap()`
- [ ] Substituir `Input::` por `request()->`

#### app/Helpers.php
- [ ] Revisar todos os helpers customizados
- [ ] Remover helpers que duplicam funcionalidade do Laravel
- [ ] Atualizar helpers para usar classes Str/Arr

### Fase 2: Autenticação e Autorização

#### Entrust → Spatie Permission
- [ ] Instalar `spatie/laravel-permission`
- [ ] Criar migrations para novas tabelas
- [ ] Migrar dados de roles existentes
- [ ] Migrar dados de permissions existentes
- [ ] Atualizar Model User:
  - [ ] Remover `use EntrustUserTrait`
  - [ ] Adicionar `use HasRoles`
- [ ] Atualizar Model Role:
  - [ ] Remover `use EntrustRoleTrait`
  - [ ] Estender `Spatie\Permission\Models\Role`
- [ ] Atualizar Model Permission:
  - [ ] Remover `use EntrustPermissionTrait`
  - [ ] Estender `Spatie\Permission\Models\Permission`
- [ ] Atualizar chamadas de verificação:
  - [ ] `$user->hasRole()` (manter)
  - [ ] `$user->can()` → manter ou `$user->hasPermissionTo()`
  - [ ] `$user->ability()` → `$user->hasAnyPermission()`
- [ ] Atualizar middleware:
  - [ ] `role:admin` → `role:admin`
  - [ ] `permission:edit-posts` → `permission:edit-posts`
- [ ] Atualizar Blade directives:
  - [ ] `@role()` (manter)
  - [ ] `@hasrole()` (manter)
  - [ ] `@permission()` → `@can()`
- [ ] Remover `config/entrust.php`
- [ ] Criar `config/permission.php`
- [ ] Atualizar seeders de roles/permissions
- [ ] Testar todas as rotas protegidas

#### Gates e Policies
- [ ] Revisar `Gate::before()` callbacks
- [ ] Atualizar retornos para `null` ao invés de `false`
- [ ] Revisar todas as Policies em `app/Policies/`
- [ ] Atualizar para syntax PHP 8.x

### Fase 3: Database

#### Model Factories
- [ ] Criar diretório `database/factories/` com namespace
- [ ] Converter `UserFactory`:
  - [ ] Criar classe `Database\Factories\UserFactory`
  - [ ] Implementar método `definition()`
- [ ] Converter `TopicFactory`
- [ ] Converter `ReplyFactory`
- [ ] Converter `CategoryFactory`
- [ ] Converter `RoleFactory`
- [ ] Converter `PermissionFactory`
- [ ] Converter `NotificationFactory`
- [ ] Converter `NewsFactory`
- [ ] Converter todas as outras factories
- [ ] Adicionar `HasFactory` trait em todos os Models:
  - [ ] `User`
  - [ ] `Topic`
  - [ ] `Reply`
  - [ ] `Category`
  - [ ] `Role`
  - [ ] `Permission`
  - [ ] `Notification`
  - [ ] `News`
  - [ ] `Blog`
  - [ ] `Vote`
  - [ ] `Tag`
  - [ ] `Site`
  - [ ] `Link`
  - [ ] `Banner`
  - [ ] `Activity`
  - [ ] `Attention`
  - [ ] Demais models

#### Seeders
- [ ] Adicionar namespace `Database\Seeders` em todos os seeders
- [ ] Atualizar `DatabaseSeeder.php`
- [ ] Atualizar `UsersTableSeeder.php`
- [ ] Atualizar todos os outros seeders
- [ ] Atualizar chamadas de factory nos seeders

#### Migrations
- [ ] Verificar se migrations usam `bigIncrements` (Laravel 5.8+)
- [ ] Atualizar foreign keys para `foreignId()->constrained()`

#### Eloquent Models
- [ ] Migrar `$dates` para `$casts` com `'datetime'`:
  - [ ] `User`
  - [ ] `Topic`
  - [ ] `Reply`
  - [ ] `Notification`
  - [ ] Todos os models com `$dates`
- [ ] Converter accessors/mutators para syntax Attribute (Laravel 9+):
  - [ ] Revisar `getXxxAttribute()`
  - [ ] Revisar `setXxxAttribute()`
- [ ] Atualizar `$casts` para método (Laravel 11):
  ```php
  protected function casts(): array
  ```

### Fase 4: API

#### Dingo API → Laravel Nativo
- [ ] Remover `dingo/api` do composer
- [ ] Criar API Resources para cada endpoint:
  - [ ] `UserResource`
  - [ ] `TopicResource`
  - [ ] `ReplyResource`
  - [ ] `CategoryResource`
  - [ ] `NotificationResource`
  - [ ] Demais resources
- [ ] Migrar rotas de `routes/api.php`:
  - [ ] Remover `$api = app('Dingo\Api\Routing\Router')`
  - [ ] Usar `Route::apiResource()` e `Route::group()`
- [ ] Atualizar controllers em `app/Http/ApiControllers/`:
  - [ ] Remover `extends Dingo Controller`
  - [ ] Usar `Controller` padrão
  - [ ] Retornar Resources ao invés de Transformers
- [ ] Migrar transformers para Resources:
  - [ ] Atualizar cada arquivo em `app/Transformers/`
- [ ] Atualizar autenticação API:
  - [ ] Configurar Laravel Sanctum ou Passport
  - [ ] Atualizar middleware `api`
- [ ] Atualizar tratamento de exceções para API
- [ ] Implementar rate limiting nativo
- [ ] Atualizar versionamento de API (se necessário)
- [ ] Testar todos os endpoints

### Fase 5: Controllers e Requests

#### Controllers
- [ ] Adicionar type hints em todos os métodos
- [ ] Atualizar injeção de dependência
- [ ] Revisar uso de `$this->validate()` vs Form Requests
- [ ] Atualizar responses para usar Resources

#### Form Requests
- [ ] Revisar todas as classes em `app/Http/Requests/`
- [ ] Atualizar regras de validação
- [ ] Converter rules customizadas para invokable (Laravel 10)

### Fase 6: Jobs, Events, Listeners, Notifications

#### Jobs
- [ ] Revisar todos os jobs em `app/Jobs/`
- [ ] Atualizar para PHP 8 syntax
- [ ] Implementar `ShouldBeUnique` se necessário
- [ ] Implementar job batching se aplicável

#### Events
- [ ] Revisar todos os eventos em `app/Events/`
- [ ] Atualizar para usar typed properties

#### Listeners
- [ ] Revisar listeners em `app/Phphub/Listeners/`
- [ ] Atualizar registro em `EventServiceProvider`

#### Notifications
- [ ] Revisar todas as notifications
- [ ] Atualizar para usar database/mail channels modernos
- [ ] Implementar Telegram via `laravel-notification-channels/telegram`

### Fase 7: Middleware

#### Atualização de Middleware
- [ ] Revisar todos os middleware em `app/Http/Middleware/`
- [ ] Remover `App\Http\Kernel.php` (Laravel 11)
- [ ] Configurar middleware em `bootstrap/app.php`
- [ ] Atualizar middleware de autenticação
- [ ] Atualizar middleware de CORS
- [ ] Atualizar TrustProxies

### Fase 8: Service Providers

#### Consolidação de Providers
- [ ] Revisar todos os providers em `app/Providers/`
- [ ] Consolidar código em `AppServiceProvider`
- [ ] Mover bindings para `bootstrap/app.php`
- [ ] Criar `bootstrap/providers.php` com lista de providers
- [ ] Remover `config/app.php` providers array

### Fase 9: Rotas

#### Web Routes
- [ ] Revisar `routes/web.php`
- [ ] Atualizar para controller syntax de array:
  ```php
  Route::get('/users', [UserController::class, 'index']);
  ```
- [ ] Atualizar middleware references
- [ ] Remover rotas depreciadas

#### Console Routes
- [ ] Mover scheduling para `routes/console.php`:
  ```php
  Schedule::command('inspire')->hourly();
  ```
- [ ] Atualizar comandos Artisan customizados

#### API Routes
- [ ] Já coberto na Fase 4

### Fase 10: Views e Frontend

#### Blade Templates
- [ ] Atualizar `@section` / `@yield` se necessário
- [ ] Converter para component syntax onde aplicável
- [ ] Atualizar paginação para Bootstrap 5:
  ```php
  Paginator::useBootstrapFive();
  ```
- [ ] Remover uso de `@php` excessivo

#### Assets
- [ ] Migrar de Laravel Mix para Vite
- [ ] Atualizar `package.json`
- [ ] Criar `vite.config.js`
- [ ] Atualizar `@vite()` directive nas views

### Fase 11: Testes

#### PHPUnit
- [ ] Atualizar `phpunit.xml`:
  - [ ] Remover `whitelist`
  - [ ] Adicionar `coverage`
  - [ ] Atualizar deprecated attributes
- [ ] Atualizar para PHPUnit 11
- [ ] Atualizar test traits:
  - [ ] `RefreshDatabase`
  - [ ] `WithFaker`
  - [ ] `DatabaseMigrations`
- [ ] Atualizar assertions depreciadas
- [ ] Atualizar uso de factories nos testes

#### Feature Tests
- [ ] Atualizar todos os testes em `tests/Feature/`
- [ ] Usar `actingAs()` com novo sistema de auth

#### Unit Tests
- [ ] Atualizar todos os testes em `tests/Unit/`

### Fase 12: Configuração

#### Config Files
- [ ] Atualizar `config/app.php` (remover providers/aliases)
- [ ] Atualizar `config/auth.php`
- [ ] Atualizar `config/database.php`
- [ ] Atualizar `config/filesystems.php` (Flysystem 3)
- [ ] Atualizar `config/logging.php` (Monolog 3)
- [ ] Atualizar `config/mail.php` (`MAIL_MAILER`)
- [ ] Atualizar `config/queue.php`
- [ ] Atualizar `config/session.php`
- [ ] Remover configs de pacotes removidos
- [ ] Adicionar configs de novos pacotes

#### Environment
- [ ] Atualizar `.env.example`
- [ ] Atualizar variáveis depreciadas

### Fase 13: Pacotes de Terceiros

#### Atualização de Pacotes
- [ ] Atualizar `laravel/passport` para v12
- [ ] Atualizar `laravel/socialite` para v5
- [ ] Atualizar `spatie/laravel-backup` para v9
- [ ] Atualizar `sentry/sentry-laravel` para v4
- [ ] Atualizar `intervention/image` para nova versão
- [ ] Atualizar `guzzlehttp/guzzle` para v7
- [ ] Atualizar `pusher/pusher-php-server` para v7
- [ ] Instalar e configurar `filament/filament`
- [ ] Instalar e configurar `spatie/laravel-permission`
- [ ] Instalar e configurar `spatie/laravel-activitylog`

### Fase 14: Admin Panel (Filament)

- [ ] Remover `summerblue/administrator`
- [ ] Instalar Filament
- [ ] Criar Resources para cada Model:
  - [ ] `UserResource`
  - [ ] `TopicResource`
  - [ ] `CategoryResource`
  - [ ] `RoleResource`
  - [ ] `PermissionResource`
  - [ ] `NewsResource`
  - [ ] `BannerResource`
  - [ ] `SiteResource`
  - [ ] Demais resources
- [ ] Configurar widgets de dashboard
- [ ] Implementar filtros e ações
- [ ] Testar todas as funcionalidades admin

### Fase 15: Finalização

#### Limpeza
- [ ] Remover código morto
- [ ] Remover comentários TODO antigos
- [ ] Rodar `composer dump-autoload -o`
- [ ] Rodar `php artisan optimize:clear`
- [ ] Rodar `php artisan config:cache`
- [ ] Rodar `php artisan route:cache`
- [ ] Rodar `php artisan view:cache`

#### Testes Finais
- [ ] Rodar suite completa de testes
- [ ] Testar todas as rotas manualmente
- [ ] Testar fluxo de autenticação
- [ ] Testar permissões e roles
- [ ] Testar upload de arquivos
- [ ] Testar notificações
- [ ] Testar API completa
- [ ] Testar admin panel
- [ ] Performance testing
- [ ] Security audit

#### Deploy
- [ ] Atualizar servidor para PHP 8.2+
- [ ] Atualizar dependências do servidor
- [ ] Planejar downtime para migração
- [ ] Preparar rollback plan
- [ ] Deploy para staging
- [ ] Testes em staging
- [ ] Deploy para produção
- [ ] Monitorar logs após deploy

---

## Referências e Documentação

### Upgrade Guides Oficiais
- [5.8 to 6.0](https://laravel.com/docs/6.x/upgrade)
- [6.x to 7.0](https://laravel.com/docs/7.x/upgrade)
- [7.x to 8.0](https://laravel.com/docs/8.x/upgrade)
- [8.x to 9.0](https://laravel.com/docs/9.x/upgrade)
- [9.x to 10.0](https://laravel.com/docs/10.x/upgrade)
- [10.x to 11.0](https://laravel.com/docs/11.x/upgrade)
- [11.x to 12.0](https://laravel.com/docs/12.x/upgrade)

### Pacotes Novos
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
- [Filament Admin](https://filamentphp.com/docs)
- [Laravel Sanctum](https://laravel.com/docs/sanctum)

### Ferramentas Úteis
- [Laravel Shift](https://laravelshift.com/) - Automação de upgrades (pago)
- [Rector](https://github.com/rectorphp/rector-laravel) - Refactoring automatizado
- [PHPStan](https://phpstan.org/) - Análise estática

---

## Estimativa de Tempo por Fase

| Fase | Descrição | Estimativa |
|------|-----------|------------|
| 0 | Preparação | 1 semana |
| 1 | Código Base (Helpers) | 3-4 dias |
| 2 | Auth/Authorization | 1-2 semanas |
| 3 | Database | 1 semana |
| 4 | API | 2 semanas |
| 5 | Controllers/Requests | 3-4 dias |
| 6 | Jobs/Events/Notifications | 3-4 dias |
| 7 | Middleware | 2-3 dias |
| 8 | Service Providers | 2-3 dias |
| 9 | Rotas | 2-3 dias |
| 10 | Views/Frontend | 1 semana |
| 11 | Testes | 1 semana |
| 12 | Configuração | 2-3 dias |
| 13 | Pacotes Terceiros | 3-4 dias |
| 14 | Admin Panel | 2 semanas |
| 15 | Finalização | 1 semana |

**Total Estimado: 10-14 semanas**

---

*Documento gerado em: 2025-11-19*
*Versão: 1.0*
