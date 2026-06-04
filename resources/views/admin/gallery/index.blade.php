@extends('layouts.admin')
@section('title', 'Gallery')
@section('page_title', 'Gallery')

@section('content')
<div class="flex justify-between items-center mb-6">
    <p class="text-gray-500">Manage gallery images displayed on the website.</p>
    <a href="{{ route('admin.gallery.create') }}" class="bg-gold-400 hover:bg-gold-500 text-navy-900 font-semibold px-4 py-2 rounded-lg">
        <i class="fa-solid fa-upload mr-1"></i> Upload Image
    </a>
</div>

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    @forelse($images as $img)
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden group">
            <div class="aspect-video bg-gray-100 relative">
                <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-full object-cover" alt="{{ $img->title }}">
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
                    <a href="{{ route('admin.gallery.edit', $img) }}" class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-blue-500 hover:bg-blue-50"><i class="fa-solid fa-pen text-xs"></i></a>
                    <form action="{{ route('admin.gallery.destroy', $img) }}" method="POST" onsubmit="return confirm('Delete this image?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-red-500 hover:bg-red-50"><i class="fa-solid fa-trash text-xs"></i></button>
                    </form>
                </div>
            </div>
            <div class="p-3">
                <p class="text-sm font-medium text-gray-800 truncate">{{ $img->title ?? 'Untitled' }}</p>
                <div class="flex items-center justify-between mt-1">
                    <span class="text-xs text-gray-400">{{ $img->category }}</span>
                    <span class="px-1.5 py-0.5 text-xs rounded {{ $img->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $img->is_active ? 'Active' : 'Off' }}</span>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full py-12 text-center text-gray-400 bg-white rounded-xl border">
            <i class="fa-regular fa-images text-4xl mb-3"></i>
            <p>No images yet. <a href="{{ route('admin.gallery.create') }}" class="text-gold-400 hover:underline">Upload one</a>.</p>
        </div>
    @endforelse
</div>

@if($images->hasPages())
    <div class="mt-6">{{ $images->links() }}</div>
@endif
@endsection
