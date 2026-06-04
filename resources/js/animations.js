/* ============================================================
   ANIMATIONS JS — The Icon Hotel Kuningan
   Vanilla JS — IntersectionObserver, counters, parallax, etc.
   ============================================================ */

document.addEventListener('DOMContentLoaded', () => {

  /* --------------------------------------------------
     1. INTERSECTION OBSERVER — Reveal & Stagger
     -------------------------------------------------- */
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('in');
        // Optionally unobserve after reveal
        // observer.unobserve(entry.target);
      }
    });
  }, {
    threshold: 0.12,
    rootMargin: '0px 0px -56px 0px',
  });

  document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .stagger')
    .forEach((el) => observer.observe(el));

  /* --------------------------------------------------
     2. COUNTER ANIMATION
     -------------------------------------------------- */
  const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const el = entry.target;
        const target = parseInt(el.getAttribute('data-target'), 10);
        if (isNaN(target)) return;

        const duration = 1600; // ms
        const startTime = performance.now();

        function easeOutCubic(t) {
          return 1 - Math.pow(1 - t, 3);
        }

        function update(currentTime) {
          const elapsed = currentTime - startTime;
          const progress = Math.min(elapsed / duration, 1);
          const easedProgress = easeOutCubic(progress);
          const current = Math.round(easedProgress * target);

          el.textContent = current.toLocaleString();

          if (progress < 1) {
            requestAnimationFrame(update);
          } else {
            el.textContent = target.toLocaleString();
          }
        }

        requestAnimationFrame(update);
        counterObserver.unobserve(el);
      }
    });
  }, {
    threshold: 0.3,
  });

  document.querySelectorAll('.count-num[data-target]')
    .forEach((el) => counterObserver.observe(el));

  /* --------------------------------------------------
     3. HERO PARALLAX
     -------------------------------------------------- */
  const heroBg = document.querySelector('.hero-bg-img');
  if (heroBg) {
    window.addEventListener('scroll', () => {
      const scrollY = window.scrollY;
      heroBg.style.transform = `translateY(${scrollY * 0.28}px)`;
    }, { passive: true });
  }

  /* --------------------------------------------------
     4. MAGNETIC HOVER — Gold & Ghost Buttons
     -------------------------------------------------- */
  if (window.matchMedia('(pointer: fine)').matches) {
    document.querySelectorAll('.btn-gold, .btn-ghost').forEach((btn) => {
      btn.addEventListener('mousemove', (e) => {
        const rect = btn.getBoundingClientRect();
        const x = e.clientX - rect.left - rect.width / 2;
        const y = e.clientY - rect.top - rect.height / 2;
        const maxDist = 10;
        const dist = Math.min(Math.sqrt(x * x + y * y), maxDist);
        const angle = Math.atan2(y, x);
        const moveX = Math.cos(angle) * dist;
        const moveY = Math.sin(angle) * dist;

        btn.style.transform = `translate(${moveX}px, ${moveY}px)`;
      });

      btn.addEventListener('mouseleave', () => {
        btn.style.transform = '';
      });
    });
  }

  /* --------------------------------------------------
     5. NAVBAR SCROLL — Toggle .scrolled class
     -------------------------------------------------- */
  const navbar = document.getElementById('navbar');
  if (navbar) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 80) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    }, { passive: true });
  }

  /* --------------------------------------------------
     6. MOBILE MENU — Toggle
     -------------------------------------------------- */
  const hamburger = document.querySelector('.hamburger-btn');
  const mobileMenu = document.querySelector('.mobile-menu');
  const overlay = document.querySelector('.mobile-overlay');

  function closeMobileMenu() {
    if (mobileMenu) mobileMenu.classList.remove('open');
    if (overlay) overlay.classList.remove('open');
    document.body.style.overflow = '';
  }

  if (hamburger && mobileMenu && overlay) {
    hamburger.addEventListener('click', () => {
      const isOpen = mobileMenu.classList.contains('open');
      if (isOpen) {
        closeMobileMenu();
      } else {
        mobileMenu.classList.add('open');
        overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
      }
    });

    overlay.addEventListener('click', closeMobileMenu);

    // Close on escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeMobileMenu();
    });
  }
});
