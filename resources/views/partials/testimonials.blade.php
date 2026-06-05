{{-- ============================================================
   PARTIAL: TESTIMONIALS — The Icon Hotel Kuningan
   Animated carousel with guest reviews
   ============================================================ --}}

<section id="testimonials" class="section-padding testimonials-section">
    <div class="section-container">
        <div class="text-center mb-16 reveal">
            <span class="sec-label">{{ $sections['testimonials_intro']['subtitle'] ?? 'Testimonials' }}</span>
            <h2 class="section-title">{{ $sections['testimonials_intro']['title'] ?? 'What Our Guests Say' }}</h2>
            <div class="gold-line centered"></div>
        </div>

        @php
            $testimonials = [
                [
                    'name' => 'Sarah Wijaya',
                    'role' => 'Business Traveler',
                    'avatar' => 'SW',
                    'rating' => 5,
                    'text' => 'The executive room was absolutely stunning! The garden view in the morning was breathtaking. Staff were incredibly attentive and professional.',
                ],
                [
                    'name' => 'Budi Santoso',
                    'role' => 'Family Vacation',
                    'avatar' => 'BS',
                    'rating' => 5,
                    'text' => 'Our family loved the spacious family room. The kids enjoyed the pool while we relaxed at the Sky Terrace. Perfect weekend getaway!',
                ],
                [
                    'name' => 'Rina Amelia',
                    'role' => 'Couple Getaway',
                    'avatar' => 'RA',
                    'rating' => 4,
                    'text' => 'Romantic atmosphere with elegant decor. The junior suite was cozy and well-appointed. Will definitely come back for our anniversary.',
                ],
                [
                    'name' => 'David Lim',
                    'role' => 'Business Traveler',
                    'avatar' => 'DL',
                    'rating' => 5,
                    'text' => 'Excellent location in the heart of Kuningan. The meeting facilities were top-notch and the WiFi was super fast. Highly recommended for business trips.',
                ],
                [
                    'name' => 'Maya Putri',
                    'role' => 'Solo Traveler',
                    'avatar' => 'MP',
                    'rating' => 5,
                    'text' => 'Felt safe and welcomed from the moment I arrived. The staff went above and beyond to make my stay comfortable. The food at the restaurant was delicious!',
                ],
            ];
        @endphp

        <div class="testimonials-carousel" x-data="testimonialCarousel()">
            {{-- Main Slide --}}
            <div class="testimonial-main">
                <template x-for="(item, index) in items" :key="index">
                    <div x-show="current === index"
                         x-transition:enter="testimonial-enter"
                         x-transition:enter-start="testimonial-enter-start"
                         x-transition:enter-end="testimonial-enter-end"
                         x-transition:leave="testimonial-leave"
                         x-transition:leave-start="testimonial-leave-start"
                         x-transition:leave-end="testimonial-leave-end"
                         class="testimonial-slide">
                        {{-- Quote Icon --}}
                        <div class="testimonial-quote-icon">
                            <i class="fa-solid fa-quote-right"></i>
                        </div>

                        {{-- Rating Stars --}}
                        <div class="testimonial-stars" x-html="renderStars(item.rating)"></div>

                        {{-- Text --}}
                        <p class="testimonial-text" x-text="item.text"></p>

                        {{-- Author --}}
                        <div class="testimonial-author">
                            <div class="testimonial-avatar" x-text="item.avatar"></div>
                            <div class="testimonial-info">
                                <span class="testimonial-name" x-text="item.name"></span>
                                <span class="testimonial-role" x-text="item.role"></span>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Navigation Dots --}}
            <div class="testimonial-dots">
                <template x-for="(item, index) in items" :key="index">
                    <button @click="goTo(index)"
                            :class="{'active': current === index}"
                            class="testimonial-dot"
                            :aria-label="'Go to testimonial ' + (index + 1)">
                    </button>
                </template>
            </div>

            {{-- Arrow Buttons --}}
            <button @click="prev()" class="testimonial-arrow testimonial-arrow-prev" aria-label="Previous testimonial">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button @click="next()" class="testimonial-arrow testimonial-arrow-next" aria-label="Next testimonial">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function testimonialCarousel() {
        return {
            items: @json($testimonials),
            current: 0,
            timer: null,

            init() {
                this.startAutoplay();
            },

            startAutoplay() {
                this.stopAutoplay();
                this.timer = setInterval(() => {
                    this.next();
                }, 5000);
            },

            stopAutoplay() {
                if (this.timer) {
                    clearInterval(this.timer);
                    this.timer = null;
                }
            },

            goTo(index) {
                this.current = index;
                this.startAutoplay();
            },

            next() {
                this.current = (this.current + 1) % this.items.length;
                this.startAutoplay();
            },

            prev() {
                this.current = (this.current - 1 + this.items.length) % this.items.length;
                this.startAutoplay();
            },

            renderStars(rating) {
                let stars = '';
                for (let i = 1; i <= 5; i++) {
                    stars += i <= rating
                        ? '<i class="fa-solid fa-star text-gold-400"></i>'
                        : '<i class="fa-regular fa-star text-gray-500"></i>';
                }
                return stars;
            }
        };
    }

    // Pause autoplay on hover
    document.addEventListener('DOMContentLoaded', () => {
        const carousel = document.querySelector('.testimonials-carousel');
        if (!carousel) return;
        const alpineData = Alpine.$data(carousel);
        if (!alpineData) return;
        carousel.addEventListener('mouseenter', () => alpineData.stopAutoplay());
        carousel.addEventListener('mouseleave', () => alpineData.startAutoplay());
    });
