@extends('layouts.admin')
@section('title', $image ? 'Edit Image' : 'Upload Image')
@section('page_title', $image ? 'Edit Image' : 'Upload Image')

@section('content')
<div class="max-w-2xl">
    <form action="{{ $image ? route('admin.gallery.update', $image) : route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($image) @method('PUT') @endif

        <div class="bg-white rounded-xl shadow-sm border p-6 space-y-5">
            @if($image && $image->image_path)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                    <img src="{{ asset('storage/' . $image->image_path) }}" class="w-full max-h-64 object-cover rounded-lg border">
                </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ $image ? 'Replace Image' : 'Image' }} {{ $image ? '' : '*' }}</label>
                <input type="file" name="image" accept="image/*" {{ $image ? '' : 'required' }} class="w-full border rounded-lg px-3 py-2 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-gold-400 file:text-navy-900 file:font-semibold hover:file:bg-gold-500">
                <p class="text-xs text-gray-400 mt-1">JPG, PNG, WebP. Max 5MB.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" name="title" value="{{ old('title', $image->title ?? '') }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-400 focus:border-gold-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-400 focus:border-gold-400">
                    @foreach(['hotel', 'rooms', 'restaurant', 'pool', 'spa', 'meeting', 'other'] as $cat)
                        <option value="{{ $cat }}" {{ old('category', $image->category ?? '') === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $image->sort_order ?? 0) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-400 focus:border-gold-400" min="0">
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $image->is_active ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-gold-400 focus:ring-gold-400">
                <label for="is_active" class="text-sm text-gray-700">Active</label>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="bg-gold-400 hover:bg-gold-500 text-navy-900 font-semibold px-6 py-2 rounded-lg">
                {{ $image ? 'Update' : 'Upload' }} Image
            </button>
            <a href="{{ route('admin.gallery.index') }}" class="px-6 py-2 border rounded-lg text-gray-600 hover:bg-gray-50">Cancel</a>
        </div>
    </form>
</div>
@endsection
