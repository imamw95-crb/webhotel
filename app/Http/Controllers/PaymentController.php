<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\WebsiteSetting;

class PaymentController extends Controller
{
    /**
     * Show general payment information page.
     */
    public function index()
    {
        // Load bank accounts from settings
        $bankAccounts = [];
        for ($i = 1; $i <= 2; $i++) {
            $name = WebsiteSetting::getValue("bank_name_{$i}");
            $account = WebsiteSetting::getValue("bank_account_{$i}");
            $holder = WebsiteSetting::getValue("bank_holder_{$i}");
            if ($name && $account) {
                $bankAccounts[] = [
                    'name' => $name,
                    'account' => $account,
                    'holder' => $holder,
                ];
            }
        }

        $whatsapp = WebsiteSetting::getValue('receptionist_phone', WebsiteSetting::getValue('whatsapp', ''));
        $phone = WebsiteSetting::getValue('phone', '');
        $hotelName = WebsiteSetting::getValue('hotel_name', 'The Icon Hotel');

        return view('payment.index', compact('bankAccounts', 'whatsapp', 'phone', 'hotelName'));
    }

    /**
     * Show payment page for a booking (Bank Transfer).
     */
    public function pay(Booking $booking)
    {
        if ($booking->payment_status === 'paid') {
            return redirect()->route('booking.track', ['booking_code' => $booking->booking_code])
                ->with('success', 'This booking has already been paid.');
        }

        // Load bank accounts from settings
        $bankAccounts = [];
        for ($i = 1; $i <= 2; $i++) {
            $name = WebsiteSetting::getValue("bank_name_{$i}");
            $account = WebsiteSetting::getValue("bank_account_{$i}");
            $holder = WebsiteSetting::getValue("bank_holder_{$i}");
            if ($name && $account) {
                $bankAccounts[] = [
                    'name' => $name,
                    'account' => $account,
                    'holder' => $holder,
                ];
            }
        }

        $whatsapp = WebsiteSetting::getValue('receptionist_phone', WebsiteSetting::getValue('whatsapp', ''));
        $phone = WebsiteSetting::getValue('phone', '');

        return view('payment.pay', compact('booking', 'bankAccounts', 'whatsapp', 'phone'));
    }
}
