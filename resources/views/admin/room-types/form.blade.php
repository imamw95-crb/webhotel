@extends('layouts.admin')
@section('title', $roomType ? 'Edit Room Type' : 'Add Room Type')
@section('page_title', $roomType ? 'Edit Room Type' : 'Add Room Type')

@section('content')
<div class="max-w-2xl">
    <form action="{{ $roomType ? route('admin.room-types.update', $roomType) : route('admin.room-types.store') }}" method="POST">
        @csrf
        @if($roomType) @method('PUT') @endif

        <div class="bg-white rounded-xl shadow-sm border p-6 space-y-5">
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Code *</label>
                    <input type="text" name="code" value="{{ old('code', $roomType->code ?? '') }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-400 focus:border-gold-400" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                    <input type="text" name="name" value="{{ old('name', $roomType->name ?? '') }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-400 focus:border-gold-400" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-400 focus:border-gold-400">{{ old('description', $roomType->description ?? '') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Base Price (Rp) *</label>
                    <input type="number" name="base_price" value="{{ old('base_price', $roomType->base_price ?? 0) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-400 focus:border-gold-400" min="0" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $roomType->sort_order ?? 0) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-400 focus:border-gold-400" min="0">
                </div>
            </div>

            {{-- Room Capacity --}}
            <div class="border-t pt-5">
                <h4 class="font-semibold text-gray-700 mb-3">Room Capacity</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Max Occupancy</label>
                        <input type="number" name="max_occupancy" value="{{ old('max_occupancy', $roomType->max_occupancy ?? 2) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-400 focus:border-gold-400" min="1" max="20">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Max Adults</label>
                        <input type="number" name="max_adults" value="{{ old('max_adults', $roomType->max_adults ?? 2) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-400 focus:border-gold-400" min="1" max="10">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Max Children</label>
                        <input type="number" name="max_children" value="{{ old('max_children', $roomType->max_children ?? 1) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-400 focus:border-gold-400" min="0" max="10">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Room Size</label>
                        <input type="text" name="room_size" value="{{ old('room_size', $roomType->room_size ?? '') }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-400 focus:border-gold-400" placeholder="e.g. 32 m²">
                    </div>
                </div>
                <div class="mt-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bed Configuration</label>
                    <input type="text" name="bed_configuration" value="{{ old('bed_configuration', $roomType->bed_configuration ?? '') }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-400 focus:border-gold-400" placeholder="e.g. 1 King Bed, 2 Single Beds">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Image Path</label>
                <input type="text" name="image_path" value="{{ old('image_path', $roomType->image_path ?? '') }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-400 focus:border-gold-400" placeholder="e.g. room-types/presidential.jpg">
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $roomType->is_active ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-gold-400 focus:ring-gold-400">
                <label for="is_active" class="text-sm text-gray-700">Active</label>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="bg-gold-400 hover:bg-gold-500 text-navy-900 font-semibold px-6 py-2 rounded-lg">
                {{ $roomType ? 'Update' : 'Create' }} Room Type
            </button>
            <a href="{{ route('admin.room-types.index') }}" class="px-6 py-2 border rounded-lg text-gray-600 hover:bg-gray-50">Cancel</a>
        </div>
    </form>
</div>
@endsection
