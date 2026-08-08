---
name: database-design
description: Use when the user asks about database schema, migrations, models, relationships, factories, seeders, queries, or indexes for the Mading Digital Laravel app. Triggers on "database", "db", "schema", "migration", "migrasi", "model", "relationship", "relasi", "factory", "seeder", "query", "index", "tabel", "kolom".
---

# Database Design — Mading Digital

Rules and patterns for the app's data layer. SQLite in dev, SQLite/MySQL
compatible migrations via Laravel's schema builder.

## Current schema

- **users** — `name`, `email` (unique), `password`, `role` (`admin`|`siswa`),
  `email_verified_at`, `remember_token`.
- **categories** — `name`, `slug` (unique), `description`, `icon`.
- **posts** — `title`, `slug` (unique), `category_id` (FK → categories),
  `author`, `excerpt`, `body` (markdown text), `cover_path` (nullable),
  `is_published`, `is_featured`, `views`, `published_at`, timestamps.

Relationships: `Post` belongsTo `Category`; `Category` hasMany `Post`.

## Model conventions

- Guarded/`$fillable` defined on every model (mass-assignment safety).
- Query scopes for domain filters, e.g. `Post::published()` (drafts excluded
  from public pages, 404 on `/baca/{slug}`).
- Helper accessors where useful (e.g. cover URL fallback, formatted date) —
  keep them pure, no logic in views.
- Factories mirror real defaults: `UserFactory` defaults `role => 'siswa'`;
  `PostFactory` sets a valid `slug`, `category_id`, `is_published`, `views`.

## Migration & schema rules

- New columns: create a migration with `up()` and matching `down()`.
- Always index FKs and lookup columns: `category_id`, `slug`,
  `is_published` (composite with `published_at` for listings if needed),
  `users.email`.
- Use `foreignId()->constrained()->cascadeOnDelete()` for FKs unless business
  rules say otherwise (deleting a category with posts must be deliberate).
- Defaults: `is_published => false`, `views => 0` — never null where a default
  makes sense.
- Keep `str($column)->slug()` generated in app code, not in the DB.

## Seeders

- Seeders must be **idempotent**: use `updateOrCreate(['slug' => ...])` so
  re-running `db:seed` never duplicates rows (see `PostSeeder`).
- Keep seed content realistic and in Indonesian (matches the app).
- Demo admin user (`admin@mading.sch.id` / `admin123`, role `admin`) must
  always exist for manual testing.

## Query guidance

- Prefer Eloquent/query builder — no raw SQL string concatenation.
- Listings: eager-load relations (`with('category')`) to avoid N+1.
- Counters: `->count()` at the query level, not `count($collection)`.

## Definition of done

- [ ] Migration reversible (`down()` correct).
- [ ] Indexes added for FK/lookup columns.
- [ ] Model has `$fillable`/`$guarded`, relationships, and relevant scopes.
- [ ] Factory + seeder updated; seeder idempotent.
- [ ] `php artisan migrate:fresh --seed` runs clean; tests green.
