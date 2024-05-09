# API Laravel 11

Esta é uma API desenvolvida em Laravel 11 utilizando PHP 8.2. A API utiliza o sistema de autenticação Passport do Laravel e o banco de dados SQLite. É configurada para ser executada usando Docker Compose na porta localhost:9000.

## Funcionalidades

## Como Rodar

1. Certifique-se de ter o Docker e o Docker Compose instalados em seu sistema.
2. Clone este repositório em sua máquina local:
   git clone https://github.com/pedro162/bookstore_api.git

3. Clone este repositório em sua máquina local:
	cd bookstore_api
4. Renomeie o arquivo .env.example para .env:
	cp .env.example .env
5. Instale as dependências do Composer:
	composer install
6. Gere a chave da aplicação:
	php artisan key:generate
7. Execute as migrations para configurar o banco de dados:
	php artisan migrate
8. Inicie o servidor Laravel:
	php artisan serve


### Autenticação

A API utiliza o Grant Type de autenticação do tipo Password. Isso significa que os usuários podem obter um token de acesso fornecendo seu nome de usuário e senha através da rota `/login`. O token gerado é então usado para autenticar as solicitações subsequentes.


#### Rotas de Autenticação

- POST `/login`: Autentica o usuário e gera um token de acesso.
- POST `/logout`: Revoga o token de acesso do usuário, efetuando logout.

### Recursos da API



#### User

- GET `/user/index`: Retorna uma lista de todos os usuários cadastrados.
- POST `/user/store`: Cria um novo usuário e retorna o token para realizar requisições na api.
- PUT `/user/update/{id}`: Atualiza os detalhes de um usuário específico.

#### Store

- GET `/store/index`: Retorna uma lista de todas as lojas cadastradas.
- POST `/store/store`: Cria uma nova loja.
- PUT `/store/update/{id}`: Atualiza os detalhes de uma loja específica.
- GET `/store/show/{id}`: Retorna os detalhes de uma loja específica.
- DELETE `/store/destroy/{id}`: Exclui uma loja específica.
- POST `/store/{store_id}/book/{book_id}`: Vincula um livro existente a uma loja existente.

#### Book

- GET `/book/index`: Retorna uma lista de todos os livros cadastrados.
- POST `/book/store/{store_id}`: Adiciona um novo livro a uma loja específica.
- PUT `/book/update/{id}`: Atualiza os detalhes de um livro específico.
- GET `/book/show/{id}`: Retorna os detalhes de um livro específico.
- DELETE `/book/destroy/{id}`: Exclui um livro específico.

## Como Usar

1. Certifique-se de ter o Docker e o Docker Compose instalados em seu sistema.
2. Clone este repositório em sua máquina local.
3. Navegue até o diretório do projeto e execute o seguinte comando no terminal: docker-compose up
4. Após o contêiner Docker estar em execução, a API estará disponível em `http://localhost:9000`.
5. Para acessar as rotas protegidas que requerem autenticação, primeiro cadastre um usuario e senha enviando uma solicitação POST para `/user/store` com o nome de usuário e senha. Ao realizar essa operação, a API irá devolver um TOKEN de autorização pra inluir no cabeçalho das solicitações bubsequentes
6. Para acessar as rotas protegidas que requerem autenticação, primeiro faça login enviando uma solicitação POST para `/login` com o nome de usuário e senha.
7. Use o token de acesso retornado para autenticar as solicitações subsequentes, incluindo-o no cabeçalho `Authorization`.

## Exemplos de Requisição

### Novo usuário

POST /login
Content-Type: application/json

{
	"name":"admin",
    "email":"admin@gmail.com",
    "password":23456
}

### Login

POST /login
Content-Type: application/json

{
	"email": "admin@gmail.com",
	"password": "123456"
}

### Logout

POST /logout
Authorization: Bearer {token}

### Criar uma Nova Loja

POST /store/store
Content-Type: application/json
Authorization: Bearer {token}

{
  "name": "Minha Livraria",
  "address": "Rua Exemplo, 123",
  "active": true
}

### Criar um Novo Livro em uma Loja Existente

POST /book/store/{store_id}
Content-Type: application/json
Authorization: Bearer {token}

{
  "name": "Livro Interessante",
  "isbn": "978-3-16-148410-0",
  "value": 29.99
}

### Criar um Novo Livro sem uma Loja Existente

POST /book/store
Content-Type: application/json
Authorization: Bearer {token}

{
  "name": "Livro Interessante",
  "isbn": "978-3-16-148410-0",
  "value": 29.99
}

### Criar um Novo Livro sem uma Loja Existente

POST /book/store
Content-Type: application/json
Authorization: Bearer {token}

{
  "name": "Livro Interessante",
  "isbn": "9783161484100",
  "value": 29.99
}


### Vincular um Livro a uma Loja Existente

POST /store/{store_id}/book/{book_id}
Content-Type: application/json
Authorization: Bearer {token}

### Listar Todas as Lojas

GET /store/index
Authorization: Bearer {token}

### Mostrar Detalhes de uma Loja Específica

GET /store/show/{id}
Authorization: Bearer {token}


### Atualizar os Detalhes de uma Loja Específica

PUT /store/update/{id}
Content-Type: application/json
Authorization: Bearer {token}

{
  "name": "Nova Nome da Loja",
  "address": "Nova Endereço da Loja",
  "active": true
}

### Excluir uma Loja Específica

DELETE /store/destroy/{id}
Authorization: Bearer {token}

### Listar Todos os Livros

GET /book/index
Authorization: Bearer {token}

### Mostrar Detalhes de um Livro Específico

GET /book/show/{id}
Authorization: Bearer {token}

### Atualizar os Detalhes de um Livro Específico

PUT /book/update/{id}
Content-Type: application/json
Authorization: Bearer {token}

{
  "name": "Novo Nome do Livro",
  "isbn": "Novo ISBN do Livro",
  "value": 39.99
}

### Excluir um Livro Específico

DELETE /book/destroy/{id}
Authorization: Bearer {token}