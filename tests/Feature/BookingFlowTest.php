<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\RoomType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class BookingFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a room type for fallback
        RoomType::create([
            'code' => 'STD',
            'name' => 'Standard',
            'base_price' => 350000,
            'is_active' => true,
            'sort_order' => 1,
        ]);
    }

    public function test_home_page_loads_successfully()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_track_booking_page_loads()
    {
        $response = $this->get(route('booking.track'));

        $response->assertStatus(200);
    }

    public function test_booking_submission_validates_required_fields()
    {
        $response = $this->post(route('booking.submit'), []);

        $response->assertSessionHasErrors(['name', 'email', 'phone', 'check_in', 'check_out', 'guests']);
    }

    public function test_booking_submission_rejects_invalid_dates()
    {
        $response = $this->post(route('booking.submit'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '08123456789',
            'check_in' => '2026-06-10',
            'check_out' => '2026-06-08', // before check_in
            'guests' => 2,
        ]);

        $response->assertSessionHasErrors(['check_out']);
    }

    public function test_booking_submission_rejects_past_check_in()
    {
        $response = $this->post(route('booking.submit'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '08123456789',
            'check_in' => '2020-01-01',
            'check_out' => '2020-01-05',
            'guests' => 2,
        ]);

        $response->assertSessionHasErrors(['check_in']);
    }

    public function test_booking_is_created_and_redirects_to_confirmation()
    {
        // Fake all PMS API endpoints (availability check + reservation creation)
        Http::fake([
            '*/api/rooms/available*' => Http::response([
                'data' => [
                    [
                        'id' => 1,
                        'room_number' => '101',
                        'room_type_name' => 'Standard',
                        'price_per_night' => 350000,
                        'max_occupancy' => 2,
                    ],
                ],
            ]),
            '*/api/reservations*' => Http::response([
                'success' => true,
                'data' => ['reservation_number' => 'PMS-001'],
            ]),
        ]);

        $response = $this->post(route('booking.submit'), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '08123456788',
            'check_in' => '2026-07-01',
            'check_out' => '2026-07-03',
            'guests' => 2,
            'room_type' => 'Standard',
        ]);

        $response->assertRedirect();

        // Assert booking exists - check scalar fields first, date fields separately
        $this->assertDatabaseHas('bookings', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'guests' => 2,
            'room_type' => 'Standard',
            'room_id' => 1,
            'total_amount' => 700000, // 350000 * 2 nights
            'status' => 'pending',
            'source' => 'website',
        ]);

        $booking = Booking::where('name', 'Jane Doe')->first();
        $this->assertNotNull($booking);
        $this->assertEquals('2026-07-01', $booking->check_in->format('Y-m-d'));
        $this->assertEquals('2026-07-03', $booking->check_out->format('Y-m-d'));
    }

    public function test_booking_code_is_generated_automatically()
    {
        Http::fake([
            '*/api/rooms/available*' => Http::response([
                'data' => [
                    ['id' => 1, 'room_number' => '101', 'room_type_name' => 'Standard', 'price_per_night' => 350000, 'max_occupancy' => 2],
                ],
            ]),
            '*/api/reservations*' => Http::response([
                'success' => true,
                'data' => ['reservation_number' => 'PMS-002'],
            ]),
        ]);

        $response = $this->post(route('booking.submit'), [
            'name' => 'Code Test',
            'email' => 'code@example.com',
            'phone' => '08123456700',
            'check_in' => '2026-08-01',
            'check_out' => '2026-08-02',
            'guests' => 1,
        ]);

        $response->assertRedirect();
        $response->assertSessionDoesntHaveErrors();

        $booking = Booking::first();
        $this->assertNotNull($booking, 'Booking should be created in database');
        $this->assertNotNull($booking->booking_code);
        $this->assertStringStartsWith('ICN', $booking->booking_code);
        $this->assertEquals(9, strlen($booking->booking_code)); // ICN + 6 chars
    }

    public function test_honeypot_prevents_spam_submissions()
    {
        $response = $this->post(route('booking.submit'), [
            'website' => 'spam-bot-value',
            'name' => 'Bot',
            'email' => 'bot@example.com',
            'phone' => '08123456789',
            'check_in' => '2026-09-01',
            'check_out' => '2026-09-03',
            'guests' => 2,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // No booking should be created
        $this->assertDatabaseCount('bookings', 0);
    }

    public function test_honeypot_prevents_spam_contacts()
    {
        $response = $this->post(route('contact.submit'), [
            'website' => 'spam-value',
            'name' => 'Bot',
            'email' => 'bot@example.com',
            'message' => 'Spam message',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseCount('contacts', 0);
    }

    public function test_booking_confirmation_page_shows_booking_details()
    {
        $booking = Booking::create([
            'name' => 'Confirm Test',
            'email' => 'confirm@example.com',
            'phone' => '08123456701',
            'check_in' => '2026-10-01',
            'check_out' => '2026-10-05',
            'guests' => 3,
            'total_amount' => 1400000,
            'room_type' => 'Standard',
            'room_id' => 1,
            'status' => 'pending',
            'source' => 'website',
        ]);

        $response = $this->get(route('booking.confirmation', $booking));

        $response->assertStatus(200);
        $response->assertSee($booking->name);
        $response->assertSee($booking->booking_code);
    }

    public function test_booking_lookup_finds_by_code()
    {
        $booking = Booking::create([
            'name' => 'Lookup Test',
            'email' => 'lookup@example.com',
            'phone' => '08123456702',
            'check_in' => '2026-11-01',
            'check_out' => '2026-11-02',
            'guests' => 1,
            'total_amount' => 350000,
            'status' => 'pending',
            'source' => 'website',
        ]);

        $response = $this->post(route('booking.lookup'), [
            'booking_code' => $booking->booking_code,
        ]);

        $response->assertStatus(200);
        $response->assertSee($booking->name);
    }

    public function test_booking_lookup_returns_not_found_for_invalid_code()
    {
        $response = $this->post(route('booking.lookup'), [
            'booking_code' => 'INVALID123',
        ]);

        $response->assertSessionHasErrors(['booking_code']);
    }
}
