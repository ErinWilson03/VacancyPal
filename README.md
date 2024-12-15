# VacancyPal
VacancyPal is a web application assignment for COM621 Full Stack Development module

## Quick Start

### 1. Unzip the Repository

Unzip the submission folder, then open a terminal.


### 2. Set Up the Environment Variables

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Open the `.env` file and configure database connection settings:

```ini
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```

### 3. Install PHP Dependencies

Run the following command to install the required PHP packages:

```bash
composer install
```

### 4. Install JavaScript Dependencies

Run the following command to install the required JavaScript packages:

```bash
npm install
```

### 5. Set Up the Database

Run the migrations to create the required database tables:

```bash
php artisan migrate
```

Seed the database:

```bash
php artisan db:seed
```

### 6. Run the Laravel Server

In a terminal window, run:

```bash
php artisan serve
```

This will start the backend server at `http://127.0.0.1:8000`.

### 7. Run the Vite Server

Open a second terminal window and run:

```bash
npm run dev
```

This will start the Vite frontend server to automatically inject frontend assets into the Laravel app.

Open http://127.0.0.1:8000 in your browser to view the app.


### Summary
To see the app running:

1. Clone the repository.
2. Install dependencies with composer install and npm install.
3. Set up the .env file for database configuration.
4. Run the Laravel server with php artisan serve.
5. Run the Vite server with npm run dev.
6. Access the app at http://127.0.0.1:8000.
