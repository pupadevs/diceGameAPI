 <h1 align="center"><b>Dice Game API - Laravel</b></h1>
<p align="center"><img src="https://svgsilh.com/svg/152068-e91e63.svg" width="300" alt="dados"></a></p>

<p align="center">
<a href="https://github.com/elpupas"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


# English

## API Endpoints

### Authentication

#### Player Registration

- **Endpoint**: `POST /players`
- **Description**: Creates a new player.
- **Parameters**:
  - `name` (Optional): Player's name (if not provided, it will be assigned as "Anonymous").
  - `email` (Required): Player's email address.
  - `password` (Required): Player's password (minimum 8 characters).
- **Successful Response**:
  - Status Code: 201 (Created)
  - Content: `{ "message": "Player registered successfully" }`
- **Error Response**:
  - Status Code: 422 (Unprocessable Entity)
  - Content: `{ "message": { "email": ["The email field is required."] } }`

#### Login

- **Endpoint**: `POST /login`
- **Description**: Logs in with player's credentials.
- **Parameters**:
  - `email` (Required): Registered player's email.
  - `password` (Required): Player's password.
- **Successful Response**:
  - Status Code: 200 (Success)
  - Content: `{ "message": "Login successful", "auth_token": "authentication_token" }`
- **Error Response**:
  - Status Code: 401 (Unauthorized)
  - Content: `{ "message": "Invalid credentials" }`

#### Logout

- **Endpoint**: `POST /logout`
- **Description**: Logs out the authenticated player.
- **Parameters**:
  - `token` authentication token
- **Successful Response**:
  - Status Code: 200 (Success)
  - Content: `{ "message": "Logged out successfully" }`

### Players

#### Update Player's Name

- **Endpoint**: `PUT /players/{id}`
- **Description**: Modifies the player's name.
- **Parameters**:
  - `name` (Required): New player's name.
  - `token` authentication token
- **Successful Response**:
  - Status Code: 200 (Success)
  - Content: `{ "message": "Player's name updated successfully" }`

### Games

#### Record Dice Roll

- **Endpoint**: `POST /players/{id}/games`
- **Description**: A specific player rolls the dice.
- **Parameters**:
  - `token` authentication token
- **Successful Response**:
  - Status Code: 201 (Created)
  - Content: `{ "message": "Dice roll registered successfully" }`

#### List All Games by a Player

- **Endpoint**: `GET /players/{id}/games`
- **Description**: Returns the list of dice rolls by a player.
- **Parameters**:
  - `token` authentication token
- **Successful Response**:
  - Status Code: 200 (Success)
  - Content: `{ "games": [ { "id": 1, "dice1": 4, "dice2": 3, "win": true }, ... ] }`

#### Delete All Games of a Player

- **Endpoint**: `DELETE /players/{id}/games`
- **Description**: Deletes all dice rolls of the player.
- **Parameters**:
  `token` authentication token
- **Successful Response**:
  - Status Code: 200 (Success)
  - Content: `{ "message": "All dice rolls deleted successfully" }`

### Admin Routes (Restricted Access)

#### List All Players with Average Success Rate

- **Endpoint**: `GET /players`
- **Description**: Returns the list of all players in the system with their average success rate.
- **Parameters**:
  - (None)
- **Successful Response**:
  - Status Code: 200 (Success)
  - Content: `{ "players": [ { "id": 1, "name": "Player 1", "email": "player1@example.com", "success_rate": 70.5 }, ... ] }`

#### Best Player by Success Rate

- **Endpoint**: `GET /players/ranking/winner`
- **Description**: Returns the player with the highest success rate.
- **Parameters**:
  - (None)
- **Successful Response**:
  - Status Code: 200 (Success)
  - Content: `{ "winner": { "id": 1, "name": "Top Player", "rank, "success_rate": 80.2 } }`

#### Worst Player by Success Rate

- **Endpoint**: `GET /players/ranking/loser`
- **Description**: Returns the player with the lowest success rate.
- **Parameters**:
  - (None)
- **Successful Response**:
  - Status Code: 200 (Success)

- **Endpoint**: `GET /players/ranking/`
- **Description**: Returns the success rate of all played games.
- **Parameters**:
  - (None)
- **Successful Response**:
  - Status Code: 200 (Success)

## Installation Instructions

### Clone the repository to your local machine

- git clone https://github.com/elpupas/diceGameAPI.git

### Install PHP dependencies using Composer
- composer install

### Install Laravel Passport
- composer require laravel/passport

### Publish the migrations and Passport configuration files
- php artisan passport:install

### Copy the environment file
- cp .env.example .env

### Generate a new application key
- php artisan key:generate

### Configure your database in the .env file Run the migrations and seeders 
- php artisan migrate --seed

### Start the server
- php artisan serve


# Español
## Dice Game API - Laravel

 Esta API permite a los jugadores registrar tiradas de dados y calcular su tasa de éxito. 
También incluye autenticación a través de Laravel Passport y gestión de roles con Spatie Permission.

## Rutas de la API

### Autenticación

#### Registro de Jugador

- **Endpoint**: `POST /players`
- **Descripción**: Crea un nuevo jugador/a.
- **Parámetros**:
  - `name` (Opcional): Nombre del jugador (si no se proporciona, se asigna como "Anónimo").
  - `email` (Obligatorio): Correo electrónico del jugador.
  - `password` (Obligatorio): Contraseña del jugador (mínimo 8 caracteres).
- **Respuesta Exitosa**:
  - Código de Estado: 201 (Creado)
  - Contenido: `{ "message": "Jugador/a registrado/a exitosamente" }`
