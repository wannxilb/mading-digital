---
name: performance
description: Use when the user asks to make the app faster, optimize queries, reduce load time, fix slow pages, or profile performance in the Mading Digital Laravel app. Triggers on "performance", "kinerja", "lambat", "slow", "optimize", "optimasi", "cache", "n+1", "bottleneck", "loading", "beban".
---

# Performance — Mading Digital

Where performance problems actually come from in this app, in order of
likelihood: database queries → asset payload → rendering → caching.

## 1. Database / queries (biggest wins)

- **N+1**: listings must eager-load — `Post::with('category')->paginate(12)`.
  Look for relationship access inside Blade `@foreach`.
- **Counters**: `->count()`/`->sum()` in the query, never loading a full
  collection to count it.
- **Indexes**: confirm `posts.category_id`, `posts.slug`, `posts.is_published`,
  `categories.slug`, `users.email` are indexed (see migrations).
- **Pagination**: public lists are paginated (12/page); category + search
  must also paginate, not `->get()` everything.
- **Views increment**: `/baca/{post}` bumps `views`. Avoid double increment
  (controller + observer) and consider skipping the write for bots when it
  matters.
- Verify with `->toSql()`/`DB::getQueryLog()` or `php artisan debugbar` (if
  installed) rather than guessing.

## 2. Asset payload

- Tailwind v4 + Vite: production uses `npm run build` (minified, hashed).
  Don't ship the dev server build.
- Fonts: Sora + Plus Jakarta Sans load from Google Fonts with
  `display=swap`; consider `preconnect`. Keep subsetting where possible.
- Custom CSS/JS: animations in `app.css` are small; avoid shipping unused
  keyframes/classes.
- Images: cover uploads should be served at display size; use `loading="lazy"`
  below the fold.

## 3. Rendering / caching

- Avoid heavy work in Blade (format/query in controller/models, not views).
- Cache slow admin aggregations on the dashboard (`Cache::remember`) if they
  become slow; invalidate on post/category writes.
- Views are compiled by Blade automatically — run `php artisan view:cache` in
  production deploys.

## 4. Measuring

```bash
php artisan test                        # baseline
curl -s -o /dev/null -w "TTFB: %{time_starttransfer}s | code: %{http_code}\n" http://127.0.0.1:8000/
```
Use browser DevTools (Network tab) for asset size/TTFB and Lighthouse for
frontend scores. Measure before AND after a change.

## Reporting

For each finding: symptom → cause (`file:line`) → impact → fix → measured
improvement.

## Definition of done

- [ ] No N+1 or full-table loads on public/admin listings.
- [ ] Public lists paginated; counters query-level.
- [ ] Production assets built; images sized/lazy-loaded.
- [ ] Change measured before/after (time or query count).
