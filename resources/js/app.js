import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

Alpine.plugin(collapse);
window.Alpine = Alpine;
Alpine.start();

// ============================================
// DOM Ready
// ============================================
document.addEventListener('DOMContentLoaded', () => {

    // --- Smooth scroll for anchor links ---
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const href = this.getAttribute('href');
            if (!href || href === '#') return;
            const target = document.querySelector(href);
            if (target) {
                const navHeight = document.querySelector('nav')?.offsetHeight || 0;
                const targetPosition = target.getBoundingClientRect().top + window.scrollY - navHeight;
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // --- Intersection Observer for reveal animations ---
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

    document.querySelectorAll('.reveal').forEach(el => {
        revealObserver.observe(el);
    });

    // --- Skeleton loader removal ---
    initSkeletonRemoval();

    // --- Stagger animation trigger for spaces grid ---
    const staggerGrid = document.getElementById('spaces-grid');
    if (staggerGrid) {
        const staggerObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in');
                    staggerObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        staggerObserver.observe(staggerGrid);
    }

    // --- Space Carousel (Explore Our Spaces) ---
    initSpaceCarousel();

    // --- Auto-cycling slideshow on space cards ---
    initCardSlideshow();

    // --- Animated Counters ---
    initCounters();

    // --- Back to Top & Progress Bar ---
    initScrollTools();

    // --- 3D Tilt Effect for Room Cards ---
    initTiltEffect();

});

// ============================================
// Back to Top & Reading Progress
// ============================================
function initScrollTools() {
    const backToTop = document.getElementById('back-to-top');
    const progressBar = document.getElementById('reading-progress');
    if (!backToTop && !progressBar) return;

    let ticking = false;

    window.addEventListener('scroll', () => {
        if (!ticking) {
            requestAnimationFrame(() => {
                const scrollY = window.scrollY;
                const winHeight = document.documentElement.scrollHeight - window.innerHeight;
                const progress = winHeight > 0 ? (scrollY / winHeight) * 100 : 0;

                // Progress bar
                if (progressBar) {
                    progressBar.style.width = progress + '%';
                    progressBar.setAttribute('aria-valuenow', Math.round(progress));
                }

                // Back to top visibility
                if (backToTop) {
                    if (scrollY > 400) {
                        backToTop.classList.add('visible');
                    } else {
                        backToTop.classList.remove('visible');
                    }
                }

                ticking = false;
            });
            ticking = true;
        }
    }, { passive: true });

    // Back to top click
    if (backToTop) {
        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
}

// ============================================
// 3D Tilt Effect for Room Cards
// ============================================
function initTiltEffect() {
    if (window.matchMedia('(pointer: coarse)').matches) return; // skip on touch devices

    const cards = document.querySelectorAll('.room-card');
    if (!cards.length) return;

    cards.forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            const rotateX = ((y - centerY) / centerY) * -6;
            const rotateY = ((x - centerX) / centerX) * 6;

            card.style.transform =
                `perspective(1200px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-8px)`;
        });

        card.addEventListener('mouseleave', () => {
            card.style.transform = '';
        });
    });
}

// ============================================
// Skeleton loader — remove skeleton on image load
// ============================================
function initSkeletonRemoval() {
    document.querySelectorAll('.space-card-img').forEach(img => {
        if (img.complete) {
            const skeleton = img.parentElement?.querySelector('.space-card-skeleton');
            if (skeleton) skeleton.remove();
        } else {
            img.addEventListener('load', () => {
                const skeleton = img.parentElement?.querySelector('.space-card-skeleton');
                if (skeleton) skeleton.remove();
            });
            img.addEventListener('error', () => {
                const skeleton = img.parentElement?.querySelector('.space-card-skeleton');
                if (skeleton) skeleton.remove();
            });
        }
    });
}

