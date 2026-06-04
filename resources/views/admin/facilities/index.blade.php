@extends('layouts.admin')
@section('title', 'Facilities')
@section('page_title', 'Facilities')

@section('content')
<div class="flex justify-between items-center mb-6">
    <p class="text-gray-500">Manage hotel facilities displayed on the website.</p>
    <a href="{{ route('admin.facilities.create') }}" class="bg-gold-400 hover:bg-gold-500 text-navy-900 font-semibold px-4 py-2 rounded-lg">
        <i class="fa-solid fa-plus mr-1"></i> Add Facility
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Icon</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Name</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Description</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($facilities as $facility)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4"><i class="{{ $facility->icon }} text-xl text-gold-400"></i></td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $facility->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($facility->description, 60) }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full {{ $facility->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $facility->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.facilities.edit', $facility) }}" class="text-blue-500 hover:text-blue-700 mr-3"><i class="fa-solid fa-pen"></i></a>
                        <form action="{{ route('admin.facilities.destroy', $facility) }}" method="POST" class="inline" onsubmit="return confirm('Delete this facility?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-6 py-12 text-center text-gray-400">No facilities yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($facilities->hasPages())
        <div class="p-4 border-t">{{ $facilities->links() }}</div>
    @endif
</div>
@endsection
