<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\BookingStatusChanged;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::query();

        // Search by name, email, phone, or booking code
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('booking_code', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        // Filter by payment status
        if ($paymentStatus = $request->get('payment_status')) {
            $query->where('payment_status', $paymentStatus);
        }

        // Filter by date range
        if ($dateFrom = $request->get('date_from')) {
            $query->whereDate('check_in', '>=', $dateFrom);
        }
        if ($dateTo = $request->get('date_to')) {
            $query->whereDate('check_out', '<=', $dateTo);
        }

        $bookings = $query->recent()->paginate(20);

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
