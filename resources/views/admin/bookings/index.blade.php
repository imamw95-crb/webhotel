@extends('layouts.admin')
@section('title', 'Bookings')
@section('page_title', 'Bookings')

@section('content')
<div class="flex justify-between items-center mb-6">
    <p class="text-gray-500">Manage booking requests from the website.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Guest</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Contact</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Dates</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Guests</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Room</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Date</th>
                    <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($bookings as $booking)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-navy-800 text-white rounded-full flex items-center justify-center flex-shrink-0 text-sm font-medium">
                                    {{ strtoupper(substr($booking->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $booking->name }}</p>
                                    <p class="text-xs text-gray-400 font-mono">{{ $booking->booking_code }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <p class="text-gray-600">{{ $booking->email }}</p>
                            <p class="text-gray-400 text-xs">{{ $booking->phone }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                            <p>{{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}</p>
                            <p class="text-gray-400">→ {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $booking->guests }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $booking->room_type ?? '—' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 text-xs rounded-full font-medium
                                {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-400 whitespace-nowrap">{{ $booking->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <a href="{{ route('admin.bookings.show', $booking) }}" class="text-blue-500 hover:text-blue-700 mr-2" title="View">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            @if($booking->status === 'pending')
                                <form action="{{ route('admin.bookings.confirm', $booking) }}" method="POST" class="inline mr-2">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-green-500 hover:text-green-700" title="Confirm" onclick="return confirm('Confirm this booking?')">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST" class="inline mr-2">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-red-500 hover:text-red-700" title="Cancel" onclick="return confirm('Cancel this booking?')">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="inline" onsubmit="return confirm('Delete this booking?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600" title="Delete"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="px-6 py-12 text-center text-gray-400">No bookings yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($bookings->hasPages())
        <div class="p-4 border-t">{{ $bookings->links() }}</div>
    @endif
</div>
@endsection
