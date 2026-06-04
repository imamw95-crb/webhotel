@extends('layouts.admin')
@section('title', 'Edit Section: ' . $section->section_key)
@section('page_title', 'Edit: ' . $section->section_key)

@section('content')
<div class="max-w-3xl">
    <form action="{{ route('admin.sections.update', $section) }}" method="POST">
        @csrf @method('PUT')

        <div class="bg-white rounded-xl shadow-sm border p-6 space-y-5">
            <div class="bg-gray-50 rounded-lg p-3">
                <span class="text-xs font-mono text-gray-500">Section Key: {{ $section->section_key }}</span>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" name="title" value="{{ old('title', $section->title) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-400 focus:border-gold-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                <input type="text" name="subtitle" value="{{ old('subtitle', $section->subtitle) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-400 focus:border-gold-400">
            </div>

            @if(is_array($section->content))
                @foreach($section->content as $key => $value)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                        @if(is_string($value) && strlen($value) > 100)
                            <textarea name="content[{{ $key }}]" rows="4" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-400 focus:border-gold-400">{{ old("content.{$key}", $value) }}</textarea>
                        @elseif(is_array($value))
                            <textarea name="content[{{ $key }}]" rows="6" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-400 focus:border-gold-400 font-mono text-sm">{{ old("content.{$key}", json_encode($value, JSON_PRETTY_PRINT)) }}</textarea>
                            <p class="text-xs text-gray-400 mt-1">JSON format</p>
                        @else
                            <input type="text" name="content[{{ $key }}]" value="{{ old("content.{$key}", $value) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-400 focus:border-gold-400">
                        @endif
                    </div>
                @endforeach
            @endif

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $section->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-gold-400 focus:ring-gold-400">
                <label for="is_active" class="text-sm text-gray-700">Active</label>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="bg-gold-400 hover:bg-gold-500 text-navy-900 font-semibold px-6 py-2 rounded-lg">
                Update Section
            </button>
            <a href="{{ route('admin.sections.index') }}" class="px-6 py-2 border rounded-lg text-gray-600 hover:bg-gray-50">Cancel</a>
        </div>
    </form>
</div>
@endsection
