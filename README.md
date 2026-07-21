# Literacy AI 2

A Laravel 12 web application for literacy-related data management.

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js and npm
- PHP extensions: `gd`, `zip`
- Git
- Database driver:
  - SQLite (default), or
  - MySQL / PostgreSQL if you prefer

## Repository Setup

```bash
git clone <repository-url>
cd literacy-ai-2
```

## Local Installation

1. Install PHP dependencies:

```bash
composer install
```

2. Install Node dependencies:

```bash
npm install
```

3. Create environment file:

```bash
cp .env.example .env
```

4. Generate application key:

```bash
php artisan key:generate
```

5. Configure the database:

- For SQLite (recommended for local development):
  - Create the SQLite file:

    ```bash
    touch database/database.sqlite
    ```
  - Update `.env`:

    ```env
    DB_CONNECTION=sqlite
    DB_DATABASE=${PWD}/database/database.sqlite
    ```

- For MySQL / PostgreSQL: update `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in `.env`.

6. Run database migrations:

```bash
php artisan migrate --graceful
```

## Build Frontend Assets

```bash
npm run build
```

## Serve Locally

Start the application server:

```bash
php artisan serve
```

Then open the URL shown in your terminal, usually `http://127.0.0.1:8000`.

## Development Mode

If you want hot reload for frontend assets while working locally:

```bash
npm run dev
```

## Common Commands

- Run tests:

```bash
php artisan test
```

- Clear caches:

```bash
php artisan optimize:clear
```

- Rebuild packages and assets:

```bash
composer install
npm install
npm run build
```

## Notes

- The project is built with Laravel 12 and uses Vite for asset bundling.
- If you change `.env`, restart the server and clear configuration cache if needed:

```bash
php artisan config:clear
```

---

If you need help with a specific environment (Docker, Windows WSL, or database setup), let me know and I can add tailored instructions.