- **Respuesta de Error**:
  - Código de Estado: 422 (Entidad no procesable)
  - Contenido: `{ "message": { "email": ["El campo de correo electrónico es obligatorio."] } }`

#### Inicio de Sesión

- **Endpoint**: `POST /login`
- **Descripción**: Inicia sesión con las credenciales del jugador.
- **Parámetros**:
  - `email` (Obligatorio): Correo electrónico del jugador registrado.
  - `password` (Obligatorio): Contraseña del jugador.
- **Respuesta Exitosa**:
  - Código de Estado: 200 (Éxito)
  - Contenido: `{ "message": "Inicio de sesión exitoso", "auth_token": "token_de_autenticacion" }`
- **Respuesta de Error**:
  - Código de Estado: 401 (No autorizado)
  - Contenido: `{ "message": "Credenciales inválidas" }`

#### Cierre de Sesión

- **Endpoint**: `POST /logout`
- **Descripción**: Cierra la sesión del jugador autenticado.
- **Parámetros**:
  - `token` token de autenticacion
- **Respuesta Exitosa**:
  - Código de Estado: 200 (Éxito)
  - Contenido: `{ "message": "Sesión cerrada exitosamente" }`


### Jugadores

#### Modificación del Nombre del Jugador

- **Endpoint**: `PUT /players/{id}`
- **Descripción**: Modifica el nombre del jugador/a.
- **Parámetros**:
  - `name` (Obligatorio): Nuevo nombre del jugador.
  - `token` token de autenticacion
- **Respuesta Exitosa**:
  - Código de Estado: 200 (Éxito)
  - Contenido: `{ "message": "Nombre del jugador actualizado exitosamente" }`


### Partidas

#### Registro de Tirada de Dados

- **Endpoint**: `POST /players/{id}/games`
- **Descripción**: Un jugador/a específico realiza un tirón de los dados.
- **Parámetros**:
  - `token` token de autenticacion
- **Respuesta Exitosa**:
  - Código de Estado: 201 (Creado)
  - Contenido: `{ "message": "Tirada de dados registrada exitosamente" }`

#### Listado de Partidas de un Jugador

- **Endpoint**: `GET /players/{id}/games`
- **Descripción**: Devuelve el listado de tiradas de dados por un jugador/a.
- **Parámetros**:
  - `token` token de autenticacion
- **Respuesta Exitosa**:
  - Código de Estado: 200 (Éxito)
  - Contenido: `{ "games": [ { "id": 1, "dice1": 4, "dice2": 3, "win": true }, ... ] }`

#### Eliminación de Todas las Partidas de un Jugador

- **Endpoint**: `DELETE /players/{id}/games`
- **Descripción**: Elimina todas las tiradas de dados del jugador/a.
- **Parámetros**:
  `token` token de autenticacion
- **Respuesta Exitosa**:
  - Código de Estado: 200 (Éxito)
  - Contenido: `{ "message": "Todas las tiradas de dados eliminadas exitosamente" }`
  - 
### Rutas de Administrador (Acceso Restringido)

#### Listado de Todos los Jugadores con Porcentaje de Éxito Medio

- **Endpoint**: `GET /players`
- **Descripción**: Devuelve el listado de todos los jugadores/as del sistema con su porcentaje medio de éxitos.
- **Parámetros**:
  - (Ninguno)
- **Respuesta Exitosa**:
  - Código de Estado: 200 (Éxito)
  - Contenido: `{ "players": [ { "id": 1, "name": "Jugador 1", "email": "jugador1@example.com", "success_rate": 70.5 }, ... ] }`

#### Ranking de Jugadores con Mejor Porcentaje de Éxito

- **Endpoint**: `GET /players/ranking/winner`
- **Descripción**: Devuelve al jugador/a con mejor porcentaje de éxito.
- **Parámetros**:
  - (Ninguno)
- **Respuesta Exitosa**:
  - Código de Estado: 200 (Éxito)
  - Contenido: `{ "winner": { "id": 1, "name": "Mejor Jugador", "rank, "success_rate": 80.2 } }`

#### Ranking de Jugadores con Peor Porcentaje de Éxito

- **Endpoint**: `GET /players/ranking/loser`
- **Descripción**: Devuelve al jugador/a con peor porcentaje de éxito.
- **Parámetros**:
  - (Ninguno)
- **Respuesta Exitosa**:
  - Código de Estado: 200 (Éxito)
  - Contenido: `{ "loser": { "id": 2, "name": "Peor Jugador", "email": "peorjugador@example.com", "success_rate": 40.1 } }`

- **Endpoint**: `GET /players/ranking/`
- **Descripción**: Devuelve el porcentaje de exito de todos los juegos jugados.
- **Parámetros**:
  - (Ninguno)
- **Respuesta Exitosa**:
  - Código de Estado: 200 (Éxito)


## Instrucciones de Instalación

# Clona el repositorio en tu máquina local

```bash
git clone https://github.com/elpupas/diceGameAPI.git

# Instala las dependencias de PHP utilizando Composer
composer install

# Instala Laravel Passport
composer require laravel/passport

# Publica las migraciones y los archivos de configuración de Passport
php artisan passport:install
# Copia el archivo de entorno
cp .env.example .env

# Genera una nueva clave de aplicación
php artisan key:generate

# Configura tu base de datos en el archivo .env

# Ejecuta las migraciones y los seeders
php artisan migrate --seed

# Inicia el servidor
php artisan serve
