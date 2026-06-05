<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\Facility;
use App\Models\GalleryImage;
use App\Models\RoomType;
use App\Services\PmsApiService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'room_types' => RoomType::count(),
            'facilities' => Facility::count(),
            'gallery_images' => GalleryImage::count(),
            'unread_contacts' => Contact::unread()->count(),
            'total_contacts' => Contact::count(),
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::pending()->count(),
            'confirmed_bookings' => Booking::confirmed()->count(),
        ];

        $recentContacts = Contact::orderBy('created_at', 'desc')->take(5)->get();
        $recentBookings = Booking::recent()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentContacts', 'recentBookings'));
    }

    /**
     * Trigger sinkronisasi harga dari PMS.
     */
    public function syncPrices(Request $request, PmsApiService $pms)
    {
        $result = $pms->syncRoomTypePrices();

        if ($result['updated'] > 0) {
            return redirect()->route('admin.dashboard')
                ->with('success', "Harga berhasil disinkronisasi. {$result['updated']} tipe kamar diupdate.");
        }

        if (! empty($result['errors'])) {
            return redirect()->route('admin.dashboard')
                ->with('warning', 'Sinkronisasi selesai, tetapi ada beberapa masalah: '.implode(', ', $result['errors']));
        }

        return redirect()->route('admin.dashboard')
            ->with('info', 'Semua harga sudah sesuai dengan PMS. Tidak ada perubahan.');
    }
}
