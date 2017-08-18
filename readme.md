## REST

### Requirements
- php >= 5.6.4
- composer

### Develop

Install dependencies:
```bash
composer install
```

Copy `.env.example` to `.env`

Generate `APP_KEY`:
```bash
php artisan key:generate
```

Create a database.

Set `DB_*` variables in `.env`:
```bash
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

Migrate:
```bash
php artisan migrate
```
