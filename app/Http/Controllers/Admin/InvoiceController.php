<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function download(Booking $booking)
    {
        $pdf = Pdf::loadView('admin.bookings.invoice', compact('booking'));

        return $pdf->download('invoice-'.$booking->booking_code.'.pdf');
    }

    public function view(Booking $booking)
    {
        $pdf = Pdf::loadView('admin.bookings.invoice', compact('booking'));

        return $pdf->stream('invoice-'.$booking->booking_code.'.pdf');
    }
}
