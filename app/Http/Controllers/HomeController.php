<?php

namespace App\Http\Controllers;

use App\Jobs\SyncPmsReservation;
use App\Mail\BookingAdminNotification;
use App\Mail\BookingConfirmation;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\Facility;
use App\Models\GalleryImage;
use App\Models\PageSection;
use App\Models\RoomType;
use App\Models\WebsiteSetting;
use App\Services\PmsApiService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index(PmsApiService $pms)
    {
        $sections = PageSection::getAllActive();
        $facilities = Facility::active()->ordered()->get();
        $galleryImages = GalleryImage::active()->ordered()->get();
        $roomTypes = RoomType::active()->ordered()->get();
        $pmsRoomTypes = $pms->getRoomTypes();
        $settings = [
            'hotel_name' => WebsiteSetting::getValue('hotel_name', 'The Icon Hotel'),
            'hotel_tagline' => WebsiteSetting::getValue('hotel_tagline', 'Comfortable for Family'),
            'phone' => WebsiteSetting::getValue('phone', ''),
            'email' => WebsiteSetting::getValue('email', ''),
            'whatsapp' => WebsiteSetting::getValue('whatsapp', ''),
            'instagram_url' => WebsiteSetting::getValue('instagram_url', ''),
            'address' => WebsiteSetting::getValue('address', ''),
            'copyright_text' => WebsiteSetting::getValue('copyright_text', ''),
            'meta_title' => WebsiteSetting::getValue('meta_title', 'The Icon Hotel Kuningan'),
            'meta_description' => WebsiteSetting::getValue('meta_description', ''),
            'logo_path' => WebsiteSetting::getValue('logo_path', 'logo/icon.png'),
        ];

        // Generate math captcha
        $num1 = rand(2, 10);
        $num2 = rand(2, 10);
        session()->put('booking_captcha', $num1 + $num2);
        $captchaQuestion = "{$num1} + {$num2} = ?";

        return view('home.index', compact(
            'sections', 'facilities', 'galleryImages', 'roomTypes',
            'pmsRoomTypes', 'settings', 'captchaQuestion'
        ));
    }

    public function submitContact(Request $request)
    {
        // Honeypot anti-spam
        if (! empty($request->website)) {
            return back()->with('success', 'Thank you for your message!');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        Contact::create($validated);

        return back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }

    public function submitBooking(Request $request, PmsApiService $pms)
    {
        // Honeypot anti-spam
        if (! empty($request->website)) {
            return back()->with('success', 'Booking request submitted successfully! We will confirm your reservation shortly.');
        }

        // Math captcha validation
        $expectedAnswer = session()->pull('booking_captcha');
        if ($expectedAnswer === null || (int) $request->input('captcha_answer') !== $expectedAnswer) {
            return back()->withErrors(['captcha_answer' => 'Math verification failed. Please try again.'])->withInput();
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20|regex:/^[0-9+\-\s]+$/',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1|max:10',
            'room_type' => 'nullable|string|max:255',
            'room_id' => 'nullable|integer|min:1',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Server-side availability check via PMS
        $availableRooms = $pms->getAvailableRooms($validated['check_in'], $validated['check_out']);
        if (empty($availableRooms)) {
            return back()->withErrors(['check_in' => 'No rooms available for the selected dates. Please try different dates.'])->withInput();
        }

        // If no specific room selected, pick first available room of chosen type or first overall
        if (empty($validated['room_id'])) {
            $firstMatch = null;
            if (! empty($validated['room_type'])) {
                $firstMatch = collect($availableRooms)->firstWhere('room_type_name', $validated['room_type']);
            }
            $firstMatch ??= collect($availableRooms)->first();
            $validated['room_id'] = $firstMatch['id'] ?? null;
        }

        // Calculate total amount from PMS API price data
        $selectedRoom = collect($availableRooms)->firstWhere('id', $validated['room_id']);
        $pricePerNight = $selectedRoom['price_per_night'] ?? 0;
        $checkIn = Carbon::parse($validated['check_in']);
        $checkOut = Carbon::parse($validated['check_out']);
        $nights = max($checkIn->diffInDays($checkOut), 1);
        $totalAmount = (float) $pricePerNight * $nights;

        // Save booking to local database
        $booking = Booking::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'check_in' => $validated['check_in'],
            'check_out' => $validated['check_out'],
            'guests' => $validated['guests'],
            'total_amount' => $totalAmount,
            'room_type' => $validated['room_type'] ?? null,
            'room_id' => $validated['room_id'] ?? null,
            'notes' => $validated['notes'] ?? '',
            'status' => 'pending',
            'source' => 'website',
        ]);

        // Send email notifications
        try {
            Mail::to($booking->email)->send(new BookingConfirmation($booking));
            Mail::to(config('mail.admin_address'))->send(new BookingAdminNotification($booking));
        } catch (\Exception $e) {
            Log::warning('Failed to send booking email', ['error' => $e->getMessage()]);
        }

        // Dispatch queue job to sync reservation to PMS API (async, auto-retry)
        SyncPmsReservation::dispatch($booking, [
            'guest_name' => $validated['name'],
            'guest_email' => $validated['email'],
            'guest_phone' => $validated['phone'],
            'room_id' => $validated['room_id'],
            'check_in' => $validated['check_in'],
            'check_out' => $validated['check_out'],
            'guest_count' => $validated['guests'],
            'notes' => $validated['notes'] ?? '',
            'ota_source' => 'website',
            'ota_reservation_number' => $booking->booking_code,
        ]);

        return redirect()->route('booking.confirmation', $booking)
            ->with('success', 'Booking request submitted successfully! Please complete the payment to secure your room.');
    }

    public function checkAvailability(Request $request, PmsApiService $pms)
    {
        $validated = $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ]);

        $availableRooms = $pms->getAvailableRooms($validated['check_in'], $validated['check_out']);

        return response()->json([
            'success' => true,
            'data' => $availableRooms,
        ]);
    }

    public function trackBooking()
    {
        return view('home.track-booking', ['booking' => null]);
    }

    public function lookupBooking(Request $request)
    {
        $validated = $request->validate([
            'booking_code' => 'required|string|min:5|max:50',
        ]);

        $code = strtoupper($validated['booking_code']);

        // Cari berdasarkan booking_code lokal atau pms_reservation_number
        $booking = Booking::byCode($code)->first();

        if (! $booking) {
            $booking = Booking::where('pms_reservation_number', $code)->first();
        }

        if (! $booking) {
            return back()->withErrors(['booking_code' => 'Booking not found. Please check your booking code.'])->withInput();
        }

        return view('home.track-booking', compact('booking'));
    }

    public function bookingConfirmation(Booking $booking)
    {
        $whatsapp = WebsiteSetting::getValue('receptionist_phone', WebsiteSetting::getValue('whatsapp', ''));
        $phone = WebsiteSetting::getValue('phone', '');

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

        $settings = [
            'hotel_name' => WebsiteSetting::getValue('hotel_name', 'The Icon Hotel'),
            'meta_title' => WebsiteSetting::getValue('meta_title', 'The Icon Hotel Kuningan'),
            'meta_description' => WebsiteSetting::getValue('meta_description', ''),
        ];

        return view('home.booking-confirmation', compact(
            'booking', 'bankAccounts', 'whatsapp', 'phone', 'settings'
        ));
    }
}