</script>
@endpush

@push('styles')
<style>
/* ---- Testimonials Section ---- */
.testimonials-section {
    background: linear-gradient(180deg, var(--bg-page) 0%, var(--bg-surface) 100%);
    border-top: 1px solid var(--border-default);
    border-bottom: 1px solid var(--border-default);
    overflow: hidden;
}

/* ---- Carousel Container ---- */
.testimonials-carousel {
    position: relative;
    max-width: 700px;
    margin: 0 auto;
    padding: 0 50px;
}

/* ---- Slide ---- */
.testimonial-main {
    position: relative;
    min-height: 320px;
}

.testimonial-slide {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 16px;
    padding: 20px 0;
}

/* ---- Transitions ---- */
.testimonial-enter {
    transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}
.testimonial-enter-start {
    opacity: 0;
    transform: translateY(30px) scale(0.95);
}
.testimonial-enter-end {
    opacity: 1;
    transform: translateY(0) scale(1);
}
.testimonial-leave {
    transition: all 0.4s ease-in;
}
.testimonial-leave-start {
    opacity: 1;
    transform: translateY(0) scale(1);
}
.testimonial-leave-end {
    opacity: 0;
    transform: translateY(-20px) scale(0.95);
}

/* ---- Quote Icon ---- */
.testimonial-quote-icon {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(212, 175, 55, 0.15), rgba(212, 175, 55, 0.05));
    border: 1px solid rgba(212, 175, 55, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: var(--gold-primary);
}

/* ---- Stars ---- */
.testimonial-stars {
    display: flex;
    gap: 4px;
    font-size: 18px;
}

/* ---- Text ---- */
.testimonial-text {
    font-size: 17px;
    color: var(--text-secondary);
    line-height: 1.8;
    font-style: italic;
    margin: 0;
    max-width: 550px;
}

/* ---- Author ---- */
.testimonial-author {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-top: 8px;
}

.testimonial-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--gold-primary), var(--gold-hover));
    color: #09090f;
    font-size: 16px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--font-body);
}

.testimonial-info {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 2px;
}

.testimonial-name {
    font-size: 15px;
    font-weight: 600;
    color: var(--text-primary);
    font-family: var(--font-display);
}

.testimonial-role {
    font-size: 12px;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.06em;
}

/* ---- Dots ---- */
.testimonial-dots {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 24px;
}

.testimonial-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.1);
    cursor: pointer;
    padding: 0;
    transition: all 0.4s ease;
}

.testimonial-dot.active {
    background: var(--gold-primary);
    border-color: var(--gold-primary);
    box-shadow: 0 0 12px rgba(212, 175, 55, 0.5);
    width: 28px;
    border-radius: 5px;
}

.testimonial-dot:hover {
    background: rgba(255, 255, 255, 0.4);
}

/* ---- Arrows ---- */
.testimonial-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.04);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    color: var(--text-secondary);
    font-size: 1rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.testimonial-arrow:hover {
    background: rgba(255, 255, 255, 0.1);
    color: var(--gold-primary);
    border-color: rgba(212, 175, 55, 0.3);
}

.testimonial-arrow-prev { left: 0; }
.testimonial-arrow-next { right: 0; }

@media (max-width: 640px) {
    .testimonials-carousel { padding: 0 10px; }
    .testimonial-arrow { display: none; }
    .testimonial-text { font-size: 15px; }
    .testimonial-main { min-height: 360px; }
}
</style>
@endpush
