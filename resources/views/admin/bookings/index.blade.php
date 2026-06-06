@extends('layouts.admin')
@section('title', 'Bookings')
@section('page_title', 'Bookings')

@section('content')
{{-- Search & Filter --}}
<div class="bg-white rounded-xl shadow-sm border p-4 mb-6">
    <form method="GET" class="grid md:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="lg:col-span-2">
            <label class="block text-xs font-medium text-gray-500 mb-1">Search</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Name, email, phone, or booking code..."
                   class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-gold-400 focus:border-gold-400">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
            <select name="status" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-gold-400 focus:border-gold-400">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Payment</label>
            <select name="payment_status" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-gold-400 focus:border-gold-400">
                <option value="">All Payments</option>
                <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="unpaid" {{ request('payment_status') === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="failed" {{ request('payment_status') === 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="bg-gold-400 hover:bg-gold-500 text-navy-900 font-semibold px-4 py-2 rounded-lg text-sm transition">
                <i class="fa-solid fa-search mr-1"></i> Filter
            </button>
            @if(request()->anyFilled(['search', 'status', 'payment_status', 'date_from', 'date_to']))
                <a href="{{ route('admin.bookings.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm transition">
                    <i class="fa-solid fa-times mr-1"></i> Clear
                </a>
            @endif
        </div>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Guest</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Contact</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Dates</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Amount</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Payment</th>
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
                            <p class="text-gray-400 text-xs">→ {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</p>
                            <p class="text-xs text-gray-400">{{ $booking->room_type ?? '—' }} · {{ $booking->guests }} guest(s)</p>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-800 whitespace-nowrap">
                            Rp {{ number_format($booking->total_amount ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 text-xs rounded-full font-medium
                                {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 text-xs rounded-full font-medium
                                {{ $booking->payment_status === 'paid' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $booking->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $booking->payment_status === 'unpaid' ? 'bg-gray-100 text-gray-600' : '' }}
                                {{ $booking->payment_status === 'failed' ? 'bg-red-100 text-red-700' : '' }}">
                                {{ ucfirst($booking->payment_status) }}
                            </span>
                            @if($booking->payment_method)
                                <p class="text-xs text-gray-400 mt-0.5">{{ $booking->payment_method }}</p>
                            @endif
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
                    <tr><td colspan="8" class="px-6 py-12 text-center text-gray-400">No bookings found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($bookings->hasPages())
        <div class="p-4 border-t">{{ $bookings->links() }}</div>
    @endif
</div>
@endsection
