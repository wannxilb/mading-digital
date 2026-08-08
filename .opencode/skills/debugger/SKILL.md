---
name: debugger
description: Use when the user reports an error, bug, unexpected behavior, 404/403/500, or asks to fix something that doesn't work in the Mading Digital Laravel app. Triggers on "error", "bug", "404", "403", "500", "debug", "debugging", "gagal", "tidak jalan", "tidak berfungsi", "kenapa", "masalah", "fix", "perbaiki", "exception", "warning".
---

# Debugger — Mading Digital

Structured approach to diagnosing issues in this Laravel 12 app. Do NOT guess —
reproduce, isolate, and confirm the fix.

## Reproduce first

1. Reproduce the exact failing request (URL, method, form data, logged-in
   role). For pages: hit them with curl against `php artisan serve`
   (`http://127.0.0.1:8000`) and capture the status code.
2. Read the error message from `storage/logs/laravel.log` (or `php artisan
   pail` for live logs).
3. Note the environment: dev has `APP_DEBUG=true` showing the exception page.

## Common failure classes & quick checks

- **404 on /baca/{post} or /kategori/{category}** → post is a draft
  (`is_published=false` returns 404 by design), slug typo, or wrong route
  name. Check the model exists: `Post::where('slug','...')->first()`.
- **403 on /admin** → role check. User must have `role='admin'`; a `siswa`
  user gets 403 deliberately. Verify with
  `App\Models\User::where('role','admin')->count()`.
- **401/redirect loop on /admin** → session/`auth` middleware; ensure route is
  under `auth` and login route exists.
- **500 after schema change** → migration not run (`php artisan migrate`) or
  a column referenced doesn't exist. `php artisan migrate:status`.
- **Upload image broken** → `public/storage` symlink missing. Run
  `php artisan storage:link`; verify `Storage::disk('public')` path matches
  the URL.
- **Styling/JS not applied** → assets not rebuilt. Run `npm run build`
  (dev: `npm run dev`) and hard-refresh; confirm `@vite`/manifest exists.
- **Views not incrementing / wrong data** → check observers + controller both
  increment; check caching.

## Toolbox

```bash
php artisan tinker                          # REPL for models/queries
php artisan tinker --execute="App\Models\Post::count();"
php artisan pail                             # tail live logs
tail storage/logs/laravel.log
php artisan route:list                       # verify route names/middleware
php artisan config:clear                     # stale config cache
php artisan view:clear && php artisan cache:clear
```

## Reproduce with a failing test

When a bug is reported, write a failing test that reproduces it first, then
fix code until the test passes. Keep the test — it prevents regressions.

## Workflow

1. Reproduce → confirm the failing status/error.
2. Read logs + inspect the relevant controller/model/view path.
3. State root cause with `file:line` evidence.
4. Fix the smallest thing that resolves it (or ask if a design decision is
   ambiguous).
5. Run `php artisan test` + `./vendor/bin/pint --test`.

## Definition of done

- [ ] Root cause identified and explained with evidence (not "tried stuff").
- [ ] Fix applied; the originally failing request now works.
- [ ] Regression test added if it was a real bug.
- [ ] Full suite green.
