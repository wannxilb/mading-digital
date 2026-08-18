import './bootstrap';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

/* ── Page load fade-in ──────────────────────────────────── */
if (!reduceMotion) {
    gsap.from('main', { autoAlpha: 0, duration: 0.4, ease: 'power2.out' });
}

const nav = document.getElementById('site-nav');
const mobileMenu = document.getElementById('mobile-menu');
const navToggle = document.getElementById('nav-toggle');
const iconOpen = document.getElementById('icon-open');
const iconClose = document.getElementById('icon-close');

const setNavState = () => {
    if (!nav) return;
    const inner = nav.querySelector('div.mx-auto > div');
    const mobileMenu = document.getElementById('mobile-menu');
    if (!inner) return;

    const scrolled = window.scrollY > 16;

    if (scrolled) {
        inner.classList.add('mt-3', 'mx-3', 'sm:mx-4', 'rounded-brutal', 'overflow-hidden', 'border-2', 'border-ink', 'shadow-soft', 'bg-cream/95', 'backdrop-blur-xl');
        inner.classList.remove('mt-0', 'bg-transparent');
        if (mobileMenu) {
            mobileMenu.classList.remove('rounded-brutal', 'border-2', 'border-ink', 'bg-cream', 'shadow-brutal-sm');
            mobileMenu.classList.add('border-0', 'bg-transparent', 'shadow-none');
        }
    } else {
        inner.classList.remove('mt-3', 'mx-3', 'sm:mx-4', 'rounded-brutal', 'overflow-hidden', 'border-2', 'border-ink', 'shadow-soft', 'bg-cream/95', 'backdrop-blur-xl');
        inner.classList.add('mt-0', 'bg-transparent');
        if (mobileMenu) {
            mobileMenu.classList.add('rounded-brutal', 'border-2', 'border-ink', 'bg-cream', 'shadow-brutal-sm');
            mobileMenu.classList.remove('border-0', 'bg-transparent', 'shadow-none');
        }
    }
};

window.addEventListener('scroll', setNavState, { passive: true });
setNavState();

if (navToggle && mobileMenu) {
    navToggle.addEventListener('click', () => {
        const isHidden = mobileMenu.classList.contains('hidden');
        mobileMenu.classList.toggle('hidden', !isHidden);
        iconOpen?.classList.toggle('hidden', isHidden);
        iconClose?.classList.toggle('hidden', !isHidden);
        navToggle.setAttribute('aria-expanded', String(isHidden));
    });
}

const adminNavToggle = document.getElementById('admin-nav-toggle');
const adminSidebar = document.getElementById('admin-sidebar');
if (adminNavToggle && adminSidebar) {
    adminNavToggle.addEventListener('click', () => {
        adminSidebar.classList.toggle('-translate-x-full');
    });
}

const toast = document.getElementById('toast');
if (toast) {
    setTimeout(() => {
        toast.style.transition = 'opacity .6s, transform .6s';
        toast.style.opacity = '0';
        toast.style.transform = 'translate(-50%, 12px)';
        setTimeout(() => toast.remove(), 700);
    }, 3200);
}

document.querySelectorAll('a[href^="#"]').forEach((link) => {
    link.addEventListener('click', (event) => {
        const targetId = link.getAttribute('href');
        if (targetId.length < 2) return;
        const target = document.querySelector(targetId);
        if (!target) return;
        event.preventDefault();
        target.scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth', block: 'start' });
    });
});

document.querySelectorAll('.prose-wrap img').forEach((img) => {
    img.classList.add('cursor-zoom-in', 'rounded-brutal', 'border-2', 'border-ink', 'my-8');
    img.addEventListener('click', () => {
        const overlay = document.createElement('div');
        overlay.className =
            'fixed inset-0 z-50 flex items-center justify-center bg-ink/95 backdrop-blur-sm p-4 animate-[rise_0.55s_cubic-bezier(0.22,1,0.36,1)_both]';
        overlay.innerHTML = `
            <button class="absolute right-4 top-4 grid place-items-center size-11 rounded-brutal border-2 border-cream bg-transparent text-cream hover:bg-accent hover:text-cream transition-colors" aria-label="Tutup">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 6l12 12M18 6L6 18"/></svg>
            </button>
            <img src="${img.currentSrc || img.src}" alt="${img.alt || ''}" class="max-h-[88vh] max-w-full rounded-brutal border-2 border-cream object-contain">
        `;
        const close = () => overlay.remove();
        overlay.querySelector('button').addEventListener('click', close);
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) close();
        });
        document.addEventListener('keydown', function handler(e) {
            if (e.key === 'Escape') {
                close();
                document.removeEventListener('keydown', handler);
            }
        });
        document.body.appendChild(overlay);
    });
});

