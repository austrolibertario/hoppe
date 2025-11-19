# Guia de Testes - Laravel 11

Este documento contém a configuração e exemplos de testes para migração do projeto Hoppe para Laravel 11.

---

## Bloco 1: phpunit.xml Compatível com Laravel 11 e PHPUnit 11

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="vendor/phpunit/phpunit/phpunit.xsd"
         bootstrap="vendor/autoload.php"
         colors="true"
         cacheDirectory=".phpunit.cache"
         executionOrder="depends,defects"
         requireCoverageMetadata="false"
         beStrictAboutCoverageMetadata="false"
         beStrictAboutOutputDuringTests="true"
         failOnRisky="true"
         failOnWarning="true">

    <!-- ===========================================
         Test Suites
         =========================================== -->
    <testsuites>
        <testsuite name="Unit">
            <directory>tests/Unit</directory>
        </testsuite>
        <testsuite name="Feature">
            <directory>tests/Feature</directory>
        </testsuite>
        <testsuite name="Browser">
            <directory>tests/Browser</directory>
        </testsuite>
    </testsuites>

    <!-- ===========================================
         Coverage Configuration
         =========================================== -->
    <source>
        <include>
            <directory>app</directory>
        </include>
        <exclude>
            <directory>app/Console/Commands</directory>
            <file>app/Helpers.php</file>
        </exclude>
    </source>

    <coverage includeUncoveredFiles="true"
              pathCoverage="false"
              ignoreDeprecatedCodeUnits="true"
              disableCodeCoverageIgnore="false">
        <report>
            <clover outputFile="coverage/clover.xml"/>
            <html outputDirectory="coverage/html"/>
            <text outputFile="coverage/coverage.txt"/>
        </report>
    </coverage>

    <!-- ===========================================
         PHP Configuration
         =========================================== -->
    <php>
        <env name="APP_ENV" value="testing"/>
        <env name="APP_MAINTENANCE_DRIVER" value="file"/>
        <env name="BCRYPT_ROUNDS" value="4"/>
        <env name="CACHE_STORE" value="array"/>
        <env name="DB_CONNECTION" value="sqlite"/>
        <env name="DB_DATABASE" value=":memory:"/>
        <env name="MAIL_MAILER" value="array"/>
        <env name="PULSE_ENABLED" value="false"/>
        <env name="QUEUE_CONNECTION" value="sync"/>
        <env name="SESSION_DRIVER" value="array"/>
        <env name="TELESCOPE_ENABLED" value="false"/>
    </php>
</phpunit>
```

### Mudanças do PHPUnit 9 → 11

| Antes (PHPUnit 9) | Depois (PHPUnit 11) |
|-------------------|---------------------|
| `<filter><whitelist>` | `<source><include>` |
| `processUncoveredFilesFromWhitelist` | `includeUncoveredFiles` |
| `backupGlobals` | Removido (default false) |
| `backupStaticAttributes` | Removido |
| `convertErrorsToExceptions` | Removido (sempre true) |
| `convertNoticesToExceptions` | Removido (sempre true) |
| `convertWarningsToExceptions` | Removido (sempre true) |
| `stopOnFailure` | `stopOnFailure` no CLI |

---

## Bloco 2: Estrutura de Testes com PHPUnit Organizado

### Estrutura de Diretórios Proposta

```
tests/
├── TestCase.php                    # Base test case
├── CreatesApplication.php          # Trait para criar aplicação
├── DuskTestCase.php                # Base para testes Dusk
│
├── Unit/                           # Testes unitários (sem DB/HTTP)
│   ├── Models/
│   │   ├── UserTest.php
│   │   ├── TopicTest.php
│   │   ├── ReplyTest.php
│   │   └── NotificationTest.php
│   ├── Services/
│   │   ├── MarkdownServiceTest.php
│   │   ├── NotificationServiceTest.php
│   │   └── ImageUploadServiceTest.php
│   └── Helpers/
│       └── HelpersTest.php
│
├── Feature/                        # Testes de integração (HTTP/DB)
│   ├── Auth/
│   │   ├── LoginTest.php
│   │   ├── RegistrationTest.php
│   │   ├── PasswordResetTest.php
│   │   ├── EmailVerificationTest.php
│   │   └── SocialAuthTest.php
│   ├── Topics/
│   │   ├── CreateTopicTest.php
│   │   ├── UpdateTopicTest.php
│   │   ├── DeleteTopicTest.php
│   │   ├── ViewTopicTest.php
│   │   └── SearchTopicTest.php
│   ├── Replies/
│   │   ├── CreateReplyTest.php
│   │   ├── UpdateReplyTest.php
│   │   ├── DeleteReplyTest.php
│   │   └── VoteReplyTest.php
│   ├── Users/
│   │   ├── ProfileTest.php
│   │   ├── SettingsTest.php
│   │   ├── FollowTest.php
│   │   └── NotificationsTest.php
│   ├── Admin/
│   │   ├── DashboardTest.php
│   │   ├── UserManagementTest.php
│   │   └── ModerationTest.php
│   └── Api/
│       ├── TopicsApiTest.php
│       ├── UsersApiTest.php
│       └── AuthApiTest.php
│
├── Browser/                        # Testes E2E com Dusk
│   ├── Pages/
│   │   └── ...
│   └── ...
│
└── Fixtures/                       # Dados de teste
    ├── users.json
    └── topics.json
