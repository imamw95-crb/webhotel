{{-- ============================================================
   PARTIAL: SOCIAL PROOF BAR — The Icon Hotel Kuningan
   Animated stats bar with floating numbers
   ============================================================ --}}

<section class="social-proof-section">
    <div class="section-container">
        <div class="social-proof-bar reveal">
            <div class="sp-item">
                <div class="sp-icon">
                    <i class="fa-solid fa-building"></i>
                </div>
                <div class="sp-content">
                    <span class="sp-number count-num" data-target="31">0</span>
                    <span class="sp-label">Luxury Rooms</span>
                </div>
            </div>

            <div class="sp-divider"></div>

            <div class="sp-item">
                <div class="sp-icon">
                    <i class="fa-solid fa-star"></i>
                </div>
                <div class="sp-content">
                    <span class="sp-number">4.8</span>
                    <span class="sp-label">Guest Rating</span>
                </div>
            </div>

            <div class="sp-divider"></div>

            <div class="sp-item">
                <div class="sp-icon">
                    <i class="fa-solid fa-user-check"></i>
                </div>
                <div class="sp-content">
                    <span class="sp-number count-num" data-target="1280">0</span>
                    <span class="sp-label">Happy Guests</span>
                </div>
            </div>

            <div class="sp-divider"></div>

            <div class="sp-item">
                <div class="sp-icon">
                    <i class="fa-solid fa-award"></i>
                </div>
                <div class="sp-content">
                    <span class="sp-number">2026</span>
                    <span class="sp-label">Award Winner</span>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
/* ---- Social Proof Section ---- */
.social-proof-section {
    padding: 0 var(--space-lg);
    margin-top: -8px;
    position: relative;
    z-index: 1;
}

.social-proof-bar {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0;
    background: linear-gradient(135deg, var(--bg-surface) 0%, var(--bg-surface-2) 100%);
    border: 1px solid var(--border-default);
    border-radius: var(--radius-lg);
    padding: 28px 40px;
    max-width: 900px;
    margin: 0 auto;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
}

.sp-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 0 24px;
    flex: 1;
    justify-content: center;
}

.sp-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(212, 175, 55, 0.12), rgba(212, 175, 55, 0.04));
    border: 1px solid rgba(212, 175, 55, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: var(--gold-primary);
    flex-shrink: 0;
}

.sp-content {
    display: flex;
    flex-direction: column;
}

.sp-number {
    font-family: var(--font-display);
    font-size: 26px;
    font-weight: 600;
    color: var(--text-primary);
    line-height: 1.2;
}

.sp-label {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--text-muted);
}

.sp-divider {
    width: 1px;
    height: 40px;
    background: var(--border-default);
    flex-shrink: 0;
}

@media (max-width: 768px) {
    .social-proof-bar {
        flex-direction: column;
        gap: 16px;
        padding: 24px 20px;
    }

    .sp-item {
        padding: 8px 0;
        width: 100%;
        justify-content: flex-start;
    }

    .sp-divider {
        width: 100%;
        height: 1px;
    }

    .sp-number {
        font-size: 22px;
    }
}
</style>
@endpush
