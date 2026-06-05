@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Room Types</p>
                <p class="text-3xl font-bold text-navy-800">{{ $stats['room_types'] }}</p>
            </div>
            <div class="w-12 h-12 bg-gold-400/10 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-bed text-gold-400 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Facilities</p>
                <p class="text-3xl font-bold text-navy-800">{{ $stats['facilities'] }}</p>
            </div>
            <div class="w-12 h-12 bg-gold-400/10 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-star text-gold-400 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Gallery Images</p>
                <p class="text-3xl font-bold text-navy-800">{{ $stats['gallery_images'] }}</p>
            </div>
            <div class="w-12 h-12 bg-gold-400/10 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-images text-gold-400 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Messages</p>
                <p class="text-3xl font-bold text-navy-800">{{ $stats['total_contacts'] }}</p>
            </div>
            <div class="w-12 h-12 bg-gold-400/10 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-envelope text-gold-400 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Bookings</p>
                <p class="text-3xl font-bold text-navy-800">{{ $stats['total_bookings'] }}</p>
            </div>
            <div class="w-12 h-12 bg-gold-400/10 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-calendar-check text-gold-400 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Pending</p>
                <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending_bookings'] }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-50 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-clock text-yellow-500 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Confirmed</p>
                <p class="text-3xl font-bold text-green-600">{{ $stats['confirmed_bookings'] }}</p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-check-circle text-green-500 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-6">
    {{-- Recent Bookings --}}
    <div class="bg-white rounded-xl shadow-sm border">
        <div class="p-6 border-b flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Recent Bookings</h3>
            <a href="{{ route('admin.bookings.index') }}" class="text-sm text-gold-400 hover:underline">View All</a>
        </div>
        <div class="divide-y">
            @forelse($recentBookings as $booking)
                <a href="{{ route('admin.bookings.show', $booking) }}" class="p-4 flex items-start gap-4 hover:bg-gray-50 transition">
                    <div class="w-10 h-10 bg-navy-800 text-white rounded-full flex items-center justify-center flex-shrink-0 text-sm font-medium">
                        {{ strtoupper(substr($booking->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <p class="font-medium text-gray-800">{{ $booking->name }}</p>
                            <span class="px-2 py-0.5 text-xs rounded-full font-medium
                                {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500">{{ $booking->check_in->format('d M') }} → {{ $booking->check_out->format('d M Y') }}</p>
                        <p class="text-xs text-gray-400">{{ $booking->created_at->diffForHumans() }}</p>
                    </div>
                </a>
            @empty
                <div class="p-8 text-center text-gray-400">
                    <i class="fa-regular fa-calendar text-4xl mb-3"></i>
                    <p>No bookings yet</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Recent Messages --}}
    <div class="bg-white rounded-xl shadow-sm border">
        <div class="p-6 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Recent Messages</h3>
        </div>
        <div class="divide-y">
            @forelse($recentContacts as $contact)
                <div class="p-4 flex items-start gap-4 {{ $contact->is_read ? '' : 'bg-yellow-50' }}">
                    <div class="w-10 h-10 bg-navy-800 text-white rounded-full flex items-center justify-center flex-shrink-0">
                        {{ strtoupper(substr($contact->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <p class="font-medium text-gray-800">{{ $contact->name }}</p>
                            <span class="text-xs text-gray-400">{{ $contact->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-gray-500">{{ $contact->subject ?? 'No subject' }}</p>
                        <p class="text-sm text-gray-600 truncate">{{ $contact->message }}</p>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-400">
                    <i class="fa-regular fa-envelope text-4xl mb-3"></i>
                    <p>No messages yet</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