/* ── Hero + scroll animations (GSAP) ─────────────────────── */
function splitToWords(el) {
    const walker = document.createTreeWalker(el, NodeFilter.SHOW_TEXT);
    const nodes = [];
    while (walker.nextNode()) nodes.push(walker.currentNode);

    nodes.forEach((node) => {
        const raw = node.textContent;
        if (!raw.trim()) return;
        const parts = raw.split(/(\s+)/);
        if (parts.length <= 1) return;

        const frag = document.createDocumentFragment();
        parts.forEach((part) => {
            if (/^\s+$/.test(part)) {
                frag.appendChild(document.createTextNode(part));
            } else {
                const outer = document.createElement('span');
                outer.style.cssText = 'display:inline-block;overflow:hidden;vertical-align:top;padding-bottom:0.25em;margin-bottom:-0.25em;padding-right:0.15em;margin-right:-0.15em;';
                const inner = document.createElement('span');
                inner.style.cssText = 'display:inline-block;';
                inner.textContent = part;
                outer.appendChild(inner);
                frag.appendChild(outer);
            }
        });
        node.parentNode.replaceChild(frag, node);
    });

    return el.querySelectorAll('span[style] > span');
}

const heroTitle = document.querySelector('[data-hero="title"]');
const heroKicker = document.querySelector('[data-hero="kicker"]');
const heroDesc = document.querySelector('[data-hero="desc"]');
const heroSearch = document.querySelector('[data-hero="search"]');
const heroStats = document.querySelector('[data-hero="stats"]');
const heroFeatured = document.querySelector('[data-hero="featured"]');

if (heroTitle && !reduceMotion) {
    const wordEls = splitToWords(heroTitle);
    const titleInner = heroTitle;
    titleInner.style.clipPath = 'inset(0 0 100% 0)';
    titleInner.style.willChange = 'clip-path';

    gsap.set(wordEls, { yPercent: 100 });
    gsap.set(heroKicker, { autoAlpha: 0, y: 14, rotationX: -8 });
    gsap.set(heroDesc, { autoAlpha: 0, y: 18 });
    gsap.set(heroSearch, { autoAlpha: 0, y: 20, scale: 0.98 });
    gsap.set(heroStats, { autoAlpha: 0, y: 14 });
    gsap.set(heroFeatured, { autoAlpha: 0, x: 50, scale: 0.95, rotationY: -4 });

    const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });

    tl.to(heroKicker, { autoAlpha: 1, y: 0, rotationX: 0, duration: 0.5, ease: 'back.out(1.4)' })
      .to(titleInner, { clipPath: 'inset(0 0 0% 0)', duration: 0.8, ease: 'power4.out' }, '-=0.2')
      .to(wordEls, { yPercent: 0, duration: 0.55, stagger: 0.04, ease: 'power3.out' }, '-=0.6')
      .to(heroDesc, { autoAlpha: 1, y: 0, duration: 0.55 }, '-=0.25')
      .to(heroSearch, { autoAlpha: 1, y: 0, scale: 1, duration: 0.55, ease: 'back.out(1.2)' }, '-=0.3')
      .to(heroStats, { autoAlpha: 1, y: 0, duration: 0.5 }, '-=0.3')
      .to(heroFeatured, { autoAlpha: 1, x: 0, scale: 1, rotationY: 0, duration: 0.9, ease: 'power2.out' }, '-=0.45');

    document.querySelectorAll('[data-count]').forEach((el) => {
        const target = parseInt(el.dataset.count, 10);
        const obj = { val: 0 };
        tl.add(
            gsap.to(obj, {
                val: target,
                duration: 1.1,
                ease: 'power2.out',
                onUpdate: () => {
                    el.textContent = Math.round(obj.val).toLocaleString('id-ID');
                },
            },
            0.6
        ), 0);
    });

    tl.call(() => { titleInner.style.clipPath = 'none'; }, null, '+=0.1');

    /* ── Hero parallax on scroll ── */
    const heroSection = document.querySelector('section.border-b-2');
    if (heroSection) {
        gsap.to(heroFeatured, {
            y: -30,
            ease: 'none',
            scrollTrigger: {
                trigger: heroSection,
                start: 'top top',
                end: 'bottom top',
                scrub: 1.5,
            },
        });
    }

} else if (heroTitle) {
    gsap.set([heroKicker, heroTitle, heroDesc, heroSearch, heroStats, heroFeatured], { autoAlpha: 1 });
    document.querySelectorAll('[data-count]').forEach((el) => {
        el.textContent = parseInt(el.dataset.count, 10).toLocaleString('id-ID');
    });
}

