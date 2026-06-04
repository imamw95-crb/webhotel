@extends('layouts.admin')
@section('title', 'Page Sections')
@section('page_title', 'Page Sections')

@section('content')
<p class="text-gray-500 mb-6">Edit the content of each section on the homepage.</p>

<div class="space-y-4">
    @forelse($sections as $section)
        <div class="bg-white rounded-xl shadow-sm border p-5 flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <span class="px-2 py-1 text-xs font-mono bg-gray-100 text-gray-600 rounded">{{ $section->section_key }}</span>
                    <h3 class="font-semibold text-gray-800">{{ $section->title ?? 'Untitled' }}</h3>
                    <span class="px-2 py-0.5 text-xs rounded-full {{ $section->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $section->is_active ? 'Active' : 'Inactive' }}</span>
                </div>
                @if($section->subtitle)
                    <p class="text-sm text-gray-500 mt-1">{{ $section->subtitle }}</p>
                @endif
            </div>
            <a href="{{ route('admin.sections.edit', $section) }}" class="text-blue-500 hover:text-blue-700 px-4 py-2 border border-blue-200 rounded-lg hover:bg-blue-50">
                <i class="fa-solid fa-pen mr-1"></i> Edit
            </a>
        </div>
    @empty
        <div class="bg-white rounded-xl shadow-sm border p-12 text-center text-gray-400">
            <i class="fa-solid fa-pager text-4xl mb-3"></i>
            <p>No page sections found.</p>
        </div>
    @endforelse
</div>
@endsection
