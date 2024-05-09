# Bookstore API

This is an API developed in Laravel 11 using PHP 8.2. The API utilizes Laravel's Passport authentication system and SQLite database. It is also possible to run using Docker Compose on port localhost:9000.

## Features

## How to Run

1. Make sure you have Docker and Docker Compose installed on your system.
2. Clone this repository to your local machine:
	git clone https://github.com/pedro162/bookstore_api.git
3. Navigate to the project directory:
	cd bookstore_api
4. Rename the .env.example file to .env:
	cp .env.example .env
5. Install Composer dependencies:
	composer install
6. Generate the application key:
	php artisan key:generate
7. Run the migrations to set up the database:
	php artisan migrate
8. Start the Laravel server:
	php artisan serve


### Authentication

The API uses the Password Grant Type authentication. This means that users can obtain an access token by providing their username and password through the /login route. The generated token is then used to authenticate subsequent requests.

### Authentication Routes

- POST /login: Authenticates the user and generates an access token.
- POST /logout: Revokes the user's access token, logging them out.

### API Resources

### User
- GET /user/index: Returns a list of all registered users.
- POST /user/store: Creates a new user and returns the token to make requests to the API.
- PUT /user/update/{id}: Updates the details of a specific user.

#### Store

- GET /store/index: Returns a list of all registered stores.
- POST /store/store: Creates a new store.
- PUT /store/update/{id}: Updates the details of a specific store.
- GET /store/show/{id}: Returns the details of a specific store.
- DELETE /store/destroy/{id}: Deletes a specific store.
- POST /store/{store_id}/book/{book_id}: Links an existing book to an existing store.

#### Book

- GET /book/index: Returns a list of all registered books.
- POST /book/store/{store_id}: Adds a new book to a specific store.
- PUT /book/update/{id}: Updates the details of a specific book.
- GET /book/show/{id}: Returns the details of a specific book.
- DELETE /book/destroy/{id}: Deletes a specific book.

## How to Use

1. Make sure you have Docker and Docker Compose installed on your system.
2. Clone this repository to your local machine.
3. Navigate to the project directory and run the following command in the terminal: docker-compose up
4. Once the Docker container is running, the API will be available at http://localhost:9000.
5. To access protected routes that require authentication, first register a user and password by sending a POST request to /user/store with the username and password. Upon successful registration, the API will return an authorization TOKEN to include in the header of subsequent requests.
6. To access protected routes that require authentication, first login by sending a POST request to /login with the username and password.
7. Use the returned access token to authenticate subsequent requests by including it in the Authorization header.

## Request Examples

### New User

...http
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

### Create a New Store

POST /store/store
Content-Type: application/json
Authorization: Bearer {token}

{
"name": "My Bookstore",
"address": "123 Example Street",
"active": true
}

### Create a New Book in an Existing Store

POST /book/store/{store_id}
Content-Type: application/json
Authorization: Bearer {token}

{
"name": "Interesting Book",
"isbn": "978-3-16-148410-0",
"value": 29.99
}

### Create a New Book without an Existing Store

POST /book/store
Content-Type: application/json
Authorization: Bearer {token}

{
"name": "Interesting Book",
"isbn": "978-3-16-148410-0",
"value": 29.99
}

### Create a New Book without an Existing Store

POST /book/store
Content-Type: application/json
Authorization: Bearer {token}

{
"name": "Interesting Book",
"isbn": "9783161484100",
"value": 29.99
}

### Link a Book to an Existing Store

POST /store/{store_id}/book/{book_id}
Content-Type: application/json
Authorization: Bearer {token}

### List All Stores

GET /store/index
Authorization: Bearer {token}

### Show Details of a Specific Store

GET /store/show/{id}
Authorization: Bearer {token}

### Update Details of a Specific Store

PUT /store/update/{id}
Content-Type: application/json
Authorization: Bearer {token}

{
"name": "New Store Name",
"address": "New Store Address",
"active": true
}

### Delete a Specific Store

DELETE /store/destroy/{id}
Authorization: Bearer {token}

### List All Books

GET /book/index
Authorization: Bearer {token}

### Show Details of a Specific Book

GET /book/show/{id}
Authorization: Bearer {token}

### Update Details of a Specific Book

PUT /book/update/{id}
Content-Type: application/json
Authorization: Bearer {token}

{
"name": "New Book Name",
"isbn": "New Book ISBN",
"value": 39.99
}

### Delete a Specific Book

DELETE /book/destroy/{id}
Authorization: Bearer {token}"