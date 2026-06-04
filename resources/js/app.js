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
            const target = document.querySelector(this.getAttribute('href'));
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

    // --- Space Carousel (Explore Our Spaces) ---
    initSpaceCarousel();

    // --- Auto-cycling slideshow on space cards ---
    initCardSlideshow();

    // --- Animated Counters ---
    initCounters();

});

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

    // Click on space card
    section.addEventListener('click', (e) => {
        const card = e.target.closest('.space-card');
        if (!card) return;

        // Try to get photos from data attribute (DB mode)
        let photos = [];
        try {
            const raw = card.dataset.photos;
            if (raw) photos = JSON.parse(raw);
        } catch (_) {}

        if (!photos.length) {
            // Fallback: just open with the single card image
            const img = card.querySelector('.space-card-img');
            if (img && img.src) {
                photos = [{ src: img.src, title: card.dataset.category || 'Photo' }];
            }
        }

        if (!photos.length) return;

        images = photos;
        idx = 0;
        openCarousel();
    });

    function openCarousel() {
        carousel.classList.add('open');
        document.body.style.overflow = 'hidden';
        renderImage();
        renderThumbs();
    }

    function closeCarousel() {
        carousel.classList.remove('open');
        document.body.style.overflow = '';
    }

    function navigateTo(newIdx) {
        if (newIdx < 0) newIdx = images.length - 1;
        if (newIdx >= images.length) newIdx = 0;
        if (newIdx === idx) return;
        idx = newIdx;
        renderImage();
        renderThumbs();
    }

    function renderImage() {
        const data = images[idx];
        if (!data) return;

        scImage.style.opacity = '0';
        scImage.classList.remove('slide-next', 'slide-prev', 'loaded');
        scImage.src = '';
        scCaption.textContent = '';

        // Preload then show
        const img = new Image();
        img.onload = () => {
            scImage.src = data.src;
            scImage.alt = data.title || '';
            scCaption.textContent = data.title || '';
            scCounter.textContent = `${idx + 1} / ${images.length}`;
            scImage.classList.add('slide-next', 'loaded');
        };
        img.src = data.src;
    }

    function renderThumbs() {
        scThumbs.innerHTML = '';
        images.forEach((imgData, i) => {
            const thumb = document.createElement('div');
            thumb.className = 'sc-thumb' + (i === idx ? ' active' : '');
            thumb.innerHTML = `<img src="${imgData.src}" alt="${imgData.title || ''}" loading="lazy">`;
            thumb.addEventListener('click', (e) => {
                e.stopPropagation();
                navigateTo(i);
            });
            scThumbs.appendChild(thumb);

            // Scroll active into view
            if (i === idx) {
                requestAnimationFrame(() => {
                    thumb.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
                });
            }
        });
    }

    // Event listeners
    closeBtn.addEventListener('click', closeCarousel);
    prevBtn.addEventListener('click', () => navigateTo(idx - 1));
    nextBtn.addEventListener('click', () => navigateTo(idx + 1));
    backdrop.addEventListener('click', closeCarousel);

    // Keyboard
    document.addEventListener('keydown', function scKey(e) {
        if (!carousel.classList.contains('open')) return;
        if (e.key === 'Escape') closeCarousel();
        if (e.key === 'ArrowLeft') navigateTo(idx - 1);
        if (e.key === 'ArrowRight') navigateTo(idx + 1);
    });

    // Touch swipe
    let touchStartX = 0;
    carousel.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });
    carousel.addEventListener('touchend', (e) => {
        const diff = e.changedTouches[0].screenX - touchStartX;
        if (Math.abs(diff) > 50) {
            if (diff > 0) navigateTo(idx - 1);
            else navigateTo(idx + 1);
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
