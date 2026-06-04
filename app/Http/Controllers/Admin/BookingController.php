<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\BookingStatusChanged;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::recent()->paginate(20);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }

    public function confirm(Booking $booking)
    {
        $booking->update(['status' => 'confirmed']);

        // Notify guest
        try {
            Mail::to($booking->email)->send(new BookingStatusChanged($booking));
        } catch (\Exception $e) {
            Log::warning('Failed to send status email', ['error' => $e->getMessage()]);
        }

        return redirect()->route('admin.bookings.index')->with('success', 'Booking confirmed successfully.');
    }

    public function cancel(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);

        // Notify guest
        try {
            Mail::to($booking->email)->send(new BookingStatusChanged($booking));
        } catch (\Exception $e) {
            Log::warning('Failed to send status email', ['error' => $e->getMessage()]);
        }

        return redirect()->route('admin.bookings.index')->with('success', 'Booking cancelled.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully.');
    }
}
