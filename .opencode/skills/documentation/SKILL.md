---
name: documentation
description: Use when the user asks to write, update, or review documentation — README, docblocks, comments, changelog, run instructions, or explaining how parts of the Mading Digital app work. Triggers on "documentation", "dokumentasi", "readme", "doc", "docs", "jelaskan", "explain", "how to run", "cara menjalankan", "changelog", "catatan".
---

# Documentation — Mading Digital

Rules for writing and maintaining documentation for this app. The user-facing
content is Indonesian; technical docs may be Indonesian or English but stay
consistent within one document.

## Conventions

- **Code**: follow the repo rule — no unnecessary comments. Add docblocks only
  for public APIs, non-obvious logic, and intent that the code doesn't convey.
- **Blade views**: no inline comments unless clarifying a non-obvious block.
- **README** (`README.md`): project name + one-liner, features, stack, quick
  start (`composer install`, `.env`, `php artisan migrate --seed`,
  `php artisan storage:link`, `npm run build`, `php artisan serve`), demo
  admin credentials, and test commands (`php artisan test`,
  `./vendor/bin/pint`).
- **Models/controllers**: a one-line `@property`-free docblock on classes is
  enough; prefer descriptive method names over comment walls.

## What to document when asked

1. **README** — setup, run, test, deploy (if the user asks).
2. **Feature walkthrough** — what each route/page does (e.g. admin CRUD flow).
3. **Database** — schema summary + relationships (see database-design skill).
4. **Changelog** — dated, user-visible changes grouped as Added / Fixed /
   Changed, in Indonesian if the user speaks it.
5. **Explanations** — "how does X work": point to exact `file:line` and walk
   through the flow concisely.

## Style

- Concise sections, code blocks with language tags, tables for structured
  data (roles, credentials, routes).
- Keep credentials in docs clearly marked as demo-only.
- Do not invent URLs or paths — verify they exist.
- Only create `.md` files when the user explicitly asks for them.

## Definition of done

- [ ] Commands/paths/credentials verified against the actual app.
- [ ] Consistent language (no mixing mid-document unless intentional).
- [ ] Concise — no filler, no invented details.
- [ ] README up to date if the user requested it.
