# Desafio ListaDeTarefas

Este é um desafio técnico para vaga de estágio como desenvolvedor PHP/Laravel. O objetivo foi criar uma aplicação simples de gestão de tarefas (To-Do List) com funcionalidades básicas de CRUD, autenticação e uma interface responsiva utilizando Tailwind Css e Blade.

## Tecnologias Utilizadas

- **Backend:** Laravel 12
- **Frontend:** Blade Template Engine + Tailwind Css
- **Banco de Dados:** MySQL
- **Autenticação:** Laravel Breeze
- **Versionamento:** Git

## ✅ Funcionalidades

- [x] Cadastro de tarefas
- [x] Edição de tarefas
- [x] Exclusão de tarefas (Soft Delete)
- [x] Restauração de Tarefas que foram para o status trashed (Soft Delete)
- [x] Filtro de tarefas por status (pendente/concluída)
- [x] Autenticação de usuários
- [x] Interface responsiva com Tailwind Css
- [x] Proteção das Rotas com Middleware "Auth"
- [x] Policies para autorização
- [x] Factory Pattern para criação de dados fakes nos Testes
- [x] 100% de Teste Coverage usando PHP UNIT !!!!
- [x] BONUS: Filtro das tarefas que foram excluidas (Soft Delete)

## Futuras Melhorias

- **Separar funcionalidades:** Separa as funcionalidades do crud feitas no controller em outras classes, podemos utilizar Services (Classes de Negócio) e Respository (Classes com acesso ao banco de dados), Action Pattern (Padrão onde uma classe tem apenas uma responsabilidade).
- **Utilizar DTOs:** Criarmos objetos de transferência, onde este objeto receberia as informações vinda do request e serviria de intermediário entre a camada HTTP e classes de negócios.
- **Utilizar Acessors:** Caso se repita poderiamos utilizar acessors na propriedade created_at do todo, onde o valor vindo do banco seria formatado com o Carbon para seguir o padrão estabelecido.

## 📦 Instalação e Execução
### 1. Clone o repositório

```bash
git clone https://github.com/RichardGL11/ListaDeTarefas.git
cd ListaDeTarefas
```
### 2. Instale As Dependências

```bash
composer install
npm install
```
### 3. Gere uma Chave
```bash
cp .env.example .env
php artisan key:generate
```
### 4. Configure seu banco de dados

```bash
# Configure o .env com os dados do seu banco:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=todoapp
# DB_USERNAME=root
# DB_PASSWORD=
```
### 5. Para Rodar o Projeto
```bash
php artisan migrate --seed
npm run dev
php artisan serve
```
### 6. Para rodar os testes com coverage
```bash
npm run build
php artisan test --coverage
```