// ============================================
// Space Carousel — click space card to open
// ============================================
function initSpaceCarousel() {
    const section = document.getElementById('explore-spaces');
    if (!section) return;

    const carousel = document.getElementById('space-carousel');
    if (!carousel) return;

    const backdrop = carousel.querySelector('.sc-backdrop');
    const closeBtn = carousel.querySelector('.sc-close');
    const prevBtn = carousel.querySelector('.sc-prev');
    const nextBtn = carousel.querySelector('.sc-next');
    const scImage = carousel.querySelector('.sc-image');
    const scCaption = carousel.querySelector('.sc-caption');
    const scCounter = carousel.querySelector('.sc-counter');
    const scThumbs = carousel.querySelector('.sc-thumbs');

    let images = [];
    let idx = 0;
    let previousFocus = null;

    // Open card on click OR Enter/Space key
    function openCard(card) {
        let photos = [];
        try {
            const raw = card.dataset.photos;
            if (raw) photos = JSON.parse(raw);
        } catch (_) {}

        if (!photos.length) {
            const img = card.querySelector('.space-card-img');
            if (img && img.src) {
                photos = [{ src: img.src, title: card.dataset.category || 'Photo' }];
            }
        }

        if (!photos.length) return;
        images = photos;
        idx = 0;
        previousFocus = document.activeElement;
        openCarousel();
    }

    // Click on space card
    section.addEventListener('click', (e) => {
        const card = e.target.closest('.space-card');
        if (!card) return;
        // Ignore if clicking the CTA button or inside carousel
        if (e.target.closest('#view-all-gallery')) return;
        openCard(card);
    });

    // Enter/Space on space card (keyboard a11y)
    section.addEventListener('keydown', (e) => {
        const card = e.target.closest('.space-card');
        if (!card) return;
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            openCard(card);
        }
    });

    // View Full Gallery CTA — opens first card
    const viewAllBtn = document.getElementById('view-all-gallery');
    if (viewAllBtn) {
        viewAllBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const firstCard = section.querySelector('.space-card');
            if (firstCard) openCard(firstCard);
        });
    }

    // --- Focus Trap for Carousel ---
    function trapFocus(e) {
        if (!carousel.classList.contains('open')) return;
        const focusable = carousel.querySelectorAll(
            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
        );
        if (!focusable.length) return;
        const first = focusable[0];
        const last = focusable[focusable.length - 1];
        if (e.key === 'Tab') {
            if (e.shiftKey && document.activeElement === first) {
                e.preventDefault();
                last.focus();
            } else if (!e.shiftKey && document.activeElement === last) {
                e.preventDefault();
                first.focus();
            }
        }
    }

    function openCarousel() {
        carousel.classList.add('open');
        document.body.style.overflow = 'hidden';
        renderImage();
        renderThumbs();
        // Focus close button
        requestAnimationFrame(() => closeBtn.focus());
    }

    function closeCarousel() {
        carousel.classList.remove('open');
        document.body.style.overflow = '';
        // Restore focus
        if (previousFocus) {
            previousFocus.focus();
            previousFocus = null;
        }
    }

    function navigateTo(newIdx, direction) {
        if (newIdx < 0) newIdx = images.length - 1;
        if (newIdx >= images.length) newIdx = 0;
        if (newIdx === idx) return;
        idx = newIdx;
        renderImage(direction);
        renderThumbs();
    }

    function renderImage(direction) {
        const data = images[idx];
        if (!data) return;

        scImage.style.opacity = '0';
        scImage.classList.remove('slide-next', 'slide-prev', 'loaded');
        scImage.src = '';
        scCaption.textContent = '';
        scImage.alt = '';

        // Preload then show
        const img = new Image();
        img.onload = () => {
            scImage.src = data.src;
            scImage.alt = data.title || 'Gallery photo';
            scCaption.textContent = data.title || '';
            scCounter.textContent = `${idx + 1} / ${images.length}`;
            scCounter.setAttribute('aria-label', `Photo ${idx + 1} of ${images.length}`);
            if (direction === 'prev') {
                scImage.classList.add('slide-prev', 'loaded');
            } else {
                scImage.classList.add('slide-next', 'loaded');
            }
        };
        img.src = data.src;
    }

    function renderThumbs() {
        scThumbs.innerHTML = '';
        images.forEach((imgData, i) => {
            const thumb = document.createElement('button');
            thumb.className = 'sc-thumb' + (i === idx ? ' active' : '');
            thumb.setAttribute('role', 'tab');
            thumb.setAttribute('aria-label', `Photo ${i + 1}: ${imgData.title || ''}`);
            thumb.setAttribute('aria-selected', i === idx ? 'true' : 'false');
            thumb.innerHTML = `<img src="${imgData.src}" alt="${imgData.title || ''}" loading="lazy">`;
            thumb.addEventListener('click', (e) => {
                e.stopPropagation();
                navigateTo(i);
            });
            scThumbs.appendChild(thumb);

            if (i === idx) {
                requestAnimationFrame(() => {
                    thumb.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
                });
            }
        });
    }

    // Event listeners
    closeBtn.addEventListener('click', closeCarousel);
    prevBtn.addEventListener('click', () => navigateTo(idx - 1, 'prev'));
    nextBtn.addEventListener('click', () => navigateTo(idx + 1, 'next'));
    backdrop.addEventListener('click', closeCarousel);

    // Keyboard
    document.addEventListener('keydown', function scKey(e) {
        if (!carousel.classList.contains('open')) return;
        if (e.key === 'Escape') {
            e.preventDefault();
            closeCarousel();
        }
        if (e.key === 'ArrowLeft') {
            e.preventDefault();
            navigateTo(idx - 1, 'prev');
        }
        if (e.key === 'ArrowRight') {
            e.preventDefault();
            navigateTo(idx + 1, 'next');
        }
    });

    // Focus trap
    document.addEventListener('keydown', trapFocus);

    // Touch swipe with direction feedback
    let touchStartX = 0;
    let touchStartY = 0;
    carousel.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
        touchStartY = e.changedTouches[0].screenY;
    }, { passive: true });
    carousel.addEventListener('touchend', (e) => {
        const diffX = e.changedTouches[0].screenX - touchStartX;
        const diffY = e.changedTouches[0].screenY - touchStartY;
        // Only horizontal swipes (ignore vertical scrolling)
        if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 50) {
            if (diffX > 0) navigateTo(idx - 1, 'prev');
            else navigateTo(idx + 1, 'next');
        }
    }, { passive: true });
}

