---
name: code-review
description: Use when the user asks to review code, do a code review, check quality, find bugs or security issues, refactor for best practices, or audit the Mading Digital Laravel app. Triggers on "review", "code review", "audit", "kode", "review kode", "periksa kode", "tinjau", "quality", "best practice", "refactor", "improve", "bug", "security", "keamanan".
---

# Code Reviewer — Mading Digital (Laravel 12)

Use this skill whenever asked to review, audit, or assess code quality in this
project: an Indonesian school digital mading with a public site and an admin
panel. Review **in this order**: security → correctness → performance →
maintainability → style. Report findings grouped by severity.

## Project layout

- **Controllers** — `app/Http/Controllers/HomeController.php` (public site),
  `app/Http/Controllers/Admin/*` (auth + dashboard + posts + categories CRUD).
- **Middleware** — `app/Http/Middleware/EnsureUserIsAdmin.php` (role gate).
- **Models** — `app/Models/User.php` (role: `admin`|`siswa`), `Category.php`,
  `Post.php` (`is_published`, `is_featured`, `views`, `cover_path`, markdown `body`).
- **Routes** — `routes/web.php`; public (`/`, `/kategori/{category}`, `/baca/{post}`)
  and admin (`/admin/*`).
- **Views** — `resources/views` (Blade + Tailwind v4), layout in `layouts/`,
  components in `components/`, public partials in `partials/`.
- **Assets** — `resources/css/app.css` (theme tokens, animations),
  `resources/js/app.js` (reveal, marquee, counters, nav, lightbox).
- **Tests** — `tests/Feature` (PHPUnit, NOT Pest), `tests/Unit`.

## Security checklist (highest priority)

- **AuthZ**: every `/admin/*` route must go through `EnsureUserIsAdmin`; verify
  `role === 'admin'` check is on the model/route, not just hiding UI. Students
  must get 403, guests redirect to login. Check no admin action is reachable
  via `POST/PUT/DELETE` without the middleware.
- **Mass assignment**: `$fillable`/`$guarded` on all models; no unchecked user
  input flowing into `create()/update()/forceCreate()`.
- **Validation**: every store/update validates `request()->validate()`; check
  `required`, `string`, `max`, `unique` (slugs), and `image/mimes` for uploads.
- **Uploads**: `cover_path` is stored via Laravel Storage, served only through
  the `storage` disk (never direct user-controlled paths); filename must be
  randomized (`Storage::putFile` / hashed name), never user filename. Deletion
  must remove the file too.
- **XSS**: `body` rendered through `Str::markdown` (safe), any user title /
  excerpt / category name escaped with `{{ }}` — never `{!! !!}` on user input.
- **SQLi**: all queries use Eloquent/query builder (no raw string
  concatenation).
- **Secrets**: no credentials in code, config committed, or `.env` in git.
- **CSRF**: all state-changing forms include `@csrf`; logout/store/update/delete
  must be POST/PUT/DELETE, not GET.
- **Rate limiting / abuse**: login throttling (`RateLimiter`), excessive
  view-count increments handled without writes on every request where feasible.

## Correctness checklist

- Home: published posts only; drafts 404 on `/baca/{post}`; category filter and
  `?q=` search combine correctly; pagination (12/page) works on page 2.
- Post show increments `views` exactly once per request (no double-increment
  via observers + controller).
- Slug uniqueness; duplicate slugs prevented in store AND update (self-exclusion
  on unique rule).
- Deleting a category with posts: behavior is intentional and handled.
- Auth: login validates, logout invalidates session, redirects are correct.

## Performance checklist

- N+1: eager-load `category` on post listings (`with('category')`); counters use
  `count()`/`sum()` at the query level, not `->count()` on loaded collections.
- Indexes exist on `posts.category_id`, `posts.slug`, `posts.is_published`,
  `categories.slug`, `users.email`.
- No `DB::query` in loops; avoid heavy work in views (computed in controller).

## Maintainability & style

- Controllers stay thin; business rules in models/services (query scopes like
  `published()`).
- Consistent naming (routes `admin.posts.*`, controllers, views).
- Run `./vendor/bin/pint --test` — report any style failures.
- Frontend: no inline JS bloat in Blade; logic in `resources/js/app.js`;
  Tailwind classes follow existing theme tokens (navy/royal/ice, `font-display`).

## Workflow

1. **Run** `php artisan test` — a failing suite is finding #1.
2. **Scan** security checklist top-down, then correctness, performance, style.
3. **Report** findings grouped by severity (`Critical` / `High` / `Medium` /
   `Low` / `Nit`) with `file:line` references and a concrete fix for each.
4. If asked, apply fixes; then re-run tests + Pint and confirm green.

## Definition of done

- [ ] AuthZ matrix verified: guest → redirect, siswa → 403, admin → 200.
- [ ] No XSS, SQLi, mass-assignment, or upload-path issues found (or fixed).
- [ ] Every finding has a `file:line` and a suggested fix.
- [ ] `php artisan test` green and `./vendor/bin/pint --test` clean after fixes.
