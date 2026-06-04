# Agent Copilot — The Icon Hotel (WebHotel)

## Overview

Hotel booking site (Laravel 13). Guests browse rooms, check PMS availability, book, pay (bank/Midtrans), track. Admin manages rooms, facilities, gallery, sections, settings, bookings.

## Stack

| Layer | Tech |
|---|---|
| Backend | Laravel 13 (PHP 8.3) |
| Frontend | Blade, Tailwind v4, Alpine v3 |
| Bundler | Vite 8 + `@tailwindcss/vite` |
| Payment | Midtrans (midtrans-php) |
| PDF | barryvdh/laravel-dompdf |
| Email | Laravel Mail (log/smtp) |
| API | PMS API (availability, reservations) |
| DB | MySQL |

## Dependencies

**composer:** `laravel/framework ^13.8`, `laravel/boost ^2.4`, `midtrans/midtrans-php ^2.6`, `barryvdh/laravel-dompdf ^3.1`, `guzzlehttp/guzzle ^7.10`, `laravel/pint ^1.27`, `phpunit/phpunit ^12.5.12`

**package:** `tailwindcss ^4.0`, `@tailwindcss/vite ^4.0`, `alpinejs ^3.15`, `@alpinejs/collapse ^3.15`, `vite ^8.0`, `laravel-vite-plugin ^3.1`

## Structure

```
app/
├── Http/Controllers/
│   ├── Admin/ — Booking, Dashboard, Facility, Gallery,
│   │            Invoice, PageSection, RoomType, Setting
│   ├── HomeController.php — public pages & booking flow
│   └── PaymentController.php
├── Mail/ — BookingConfirmation, BookingAdminNotification, BookingStatusChanged
├── Models/ — Booking, Contact, Facility, GalleryImage,
│             PageSection, RoomType, WebsiteSetting, User
├── Services/ — MidtransService, PmsApiService, ReCaptchaService
└── Providers/ — AppServiceProvider
resources/views/ — admin/, auth/, components/, emails/, home/, layouts/, payment/
routes/ — web.php (all routes), console.php
database/ — migrations/ (13 files), seeders/
```

## Models

| Model | Key Fillables | Scopes/Methods |
|---|---|---|
| `Booking` | booking_code, name, email, check_in/out, guests, total_amount, room_type/id, notes, status, payment_status/method, paid_at, source | pending(), confirmed(), cancelled(), recent(), byCode(). Auto-code: ICN+6chars |
| `RoomType` | code, name, desc, base_price, max_occ/adults/children, room_size, bed_config, image_path, gallery/facilities (JSON), sort, is_active | active(), ordered() |
| `Facility` | name, icon, desc, sort, is_active | active(), ordered() |
| `GalleryImage` | title, image_path, category, sort, is_active | active(), ordered(), byCategory() |
| `PageSection` | section_key, title, subtitle, content (JSON), sort, is_active | Static: getSection(), getAllActive(), clearCache(). Cached. |
| `WebsiteSetting` | key, value, type, group | Static: getValue(), setValue(), getGroup(), clearGroupCache(). Cached. |
| `Contact` | name, email, phone, subject, message, is_read | unread(), markAsRead() |
| `User` | name, username, email, password | Auth via email OR username |

## Routes

**Public:** `GET /` (home), `POST /contact` (throttle:5,10), `POST /booking` (throttle:3,5), `GET /api/check-availability`, `GET /booking/track`, `GET /booking/{b}/confirmation`, `GET /payment/{b}`, `POST /payment/notification`, `GET /payment/success|failed`

**Admin (auth):** CRUD room-types/facilities/gallery, sections (GET/PUT), settings (GET/POST), bookings (GET/PATCH/DELETE), invoice (GET + download)

**Auth:** `GET/POST /login` (email or username), `POST /logout`

## Services

- **PmsApiService** — HTTP client with X-API-Key. Methods: `getRooms()`, `getAvailableRooms(in,out)`, `getRoomTypes()`, `createReservation(data)`, `clearCache()`. Cached 300s.
- **MidtransService** — `getSnapToken(booking)`, `handleNotification(array)`. OrderID: `BOOK-{CODE}-{ts}`. Handles: capture, settlement, deny, cancel, expire, pending.
- **ReCaptchaService** — Google reCAPTCHA v2 verification.

## Flows

**Booking:** Form → POST `/booking` → honeypot check → validate + PMS availability → price calc (PMS × nights) → save DB (pending) → emails (guest+admin) → PMS reservation (best-effort) → redirect `/payment/{booking}` → admin confirm/cancel → status email.

**Payment:** Bank transfer (show accounts, admin confirms) | Midtrans (Snap token, webhook updates status).

**Admin Dashboard:** Stats (rooms, facilities, gallery, contacts, bookings). Manage all entities. Edit sections (hero, about, rooms, facilities, gallery, contact). Settings (hotel name, contact, social, SEO, bank). PDF invoices.

## Conventions

- **PHP:** Constructor promotion, explicit return types, curly braces always, PHPDoc over inline, TitleCase enums, array-shape PHPDoc.
- **Blade:** `@extends` + `@section` layouts, components in `components/`, settings via `{{ $settings['key'] ?? default }}`, fonts: Playfair Display (`font-display`) + Inter.
- **Tailwind v4:** `@theme` in CSS (no config file), `@import "tailwindcss"`, `@tailwindcss/vite` plugin.
- **Alpine:** CDN (`https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js`), npm `@alpinejs/collapse`.
- **Vite:** Input `resources/css/app.css` + `resources/js/app.js`. Build: `npm run build`, Dev: `npm run dev`.

## Artisan

`migrate`, `db:seed`, `storage:link`, `make:model -mf`, `make:test {name}`, `make:mail {name}`, `route:list`, `config:show {key}`, `pail`

## Testing

PHPUnit (not Pest). `php artisan make:test --phpunit {name}`. Prefer feature tests. Run: `php artisan test --compact`, single: `--filter=testName`. Use factory states.

## Code Style

`vendor/bin/pint --dirty --format agent` after edits. Follow sibling patterns.

## Boost

Laravel Boost MCP (`boost.json`). agents:copilot, mcp:true, guidelines:true. Skills: laravel-best-practices, tailwindcss-development. Tools: database-query, database-schema, search-docs, get-absolute-url, browser-logs.

## Deployment

[Laravel Cloud](https://cloud.laravel.com/). PHP 8.3+. `npm run build` for assets.
