## Laravel Loja de Eletrônicos

Aplicação web desenvolvida com Laravel para gerenciamento de uma loja de eletrônicos.
O projeto demonstra a construção de um backend utilizando PHP, Laravel e banco de dados relacional, implementando funcionalidades típicas de um sistema de e-commerce como gerenciamento de produtos e operações CRUD.

Este projeto foi desenvolvido com foco em prática de desenvolvimento backend e organização de aplicações Laravel.
___
#### Funcionalidades

- Cadastro de produtos eletrônicos
- Listagem de produtos
- Atualização de informações dos produtos
- Remoção de produtos
- Persistência de dados em banco relacional
- Estrutura organizada seguindo o padrão MVC do Laravel

#### Tecnologias utilizadas

- PHP
- Laravel
- MySQL
- Blade
- Eloquent ORM
- Composer

#### Estrutura do projeto

O projeto segue a estrutura padrão do Laravel:

```
app/
 ├── Http/
 │    ├── Controllers
 │    └── Requests
 ├── Models
database/
 ├── migrations
 └── seeders
resources/
 └── views
routes/
 └── web.php
```

#### Principais responsabilidades:

- Controllers → lógica das requisições
- Models → representação das entidades do sistema
- Migrations → estrutura do banco de dados
- Views (Blade) → interface da aplicação
- Routes → definição das rotas da aplicação

### Como executar o projeto
1. Clonar o repositório  
`git clone https://github.com/andressa-mb/laravel-loja-eletronicos.git`  
2. Entrar na pasta  
`cd laravel-loja-eletronicos`
3. Instalar dependências  
`composer install`
4. Copiar o arquivo de exemplo:  
`cp .env.example .env`  
  Configurar as credenciais do banco de dados no .env.
5. Gerar a chave da aplicação  
`php artisan key:generate`
6. Executar migrations  
`php artisan migrate`
7. Iniciar o servidor  
`php artisan serve`

#### A aplicação estará disponível em:
```
http://localhost:8000
```

#### Conceitos aplicados

Este projeto foi desenvolvido para prática dos seguintes conceitos:
- Arquitetura MVC
- Desenvolvimento de aplicações web com Laravel
- Operações CRUD
- Migrations e gerenciamento de banco de dados
- Uso do ORM Eloquent
- Organização de rotas e controllers

#### Objetivo do projeto

O objetivo deste projeto é consolidar conhecimentos em desenvolvimento backend com Laravel, explorando a criação de aplicações web com estrutura organizada, integração com banco de dados e implementação de funcionalidades típicas de sistemas de e-commerce.
