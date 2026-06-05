---
name: ui-ux-pro-max
description: "UI/UX design intelligence for web and mobile. Includes 50+ styles, 95+ color palettes, 56 font pairings, 24 chart types, and 99+ UX guidelines across 8 tech stacks (React, Next.js, Vue, Svelte, SwiftUI, React Native, Flutter, Tailwind). Apply when: building landing pages, dashboards, admin panels, e-commerce, SaaS, mobile apps, or any UI component (button, modal, navbar, card, table, form, chart). Covers: style selection (glassmorphism, minimalism, brutalism, neumorphism, bento grid, dark mode), color systems, typography, accessibility, animation, layout, interaction states, and UX best practices."
license: MIT
metadata:
  author: nextlevelbuilder
  source: https://ui-ux-pro-max-skill.nextlevelbuilder.io
---

# UI UX Pro Max — Design Intelligence

Comprehensive design guide for web and mobile applications. Searchable database of UI styles, color palettes, font pairings, chart types, landing patterns, and UX guidelines.

Source: [ui-ux-pro-max-skill.nextlevelbuilder.io](https://ui-ux-pro-max-skill.nextlevelbuilder.io)

---

## When to Apply

### Must Use

- Designing new pages (Landing Page, Dashboard, Admin, SaaS, Mobile App)
- Creating or refactoring UI components (buttons, modals, forms, tables, charts)
- Choosing color schemes, typography systems, spacing standards, or layout systems
- Reviewing UI code for user experience, accessibility, or visual consistency
- Implementing navigation structures, animations, or responsive behavior
- Making product-level design decisions (style, information hierarchy, brand expression)
- Improving perceived quality, clarity, or usability of interfaces

### Recommended

- UI looks "not professional enough" but the reason is unclear
- Receiving feedback on usability or experience
- Pre-launch UI quality optimization
- Aligning cross-platform design (Web / iOS / Android)
- Building design systems or reusable component libraries

### Skip

- Pure backend logic development
- Only involving API or database design
- Performance optimization unrelated to the interface
- Infrastructure or DevOps work
- Non-visual scripts or automation tasks

**Decision criteria**: If the task will change how a feature **looks, feels, moves, or is interacted with**, this Skill should be used.

---

## Rule Categories by Priority

| Priority | Category | Impact | Key Checks (Must Have) | Anti-Patterns (Avoid) |
|----------|----------|--------|----------------------|----------------------|
| 1 | Accessibility | CRITICAL | Contrast 4.5:1, Alt text, Keyboard nav, Aria-labels | Removing focus rings, Icon-only buttons without labels |
| 2 | Touch & Interaction | CRITICAL | Min size 44×44px, 8px+ spacing, Loading feedback | Reliance on hover only, Instant state changes (0ms) |
| 3 | Performance | HIGH | WebP/AVIF, Lazy loading, Reserve space (CLS < 0.1) | Layout thrashing, Cumulative Layout Shift |
| 4 | Style Selection | HIGH | Match product type, Consistency, SVG icons (no emoji) | Mixing flat & skeuomorphic randomly, Emoji as icons |
| 5 | Layout & Responsive | HIGH | Mobile-first breakpoints, Viewport meta, No horizontal scroll | Horizontal scroll, Fixed px container widths, Disable zoom |
| 6 | Typography & Color | MEDIUM | Base 16px, Line-height 1.5, Semantic color tokens | Text < 12px body, Gray-on-gray, Raw hex in components |
| 7 | Animation | MEDIUM | Duration 150–300ms, Motion conveys meaning, Spatial continuity | Decorative-only animation, Animating width/height, No reduced-motion |
| 8 | Forms & Feedback | MEDIUM | Visible labels, Error near field, Helper text, Progressive disclosure | Placeholder-only label, Errors only at top, Overwhelm upfront |
| 9 | Navigation Patterns | HIGH | Predictable back, Bottom nav ≤5, Deep linking | Overloaded nav, Broken back behavior, No deep links |
| 10 | Charts & Data | LOW | Legends, Tooltips, Accessible colors | Relying on color alone to convey meaning |

---

## Quick Reference

### 1. Accessibility (CRITICAL)

- `color-contrast` — Minimum 4.5:1 ratio for normal text (large text 3:1)
- `focus-states` — Visible focus rings on interactive elements (2–4px)
- `alt-text` — Descriptive alt text for meaningful images
- `aria-labels` — `aria-label` for icon-only buttons; `accessibilityLabel` in native
- `keyboard-nav` — Tab order matches visual order; full keyboard support
- `form-labels` — Use `<label>` with `for` attribute
- `skip-links` — Skip to main content for keyboard users
- `heading-hierarchy` — Sequential h1→h6, no level skip
- `color-not-only` — Don't convey info by color alone (add icon/text)
- `dynamic-type` — Support system text scaling; avoid truncation as text grows
- `reduced-motion` — Respect `prefers-reduced-motion`; reduce/disable animations
- `voiceover-sr` — Meaningful `accessibilityLabel`/`accessibilityHint`; logical reading order
- `escape-routes` — Provide cancel/back in modals and multi-step flows
- `keyboard-shortcuts` — Preserve system and a11y shortcuts

### 2. Touch & Interaction (CRITICAL)

- `touch-target-size` — Min 44×44pt (Apple) / 48×48dp (Material)
- `touch-spacing` — Minimum 8px/8dp gap between touch targets
- `hover-vs-tap` — Use click/tap for primary interactions; don't rely on hover alone
- `loading-buttons` — Disable button during async operations; show spinner or progress
- `error-feedback` — Clear error messages near problem
- `cursor-pointer` — Add `cursor-pointer` to clickable elements (Web)
- `gesture-conflicts` — Avoid horizontal swipe on main content; prefer vertical scroll
- `tap-delay` — Use `touch-action: manipulation` to reduce 300ms delay (Web)
- `standard-gestures` — Use platform standard gestures consistently
- `system-gestures` — Don't block system gestures (Control Center, back swipe)
- `press-feedback` — Visual feedback on press (ripple/highlight)
- `haptic-feedback` — Use haptic for confirmations and important actions
- `gesture-alternative` — Always provide visible controls for critical actions
- `safe-area-awareness` — Keep primary touch targets away from notch, Dynamic Island, gesture bar
- `no-precision-required` — Avoid requiring pixel-perfect taps on small icons
- `swipe-clarity` — Swipe actions must show clear affordance or hint
- `drag-threshold` — Use a movement threshold before starting drag

### 3. Performance (HIGH)

- `image-optimization` — Use WebP/AVIF, responsive images (srcset/sizes), lazy load
- `image-dimension` — Declare width/height or use `aspect-ratio` to prevent CLS
- `font-loading` — Use `font-display: swap/optional` to avoid FOIT
- `font-preload` — Preload only critical fonts
- `critical-css` — Prioritize above-the-fold CSS
- `lazy-loading` — Lazy load non-hero components via dynamic import
- `bundle-splitting` — Split code by route/feature to reduce initial load
- `third-party-scripts` — Load async/defer; audit unnecessary ones
- `reduce-reflows` — Batch DOM reads then writes
- `content-jumping` — Reserve space for async content
- `lazy-load-below-fold` — Use `loading="lazy"` for below-the-fold images
- `virtualize-lists` — Virtualize lists with 50+ items
- `main-thread-budget` — Keep per-frame work under ~16ms for 60fps
- `progressive-loading` — Use skeleton screens / shimmer for >1s operations
- `input-latency` — Keep input latency under ~100ms for taps/scrolls
- `tap-feedback-speed` — Provide visual feedback within 100ms of tap
- `debounce-throttle` — Use debounce/throttle for high-frequency events
- `offline-support` — Provide offline state messaging and basic fallback
- `network-fallback` — Offer degraded modes for slow networks

### 4. Style Selection (HIGH)

- `style-match` — Match style to product type (SaaS → minimal/flat, gaming → vibrant/glass, etc.)
- `consistency` — Use same style across all pages
- `no-emoji-icons` — Use SVG icons (Heroicons, Lucide, Phosphor), not emojis
- `color-palette-from-product` — Choose palette from product/industry
- `effects-match-style` — Shadows, blur, radius aligned with chosen style (glass / flat / clay)
- `platform-adaptive` — Respect platform idioms (iOS HIG vs Material)
- `state-clarity` — Make hover/pressed/disabled states visually distinct
- `elevation-consistent` — Use a consistent elevation/shadow scale
- `dark-mode-pairing` — Design light/dark variants together
- `icon-style-consistent` — Use one icon set/visual language across the product
- `system-controls` — Prefer native/system controls over fully custom ones
- `blur-purpose` — Use blur to indicate background dismissal (modals, sheets), not as decoration
- `primary-action` — Each screen should have only one primary CTA

### 5. Layout & Responsive (HIGH)

- `viewport-meta` — `width=device-width, initial-scale=1` (never disable zoom)
- `mobile-first` — Design mobile-first, then scale up
- `breakpoint-consistency` — Use systematic breakpoints (375 / 768 / 1024 / 1440)
- `readable-font-size` — Minimum 16px body text on mobile
- `line-length-control` — Mobile 35–60 chars per line; desktop 60–75 chars
- `horizontal-scroll` — No horizontal scroll on mobile
- `spacing-scale` — Use 4pt/8dp incremental spacing system
- `touch-density` — Keep component spacing comfortable for touch
- `container-width` — Consistent max-width on desktop (max-w-6xl / 7xl)
- `z-index-management` — Define layered z-index scale (0 / 10 / 20 / 40 / 100 / 1000)
- `fixed-element-offset` — Fixed navbar/bottom bar must reserve safe padding
- `scroll-behavior` — Avoid nested scroll regions
- `viewport-units` — Prefer `min-h-dvh` over `100vh` on mobile
- `orientation-support` — Keep layout readable in landscape mode
- `content-priority` — Show core content first on mobile
- `visual-hierarchy` — Establish hierarchy via size, spacing, contrast

### 6. Typography & Color (MEDIUM)

- `line-height` — Use 1.5–1.75 for body text
- `line-length` — Limit to 65–75 characters per line
- `font-pairing` — Match heading/body font personalities
- `font-scale` — Consistent type scale (12 14 16 18 24 32)
- `contrast-readability` — Darker text on light backgrounds (e.g. slate-900 on white)
- `text-styles-system` — Use platform type system (display, headline, title, body, label)
- `weight-hierarchy` — Bold headings (600–700), Regular body (400), Medium labels (500)
- `color-semantic` — Define semantic color tokens (primary, secondary, error, surface)
- `color-dark-mode` — Dark mode uses desaturated/lighter tonal variants, not inverted
- `color-accessible-pairs` — Foreground/background must meet 4.5:1 (AA) or 7:1 (AAA)
- `color-not-decorative-only` — Functional color must include icon/text
- `truncation-strategy` — Prefer wrapping; when truncating use ellipsis + tooltip
- `letter-spacing` — Respect default letter-spacing per platform
- `number-tabular` — Use tabular/monospaced figures for data columns and prices
- `whitespace-balance` — Use whitespace intentionally to group related items

### 7. Animation (MEDIUM)

- `duration-timing` — Use 150–300ms for micro-interactions; complex ≤400ms
- `transform-performance` — Use `transform`/`opacity` only; avoid animating width/height/top/left
- `loading-states` — Show skeleton or progress when loading exceeds 300ms
- `excessive-motion` — Animate 1–2 key elements per view max
- `easing` — Use `ease-out` for entering, `ease-in` for exiting; avoid linear
- `motion-meaning` — Every animation must express a cause-effect relationship
- `state-transition` — State changes should animate smoothly, not snap
- `continuity` — Page/screen transitions should maintain spatial continuity
- `parallax-subtle` — Use parallax sparingly; respect reduced-motion
- `spring-physics` — Prefer spring/physics-based curves for natural feel
- `exit-faster-than-enter` — Exit animations ~60–70% of enter duration
- `stagger-sequence` — Stagger list/grid item entrance by 30–50ms per item
- `shared-element-transition` — Use shared element / hero transitions
- `interruptible` — Animations must be interruptible by user tap
- `no-blocking-animation` — Never block user input during animation
- `fade-crossfade` — Use crossfade for content replacement
- `scale-feedback` — Subtle scale (0.95–1.05) on press for tappable cards/buttons
- `motion-consistency` — Unify duration/easing tokens globally
- `modal-motion` — Modals/sheets should animate from their trigger source
- `layout-shift-avoid` — Use transform for position changes to avoid CLS

### 8. Forms & Feedback (MEDIUM)

- `input-labels` — Visible label per input (not placeholder-only)
- `error-placement` — Show error below the related field
- `submit-feedback` — Loading → success/error state on submit
- `required-indicators` — Mark required fields (e.g. asterisk)
- `empty-states` — Helpful message and action when no content
- `toast-dismiss` — Auto-dismiss toasts in 3–5s
- `confirmation-dialogs` — Confirm before destructive actions
- `input-helper-text` — Provide persistent helper text below complex inputs
- `disabled-states` — Reduced opacity (0.38–0.5) + cursor change + semantic attribute
- `progressive-disclosure` — Reveal complex options progressively
- `inline-validation` — Validate on blur (not keystroke)
- `input-type-keyboard` — Use semantic input types (email, tel, number)
- `password-toggle` — Provide show/hide toggle for password fields
- `autofill-support` — Use `autocomplete` / `textContentType` attributes
- `undo-support` — Allow undo for destructive or bulk actions
- `success-feedback` — Confirm completed actions with brief visual feedback
- `error-recovery` — Error messages must include a clear recovery path
- `multi-step-progress` — Show step indicator or progress bar
- `error-clarity` — State cause + how to fix (not just "Invalid input")
- `field-grouping` — Group related fields logically
- `focus-management` — Auto-focus the first invalid field after error
- `error-summary` — Show summary at top with anchor links to each field
- `touch-friendly-input` — Mobile input height ≥44px
- `destructive-emphasis` — Destructive actions use semantic danger color (red)
- `toast-accessibility` — Use `aria-live="polite"` for screen reader announcement

### 9. Navigation Patterns (HIGH)

- `bottom-nav-limit` — Bottom navigation max 5 items; use labels with icons
- `drawer-usage` — Use drawer/sidebar for secondary navigation
- `back-behavior` — Predictable and consistent; preserve scroll/state
- `deep-linking` — All key screens reachable via deep link / URL
- `nav-label-icon` — Navigation items must have both icon and text label
- `nav-state-active` — Current location must be visually highlighted
- `nav-hierarchy` — Primary vs secondary nav clearly separated
- `modal-escape` — Modals/sheets must offer clear close/dismiss affordance
- `search-accessible` — Search must be easily reachable
- `breadcrumb-web` — Use breadcrumbs for 3+ level deep hierarchies
- `state-preservation` — Navigating back must restore scroll position and state
- `gesture-nav-support` — Support system gesture navigation without conflict
- `tab-badge` — Use badges sparingly; clear after user visits
- `overflow-menu` — Use overflow/more menu instead of cramming
- `adaptive-navigation` — Large screens (≥1024px) prefer sidebar
- `back-stack-integrity` — Never silently reset the navigation stack
- `navigation-consistency` — Navigation placement stays the same across all pages
- `avoid-mixed-patterns` — Don't mix Tab + Sidebar + Bottom Nav at same level
- `modal-vs-navigation` — Modals not for primary navigation flows
- `persistent-nav` — Core navigation must remain reachable from deep pages

### 10. Charts & Data (LOW)

- `chart-type` — Match chart type to data (trend→line, comparison→bar, proportion→pie/donut)
- `color-guidance` — Use accessible color palettes; avoid red/green only pairs
- `data-table` — Provide table alternative for accessibility
- `pattern-texture` — Supplement color with patterns/shapes
- `legend-visible` — Always show legend; position near the chart
- `tooltip-on-interact` — Provide tooltips on hover (Web) or tap (mobile)
- `axis-labels` — Label axes with units and readable scale
- `responsive-chart` — Charts must reflow on small screens
- `empty-data-state` — Show meaningful empty state when no data
- `loading-chart` — Use skeleton/shimmer while chart data loads
- `animation-optional` — Chart entrance animations must respect reduced-motion
- `large-dataset` — Aggregate or sample for 1000+ data points
- `number-formatting` — Use locale-aware formatting for numbers/dates
- `touch-target-chart` — Interactive chart elements must have ≥44pt tap area
- `no-pie-overuse` — Avoid pie/donut for >5 categories
- `contrast-data` — Data lines/bars vs background ≥3:1
- `legend-interactive` — Legends should be clickable to toggle series
- `direct-labeling` — Label values directly on chart for small datasets
- `tooltip-keyboard` — Tooltips must be keyboard-reachable
- `sortable-table` — Support sorting with `aria-sort`
- `trend-emphasis` — Emphasize data trends over decoration
- `gridline-subtle` — Grid lines should be low-contrast
- `screen-reader-summary` — Provide text summary describing key insight

---

## Common Rules for Professional UI

These are frequently overlooked issues that make UI look unprofessional.

### Icons & Visual Elements

| Rule | Standard | Avoid | Why |
|------|----------|-------|-----|
| **No Emoji as Icons** | Use SVG icons (Heroicons, Lucide, Phosphor) | Emojis (🎨🚀⚙️) for navigation/settings | Font-dependent, inconsistent across platforms |
| **Vector-Only Assets** | SVG or platform vector icons | Raster PNG that blur | Scalability, crisp rendering, theming |
| **Stable Interaction States** | Color/opacity/elevation for press states | Layout-shifting transforms | Prevents jitter and unstable interactions |
| **Consistent Icon Sizing** | Define as design tokens (icon-sm/md/lg) | Arbitrary values 20/24/28pt | Maintains rhythm and visual hierarchy |
| **Stroke Consistency** | Same stroke width per visual layer | Mixing thick and thin arbitrarily | Reduces perceived polish |
| **Filled vs Outline** | One icon style per hierarchy level | Mixing filled and outline at same level | Maintains semantic clarity |
| **Touch Target** | Min 44×44pt interactive area | Small icons without expanded tap area | Accessibility and platform standards |
| **Icon Alignment** | Align to text baseline | Misaligned icons or inconsistent padding | Prevents visual imbalance |

### Light/Dark Mode Contrast

| Rule | Do | Don't |
|------|----|-------|
| **Surface readability (light)** | Cards/surfaces clearly separated from background | Overly transparent surfaces |
| **Text contrast (light)** | Body text ≥4.5:1 against light surfaces | Low-contrast gray body text |
| **Text contrast (dark)** | Primary ≥4.5:1, secondary ≥3:1 on dark surfaces | Dark mode text blending into background |
| **Border visibility** | Separators visible in both themes | Disappearing in one mode |
| **State contrast** | Pressed/focused/disabled equally distinguishable | Interaction states for one theme only |
| **Token-driven theming** | Semantic color tokens per theme | Hardcoded per-screen hex values |
| **Scrim legibility** | Modal scrim 40-60% black | Weak scrim leaving background competing |

### Layout & Spacing

| Rule | Do | Don't |
|------|----|-------|
| **Safe-area compliance** | Respect safe areas for fixed UI | Placing UI under notch/gesture area |
| **System bar clearance** | Space for status/nav bars and home indicator | Content colliding with OS chrome |
| **Consistent content width** | Predictable width per device class | Arbitrary widths between screens |
| **8dp spacing rhythm** | 4/8dp spacing system | Random spacing increments |
| **Readable text measure** | Avoid edge-to-edge paragraphs | Full-width long text hurting readability |
| **Section spacing** | Clear vertical rhythm tiers (16/24/32/48) | Inconsistent spacing |
| **Adaptive gutters** | Wider insets on larger screens | Same narrow gutter on all sizes |

---

## Pre-Delivery Checklist

### Visual Quality
- [ ] No emojis used as icons (use SVG instead)
- [ ] All icons come from a consistent icon family and style
- [ ] Official brand assets with correct proportions and clear space
- [ ] Pressed-state visuals do not shift layout bounds or cause jitter
- [ ] Semantic theme tokens used consistently (no hardcoded per-screen colors)

### Interaction
- [ ] All tappable elements provide clear pressed feedback
- [ ] Touch targets meet minimum size (≥44x44pt iOS, ≥48x48dp Android)
- [ ] Micro-interaction timing stays in 150-300ms range
- [ ] Disabled states are visually clear and non-interactive
- [ ] Screen reader focus order matches visual order
- [ ] Gesture regions avoid nested/conflicting interactions

### Light/Dark Mode
- [ ] Primary text contrast ≥4.5:1 in both modes
- [ ] Secondary text contrast ≥3:1 in both modes
- [ ] Dividers/borders and interaction states distinguishable in both modes
- [ ] Modal/drawer scrim opacity strong enough (40-60% black)
- [ ] Both themes tested before delivery

### Layout
- [ ] Safe areas respected for headers, tab bars, and bottom CTA bars
- [ ] Scroll content not hidden behind fixed/sticky bars
- [ ] Verified on small phone, large phone, and tablet
- [ ] Horizontal insets/gutters adapt correctly by device size
- [ ] 4/8dp spacing rhythm maintained across all levels
- [ ] Long-form text readable on larger devices

### Accessibility
- [ ] All meaningful images/icons have accessibility labels
- [ ] Form fields have labels, hints, and clear error messages
- [ ] Color is not the only indicator
- [ ] Reduced motion and dynamic text size supported
- [ ] Accessibility traits/roles/states announced correctly

---

## Workflow: How to Use This Skill

### Step 1: Analyze Requirements
Extract key info from user request:
- **Product type**: SaaS, e-commerce, healthcare, fintech, portfolio, entertainment, service, etc.
- **Target audience**: Consumer, business, age group, usage context
- **Style keywords**: playful, vibrant, minimal, dark mode, content-first, immersive
- **Stack**: React, Next.js, Vue, Svelte, Tailwind, SwiftUI, React Native, Flutter

### Step 2: Design System (Required)
Generate comprehensive recommendations covering:
1. **Style** — Match to product type and brand personality
2. **Color palette** — Primary, secondary, CTA, background, text, border
3. **Typography** — Font pairings with hierarchy and scale
4. **Landing pattern** — Page structure with CTA placement
5. **UX rules** — Critical/high priority guidelines to follow

### Step 3: Detailed Design (As Needed)
Deep-dive into specific domains:
- **Style**: glassmorphism, minimalism, brutalism, neumorphism, bento grid, claymorphism, dark mode
- **Color**: SaaS palettes, e-commerce, healthcare, fintech, beauty
- **Typography**: Google Fonts pairings, mood-based recommendations
- **Landing**: Hero-centric, video-first, social-proof, pricing, testimonial
- **Charts**: Line, bar, pie, heatmap, area with library suggestions
- **UX**: Animation, accessibility, z-index, loading states, forms

### Step 4: Quality Review
Run through Quick Reference §1–§3 (CRITICAL + HIGH priorities) as a final review:
- [ ] Accessibility — contrast, focus, keyboard, aria
- [ ] Touch & Interaction — target sizes, feedback, gestures
- [ ] Performance — images, fonts, lazy loading, CLS
- [ ] Test on 375px (small phone) and landscape orientation
- [ ] Verify with `prefers-reduced-motion` enabled
- [ ] Check dark mode contrast independently
- [ ] Confirm all touch targets ≥44pt
