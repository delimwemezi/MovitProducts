import './bootstrap';
// app.js

/* ═══════════════════════════════════════════════════════════
   MOVIT BEAUTY STORE — main.js
   All JavaScript for the entire site
═══════════════════════════════════════════════════════════ */

document.addEventListener('DOMContentLoaded', function () {

    /* ════════════════════════════════
       1. CATEGORY TABS
    ════════════════════════════════ */
    const categoryCards = document.querySelectorAll('.category-card');

    if (categoryCards.length) {
        // Auto-activate first tab if none is already active
        if (!document.querySelector('.category-card.active')) {
            categoryCards[0].classList.add('active');
        }

        categoryCards.forEach(card => {
            card.addEventListener('click', function (e) {
                e.preventDefault();
                categoryCards.forEach(c => c.classList.remove('active'));
                this.classList.add('active');
            });
        });
    }

    /* ════════════════════════════════
       2. DEAL CARD SCROLL REVEAL
    ════════════════════════════════ */
    const dealCards = document.querySelectorAll('.deal-card');

    if (dealCards.length) {
        if ('IntersectionObserver' in window) {
            const revealObserver = new IntersectionObserver(function (entries) {
                entries.forEach((entry, i) => {
                    if (entry.isIntersecting) {
                        setTimeout(function () {
                            entry.target.classList.add('revealed');
                        }, i * 120);
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15 });

            dealCards.forEach(card => revealObserver.observe(card));
        } else {
            // Fallback for old browsers
            dealCards.forEach(card => card.classList.add('revealed'));
        }
    }

    /* ════════════════════════════════
       3. BUTTON RIPPLE EFFECT
    ════════════════════════════════ */
    document.querySelectorAll('.btn-small, .btn, .login-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            // avoid double ripple on links navigating away
            const ripple = document.createElement('span');
            const rect   = this.getBoundingClientRect();

            ripple.style.cssText = [
                'position:absolute',
                'border-radius:50%',
                'width:60px',
                'height:60px',
                'background:rgba(255,255,255,0.35)',
                'transform:translate(-50%,-50%) scale(0)',
                'animation:ripple 0.55s linear',
                'pointer-events:none',
                `left:${e.clientX - rect.left}px`,
                `top:${e.clientY - rect.top}px`,
            ].join(';');

            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            setTimeout(() => ripple.remove(), 560);
        });
    });

    /* ════════════════════════════════
       4. PRODUCT CARD TOGGLE (description)
    ════════════════════════════════ */
    const productCards = document.querySelectorAll('.card:not(.deal-card)');

    productCards.forEach(card => {
        card.addEventListener('click', function () {
            const isActive = this.classList.contains('active');
            // close all first
            productCards.forEach(c => c.classList.remove('active'));
            // open clicked one (unless it was already open)
            if (!isActive) this.classList.add('active');
        });
    });

    /* ════════════════════════════════
       5. AUTO-DISMISS ALERTS
    ════════════════════════════════ */
    const alerts = document.querySelectorAll('.alert');

    alerts.forEach(alert => {
        // fade out after 4 seconds
        setTimeout(function () {
            alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            alert.style.opacity    = '0';
            alert.style.transform  = 'translateY(-8px)';
            setTimeout(() => alert.remove(), 500);
        }, 4000);
    });

    /* ════════════════════════════════
       6. SEARCH — clear on Escape
    ════════════════════════════════ */
    const searchInput = document.querySelector('.search-box input');

    if (searchInput) {
        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                this.value = '';
                this.blur();
            }
        });
    }

    /* ════════════════════════════════
       7. NAVBAR — hide on scroll down,
          show on scroll up
    ════════════════════════════════ */
    const navbar = document.querySelector('.navbar');

    if (navbar) {
        let lastScroll = 0;

        window.addEventListener('scroll', function () {
            const current = window.scrollY;

            if (current > lastScroll && current > 80) {
                // scrolling down — hide
                navbar.style.transform = 'translateY(-100%)';
                navbar.style.transition = 'transform 0.3s ease';
            } else {
                // scrolling up — show
                navbar.style.transform = 'translateY(0)';
            }

            lastScroll = current;
        });
    }

});

