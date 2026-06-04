<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\Facility;
use App\Models\GalleryImage;
use App\Models\RoomType;

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
}
