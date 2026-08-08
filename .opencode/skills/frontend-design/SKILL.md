---
name: frontend-design
description: Use when the user asks to build, improve, or fix the UI/UX — Blade views, Tailwind v4 styling, layout, responsiveness, animations, components, accessibility, or visual design of the Mading Digital app. Triggers on "design", "UI", "UX", "frontend", "layout", "responsive", "animasi", "desain", "tampilan", "halaman", "komponen", "style", "warna", "dark mode".
---

# Frontend Design — Mading Digital

Guide for designing and maintaining the frontend: a school digital mading with
a public "journey" theme (blue & white) and an admin panel.

## Stack

- **Blade** templates in `resources/views` (layouts, partials, components).
- **Tailwind CSS v4** via Vite (`npm run dev` / `npm run build`). Theme lives
  in `resources/css/app.css` `@theme` block + custom utilities/animations.
- **Vanilla JS** in `resources/js/app.js` (no framework).
- Google Fonts: **Sora** (display) + **Plus Jakarta Sans** (body) — the project
  already uses a `font-display` utility.

## Design language (keep consistent)

- Palette: navy (`navy-*`), royal blue (`royal-*`), ice/white (`ice-*`) —
  use the existing tokens, do not invent new hex colors ad hoc.
- Concept: "School Journey" — hero uses a winding SVG route path with stop
  markers; content sections are journey stops; cards feel like route signs.
- Personality: friendly, clean, glassmorphism navbar, soft shadows
  (`shadow-glow`), rounded corners, generous whitespace.
- Icons: use the `<x-icon name="..."/>` component (lucide-style strokes) —
  never inline raw SVGs when an icon name already exists.

## Conventions

- Reuse components (`components/icon.blade.php`, nav partial) and layouts
  (`layouts/app.blade.php`, `layouts/admin.blade.php`) instead of duplicating
  markup.
- Add custom utilities/animations in `resources/css/app.css` under the
  existing pattern (`.reveal`, `.animate-marquee`, etc.). Tailwind v4 picks up
  classes from Blade files automatically.
- After changing Blade/JS/CSS, run `npm run build` and verify the page.
- Accessibility: keep skip-link, focus styles, `aria-*`, and respect
  `prefers-reduced-motion` (already set up).

## Common tasks

- **New page/section**: check existing patterns first (home sections, post
  cards), copy the journey-stop structure, stay responsive (mobile-first).
- **Responsive**: test breakpoints `sm/md/lg/xl`; admin sidebar is a drawer on
  mobile, sticky on `lg+`.
- **Animations**: use existing keyframes (`marquee`, `float`, `reveal`,
  counters) instead of writing new ones unless needed.
- **Markdown content**: rendered by `Str::markdown` server-side — style with
  prose utilities or custom `article` CSS, never `{!! !!}` unescaped.

## Definition of done

- [ ] Matches the existing design language (tokens, fonts, journey theme).
- [ ] Reuses components/layouts; no duplicated markup.
- [ ] Responsive on mobile and desktop.
- [ ] `npm run build` succeeds; page renders 200 with new styles.
- [ ] Accessible (keyboard, contrast, reduced-motion respected).
