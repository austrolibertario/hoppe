# Primeiro forum anarco-capitalista!=============                                                     

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/austrolibertario/hoppe/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/austrolibertario/hoppe/?branch=master)[![Code Coverage](https://scrutinizer-ci.com/g/austrolibertario/hoppe/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/austrolibertario/hoppe/?branch=master)[![Latest Stable Version](https://poser.pugx.org/austrolibertario/hoppe/v/stable.png)](https://packagist.org/packages/austrolibertario/hoppe) [![Total Downloads](https://poser.pugx.org/austrolibertario/hoppe/downloads.png)](https://packagist.org/packages/austrolibertario/hoppe) [![Latest Unstable Version](https://poser.pugx.org/austrolibertario/hoppe/v/unstable.png)](https://packagist.org/packages/austrolibertario/hoppe) [![License](https://poser.pugx.org/austrolibertario/hoppe/license.png)](https://packagist.org/packages/austrolibertario/hoppe)

## Visão geral do projeto                                                                                                             
* Instituto Hoppe Brasil：https://h3sotospeak.com/
* Documentação: https://austrolibertario.github.io/hoppe/

[SoToSpeak](https://github.com/austrolibertarios/hoppe) Running with Laravel 5.8 :heart:.

## Installing With Docker | Instalando com Docker

## Requirements

```
Docker
```

### Installing

#### 1. Clonar código-fonte

Este código de projeto foi desenvolvido usando o framework PHP [Laravel 5.8], usado no ambiente de desenvolvimento local [Laravel Homestead] ou docker. E usando docker também em produção.

Instale via composer
```
composer create-project austrolibertario/hoppe
```

ou

Clone o código-fonte para o local:

    > git clone https://github.com/austrolibertarios/hoppe.git


#### 2. Copie e configura o arquivo .env e  suba os servidores:
```
cp .env.example .env && \
docker-compose up
```

#### 3. Se conecte no container do php e crie os bancos de dados e faça a importação das bases
```
docker exec -it hoppe_php_1 bash
php artisan key:generate && \
php artisan migrate --seed
```

or

```
docker exec -it hoppe_php_1 bash
php artisan est:install
```

#### Obs 

For connecting in database use this command
```
docker exec -it hoppe_db_1 bash
mysql -u root -p hoppe;
```

## Installing na Mão

## Implantação / instalação do ambiente de desenvolvimento

Este código de projeto foi desenvolvido usando o framework PHP [Laravel 5.8] (https://doc.h3sotospeak.com/docs/5.1/), usado no ambiente de desenvolvimento local [Laravel Homestead](https://doc.h3sotospeak.com/docs/5.1/homestead).

A seguinte descrição será feita assumindo que o leitor já instalou o Homestead. Se você não instalou o Homestead, você pode consultar [Instalação e Configuração do Homestead] (https://doc.h3sotospeak.com/docs/5.1/homestead#installation-and-setup) para a configuração da instalação.


### Ambiente operacional

```
- Nginx 1.8+
- PHP 7.0+
- Mysql 5.7+
- Redis 3.0+
- Memcached 1.4+
```

## Requirements

```
* php +7
* ext-mcrypt
```

Install in ubuntu
```
sudo apt install php php-mcrypt
```


### Instalação com Homestead

#### 1. Clone github code

Clone o código-fonte para o local:

    > git clone https://github.com/austrolibertarios/hoppe.git
    
      
#### 3. Se conecte no container do postgres e crie os bancos de dados e fa�a a importa��o das bases
```
docker exec -it hoppe_db_1 bash
mysql -u root -p
CREATE DATABASE hoppe;
```


#### 2. Configurando um ambiente Homestead local

1). Edite o arquivo Homestead.yaml executando o seguinte comando:

```shell
homestead edit
```

2). Adicione as alterações correspondentes da seguinte forma:

```
folders:
    - map: ~/my-path/hoppe/ # Seu endereço do diretório de projetos local
      to: /home/vagrant/hoppe
sites:
    - map: hoppe.app
      to: /home/vagrant/hoppe/public

databases:
    - hoppe
```

3). Modificação do aplicativo

Salve após a conclusão da modificação e, em seguida, execute o seguinte comando para aplicar a modificação das informações de configuração:

```shell
homestead provision
```

> Nota: Às vezes você precisa reiniciar para ver o aplicativo. Execute `homestead halt` e, em seguida,` homestead up` para reinicializar.

#### 3. Instalar dependências do pacote de extensão

    > composer install

#### 4. Gerar arquivo de configuração

    > cp .env.example .env

#### 5. Use o comando de instalação

Dentro da máquina virtual:

```shell
php artisan est:install
```

> Para mais informações, confira ESTInstallCommand

#### 6. Configurando o arquivo hosts

Host:

    echo "192.168.10.10   hoppe.app" | sudo tee -a /etc/hosts

### Instalação de ferramentas de front-end

> O código vem com o código front-end compilado.Se você não quer desenvolver o estilo front-end, você não precisa configurar o conjunto de ferramentas front-end.Você pode pular o link direto para a seção `link entry '.

1). Instale o node.js

Vá diretamente para o site oficial [https://nodejs.org/en/] (https://nodejs.org/en/) para baixar e instalar a versão mais recente.

2). Instalar Npm


### Link de entrada

> Por favor modifique o arquivo `.env` para` APP_ENV = local` e `APP_DEBUG = true`.

* Endereço residencial：http://hoppe.app/
* Fundo de gestão：http://hoppe.app/admin

No ambiente de desenvolvimento, você pode efetuar login no Usuário nº 1, acessando diretamente o endereço de segundo plano.

Neste ponto, a instalação está completa.

## Descrição do pacote de extensão

| Pacote de Expansão | Descrição de uma frase | Casos de uso deste projeto |
| --- | --- | --- |   
|[infyomlabs/laravel-generator](https://packagist.org/packages/infyomlabs/laravel-generator)| Laravel Gerador de código | Na hora do desenvolvimento Migration、Model、Controller Ambos são gerados usando este pacote de extensão. |  
| [orangehill/iseed](https://github.com/orangehill/iseed) | Exportar os dados na tabela de dados como semente | BannersTableSeeder, LinksTableSeeder, CategoriesTableSeeder E o TipsTableSeeder é gerado usando este pacote de extensão. |
| [barryvdh/laravel-debugbar](https://github.com/barryvdh/laravel-debugbar) |Barra de ferramentas de depuração | Ferramentas de depuração essenciais para desenvolvimento. |
|[rap2hpoutre/laravel-logviewer](https://github.com/rap2hpoutre/laravel-log-viewer)| Ferramenta Log View | No ambiente de produção, use este pacote de extensão para visualizar rapidamente o Log e ter o controle de permissão. |
| [laracasts/presenter](https://github.com/laracasts/Presenter) | Mecanismo do Apresentador | O seguinte Modelo: Usuário, Tópico e Notificação todos usam o Presenter. |
|[league/html-to-markdown](https://github.com/thephpleague/html-to-markdown)|Converter HTML em Markdown | Essa extensão é usada quando os usuários postam e respondem a postagens. |
|[erusev/parsedown](https://github.com/erusev/parsedown)| Converter Markdown em HTML | Essa extensão é usada ao postar e responder a postagens. |
| [laravel/socialite](https://github.com/laravel/socialite) | Componente Oficial de Login Social | A lógica de login do GitHub usa essa extensão. |
|[NauxLiu/auto-correct](https://github.com/NauxLiu/auto-correct)| Adicionar automaticamente espaços razoáveis entre chinês e inglês para corrigir o caso de substantivos especiais Use essa extensão para filtrar o título ao postar. |
| [Intervention/image](https://github.com/Intervention/image) |Biblioteca de Processamento de Imagens - Ao fazer o upload e responder a uma postagem, a lógica de upload de imagens usa essa extensão.|
| [zizaco/entrust](https://github.com/Zizaco/entrust.git) |Permissões de Grupo de Usuários Sistema | O sistema de permissões para todo o site é baseado neste pacote de extensões. |
| [VentureCraft/revisionable](https://github.com/VentureCraft/revisionable) | Registre o log de alterações do Modelo | O Modelo a seguir: Usuário, Tópico, Resposta, Categoria, Banner use este pacote de extensões para registrar o log de exclusão.|
| [mews/purifier](https://github.com/mewebstudio/Purifier) | HTML Filtro de lista de permissões | Impede a filtragem de XSS quando os usuários publicam e respondem. |
|[oumen/sitemap](https://github.com/RoumenDamianoff/laravel-sitemap)| Sitemap Ferramentas de Construção | O sitemap deste projeto é gerado usando esta extensão. |
|[spatie/laravel-backup](https://github.com/spatie/laravel-backup)| Solução de Backup de Banco de Dados Os backups de banco de dados para este projeto são feitos usando essa extensão. |
|[summerblue/administrator](https://github.com/summerblue/administrator)| Gerenciar soluções em background | O backend deste projeto foi desenvolvido usando esta extensão. |
|[laracasts/flash](https://packagist.org/packages/laracasts/flash)| Mensagens instantâneas simples | Sucesso de login do usuário, prompts de pós-sucesso usando este desenvolvimento de pacote de extensão |


## Personalize a lista de comandos do Artisan

| Comando | Descrição |
| --- | --- |
| est:install | O comando de instalação suporta apenas a execução no ambiente de desenvolvimento e é necessário executá-lo na instalação inicial.|
| est:reinstall | O comando reload suporta apenas a execução no ambiente de desenvolvimento.A chamada desse comando reconfigura o banco de dados e redefine a identidade do usuário.|

## Tarefa planejada

As tarefas planejadas para este projeto são realizadas no Laravel [Task Scheduling] (https://doc.h3sotospeak.com/docs/5.1/scheduling).

| Comando | descrição | chamada |
| --- | --- | --- |
| `backup:run --only-db` | Backup de banco de dados, executado a cada 4 horas, pertence a [spatie/laravel-backup](https://github.com/spatie/laravel-backup) Lógica | php artisan backup:run --only-db|
| `backup:clean` | Limpe backups de banco de dados expirados, rodando 1:20 diariamente, pertencentes a [spatie/laravel-backup](https://github.com/spatie/laravel-backup) Lógica | php artisan backup:clean |


## Log de gerador de código

Este projeto usa [infyomlabs / laravel-generator] (https://packagist.org/packages/infyomlabs/laravel-generator) para construir rapidamente projetos, e a finalidade de registrar esses logs é facilitar o desenvolvimento futuro.

```shell

php artisan make:scaffold Appends --schema="content:text,topic_id:integer:unsigned:default(0):index"

php artisan make:scaffold Attentions --schema="topic_id:integer:unsigned:default(0):index,user_id:integer:unsigned:default(0):index"

php artisan make:scaffold Links --schema="title:string:index,link:string:index,cover:text:nullable"

php artisan make:scaffold Replies --schema="topic_id:integer:unsigned:default(0):index,user_id:integer:unsigned:default(0):index,is_block:tinyInteger:unsigned:default(0):index,vote_count:integer:unsigned:default(0):index,body:text,body_original:text:nullable"

php artisan make:scaffold SiteStatuses --schema="day:string:index,register_count:integer:unsigned:default(0),topic_count:tinyInteger:unsigned:default(0),reply_count:integer:unsigned:default(0),image_count:integer:unsigned:default(0)"

php artisan make:scaffold Tips --schema="body:text:nullable"

php artisan make:scaffold Topics --schema="title:string:index,body:text,user_id:tinyInteger:unsigned:default(0),category_id:integer:unsigned:default(0),reply_count:integer:unsigned:default(0),view_count:integer:unsigned:default(0),vote_count:integer:unsigned:default(0),last_reply_user_id:integer:unsigned:default(0),order:integer:unsigned:default(0),is_excellent:tinyInteger:unsigned:default(0),is_wiki:tinyInteger:unsigned:default(0),is_blocked:tinyInteger:unsigned:default(0),body_original:text:nullable,excerpt:text:nullable"

php artisan make:scaffold Topics --schema="user_id:integer:unsigned:default(0),votable_id:integer:unsigned:default(0),votable_type:string:index,is:string:index"

php artisan make:scaffold Users --schema="github_id:integer:unsigned:default(0):index,github_url:string:index,email:string:index:index,name:string:index:index"

php artisan make:scaffold Votes --schema="user_id:integer:unsigned:default(0),votable_id:integer:unsigned:default(0),votable_type:string:index,is:string:index"

php artisan make:scaffold Banners --schema="position:string:index,order:integer:unsigned:default(0):index,image_url:string,title:string:index,description:text:nullable"

php artisan make:scaffold NotificationMailLogs --schema="from_user_id:integer:unsigned:default(0):index,user_id:integer:unsigned:default(0):index,type:string:index,body:text:nullable"
```
