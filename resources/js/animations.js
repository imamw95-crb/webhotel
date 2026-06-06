/* ============================================================
   ANIMATIONS JS — The Icon Hotel Kuningan
   Vanilla JS — IntersectionObserver, counters, parallax,
   magnetic hover, ripple, text split, scroll effects
   UI/UX Pro Max — Smooth & Premium
   ============================================================ */

document.addEventListener('DOMContentLoaded', () => {

  /* --------------------------------------------------
     1. INTERSECTION OBSERVER — Reveal & Stagger
     Uses requestAnimationFrame for smooth triggering
     -------------------------------------------------- */
  const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        requestAnimationFrame(() => {
          entry.target.classList.add('in');
        });
        revealObserver.unobserve(entry.target);
      }
    });
  }, {
    threshold: 0.12,
    rootMargin: '0px 0px -56px 0px',
  });

  document.querySelectorAll(
    '.reveal, .reveal-left, .reveal-right, .reveal-scale, .reveal-zoom, .stagger, .text-split-reveal'
  ).forEach((el) => revealObserver.observe(el));

  /* --------------------------------------------------
     2. COUNTER ANIMATION — Smooth easing (spring-like)
     -------------------------------------------------- */
  const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const el = entry.target;
        const target = parseInt(el.getAttribute('data-target'), 10);
        if (isNaN(target)) return;

        const duration = 2000; // ms — slightly slower for smoother feel
        const startTime = performance.now();

        // Spring-like ease-out: fast start, smooth settle
        function easeOutQuart(t) {
          return 1 - Math.pow(1 - t, 4);
        }

        function update(currentTime) {
          const elapsed = currentTime - startTime;
          const progress = Math.min(elapsed / duration, 1);
          const easedProgress = easeOutQuart(progress);
          const current = Math.round(easedProgress * target);

          el.textContent = current.toLocaleString();

          if (progress < 1) {
            requestAnimationFrame(update);
          } else {
            el.textContent = target.toLocaleString();
            el.classList.add('animated');
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
     3. HERO PARALLAX — Smooth multi-layer parallax
     -------------------------------------------------- */
  const heroBg = document.querySelector('.hero-bg-img');
  if (heroBg) {
    let ticking = false;
    window.addEventListener('scroll', () => {
      if (!ticking) {
        requestAnimationFrame(() => {
          const scrollY = window.scrollY;
          heroBg.style.transform = `translateY(${scrollY * 0.28}px)`;
          ticking = false;
        });
        ticking = true;
      }
    }, { passive: true });
  }

  /* --------------------------------------------------
     4. HERO TEXT SPLIT REVEAL — Animate each word
     -------------------------------------------------- */
  function initTextSplit() {
    document.querySelectorAll('.text-split-reveal').forEach((el) => {
      const text = el.textContent.trim();
      const words = text.split(/\s+/);
      if (words.length < 2) return;

      el.innerHTML = words
        .map((word) => `<span class="split-word">${word}</span>`)
        .join(' ');
    });
  }
  initTextSplit();

  /* --------------------------------------------------
     5. MAGNETIC HOVER — Gold & Ghost Buttons (desktop only)
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
     6. RIPPLE EFFECT — Buttons (optional class .ripple-btn)
     -------------------------------------------------- */
  function initRipple() {
    document.querySelectorAll('.ripple-btn').forEach((btn) => {
      btn.addEventListener('click', function (e) {
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;

        const ripple = document.createElement('span');
        ripple.className = 'ripple-effect';
        ripple.style.width = ripple.style.height = `${size}px`;
        ripple.style.left = `${x}px`;
        ripple.style.top = `${y}px`;

        this.appendChild(ripple);

        ripple.addEventListener('animationend', () => {
          ripple.remove();
        });
      });
    });
  }
  initRipple();

  /* --------------------------------------------------
     7. NAVBAR SCROLL — Toggle .scrolled class with RAF
     -------------------------------------------------- */
  const navbar = document.getElementById('navbar');
  if (navbar) {
    let ticking = false;
    window.addEventListener('scroll', () => {
      if (!ticking) {
        requestAnimationFrame(() => {
          if (window.scrollY > 80) {
            navbar.classList.add('scrolled');
          } else {
            navbar.classList.remove('scrolled');
          }
          ticking = false;
        });
        ticking = true;
      }
    }, { passive: true });
  }

  /* --------------------------------------------------
     8. MOBILE MENU — Toggle with body scroll lock
     -------------------------------------------------- */
  const hamburger = document.querySelector('.hamburger-btn');
  const mobileMenu = document.querySelector('.mobile-menu');
  const overlay = document.querySelector('.mobile-overlay');
  const mobileCloseBtn = document.querySelector('.mobile-close-btn');

  function closeMobileMenu() {
    if (mobileMenu) {
      mobileMenu.classList.remove('open');
      mobileMenu.setAttribute('aria-hidden', 'true');
    }
    if (overlay) overlay.classList.remove('open');
    document.body.style.overflow = '';
    if (hamburger) {
      hamburger.setAttribute('aria-expanded', 'false');
      hamburger.focus();
    }
  }

  function openMobileMenu() {
    if (mobileMenu) {
      mobileMenu.classList.add('open');
      mobileMenu.setAttribute('aria-hidden', 'false');
    }
    if (overlay) overlay.classList.add('open');
    document.body.style.overflow = 'hidden';
    if (hamburger) hamburger.setAttribute('aria-expanded', 'true');
  }

  if (hamburger && mobileMenu && overlay) {
    hamburger.addEventListener('click', () => {
      const isOpen = mobileMenu.classList.contains('open');
      isOpen ? closeMobileMenu() : openMobileMenu();
    });

    overlay.addEventListener('click', closeMobileMenu);

    if (mobileCloseBtn) {
      mobileCloseBtn.addEventListener('click', closeMobileMenu);
    }

    // Close on escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && mobileMenu?.classList.contains('open')) {
        closeMobileMenu();
      }
    });

    // Close mobile menu on link click
    mobileMenu.querySelectorAll('.mobile-link').forEach((link) => {
      link.addEventListener('click', closeMobileMenu);
    });
  }

  /* --------------------------------------------------
     9. IMAGE LOAD REVEAL — Fade in images on load
     -------------------------------------------------- */
  function initImgReveal() {
    document.querySelectorAll('.img-reveal').forEach((img) => {
      if (img.complete) {
        img.classList.add('loaded');
      } else {
        img.addEventListener('load', () => img.classList.add('loaded'));
        img.addEventListener('error', () => img.classList.add('loaded'));
      }
    });
  }
  initImgReveal();

  /* --------------------------------------------------
     10. SMOOTH ACTIVE NAV LINK — Highlight on scroll
     -------------------------------------------------- */
  function initActiveNav() {
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-link[href^="#"]');
    if (!sections.length || !navLinks.length) return;

    let ticking = false;
    window.addEventListener('scroll', () => {
      if (!ticking) {
        requestAnimationFrame(() => {
          const scrollPos = window.scrollY + 120;
          let currentSection = '';

          sections.forEach((section) => {
            const top = section.offsetTop;
            const height = section.offsetHeight;
            if (scrollPos >= top && scrollPos < top + height) {
              currentSection = '#' + section.getAttribute('id');
            }
          });

          navLinks.forEach((link) => {
            link.style.color = link.getAttribute('href') === currentSection
              ? 'var(--gold-primary)'
              : '';
          });

          ticking = false;
        });
        ticking = true;
      }
    }, { passive: true });
  }
  initActiveNav();

  /* --------------------------------------------------
     11. PARALLAX ON SCROLL — Multiple .parallax-layer elements
     -------------------------------------------------- */
  function initParallaxLayers() {
    const layers = document.querySelectorAll('.parallax-layer');
    if (!layers.length) return;

    let ticking = false;
    window.addEventListener('scroll', () => {
      if (!ticking) {
        requestAnimationFrame(() => {
          const scrollY = window.scrollY;
          layers.forEach((layer) => {
            const speed = parseFloat(layer.dataset.speed) || 0.15;
            const rect = layer.getBoundingClientRect();
            // Only move if element is in viewport
            if (rect.top < window.innerHeight && rect.bottom > 0) {
              const offset = scrollY * speed;
              layer.style.transform = `translateY(${offset}px)`;
            }
          });
          ticking = false;
        });
        ticking = true;
      }
    }, { passive: true });
  }
  initParallaxLayers();

  /* --------------------------------------------------
     12. SMOOTH SCROLL FOR ANCHOR LINKS (with offset)
     Also handles external anchor links
     -------------------------------------------------- */
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener('click', function (e) {
      const href = this.getAttribute('href');
      if (href === '#') return;

      const target = document.querySelector(href);
      if (target) {
        e.preventDefault();
        const navHeight = document.querySelector('nav')?.offsetHeight || 0;
        const targetPosition = target.getBoundingClientRect().top + window.scrollY - navHeight - 10;
        window.scrollTo({
          top: targetPosition,
          behavior: 'smooth',
        });
      }
    });
  });

});
