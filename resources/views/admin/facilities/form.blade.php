@extends('layouts.admin')
@section('title', $facility ? 'Edit Facility' : 'Add Facility')
@section('page_title', $facility ? 'Edit Facility' : 'Add Facility')

@section('content')
<div class="max-w-2xl">
    <form action="{{ $facility ? route('admin.facilities.update', $facility) : route('admin.facilities.store') }}" method="POST">
        @csrf
        @if($facility) @method('PUT') @endif

        <div class="bg-white rounded-xl shadow-sm border p-6 space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                <input type="text" name="name" value="{{ old('name', $facility->name ?? '') }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-400 focus:border-gold-400" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Icon (Font Awesome class)</label>
                <input type="text" name="icon" value="{{ old('icon', $facility->icon ?? 'fa-solid fa-star') }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-400 focus:border-gold-400" placeholder="fa-solid fa-star">
                <p class="text-xs text-gray-400 mt-1">Use Font Awesome 6 classes, e.g. <code>fa-solid fa-wifi</code></p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-400 focus:border-gold-400">{{ old('description', $facility->description ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $facility->sort_order ?? 0) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-400 focus:border-gold-400" min="0">
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $facility->is_active ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-gold-400 focus:ring-gold-400">
                <label for="is_active" class="text-sm text-gray-700">Active</label>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="bg-gold-400 hover:bg-gold-500 text-navy-900 font-semibold px-6 py-2 rounded-lg">
                {{ $facility ? 'Update' : 'Create' }} Facility
            </button>
            <a href="{{ route('admin.facilities.index') }}" class="px-6 py-2 border rounded-lg text-gray-600 hover:bg-gray-50">Cancel</a>
        </div>
    </form>
</div>
@endsection
