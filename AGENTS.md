# Repository Guidelines

## Project Structure & Module Organization
This Laravel 12 + Vite codebase keeps backend logic in `app/` (actions, models, Filament panels) while HTTP and API entry points live in `routes/web.php` and `routes/api.php`. Blade templates and frontend assets live under `resources/views` and `resources/js`, compiled by Vite into `public/build`. Database contracts stay in `database/migrations`, with reusable fixtures under `database/factories` and `database/seeders`. Feature and unit tests live in `tests/Feature` and `tests/Unit`, while generated files live in `storage/` (keep it writable and untracked).

## Build, Test, and Development Commands
Install dependencies with `composer install` and `npm install`, then copy `.env.example` to `.env` and run `php artisan key:generate`. Apply schema updates with `php artisan migrate --seed`. Daily workflows:
- `composer run dev` — spins up the PHP dev server, queue listener, log tail, and Vite watcher in one pane.
- `npm run dev` — rebuilds JS/CSS only when you already have a PHP server elsewhere.
- `npm run build` — produces versioned production assets in `public/build`.
- `php artisan serve` + `php artisan queue:listen` — use when you need to control workers separately (e.g., debugging queue jobs).

## Coding Style & Naming Conventions
Follow PSR-12 and Laravel defaults: 4-space indentation, StudlyCase PHP classes stored via PSR-4 paths, snake_case columns in migrations, and kebab-case Blade component files. Run `./vendor/bin/pint` for PHP formatting and `./vendor/bin/duster fmt` before commits to catch Pint + ESLint/Tailwind lint. Keep Blade partials under `resources/views/{feature}` directories such as `projects/board.blade.php`.

## Testing Guidelines
`php artisan test` (aliased as `composer test`) runs PHPUnit 11 with Collision output. Group specs by behavior: HTTP and Filament flows go in `tests/Feature`, while service classes in `app/Actions` or helpers belong in `tests/Unit`. Name files `<Scenario>Test.php`, leverage factories plus the `RefreshDatabase` trait, and assert localized strings with `__()` helpers. New endpoints or migrations should land with at least one happy-path test and one guard-rail (validation/error) test before requesting review.

## Commit & Pull Request Guidelines
History shows Conventional Commits (`feat: ...`, `fix: ...`), so stick with lowercase types and imperative subjects (`feat: add worker progress tracking`). Each PR should include a concise summary, linked issue or ticket, screenshots/screencasts for UI changes (desktop + mobile for Filament when applicable), and a testing checklist referencing the commands above. Call out breaking migrations or queue changes in bold in the PR body, and document rollback steps whenever schema changes or seeds might affect reviewers.

last use curr section  