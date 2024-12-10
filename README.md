# VacancyPal
VacancyPal is a web application assignment for COM621 Full Stack Development module

## Installation

Aftern unzipping the template, open a terminal in the template folder and run following command to install dependencies.

```
$ composer install
```

Then run the project by executing

```
$ php artisan serve
```
The following steps may be needed if there are any errors when trying to serve the app:

1. Install dependencies: `composer install`
2. Create `.env` file: `cp .env.example .env`
3. Generate app key: `php artisan key:generate`
4. Create the database:
   - For SQLite: `touch database/database.sqlite` // maybe not
   - Run migrations: `php artisan migrate --seed`
5. Create storage link: `php artisan storage:link`
6. Serve the app: `php artisan serve`