```

### TestCase Base Atualizado

```php
<?php
// tests/TestCase.php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Criar um usuário autenticado para testes
     */
    protected function signIn(?User $user = null): User
    {
        $user = $user ?? User::factory()->create();
        $this->actingAs($user);
        return $user;
    }

    /**
     * Criar um usuário admin autenticado
     */
    protected function signInAsAdmin(): User
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->actingAs($user);
        return $user;
    }

    /**
     * Criar um usuário moderador autenticado
     */
    protected function signInAsModerator(): User
    {
        $user = User::factory()->create();
        $user->assignRole('moderator');
        $this->actingAs($user);
        return $user;
    }

    /**
     * Assert que a resposta contém erros de validação
     */
    protected function assertValidationError($response, string $field): void
    {
        $response->assertSessionHasErrors($field);
    }

    /**
     * Assert flash message
     */
    protected function assertFlashMessage($response, string $message): void
    {
        $response->assertSessionHas('flash_notification.0.message', $message);
    }
}
```

---

## Bloco 3: 10 Casos de Teste Prioritários para um Fórum

### Matriz de Prioridade

| # | Área | Caso de Teste | Prioridade | Complexidade |
|---|------|---------------|------------|--------------|
| 1 | Auth | Login com credenciais válidas/inválidas | CRÍTICA | Baixa |
| 2 | Auth | Registro de novo usuário com verificação de email | CRÍTICA | Média |
| 3 | Topics | Criar tópico com markdown e categorias | ALTA | Média |
| 4 | Topics | Editar/deletar tópico (autor e permissões) | ALTA | Média |
| 5 | Replies | Criar resposta em tópico | ALTA | Baixa |
| 6 | Replies | Votar em respostas (upvote/downvote) | ALTA | Média |
| 7 | Permissions | Moderador pode editar/deletar qualquer conteúdo | CRÍTICA | Alta |
| 8 | Users | Seguir/deixar de seguir usuários | MÉDIA | Baixa |
| 9 | Notifications | Receber notificação ao ser mencionado | MÉDIA | Média |
| 10 | API | CRUD de tópicos via API REST | ALTA | Média |

### Descrição Detalhada dos Casos

#### 1. Login com credenciais válidas/inválidas
- **Cenário positivo**: Usuário com email/senha corretos consegue logar
- **Cenário negativo**: Credenciais incorretas retornam erro
- **Edge cases**: Conta não verificada, conta banida, rate limiting

#### 2. Registro de novo usuário
- **Cenário positivo**: Registro com dados válidos cria usuário não verificado
- **Validações**: Email único, senha forte, username válido
- **Verificação**: Email enviado, link funciona, conta ativada

#### 3. Criar tópico
- **Pré-condição**: Usuário autenticado e verificado
- **Dados**: Título, corpo (markdown), categoria, tags
- **Validações**: Título único, corpo mínimo, categoria válida
- **Pós-condição**: Tópico aparece na listagem, autor notificado

#### 4. Editar/deletar tópico
- **Permissões**: Apenas autor ou moderador pode editar
- **Soft delete**: Tópicos deletados são arquivados
- **Cascade**: Deletar tópico não deleta respostas (ou deleta?)

#### 5. Criar resposta
- **Pré-condição**: Usuário autenticado, tópico não trancado
- **Notificações**: Autor do tópico é notificado
- **Menções**: @username notifica o mencionado

#### 6. Votar em respostas
- **Regras**: Um voto por usuário por resposta
- **Toggle**: Segundo clique remove o voto
- **Karma**: Votos afetam reputação do autor

#### 7. Permissões de moderação
- **Moderador pode**: Editar/deletar qualquer conteúdo, banir usuários
- **Admin pode**: Tudo + gerenciar moderadores
- **Usuário comum**: Apenas seu próprio conteúdo

#### 8. Seguir usuários
- **Ação**: Seguir/deixar de seguir
- **Feed**: Tópicos de seguidos aparecem no feed
- **Notificação**: Notificar quando seguido posta

#### 9. Notificações de menção
- **Trigger**: @username no corpo de tópico/resposta
- **Canais**: Database, email (configurável)
- **Leitura**: Marcar como lida, marcar todas

#### 10. API REST de tópicos
- **Endpoints**: GET /api/topics, POST, PUT, DELETE
- **Autenticação**: Bearer token (Sanctum)
- **Paginação**: Cursor-based para performance

---

## Bloco 4: Exemplos Completos de Testes de Feature

### Exemplo 1: Teste de Autenticação

```php
<?php
// tests/Feature/Auth/LoginTest.php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    // =========================================
    // Testes de Login Bem-sucedido
    // =========================================

    /** @test */
    public function user_can_view_login_page(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    /** @test */
    public function user_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
            'verified' => true,
        ]);

        $response = $this->post(route('login'), [
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_is_redirected_to_intended_url_after_login(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
            'verified' => true,
        ]);

        // Tentar acessar página protegida
        $this->get(route('topics.create'))
            ->assertRedirect(route('login'));

        // Login
        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        // Deve redirecionar para a página que tentou acessar
        $response->assertRedirect(route('topics.create'));
    }

    // =========================================
    // Testes de Login Falho
    // =========================================

    /** @test */
    public function user_cannot_login_with_incorrect_password(): void
    {
        $user = User::factory()->create([
            'email' => 'john@example.com',
            'password' => Hash::make('correct-password'),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'john@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /** @test */
    public function user_cannot_login_with_nonexistent_email(): void
    {
        $response = $this->post(route('login'), [
            'email' => 'nonexistent@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /** @test */
    public function user_cannot_login_without_email_verification(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
            'verified' => false,
        ]);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('email-verification-required'));
        $this->assertGuest();
    }

    // =========================================
    // Testes de Validação
    // =========================================

    /** @test */
    public function email_is_required(): void
    {
        $response = $this->post(route('login'), [
            'email' => '',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function email_must_be_valid(): void
    {
        $response = $this->post(route('login'), [
            'email' => 'not-an-email',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function password_is_required(): void
    {
        $response = $this->post(route('login'), [
            'email' => 'john@example.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors('password');
    }

    // =========================================
    // Testes de Logout
    // =========================================

    /** @test */
    public function authenticated_user_can_logout(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('logout'));

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    // =========================================
    // Testes de Rate Limiting
    // =========================================

    /** @test */
    public function user_is_locked_out_after_too_many_attempts(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        // Tentar login 6 vezes com senha errada
        for ($i = 0; $i < 6; $i++) {
            $this->post(route('login'), [
                'email' => $user->email,
                'password' => 'wrong-password',
            ]);
        }

        // Próxima tentativa deve ser bloqueada
        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertStringContainsString(
            'Too many login attempts',
            session('errors')->first('email')
        );
    }
}
```

### Exemplo 2: Teste de Criação de Tópicos

```php
<?php
// tests/Feature/Topics/CreateTopicTest.php

namespace Tests\Feature\Topics;

use App\Models\Category;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TopicCreated;
use Tests\TestCase;

class CreateTopicTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['verified' => true]);
        $this->category = Category::factory()->create();
    }

    // =========================================
    // Testes de Acesso
    // =========================================

    /** @test */
    public function guest_cannot_view_create_topic_page(): void
    {
        $response = $this->get(route('topics.create'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_user_can_view_create_topic_page(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('topics.create'));

        $response->assertStatus(200);
        $response->assertViewIs('topics.create');
        $response->assertViewHas('categories');
    }

    /** @test */
    public function unverified_user_cannot_create_topic(): void
    {
        $unverifiedUser = User::factory()->create(['verified' => false]);

        $response = $this->actingAs($unverifiedUser)
            ->post(route('topics.store'), [
                'title' => 'Test Topic',
                'body' => 'Test body content',
                'category_id' => $this->category->id,
            ]);

        $response->assertRedirect(route('email-verification-required'));
        $this->assertDatabaseMissing('topics', ['title' => 'Test Topic']);
    }

    // =========================================
    // Testes de Criação Bem-sucedida
    // =========================================

    /** @test */
    public function user_can_create_topic_with_valid_data(): void
    {
        $topicData = [
            'title' => 'Introdução ao Libertarianismo',
            'body' => 'Este é um texto introdutório sobre os princípios básicos do libertarianismo e da ética argumentativa.',
            'category_id' => $this->category->id,
        ];

        $response = $this->actingAs($this->user)
            ->post(route('topics.store'), $topicData);

        $response->assertRedirect();

        $this->assertDatabaseHas('topics', [
            'title' => $topicData['title'],
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
        ]);

        $topic = Topic::where('title', $topicData['title'])->first();
        $this->assertNotNull($topic);
        $this->assertEquals($this->user->id, $topic->user_id);
    }

    /** @test */
    public function topic_body_is_parsed_as_markdown(): void
    {
        $topicData = [
            'title' => 'Markdown Test',
            'body' => "# Heading\n\n**Bold text** and *italic*\n\n```php\necho 'code';\n```",
            'category_id' => $this->category->id,
        ];

        $this->actingAs($this->user)
            ->post(route('topics.store'), $topicData);

        $topic = Topic::where('title', 'Markdown Test')->first();

        // O body_original mantém o markdown
        $this->assertStringContainsString('**Bold text**', $topic->body);
    }

    /** @test */
    public function topic_creates_with_slug(): void
    {
        $topicData = [
            'title' => 'Meu Primeiro Tópico no Fórum',
            'body' => 'Conteúdo do tópico aqui.',
            'category_id' => $this->category->id,
        ];

        $this->actingAs($this->user)
            ->post(route('topics.store'), $topicData);

        $topic = Topic::where('title', $topicData['title'])->first();
        $this->assertEquals('meu-primeiro-topico-no-forum', $topic->slug);
    }

    /** @test */
    public function topic_can_have_tags(): void
    {
        $topicData = [
            'title' => 'Topic with Tags',
            'body' => 'Content here',
            'category_id' => $this->category->id,
            'tags' => ['libertarianismo', 'economia', 'ética'],
        ];

        $this->actingAs($this->user)
            ->post(route('topics.store'), $topicData);

        $topic = Topic::where('title', 'Topic with Tags')->first();
        $this->assertCount(3, $topic->tags);
    }

    // =========================================
    // Testes de Validação
    // =========================================

    /** @test */
    public function title_is_required(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('topics.store'), [
                'title' => '',
                'body' => 'Valid body content',
                'category_id' => $this->category->id,
            ]);

        $response->assertSessionHasErrors('title');
        $this->assertDatabaseCount('topics', 0);
    }

    /** @test */
    public function title_must_be_at_least_10_characters(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('topics.store'), [
                'title' => 'Short',
                'body' => 'Valid body content with enough characters.',
                'category_id' => $this->category->id,
            ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function title_must_not_exceed_200_characters(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('topics.store'), [
                'title' => str_repeat('a', 201),
                'body' => 'Valid body content',
                'category_id' => $this->category->id,
            ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function body_is_required(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('topics.store'), [
                'title' => 'Valid Title Here',
                'body' => '',
                'category_id' => $this->category->id,
            ]);

        $response->assertSessionHasErrors('body');
    }

    /** @test */
    public function body_must_be_at_least_30_characters(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('topics.store'), [
                'title' => 'Valid Title Here',
                'body' => 'Too short',
                'category_id' => $this->category->id,
            ]);

        $response->assertSessionHasErrors('body');
    }

    /** @test */
    public function category_id_is_required(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('topics.store'), [
                'title' => 'Valid Title Here',
                'body' => 'Valid body content with enough characters.',
                'category_id' => '',
            ]);

        $response->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function category_id_must_exist(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('topics.store'), [
                'title' => 'Valid Title Here',
                'body' => 'Valid body content with enough characters.',
                'category_id' => 999999,
            ]);

        $response->assertSessionHasErrors('category_id');
    }

    // =========================================
    // Testes de XSS/Segurança
    // =========================================

    /** @test */
    public function topic_body_is_sanitized(): void
    {
        $topicData = [
            'title' => 'XSS Test Topic',
            'body' => '<script>alert("xss")</script>Conteúdo normal',
            'category_id' => $this->category->id,
        ];

        $this->actingAs($this->user)
            ->post(route('topics.store'), $topicData);

        $topic = Topic::where('title', 'XSS Test Topic')->first();
        $this->assertStringNotContainsString('<script>', $topic->body);
    }

    // =========================================
    // Testes de Notificações
    // =========================================

    /** @test */
    public function followers_are_notified_when_user_creates_topic(): void
    {
        Notification::fake();

        $follower = User::factory()->create();
        $follower->follow($this->user);

        $this->actingAs($this->user)
            ->post(route('topics.store'), [
                'title' => 'New Topic Notification Test',
                'body' => 'This should notify my followers.',
                'category_id' => $this->category->id,
            ]);

        Notification::assertSentTo($follower, TopicCreated::class);
    }
}
```

### Exemplo 3: Teste de Permissões e Moderação

```php
<?php
// tests/Feature/Admin/ModerationTest.php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Reply;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ModerationTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $moderator;
    private User $regularUser;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        // Criar roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'moderator']);

        // Criar usuários
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');

        $this->moderator = User::factory()->create();
        $this->moderator->assignRole('moderator');

        $this->regularUser = User::factory()->create(['verified' => true]);

        $this->category = Category::factory()->create();
    }

    // =========================================
    // Testes de Edição de Tópicos
    // =========================================

    /** @test */
    public function topic_author_can_edit_own_topic(): void
    {
        $topic = Topic::factory()->create([
            'user_id' => $this->regularUser->id,
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->regularUser)
            ->put(route('topics.update', $topic), [
                'title' => 'Updated Title by Author',
                'body' => 'Updated body content by the author.',
                'category_id' => $this->category->id,
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('topics', [
            'id' => $topic->id,
            'title' => 'Updated Title by Author',
        ]);
    }

    /** @test */
    public function regular_user_cannot_edit_others_topic(): void
    {
        $author = User::factory()->create();
        $topic = Topic::factory()->create([
            'user_id' => $author->id,
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->regularUser)
            ->put(route('topics.update', $topic), [
                'title' => 'Hacked Title',
                'body' => 'Hacked body content.',
                'category_id' => $this->category->id,
            ]);

        $response->assertForbidden();
        $this->assertDatabaseMissing('topics', [
            'id' => $topic->id,
            'title' => 'Hacked Title',
        ]);
    }

    /** @test */
    public function moderator_can_edit_any_topic(): void
    {
        $topic = Topic::factory()->create([
            'user_id' => $this->regularUser->id,
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->moderator)
            ->put(route('topics.update', $topic), [
                'title' => 'Edited by Moderator',
                'body' => 'Content edited by moderator for policy compliance.',
                'category_id' => $this->category->id,
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('topics', [
            'id' => $topic->id,
            'title' => 'Edited by Moderator',
        ]);
    }

    /** @test */
    public function admin_can_edit_any_topic(): void
    {
        $topic = Topic::factory()->create([
            'user_id' => $this->regularUser->id,
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->put(route('topics.update', $topic), [
                'title' => 'Edited by Admin',
                'body' => 'Admin edited this content.',
                'category_id' => $this->category->id,
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('topics', [
            'id' => $topic->id,
            'title' => 'Edited by Admin',
        ]);
    }

    // =========================================
    // Testes de Deleção de Tópicos
    // =========================================

    /** @test */
    public function topic_author_can_delete_own_topic(): void
    {
        $topic = Topic::factory()->create([
            'user_id' => $this->regularUser->id,
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->regularUser)
            ->delete(route('topics.destroy', $topic));

        $response->assertRedirect();
        $this->assertSoftDeleted('topics', ['id' => $topic->id]);
    }

    /** @test */
    public function regular_user_cannot_delete_others_topic(): void
    {
        $author = User::factory()->create();
        $topic = Topic::factory()->create([
            'user_id' => $author->id,
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->regularUser)
            ->delete(route('topics.destroy', $topic));

        $response->assertForbidden();
        $this->assertDatabaseHas('topics', ['id' => $topic->id]);
    }

    /** @test */
    public function moderator_can_delete_any_topic(): void
    {
        $topic = Topic::factory()->create([
            'user_id' => $this->regularUser->id,
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->moderator)
            ->delete(route('topics.destroy', $topic));

        $response->assertRedirect();
        $this->assertSoftDeleted('topics', ['id' => $topic->id]);
    }

    // =========================================
    // Testes de Deleção de Respostas
    // =========================================

    /** @test */
    public function reply_author_can_delete_own_reply(): void
    {
        $topic = Topic::factory()->create(['category_id' => $this->category->id]);
        $reply = Reply::factory()->create([
            'user_id' => $this->regularUser->id,
            'topic_id' => $topic->id,
        ]);

        $response = $this->actingAs($this->regularUser)
            ->delete(route('replies.destroy', $reply));

        $response->assertRedirect();
        $this->assertSoftDeleted('replies', ['id' => $reply->id]);
    }

    /** @test */
    public function moderator_can_delete_any_reply(): void
    {
        $topic = Topic::factory()->create(['category_id' => $this->category->id]);
        $reply = Reply::factory()->create([
            'user_id' => $this->regularUser->id,
            'topic_id' => $topic->id,
        ]);

        $response = $this->actingAs($this->moderator)
            ->delete(route('replies.destroy', $reply));

        $response->assertRedirect();
        $this->assertSoftDeleted('replies', ['id' => $reply->id]);
    }

    // =========================================
    // Testes de Trancar Tópicos
    // =========================================

    /** @test */
    public function regular_user_cannot_lock_topic(): void
    {
        $topic = Topic::factory()->create([
            'user_id' => $this->regularUser->id,
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->regularUser)
            ->post(route('topics.lock', $topic));

        $response->assertForbidden();
        $this->assertFalse($topic->fresh()->is_locked);
    }

    /** @test */
    public function moderator_can_lock_topic(): void
    {
        $topic = Topic::factory()->create([
            'category_id' => $this->category->id,
            'is_locked' => false,
        ]);

        $response = $this->actingAs($this->moderator)
            ->post(route('topics.lock', $topic));

        $response->assertRedirect();
        $this->assertTrue($topic->fresh()->is_locked);
    }

    /** @test */
    public function user_cannot_reply_to_locked_topic(): void
    {
        $topic = Topic::factory()->create([
            'category_id' => $this->category->id,
            'is_locked' => true,
        ]);

        $response = $this->actingAs($this->regularUser)
            ->post(route('replies.store', $topic), [
                'body' => 'Trying to reply to locked topic',
            ]);

        $response->assertForbidden();
        $this->assertDatabaseMissing('replies', [
            'topic_id' => $topic->id,
            'user_id' => $this->regularUser->id,
        ]);
    }

    // =========================================
    // Testes de Banimento de Usuários
    // =========================================

    /** @test */
    public function admin_can_ban_user(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.users.ban', $this->regularUser), [
                'reason' => 'Violação das regras da comunidade',
                'duration' => 7, // dias
            ]);

        $response->assertRedirect();
        $this->assertTrue($this->regularUser->fresh()->is_banned);
    }

    /** @test */
    public function moderator_cannot_ban_user(): void
    {
        $response = $this->actingAs($this->moderator)
            ->post(route('admin.users.ban', $this->regularUser), [
                'reason' => 'Test ban',
                'duration' => 7,
            ]);

        $response->assertForbidden();
        $this->assertFalse($this->regularUser->fresh()->is_banned ?? false);
    }

    /** @test */
    public function banned_user_cannot_create_topic(): void
    {
        $this->regularUser->update(['is_banned' => true]);

        $response = $this->actingAs($this->regularUser)
            ->post(route('topics.store'), [
                'title' => 'Topic from banned user',
                'body' => 'This should not be allowed.',
                'category_id' => $this->category->id,
            ]);

        $response->assertForbidden();
        $this->assertDatabaseMissing('topics', [
            'title' => 'Topic from banned user',
        ]);
    }

    /** @test */
    public function banned_user_cannot_create_reply(): void
    {
        $this->regularUser->update(['is_banned' => true]);

        $topic = Topic::factory()->create(['category_id' => $this->category->id]);

        $response = $this->actingAs($this->regularUser)
            ->post(route('replies.store', $topic), [
                'body' => 'Reply from banned user',
            ]);

        $response->assertForbidden();
    }

    // =========================================
    // Testes de Pinning de Tópicos
    // =========================================

    /** @test */
    public function moderator_can_pin_topic(): void
    {
        $topic = Topic::factory()->create([
            'category_id' => $this->category->id,
            'is_pinned' => false,
        ]);

        $response = $this->actingAs($this->moderator)
            ->post(route('topics.pin', $topic));

        $response->assertRedirect();
        $this->assertTrue($topic->fresh()->is_pinned);
    }

    /** @test */
    public function pinned_topics_appear_first_in_listing(): void
    {
        // Criar tópicos normais
        $normalTopics = Topic::factory()->count(3)->create([
            'category_id' => $this->category->id,
            'is_pinned' => false,
        ]);

        // Criar tópico pinado
        $pinnedTopic = Topic::factory()->create([
            'category_id' => $this->category->id,
            'is_pinned' => true,
        ]);

        $response = $this->get(route('topics.index'));

        $response->assertStatus(200);
        $topics = $response->viewData('topics');

        // Primeiro tópico deve ser o pinado
        $this->assertEquals($pinnedTopic->id, $topics->first()->id);
    }
}
```

---

## Comandos para Executar Testes

```bash
# ===============================================
# EXECUTAR TESTES
# ===============================================

# Todos os testes
php artisan test
# ou
./vendor/bin/phpunit

# Testes com cobertura
php artisan test --coverage
# ou
./vendor/bin/phpunit --coverage-html coverage/html

# Suite específica
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# Arquivo específico
php artisan test tests/Feature/Auth/LoginTest.php

# Método específico
php artisan test --filter=user_can_login_with_correct_credentials

# Testes em paralelo
php artisan test --parallel

# Com output verboso
php artisan test -v

# Parar no primeiro erro
php artisan test --stop-on-failure

# ===============================================
# COBERTURA DE CÓDIGO
# ===============================================

# Gerar relatório HTML
./vendor/bin/phpunit --coverage-html coverage/html

# Gerar relatório Clover (para CI)
./vendor/bin/phpunit --coverage-clover coverage/clover.xml

# Ver cobertura no terminal
./vendor/bin/phpunit --coverage-text

# ===============================================
# DUSK (E2E)
# ===============================================

# Instalar driver do Chrome
php artisan dusk:chrome-driver

# Executar testes Dusk
php artisan dusk

# Teste específico
php artisan dusk tests/Browser/LoginTest.php
```

---

## Dicas de Boas Práticas

### 1. Nomenclatura de Testes
```php
// Use nomes descritivos em snake_case
public function user_can_create_topic_with_valid_data(): void
public function guest_cannot_access_admin_dashboard(): void
public function topic_body_is_sanitized_against_xss(): void
```

### 2. Estrutura AAA (Arrange-Act-Assert)
```php
/** @test */
public function user_can_vote_on_reply(): void
{
    // Arrange
    $user = User::factory()->create();
    $reply = Reply::factory()->create();

    // Act
    $response = $this->actingAs($user)
        ->post(route('replies.vote', $reply), ['vote' => 'up']);

    // Assert
    $response->assertRedirect();
    $this->assertEquals(1, $reply->fresh()->votes_count);
}
```

### 3. Data Providers para Múltiplos Cenários
```php
/**
 * @test
 * @dataProvider invalidTitleProvider
 */
public function topic_title_validation(string $title, string $error): void
{
    $response = $this->actingAs($this->user)
        ->post(route('topics.store'), [
            'title' => $title,
            'body' => 'Valid body content here.',
            'category_id' => $this->category->id,
        ]);

    $response->assertSessionHasErrors(['title' => $error]);
}

public static function invalidTitleProvider(): array
{
    return [
        'empty' => ['', 'The title field is required.'],
        'too short' => ['Short', 'The title must be at least 10 characters.'],
        'too long' => [str_repeat('a', 201), 'The title must not exceed 200 characters.'],
    ];
}
```

### 4. Factories com States
```php
// database/factories/UserFactory.php
public function verified(): static
{
    return $this->state(fn () => ['verified' => true]);
}

public function banned(): static
{
    return $this->state(fn () => ['is_banned' => true]);
}

public function admin(): static
{
    return $this->afterCreating(function (User $user) {
        $user->assignRole('admin');
    });
}

// Uso nos testes
$user = User::factory()->verified()->create();
$admin = User::factory()->admin()->create();
$banned = User::factory()->banned()->create();
```

---

*Documento gerado em: 2025-11-19*
*Versão: 1.0*