/* ── Scroll-triggered section reveals ────────────────────── */
const sections = document.querySelectorAll('[data-section]');
if (sections.length && !reduceMotion) {
    sections.forEach((section) => {
        const cards = section.querySelectorAll('.card, article');
        const chips = section.querySelectorAll('.chip');
        const items = section.querySelectorAll('.space-y-3 > div, .space-y-2 > div');

        if (cards.length) gsap.set(cards, { autoAlpha: 0, y: 30, scale: 0.97 });
        if (items.length && !cards.length) gsap.set(items, { autoAlpha: 0, y: 16 });
        if (chips.length) gsap.set(chips, { autoAlpha: 0, y: 12, scale: 0.9 });
    });

    const secObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                secObserver.unobserve(entry.target);

                const section = entry.target;
                const heading = section.querySelector('h2');
                const cards = section.querySelectorAll('.card, article');
                const chips = section.querySelectorAll('.chip');
                const items = section.querySelectorAll('.space-y-3 > div, .space-y-2 > div');

                const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });

                if (heading) {
                    tl.from(heading, {
                        autoAlpha: 0,
                        y: 24,
                        duration: 0.55,
                    });
                }

                if (cards.length) {
                    tl.to(cards, {
                        autoAlpha: 1,
                        y: 0,
                        scale: 1,
                        stagger: 0.07,
                        duration: 0.55,
                        ease: 'power2.out',
                    }, '-=0.2');
                }

                if (items.length && !cards.length) {
                    tl.to(items, {
                        autoAlpha: 1,
                        y: 0,
                        stagger: 0.06,
                        duration: 0.45,
                        ease: 'power2.out',
                    }, '-=0.15');
                }

                if (chips.length) {
                    tl.to(chips, {
                        autoAlpha: 1,
                        y: 0,
                        scale: 1,
                        stagger: 0.03,
                        duration: 0.4,
                        ease: 'back.out(1.6)',
                    }, '-=0.3');
                }

                if (!cards.length && !chips.length && !heading && !items.length) {
                    gsap.from(section, {
                        autoAlpha: 0,
                        y: 28,
                        duration: 0.6,
                        ease: 'power2.out',
                    });
                }
            });
        },
        { threshold: 0.06, rootMargin: '0px 0px -40px 0px' }
    );
    sections.forEach((s) => secObserver.observe(s));
}

/* ── Card hover tilt ─────────────────────────────────────── */
if (!reduceMotion) {
    document.querySelectorAll('.card-hover, article.group').forEach((card) => {
        card.addEventListener('mouseenter', () => {
            gsap.to(card, { scale: 1.015, duration: 0.25, ease: 'power2.out' });
        });
        card.addEventListener('mouseleave', () => {
            gsap.to(card, { scale: 1, rotationX: 0, rotationY: 0, duration: 0.35, ease: 'power2.out' });
        });
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = ((y - centerY) / centerY) * -2;
            const rotateY = ((x - centerX) / centerX) * 2;
            gsap.to(card, { rotationX: rotateX, rotationY: rotateY, duration: 0.3, ease: 'power1.out' });
        });
    });
}

/* ── Magnetic buttons ────────────────────────────────────── */
/* Removed — click-only animation handled by CSS :active */

