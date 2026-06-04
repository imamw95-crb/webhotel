<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\User;
use App\Models\WebsiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Set up bank account settings
        WebsiteSetting::setValue('bank_name_1', 'Bank Mandiri');
        WebsiteSetting::setValue('bank_account_1', '123-456-7890');
        WebsiteSetting::setValue('bank_holder_1', 'PT The Icon Hotel');
        WebsiteSetting::setValue('bank_name_2', 'BCA');
        WebsiteSetting::setValue('bank_account_2', '098-765-4321');
        WebsiteSetting::setValue('bank_holder_2', 'PT The Icon Hotel');
        WebsiteSetting::setValue('receptionist_phone', '08123456789');
        WebsiteSetting::setValue('phone', '0265123456');
        WebsiteSetting::setValue('hotel_name', 'The Icon Hotel');
    }

    public function test_payment_index_page_loads()
    {
        $response = $this->get(route('payment.index'));

        $response->assertStatus(200);
        $response->assertSee('Bank Mandiri');
        $response->assertSee('BCA');
    }

    public function test_payment_page_shows_booking_details()
    {
        $booking = Booking::create([
            'name' => 'Payment Test',
            'email' => 'payment@example.com',
            'phone' => '08123456703',
            'check_in' => '2026-12-01',
            'check_out' => '2026-12-03',
            'guests' => 2,
            'total_amount' => 700000,
            'room_type' => 'Standard',
            'room_id' => 1,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'source' => 'website',
        ]);

        $response = $this->get(route('payment.pay', $booking));

        $response->assertStatus(200);
        $response->assertSee($booking->name);
        $response->assertSee(number_format($booking->total_amount, 0, ',', '.'));
    }

    public function test_payment_page_redirects_if_already_paid()
    {
        $booking = Booking::create([
            'name' => 'Paid Test',
            'email' => 'paid@example.com',
            'phone' => '08123456704',
            'check_in' => '2026-12-01',
            'check_out' => '2026-12-03',
            'guests' => 2,
            'total_amount' => 700000,
            'room_type' => 'Standard',
            'room_id' => 1,
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'paid_at' => now(),
            'source' => 'website',
        ]);

        $response = $this->get(route('payment.pay', $booking));

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_admin_booking_list_shows_payment_status()
    {
        $booking = Booking::create([
            'name' => 'Admin View',
            'email' => 'adminview@example.com',
            'phone' => '08123456705',
            'check_in' => '2026-12-01',
            'check_out' => '2026-12-03',
            'guests' => 2,
            'total_amount' => 700000,
            'room_type' => 'Standard',
            'room_id' => 1,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'source' => 'website',
        ]);

        // Need auth to access admin
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('admin.bookings.index'));

        $response->assertStatus(200);
        $response->assertSee($booking->name);
        $response->assertSee($booking->booking_code);
    }

    public function test_admin_can_confirm_booking()
    {
        $booking = Booking::create([
            'name' => 'Confirm Admin',
            'email' => 'confirmadmin@example.com',
            'phone' => '08123456706',
            'check_in' => '2026-12-10',
            'check_out' => '2026-12-12',
            'guests' => 2,
            'total_amount' => 700000,
            'room_type' => 'Standard',
            'room_id' => 1,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'source' => 'website',
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->patch(route('admin.bookings.confirm', $booking));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'confirmed',
        ]);
    }

    public function test_admin_can_cancel_booking()
    {
        $booking = Booking::create([
            'name' => 'Cancel Admin',
            'email' => 'canceladmin@example.com',
            'phone' => '08123456707',
            'check_in' => '2026-12-15',
            'check_out' => '2026-12-17',
            'guests' => 2,
            'total_amount' => 700000,
            'room_type' => 'Standard',
            'room_id' => 1,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'source' => 'website',
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->patch(route('admin.bookings.cancel', $booking));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'cancelled',
        ]);
    }
}
