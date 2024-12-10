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
If a 500 Error occurs when running the server, the .env app key may need configured.
To do this:
1. Copy `.env.example` to `.env` by running `cp .env.example .env.`
2. Run `php artisan key:generate` to set the `APP_KEY`.

