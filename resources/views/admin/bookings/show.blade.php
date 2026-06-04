@extends('layouts.admin')
@section('title', 'Booking Detail')
@section('page_title', 'Booking #' . $booking->id)

@section('content')
<div class="grid lg:grid-cols-3 gap-6">
    {{-- Main detail card --}}
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Guest Information</h3>
        <dl class="grid sm:grid-cols-2 gap-4">
            <div>
                <dt class="text-xs text-gray-400 uppercase font-medium">Booking Code</dt>
                <dd class="text-gray-800 font-bold font-mono text-lg">{{ $booking->booking_code }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-400 uppercase font-medium">Full Name</dt>
                <dd class="text-gray-800 font-medium">{{ $booking->name }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-400 uppercase font-medium">Email</dt>
                <dd class="text-gray-800">{{ $booking->email }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-400 uppercase font-medium">Phone</dt>
                <dd class="text-gray-800">{{ $booking->phone }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-400 uppercase font-medium">Guests</dt>
                <dd class="text-gray-800">{{ $booking->guests }} guest(s)</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-400 uppercase font-medium">Total Amount</dt>
                <dd class="text-gray-800 font-bold text-gold-400">Rp {{ number_format($booking->total_amount ?? 0, 0, ',', '.') }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-400 uppercase font-medium">Payment</dt>
                <dd class="text-gray-800">
                    <span class="px-2 py-0.5 text-xs rounded-full font-medium
                        {{ $booking->payment_status === 'paid' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $booking->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $booking->payment_status === 'unpaid' ? 'bg-gray-100 text-gray-600' : '' }}
                        {{ $booking->payment_status === 'failed' ? 'bg-red-100 text-red-700' : '' }}">
                        {{ ucfirst($booking->payment_status) }}
                    </span>
                    @if($booking->payment_method)
                        <span class="text-xs text-gray-400 ml-1">via {{ $booking->payment_method }}</span>
                    @endif
                </dd>
            </div>
        </dl>

        <hr class="my-6">

        <h3 class="text-lg font-semibold text-gray-800 mb-4">Booking Details</h3>
        <dl class="grid sm:grid-cols-2 gap-4">
            <div>
                <dt class="text-xs text-gray-400 uppercase font-medium">Check-in</dt>
                <dd class="text-gray-800 font-medium">{{ \Carbon\Carbon::parse($booking->check_in)->format('l, d F Y') }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-400 uppercase font-medium">Check-out</dt>
                <dd class="text-gray-800 font-medium">{{ \Carbon\Carbon::parse($booking->check_out)->format('l, d F Y') }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-400 uppercase font-medium">Nights</dt>
                <dd class="text-gray-800">{{ \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out)) }} night(s)</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-400 uppercase font-medium">Room Type</dt>
                <dd class="text-gray-800">{{ $booking->room_type ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-400 uppercase font-medium">Room ID</dt>
                <dd class="text-gray-800">{{ $booking->room_id ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-gray-400 uppercase font-medium">Source</dt>
                <dd class="text-gray-800">{{ ucfirst($booking->source) }}</dd>
            </div>
        </dl>

        @if($booking->notes)
            <hr class="my-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Special Requests / Notes</h3>
            <p class="text-gray-600 bg-gray-50 rounded-lg p-4">{{ $booking->notes }}</p>
        @endif
    </div>

    {{-- Sidebar --}}
    <div class="space-y-4">
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Status</h3>
            <div class="text-center">
                <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold
                    {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                    {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                    {{ ucfirst($booking->status) }}
                </span>
                <p class="text-xs text-gray-400 mt-2">Submitted {{ $booking->created_at->diffForHumans() }}</p>
            </div>

            <div class="mt-6 space-y-3">
                @if($booking->status === 'pending')
                    <form action="{{ route('admin.bookings.confirm', $booking) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2.5 rounded-lg transition" onclick="return confirm('Confirm this booking?')">
                            <i class="fa-solid fa-check mr-1"></i> Confirm Booking
                        </button>
                    </form>
                    <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2.5 rounded-lg transition" onclick="return confirm('Cancel this booking?')">
                            <i class="fa-solid fa-xmark mr-1"></i> Cancel Booking
                        </button>
                    </form>
                @endif
                <a href="{{ route('admin.bookings.invoice', $booking) }}" target="_blank" class="block text-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2.5 rounded-lg transition">
                    <i class="fa-solid fa-file-invoice mr-1"></i> View Invoice
                </a>
                <a href="{{ route('admin.bookings.invoice.download', $booking) }}" class="block text-center bg-navy-800 hover:bg-navy-900 text-white font-semibold py-2.5 rounded-lg transition">
                    <i class="fa-solid fa-download mr-1"></i> Download Invoice
                </a>
                <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold py-2.5 rounded-lg transition" onclick="return confirm('Delete this booking?')">
                        <i class="fa-solid fa-trash mr-1"></i> Delete
                    </button>
                </form>
                <a href="{{ route('admin.bookings.index') }}" class="block text-center bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2.5 rounded-lg transition">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Back to Bookings
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
