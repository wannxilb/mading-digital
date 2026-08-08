---
name: qa-testing
description: Use when the user asks to QA, test, verify, or check the Mading Digital Laravel app — writing or running PHPUnit feature/unit tests, testing auth & roles, CRUD, validation, image uploads, search, or doing manual smoke checks of pages. Triggers on "test", "QA", "verify", "check", "test", "coverage", "regression", "bug". Also triggers in Indonesian: "uji", "test", "periksa", "verifikasi", "analisis permasalahan", "cek", "bug", "error", "jalankan test", "coba".
---

# QA Testing — Mading Digital (Laravel 12 + PHPUnit)

This skill guides quality assurance for this project: an Indonesian school
"digital mading" (notice board) with a public site and an admin panel.

## Test stack (do not assume)

- **PHPUnit 11** via `php artisan test`. Pest is NOT installed — write plain
  PHPUnit class tests, not Pest `it()`/`test()` functions.
- Feature tests live in `tests/Feature`, unit tests in `tests/Unit`.
- Test classes extend `Tests\TestCase` (see `tests/TestCase.php`) and use the
  `RefreshDatabase` trait.
- Factories: `UserFactory`, `CategoryFactory`, `PostFactory` (in
  `database/factories/`). `UserFactory` defaults `role => 'siswa'`; pass
  `['role' => 'admin']` for admins.
- Code style is enforced by Laravel Pint (`./vendor/bin/pint`).

## Models & key fields

| Model    | Fields                                                               |
| -------- | -------------------------------------------------------------------- |
| User     | `name`, `email`, `password`, `role` (`admin` \| `siswa`)             |
| Category | `name`, `slug`, `description`, `icon`                                |
| Post     | `title`, `slug`, `category_id`, `author`, `excerpt`, `body` (markdown), `cover_path`, `is_published`, `is_featured`, `views`, `published_at` |

Post scopes: `published()` (draft posts return 404 on `/baca/{post}`).
Bodies render via `Str::markdown`.

## Commands

```bash
php artisan test                      # full suite
php artisan test --filter=HomeTest    # one file
php artisan test --filter=test_name   # one test
php artisan test --testsuite=Feature  # one suite
./vendor/bin/pint --test              # dry-run code style check
./vendor/bin/pint                     # fix code style
npm run build                         # rebuild assets after view changes
```

## Routes to cover

Public (guest): `GET /` (home, search via `?q=`, category filter via
`?category=`), `GET /kategori/{category}`, `GET /baca/{post}`.

Auth: `GET/POST /admin/login`, `POST /admin/logout`.

Admin (role `admin` only, middleware `EnsureUserIsAdmin` — students get 403,
guests get redirected to login):
`GET /admin` (dashboard), `GET/POST /admin/posts`, `GET/POST /admin/posts/baru`,
`GET/PUT /admin/posts/{post}/edit`, `DELETE /admin/posts/{post}`,
`GET/POST /admin/kategori`, `PUT/DELETE /admin/kategori/{category}`.

## Required test coverage

### 1. Public pages
- Home returns 200 and renders site title.
- Category page lists published posts, excludes drafts.
- Post detail returns 200 and **increments `views` by exactly 1**.
- Draft post returns 404.
- Search `?q=` filters results; category filter works; unknown category 404s.
- Unknown slug/post 404s.

### 2. Auth & roles
- Login page accessible; failed login redirects back with errors; successful
  login redirects to `/admin`.
- Admin can access dashboard and every admin route.
- **Student (`role=siswa`) gets 403 on every admin route**.
- Guest gets redirected to `/admin/login` when hitting admin routes.

### 3. CRUD (admin)
- Create post: valid data persists; missing required fields fails validation
  (`assertSessionHasErrors`).
- Update post: edits persist; `slug` regenerates from title; published status
  toggles draft visibility.
- Delete post: row gone; deleting a category that has posts is blocked (or
  handled deliberately — check the controller behavior).
- File upload: use `Storage::fake('public')`, `UploadedFile::fake()->image(...)`,
  assert the file was stored and a `cover_path` was set; on delete assert the
  cover file is removed.
- Category CRUD: unique slug/name enforced.

### 4. Edge cases & security
- Post body is escaped / markdown-rendered, not raw HTML from users.
- Pagination (12 per page) — seed >12 posts and assert page 2 works.
- Empty states (no posts, no search results) render without errors.
- `views` never go negative; duplicate slugs cannot be created.

## Manual browser smoke check

For visual/JS behavior that unit tests can't catch (scroll-reveal, marquee,
mobile menu, lightbox, Tailwind v4 styling), verify against the running app:

```bash
php artisan serve   # http://127.0.0.1:8000
```

Check with curl for status codes and key HTML, and eyeball in a browser:
- Home hero, animated counters, marquee, nav collapse on mobile.
- Admin login flow with the demo admin (`admin@mading.sch.id` / `admin123`).
- Create → edit → delete a post with an uploaded cover image.
- Search + category filter UX.

## Workflow

1. **Run** `php artisan test` first. Fix existing failures before adding new tests.
2. **Write** tests alongside any feature/bugfix using the patterns above and
   existing tests in `tests/Feature/HomeTest.php` as the style reference.
3. **Run** the suite again; all tests must pass.
4. **Run** `./vendor/bin/pint --test` and fix any style issues (or run pint).
5. **Report** results: pass/fail counts, which areas were covered.

## Definition of done

- [ ] New/changed behavior has a passing test (feature test at minimum).
- [ ] Full suite passes with no failures.
- [ ] Pint reports no style issues.
- [ ] Auth matrix verified: guest → redirect, student → 403, admin → 200.
- [ ] Image upload path tested with `Storage::fake` if post covers changed.
