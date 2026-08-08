---
name: api-design
description: Use when the user asks to design, add, or review an API — JSON endpoints, controllers, validation, responses, or API testing — for the Mading Digital Laravel app. Triggers on "api", "endpoint", "json", "rest", "restful", "resource", "response", "postman".
---

# API Design — Mading Digital

This app is **server-rendered Blade, with no API layer today**. Use this
skill when the user wants to introduce one, or to review any JSON endpoints
that get added.

## Default stance

- Before adding an API, confirm it's needed: does the admin panel or public
  site actually require client-side data fetching? If it's only serving the
  Blade UI, keep rendering server-side.
- If an API IS required, follow the patterns below and keep it minimal.

## If adding API endpoints

- **Routing**: version them — `/api/v1/...` in `routes/api.php` (Laravel 12:
  ensure the file is registered in `bootstrap/app.php`). Use `api` middleware
  group.
- **Controllers**: dedicated controllers under `app/Http/Controllers/Api/`,
  returning JSON via `response()->json()` or `->toArray()` / `->resolve()`
  through Form Resources (`php artisan make:resource`).
- **Auth**: use Sanctum tokens for authenticated endpoints; public endpoints
  (published posts, categories) need none. Reuse `Post::published()` scoping —
  never expose drafts.
- **Validation**: `FormRequest` classes or inline `validate()`; return
  `422` with errors.
- **Responses**: consistent envelope only if useful — plain data otherwise.
  Use HTTP verbs + status codes correctly (200/201/204/404/422/403).
- **Rate limiting**: add `throttle` on write endpoints.
- **Tests**: feature tests with `assertJson` covering happy path, 404 for
  drafts/unknown ids, and role gating on admin endpoints.

## Example resource contract

```json
{
  "id": 3,
  "title": "Selamat! Tim Robotik Raih Juara 2",
  "slug": "tim-robotik-juara-2-provinsi",
  "category": { "name": "Prestasi", "slug": "prestasi" },
  "author": "Redaksi Mading",
  "excerpt": "...",
  "published_at": "2026-08-03T00:00:00+07:00",
  "views": 128
}
```

## Definition of done

- [ ] API justified (not duplicating Blade rendering).
- [ ] Drafts and non-public data never exposed.
- [ ] Auth (Sanctum) + validation + throttling in place on protected routes.
- [ ] Feature tests assert JSON shape, status codes, and auth failures.
