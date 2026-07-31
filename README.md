# PSEMS - Primary School Examination Management System

A comprehensive Primary School Examination Management System built with PHP and MySQL.

## Installation

1. Clone the repository:

```bash
git clone https://github.com/Newton2050/psems.git
cd psems
```

2. Copy the example environment file and update values for your environment:

```bash
cp .env.example .env
# edit .env (database credentials, APP_KEY, mail settings, etc.)
```

3. Install PHP dependencies using Composer:

```bash
composer install --no-interaction --prefer-dist
```

4. Generate autoload files (optional) and prepare storage directories:

```bash
composer dump-autoload -o
# storage directories are created by post-install script, but ensure permissions are correct
```

5. Start the local development server (example):

```bash
php -S localhost:8080 -t public/
```

## Running tests

If tests are present, run:

```bash
./vendor/bin/phpunit --configuration phpunit.xml
```

## Notes

- Copy `.env.example` to `.env` and never commit your real `.env` to the repository.
- Use CI secrets or your deployment system to store sensitive credentials (DB password, mail credentials, etc.).
- For production, configure your webserver's document root to point to the `public/` directory instead of relying on `.htaccess` rewrites.

