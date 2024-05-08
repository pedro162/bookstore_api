# API Laravel 11

Esta é uma API desenvolvida em Laravel 11 utilizando PHP 8.2. A API utiliza o sistema de autenticação Passport do Laravel e o banco de dados SQLite. É configurada para ser executada usando Docker Compose na porta localhost:9000.

## Funcionalidades

### Autenticação

A API utiliza o Grant Type de autenticação do tipo Password. Isso significa que os usuários podem obter um token de acesso fornecendo seu nome de usuário e senha através da rota `/login`. O token gerado é então usado para autenticar as solicitações subsequentes.

#### Rotas de Autenticação

- POST `/login`: Autentica o usuário e gera um token de acesso.
- POST `/logout`: Revoga o token de acesso do usuário, efetuando logout.

### Recursos da API

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
5. Para acessar as rotas protegidas que requerem autenticação, primeiro faça login enviando uma solicitação POST para `/login` com o nome de usuário e senha.
6. Use o token de acesso retornado para autenticar as solicitações subsequentes, incluindo-o no cabeçalho `Authorization`.

## Exemplos de Requisição

### Login

POST /login
Content-Type: application/json

{
"email": "admin@gmail.com",
"password": "123456"
}

### Logout


### Logout