/* ── Chip hover bounce ───────────────────────────────────── */
if (!reduceMotion) {
    document.querySelectorAll('.chip').forEach((chip) => {
        chip.addEventListener('mouseenter', () => {
            gsap.to(chip, { scale: 1.06, duration: 0.2, ease: 'back.out(2)' });
        });
        chip.addEventListener('mouseleave', () => {
            gsap.to(chip, { scale: 1, duration: 0.3, ease: 'power2.out' });
        });
    });
}

/* ── Image skeleton loading + adaptive orientation ───────── */
document.querySelectorAll('.img-skel').forEach((wrap) => {
    const img = wrap.querySelector('img');
    const skel = wrap.querySelector('.skeleton-image');
    if (!img) return;

    const show = () => {
        img.style.opacity = '1';
        if (skel) {
            skel.style.transition = 'opacity .4s';
            skel.style.opacity = '0';
            setTimeout(() => skel.remove(), 450);
        }

        if (img.dataset.adapt !== undefined && img.naturalWidth && img.naturalHeight) {
            const aspect = `${img.naturalWidth} / ${img.naturalHeight}`;
            wrap.style.aspectRatio = aspect;
            if (skel) {
                skel.style.aspectRatio = aspect;
            }
            const isPortrait = img.naturalHeight > img.naturalWidth * 1.15;
            if (isPortrait) {
                wrap.classList.add('max-w-md', 'mx-auto');
            }
        }
    };

    if (img.dataset.src) {
        img.src = img.dataset.src;
        img.removeAttribute('data-src');
    }

    if (img.complete) {
        show();
    } else {
        img.addEventListener('load', show, { once: true });
        img.addEventListener('error', show, { once: true });
    }
});

/* ── Password toggle ─────────────────────────────────────── */
document.querySelectorAll('.toggle-password').forEach((btn) => {
    btn.addEventListener('click', () => {
        const input = btn.parentElement.querySelector('input[type="password"], input[type="text"]');
        if (!input) return;
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        btn.querySelector('.eye-open')?.classList.toggle('hidden', !isPassword);
        btn.querySelector('.eye-closed')?.classList.toggle('hidden', isPassword);
    });
});

/* ── Image file preview ────────────────────────────────── */
document.querySelectorAll('input[type="file"][accept*="image"]').forEach((input) => {
    input.addEventListener('change', () => {
        const file = input.files?.[0];
        if (!file || !file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.onload = (e) => {
            const label = input.closest('label');
            const wrapper = input.parentElement;
            const imgSrc = e.target.result;

            if (label && label.contains(input)) {
                label.innerHTML = `
                    <img src="${imgSrc}" alt="Preview" class="max-h-48 w-full rounded-brutal object-contain">
                    <span class="mt-2 text-[11px] font-semibold text-ink-3">${file.name}</span>
                    <button type="button" data-action="cancel" class="mt-1 text-[11px] font-bold text-accent hover:underline">Batalkan</button>
                `;
                label.querySelector('[data-action="cancel"]').addEventListener('click', (ev) => {
                    ev.preventDefault();
                    ev.stopPropagation();
                    input.value = '';
                    location.reload();
                });
            } else if (wrapper) {
                const previewBox = wrapper.querySelector('.rounded-brutal.border-2');
                if (previewBox) {
                    const oldImg = previewBox.querySelector('img');
                    if (oldImg) {
                        oldImg.src = imgSrc;
                    } else {
                        previewBox.innerHTML = `<img src="${imgSrc}" alt="Preview" class="size-full object-contain p-1">`;
                    }
                }
                let cancelBtn = wrapper.querySelector('[data-action="cancel-settings"]');
                if (!cancelBtn) {
                    cancelBtn = document.createElement('button');
                    cancelBtn.type = 'button';
                    cancelBtn.setAttribute('data-action', 'cancel-settings');
                    cancelBtn.className = 'text-[11px] font-bold text-accent hover:underline';
                    cancelBtn.textContent = 'Batalkan';
                    wrapper.appendChild(cancelBtn);
                }
                cancelBtn.onclick = () => {
                    input.value = '';
                    cancelBtn.remove();
                    location.reload();
                };
            }
        };
        reader.readAsDataURL(file);
    });
});
