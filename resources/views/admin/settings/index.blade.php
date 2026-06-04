@extends('layouts.admin')
@section('title', 'Settings')
@section('page_title', 'Website Settings')

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf

    @foreach($grouped as $group => $items)
        <div class="bg-white rounded-xl shadow-sm border mb-6">
            <div class="p-5 border-b">
                <h3 class="text-lg font-semibold text-gray-800 capitalize">{{ $group }}</h3>
            </div>
            <div class="p-5 space-y-5">
                @foreach($items as $setting)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ ucfirst(str_replace('_', ' ', $setting->key)) }}</label>
                        @if($setting->type === 'textarea')
                            <textarea name="settings[{{ $setting->key }}]" rows="3" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-400 focus:border-gold-400">{{ old("settings.{$setting->key}", $setting->value) }}</textarea>
                        @else
                            <input type="text" name="settings[{{ $setting->key }}]" value="{{ old("settings.{$setting->key}", $setting->value) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-gold-400 focus:border-gold-400">
                        @endif
                        <p class="text-xs text-gray-400 mt-1 font-mono">{{ $setting->key }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <div class="flex gap-3">
        <button type="submit" class="bg-gold-400 hover:bg-gold-500 text-navy-900 font-semibold px-6 py-2 rounded-lg">
            Save All Settings
        </button>
    </div>
</form>
@endsection
