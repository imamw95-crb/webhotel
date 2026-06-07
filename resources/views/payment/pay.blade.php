@extends('layouts.app')

@section('content')
<section class="min-h-screen bg-[#FAF8F5] pt-32 pb-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Success Header --}}
        @if(session('success'))
            <div class="mb-8 p-5 bg-green-50 border border-green-200 text-green-700 rounded-2xl flex items-start gap-3">
                <i class="fa-solid fa-check-circle text-xl mt-0.5"></i>
                <div>
                    <p class="font-semibold text-lg">{{ session('success') }}</p>
                    <p class="text-sm text-green-600 mt-1">Booking code: <strong class="font-mono">{{ $booking->booking_code }}</strong></p>
                </div>
            </div>
        @endif

        <div class="text-center mb-10">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-check text-green-600 text-2xl"></i>
            </div>
            <h1 class="font-display text-3xl md:text-4xl font-bold text-navy-800 mb-2">Booking Submitted!</h1>
            <p class="text-gray-500">Your booking has been saved. Please complete the payment via bank transfer below.</p>
        </div>

        {{-- Payment Deadline Alert --}}
        @if($booking->payment_due_at && $booking->payment_status !== 'paid')
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-2xl p-5 mb-6 flex items-start gap-3">
            <i class="fa-solid fa-clock text-xl mt-0.5"></i>
            <div>
                <p class="font-semibold">⏰ Payment Deadline: {{ $booking->payment_due_at->format('H:i') }} WIB</p>
                <p class="text-sm text-red-600 mt-1">
                    Please complete your payment before <strong>{{ $booking->payment_due_at->format('H:i') }} WIB</strong>. 
                    Your booking will be <strong>automatically cancelled</strong> if payment is not confirmed within <strong>3 hours</strong>.
                </p>
            </div>
        </div>
        @endif

        {{-- Booking Summary Card --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
            <div class="p-6 border-b bg-navy-800 text-white">
                <div class="flex items-center justify-between">
                    <h2 class="font-display text-xl font-bold">Booking Summary</h2>
                    <span class="px-3 py-1 rounded-full text-sm font-semibold bg-yellow-400 text-navy-900">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
                <p class="text-white/70 text-sm mt-1 font-mono">Code: {{ $booking->booking_code }}</p>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-medium">Guest Name</p>
                        <p class="font-medium text-gray-800">{{ $booking->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-medium">Email</p>
                        <p class="text-gray-800">{{ $booking->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-medium">Phone</p>
                        <p class="text-gray-800">{{ $booking->phone }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-medium">Room Type</p>
                        <p class="text-gray-800">{{ $booking->room_type ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-medium">Check-in</p>
                        <p class="text-gray-800">{{ \Carbon\Carbon::parse($booking->check_in)->format('l, d F Y') }}</p>
                        <p class="text-xs text-gray-400">From 14:00</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-medium">Check-out</p>
                        <p class="text-gray-800">{{ \Carbon\Carbon::parse($booking->check_out)->format('l, d F Y') }}</p>
                        <p class="text-xs text-gray-400">Until 12:00</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-medium">Duration</p>
                        <p class="text-gray-800">{{ $booking->nightsLabel() }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-medium">Guests</p>
                        <p class="text-gray-800">{{ $booking->guests }} person(s)</p>
                    </div>
                </div>

                @if($booking->notes)
                    <div class="pt-4 border-t">
                        <p class="text-xs text-gray-400 uppercase font-medium mb-1">Special Requests</p>
                        <p class="text-gray-600 bg-gray-50 rounded-lg p-3 text-sm">{{ $booking->notes }}</p>
                    </div>
                @endif

                <div class="pt-4 border-t">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Total Amount</span>
                        <span class="font-bold text-2xl text-gold-400">
                            Rp {{ number_format($booking->total_amount ?? 0, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bank Transfer Payment Card --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
            <div class="p-6 border-b bg-blue-50 border-blue-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-building-columns text-blue-600"></i>
                    </div>
                    <div>
                        <h2 class="font-display text-xl font-bold text-navy-800">Bank Transfer Payment</h2>
                        <p class="text-sm text-gray-500">Transfer the total amount to one of the bank accounts below</p>
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-4">
                @forelse($bankAccounts as $bank)
                    <div class="border border-gray-200 rounded-xl p-5 hover:border-blue-200 transition {{ $loop->first ? 'ring-2 ring-blue-100 bg-blue-50/50' : '' }}">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm text-gray-400 uppercase font-medium">Bank</p>
                                <p class="font-bold text-lg text-navy-800">{{ $bank['name'] }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-400 uppercase font-medium">Account Number</p>
                                <p class="font-mono font-bold text-lg text-navy-800 tracking-wider select-all">{{ $bank['account'] }}</p>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p class="text-sm text-gray-400 uppercase font-medium">Account Holder</p>
                            <p class="font-semibold text-gray-700">{{ $bank['holder'] }}</p>
                        </div>
                    </div>
                @empty
                    <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 rounded-xl p-4">
                        <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                        Bank account information is not available yet. Please contact reception for payment instructions.
                    </div>
                @endforelse

                <div class="bg-gray-50 rounded-xl p-4 mt-2">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 font-medium">Total to Transfer:</span>
                        <span class="font-bold text-xl text-gold-400">
                            Rp {{ number_format($booking->total_amount ?? 0, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Confirmation Steps --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
            <div class="p-6 border-b">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-circle-exclamation text-orange-600"></i>
                    </div>
                    <h2 class="font-display text-xl font-bold text-navy-800">Confirmation Steps</h2>
                </div>
            </div>
            <div class="p-6">
                <ol class="space-y-4">
                    <li class="flex gap-4">
                        <span class="flex-shrink-0 w-8 h-8 bg-gold-400 text-navy-900 rounded-full flex items-center justify-center font-bold text-sm">1</span>
                        <div>
                            <p class="font-semibold text-navy-800">Transfer the payment</p>
                            <p class="text-sm text-gray-500">Transfer exactly <strong>Rp {{ number_format($booking->total_amount ?? 0, 0, ',', '.') }}</strong> to one of the bank accounts above.</p>
                        </div>
                    </li>
                    <li class="flex gap-4">
                        <span class="flex-shrink-0 w-8 h-8 bg-gold-400 text-navy-900 rounded-full flex items-center justify-center font-bold text-sm">2</span>
                        <div>
                            <p class="font-semibold text-navy-800">Confirm via WhatsApp</p>
                            <p class="text-sm text-gray-500">Send the transfer proof to our receptionist via WhatsApp or phone call.</p>
                        </div>
                    </li>
                    <li class="flex gap-4">
                        <span class="flex-shrink-0 w-8 h-8 bg-gold-400 text-navy-900 rounded-full flex items-center justify-center font-bold text-sm">3</span>
                        <div>
                            <p class="font-semibold text-navy-800">Booking confirmed</p>
                            <p class="text-sm text-gray-500">Once the payment is verified, your booking will be confirmed and you will receive a confirmation email.</p>
                        </div>
                    </li>
                </ol>

                @if($whatsapp)
                    <div class="mt-6 p-5 bg-green-50 border border-green-200 rounded-xl">
                        <div class="flex items-center gap-3 mb-3">
                            <i class="fa-brands fa-whatsapp text-green-600 text-xl"></i>
                            <p class="font-semibold text-green-800">Confirm to Receptionist</p>
                        </div>
                        <p class="text-sm text-green-700 mb-4">
                            Please send your transfer proof to our receptionist via WhatsApp for quick confirmation.
                            Include your booking code <strong class="font-mono">{{ $booking->booking_code }}</strong> in the message.
                        </p>
                        @php
                            $message = urlencode(
                                "Halo, saya ingin konfirmasi pembayaran booking hotel.\n\n" .
                                "Booking Code: {$booking->booking_code}\n" .
                                "Nama: {$booking->name}\n" .
                                "Check-in: " . \Carbon\Carbon::parse($booking->check_in)->format('d M Y') . "\n" .
                                "Check-out: " . \Carbon\Carbon::parse($booking->check_out)->format('d M Y') . "\n" .
                                "Total: Rp " . number_format($booking->total_amount ?? 0, 0, ',', '.') . "\n\n" .
                                "Berikut saya lampirkan bukti transfernya."
                            );
                        @endphp
                        <a href="https://api.whatsapp.com/send?phone={{ $whatsapp }}&text={{ $message }}"
                           target="_blank"
                           class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-3 rounded-xl transition-all hover:shadow-lg">
                            <i class="fa-brands fa-whatsapp"></i>
                            Confirm via WhatsApp
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Track Booking Link --}}
        <div class="text-center">
            <a href="{{ route('booking.track', ['booking_code' => $booking->booking_code]) }}"
               class="inline-flex items-center gap-2 text-gold-600 hover:text-gold-700 font-medium">
                <i class="fa-solid fa-search"></i>
                Track your booking status
            </a>
        </div>
    </div>
</section>
@endsection
