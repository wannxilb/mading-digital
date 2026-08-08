import './bootstrap';

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

const nav = document.getElementById('site-nav');
const mobileMenu = document.getElementById('mobile-menu');
const navToggle = document.getElementById('nav-toggle');
const iconOpen = document.getElementById('icon-open');
const iconClose = document.getElementById('icon-close');

const setNavState = () => {
    if (!nav) return;
    const scrolled = window.scrollY > 16;
    const inner = nav.querySelector('div.mx-auto > div');
    if (!inner) return;

    if (scrolled) {
        inner.classList.add('bg-white/85', 'backdrop-blur-xl', 'shadow-soft', 'ring-1', 'ring-navy-900/5');
        inner.classList.remove('bg-transparent');
    } else {
        inner.classList.remove('bg-white/85', 'backdrop-blur-xl', 'shadow-soft', 'ring-1', 'ring-navy-900/5');
        inner.classList.add('bg-transparent');
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

const revealElements = document.querySelectorAll('.reveal');
if (revealElements.length) {
    if (reduceMotion || !('IntersectionObserver' in window)) {
        revealElements.forEach((el) => el.classList.add('is-visible'));
    } else {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
        );
        revealElements.forEach((el) => observer.observe(el));
    }
}

const counters = document.querySelectorAll('[data-count]');
if (counters.length) {
    const animateCount = (el) => {
        const target = Number(el.dataset.count);
        if (reduceMotion) {
            el.textContent = target.toLocaleString('id-ID');
            return;
        }
        const duration = 1400;
        const start = performance.now();
        const step = (now) => {
            const p = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.round(target * eased).toLocaleString('id-ID');
            if (p < 1) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
    };

    const counterObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    animateCount(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.4 }
    );
    counters.forEach((el) => counterObserver.observe(el));
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

const marquee = document.getElementById('marquee');
if (marquee) {
    marquee.addEventListener('mouseenter', () => (marquee.style.animationPlayState = 'paused'));
    marquee.addEventListener('mouseleave', () => (marquee.style.animationPlayState = 'running'));
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

document.querySelectorAll('#konten img').forEach((img) => {
    img.classList.add('cursor-zoom-in', 'rounded-2xl', 'my-6');
    img.addEventListener('click', () => {
        const overlay = document.createElement('div');
        overlay.className =
            'fixed inset-0 z-50 flex items-center justify-center bg-navy-950/90 backdrop-blur-sm p-4 animate-rise';
        overlay.innerHTML = `
            <button class="absolute right-4 top-4 grid place-items-center size-11 rounded-full bg-white/10 text-white hover:bg-white/20 transition-colors" aria-label="Tutup">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 6l12 12M18 6L6 18"/></svg>
            </button>
            <img src="${img.currentSrc || img.src}" alt="${img.alt || ''}" class="max-h-[88vh] max-w-full rounded-2xl shadow-lift object-contain">
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
