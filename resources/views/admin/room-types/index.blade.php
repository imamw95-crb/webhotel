@extends('layouts.admin')
@section('title', 'Room Types')
@section('page_title', 'Room Types')

@section('content')
<div class="flex justify-between items-center mb-6">
    <p class="text-gray-500">Manage hotel room types displayed on the website.</p>
    <a href="{{ route('admin.room-types.create') }}" class="bg-gold-400 hover:bg-gold-500 text-navy-900 font-semibold px-4 py-2 rounded-lg">
        <i class="fa-solid fa-plus mr-1"></i> Add Room Type
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Name</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Code</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Price</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($roomTypes as $type)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($type->image_path)
                                <img src="{{ asset('storage/' . $type->image_path) }}" class="w-12 h-12 rounded-lg object-cover">
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center"><i class="fa-solid fa-bed text-gray-400"></i></div>
                            @endif
                            <div>
                                <p class="font-medium text-gray-800">{{ $type->name }}</p>
                                <p class="text-xs text-gray-400">{{ Str::limit($type->description, 50) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $type->code }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">Rp {{ number_format($type->base_price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full {{ $type->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $type->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.room-types.edit', $type) }}" class="text-blue-500 hover:text-blue-700 mr-3"><i class="fa-solid fa-pen"></i></a>
                        <form action="{{ route('admin.room-types.destroy', $type) }}" method="POST" class="inline" onsubmit="return confirm('Delete this room type?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-6 py-12 text-center text-gray-400">No room types yet. <a href="{{ route('admin.room-types.create') }}" class="text-gold-400 hover:underline">Add one</a>.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($roomTypes->hasPages())
        <div class="p-4 border-t">{{ $roomTypes->links() }}</div>
    @endif
</div>
@endsection