// ============================================
// Animated Counters
// ============================================
function initCounters() {
    const counters = document.querySelectorAll('.stat-number');
    if (!counters.length) return;

    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = parseInt(el.dataset.target) || 0;
                const suffix = el.dataset.suffix || '';
                const duration = 1500;
                const start = performance.now();

                function update(currentTime) {
                    const elapsed = currentTime - start;
                    const progress = Math.min(elapsed / duration, 1);
                    // Ease out cubic
                    const eased = 1 - Math.pow(1 - progress, 3);
                    const current = Math.floor(eased * target);
                    el.textContent = current.toLocaleString('id-ID') + suffix;
                    if (progress < 1) {
                        requestAnimationFrame(update);
                    } else {
                        el.textContent = target.toLocaleString('id-ID') + suffix;
                    }
                }
                requestAnimationFrame(update);
                counterObserver.unobserve(el);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(el => counterObserver.observe(el));
}

// ============================================
// Card Slideshow — auto-cycle with true crossfade
// ============================================
function initCardSlideshow() {
    const cards = document.querySelectorAll('.space-card');
    if (!cards.length) return;

    cards.forEach(card => {
        let photos = [];
        try {
            const raw = card.dataset.photos;
            if (raw) photos = JSON.parse(raw);
        } catch (_) {}

        if (photos.length < 2) return;

        const inner = card.querySelector('.space-card-inner');
        if (!inner) return;

        // Use the existing img as front layer, create a back layer underneath
        let front = inner.querySelector('.space-card-img');
        if (!front) return;

        // Remove transition from front during setup to prevent flash
        front.style.transition = 'opacity 0.8s ease, transform 0.8s cubic-bezier(0.16, 1, 0.3, 1)';
        front.style.position = 'relative';
        front.style.zIndex = '2';

        // Create back image layer (sits behind front)
        let back = inner.querySelector('.sc-back-img');
        if (!back) {
            back = document.createElement('img');
            back.className = 'space-card-img sc-back-img';
            back.src = front.src;
            back.alt = front.alt;
            back.style.position = 'absolute';
            back.style.inset = '0';
            back.style.width = '100%';
            back.style.height = '100%';
            back.style.objectFit = 'cover';
            back.style.zIndex = '1';
            back.style.opacity = '0';
            back.style.transition = 'opacity 0.8s ease, transform 0.8s cubic-bezier(0.16, 1, 0.3, 1)';
            // Insert before overlay to keep it under all content
            const overlay = inner.querySelector('.space-card-overlay');
            if (overlay) {
                inner.insertBefore(back, overlay);
            } else {
                inner.appendChild(back);
            }
        }

        // Preload ALL images upfront for instant swaps
        photos.forEach(p => {
            const pre = new Image();
            pre.src = p.src;
        });

        let currentIdx = 0;
        let isTransitioning = false;
        const INTERVAL = 5500; // 5.5 seconds between changes

        function nextPhoto() {
            if (isTransitioning) return;
            isTransitioning = true;

            currentIdx = (currentIdx + 1) % photos.length;
            const data = photos[currentIdx];

            // Set back to new photo (already preloaded)
            back.src = data.src;
            back.alt = data.title || '';

            // True crossfade: both layers transition simultaneously
            front.style.opacity = '0';
            back.style.opacity = '1';

            // After crossfade completes, swap roles for next cycle
            setTimeout(() => {
                // Disable transitions for instant swap (prevents flash)
                front.style.transition = 'none';
                back.style.transition = 'none';

                front.src = back.src;
                front.alt = back.alt;
                front.style.opacity = '1';
                back.style.opacity = '0';

                // Force reflow so the instant change takes effect
                void front.offsetHeight;

                // Re-enable transitions for next crossfade
                front.style.transition = 'opacity 0.8s ease, transform 0.8s cubic-bezier(0.16, 1, 0.3, 1)';
                back.style.transition = 'opacity 0.8s ease, transform 0.8s cubic-bezier(0.16, 1, 0.3, 1)';

                isTransitioning = false;
            }, 850); // slightly longer than CSS transition (0.8s)
        }

        let timer = setInterval(nextPhoto, INTERVAL);

        // Pause on hover/resume on leave
        card.addEventListener('mouseenter', () => clearInterval(timer));
        card.addEventListener('mouseleave', () => {
            timer = setInterval(nextPhoto, INTERVAL);
        });

        // Stop when card is clicked to open carousel
        card.addEventListener('click', () => clearInterval(timer), { once: true });
    });
}
