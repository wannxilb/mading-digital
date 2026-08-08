---
name: architecture
description: Use when the user asks about system/application structure, adding a new feature or module, refactoring the codebase organization, choosing where code should live, or explaining how the Mading Digital Laravel app is put together. Triggers on "architecture", "struktur", "modul", "feature", "fitur", "refactor", "arsitektur", "organisasi kode", "mvc", "layering", "design".
---

# Architecture — Mading Digital

Map of the app's structure and the rules for extending it. This is a Laravel
12 app: server-rendered Blade + a small amount of Vanilla JS, SQLite in dev,
no API layer.

## Layers & where things live

| Concern              | Location                                             |
| -------------------- | ---------------------------------------------------- |
| HTTP entry           | `routes/web.php`                                     |
| Controllers (public) | `app/Http/Controllers/HomeController.php`             |
| Controllers (admin)  | `app/Http/Controllers/Admin/*` (Auth, Dashboard, Post, Category) |
| AuthZ gate           | `app/Http/Middleware/EnsureUserIsAdmin.php`           |
| Models               | `app/Models/{User,Category,Post}.php`                 |
| Validation           | inline `request()->validate()` in controllers         |
| Views                | `resources/views/{layouts,partials,components,home,posts,...}` |
| Styles/JS            | `resources/css/app.css`, `resources/js/app.js`        |
| DB schema            | `database/migrations`, seeders in `database/seeders`  |
| Tests                | `tests/Feature` (PHPUnit), `tests/Unit`               |
| Assets build         | Vite (`vite.config.js`, `npm run build`)              |

## Core rules

- **Routes stay thin**; controllers orchestrate, models carry behavior (query
  scopes like `Post::published()`, relationships, slug handling).
- **Keep controllers slim**: move reusable query logic into model scopes or
  (for real complexity) small service/action classes under `app/`.
- **Feature flow** for new functionality:
  1. Migration + model (+ factory + seeder).
  2. Routes in `web.php` — public under `/`, admin under `/admin/*` with
     `EnsureUserIsAdmin` middleware.
  3. Controller methods (index/store/show/edit/update/destroy pattern).
  4. Blade views using existing layouts/components.
  5. Tests in `tests/Feature`.
- **AuthZ**: never gate admin UI by hiding links alone — always enforce in
  routes via middleware. Students must get 403, guests redirect to login.
- **Naming**: follow existing conventions — `admin.posts.store` style route
  names, `Admin\PostController`, kebab-case slugs, `*Controller@method`.

## Decision guide

- New admin CRUD → mirror `PostController` + `resources/views/posts/*`.
- New public section → add to `HomeController` + home layout sections.
- Shared UI → component in `resources/views/components/`.
- Complex domain logic → model scope or `app/Services/*` class, unit-test it.
- Ask before adding an API, queue, or package — the app is intentionally
  simple and server-rendered.

## Definition of done

- [ ] New code follows the layering above (no logic dumped in routes/views).
- [ ] Admin routes protected; public routes stay open.
- [ ] Tests added for new behavior; full suite green.
- [ ] No unnecessary packages or architectural complexity added.
