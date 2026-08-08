---
name: security-audit
description: Use when the user asks to audit security, find vulnerabilities, harden the app, or review auth, uploads, input handling, or data protection in the Mading Digital Laravel app. Triggers on "security", "keamanan", "audit", "vulnerability", "kerentanan", "hack", "peretasan", "owasp", "harden", "csrf", "xss", "sql injection", "upload".
---

# Security Audit — Mading Digital

Focused, defense-in-depth review for this Laravel 12 school app. Audit in this
order of impact: AuthN/AuthZ → Input handling → Uploads → Data exposure →
Hardening. Report findings with severity + `file:line` + a concrete fix.

## 1. Authentication & Authorization (AuthN/AuthZ)

- All `/admin/*` routes behind `auth` + `EnsureUserIsAdmin` middleware
  (role `admin`). Students 403, guests redirect to login. **Never rely on
  hiding UI links as the gate.**
- Admin credentials never committed; demo seed password acceptable but flag
  it for production.
- Login protected against brute force — `RateLimiter`/`throttle` on the
  login POST; generic error message (no "user not found").
- Logout invalidates the session (`$request->session()->invalidate()` +
  `regenerateToken()`); no GET logout.

## 2. Input handling

- **XSS**: all user-controlled data escaped in Blade with `{{ }}`. Post
  `body` renders via `Str::markdown` — verify it strips raw HTML/script
  (markdown safe), and that title/excerpt/category name never use `{!! !!}`.
- **SQL injection**: no raw query string concatenation anywhere; Eloquent/query
  builder only.
- **Mass assignment**: `$fillable`/`$guarded` set on `User`, `Category`, `Post`
  — `role` and `is_published`/`is_featured` must NOT be user-overridable on
  create (a student-supplied `role=admin` payload would be a critical flaw).
- **Validation**: all store/update validate `request()->validate()` —
  `required`, `max`, `unique` on slug/name/email, `image` + mime/size for
  covers.

## 3. File uploads

- `cover_path` randomized on store (`Storage::putFile`/hashed names) — never
  the client filename.
- Served only via `public/storage` symlink; extension/type validated; no
  executable file types.
- Deleting a post also deletes its cover file.

## 4. Data exposure

- Draft posts never reachable publicly (404), not even by guessed slug.
- Admin pages show no sensitive data (emails/roles) beyond what's needed.
- No secrets in `.env` committed; `.env` git-ignored.
- Search endpoint doesn't leak anything or allow heavy query abuse (cap
  length).

## 5. Hardening / platform

- `APP_DEBUG=false` in production; `APP_KEY` set.
- HTTPS in production; `Secure` cookie / `http_only` (Laravel defaults on).
- `TrustProxies` correct if behind a proxy.
- Headers: consider `X-Frame-Options`/CSP for admin pages.

## Reporting format

```
[Critical] <issue>  → file:line
[High]     <issue>  → file:line
[Medium]   <issue>  → file:line
[Low]      <issue>  → file:line
Fix suggestion per finding.
```

## Definition of done

- [ ] AuthZ matrix verified (guest→redirect, siswa→403, admin→200) with tests.
- [ ] Mass assignment on `role`/publish flags checked.
- [ ] XSS/SQLi/upload path audited end-to-end.
- [ ] Findings reported with severity + fix; if fixing, suite + Pint green.
