@extends('layouts.admin')
@section('title', 'Message from ' . $contact->name)
@section('page_title', 'Message Details')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <div class="flex items-start gap-4 mb-6">
            <div class="w-14 h-14 bg-navy-800 text-white rounded-full flex items-center justify-center flex-shrink-0 text-xl font-bold">
                {{ strtoupper(substr($contact->name, 0, 1)) }}
            </div>
            <div class="flex-1">
                <h3 class="text-xl font-semibold text-gray-800">{{ $contact->name }}</h3>
                <p class="text-gray-500">{{ $contact->email }}</p>
                @if($contact->phone)
                    <p class="text-gray-500">{{ $contact->phone }}</p>
                @endif
            </div>
            <div class="text-right text-sm text-gray-400">
                <p>{{ $contact->created_at->format('d M Y') }}</p>
                <p>{{ $contact->created_at->format('H:i') }}</p>
            </div>
        </div>

        @if($contact->subject)
            <div class="mb-4">
                <span class="text-xs text-gray-400 uppercase font-medium">Subject</span>
                <p class="text-gray-800 font-medium">{{ $contact->subject }}</p>
            </div>
        @endif

        <div class="mb-6">
            <span class="text-xs text-gray-400 uppercase font-medium">Message</span>
            <div class="mt-2 bg-gray-50 rounded-lg p-4 text-gray-700 whitespace-pre-wrap">{{ $contact->message }}</div>
        </div>

        <hr class="my-6">

        <div class="flex items-center justify-between">
            <div>
                @if($contact->is_read)
                    <span class="px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-600">
                        <i class="fa-solid fa-check-circle mr-1"></i> Read
                    </span>
                @else
                    <span class="px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-700">
                        <i class="fa-solid fa-envelope mr-1"></i> New
                    </span>
                @endif
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.contacts.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition text-sm font-medium">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Back
                </a>
                @if(!$contact->is_read)
                    <form action="{{ route('admin.contacts.mark-read', $contact) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition text-sm font-medium">
                            <i class="fa-solid fa-envelope-open mr-1"></i> Mark as Read
                        </button>
                    </form>
                @endif
                <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="inline" onsubmit="return confirm('Delete this message?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition text-sm font-medium">
                        <i class="fa-solid fa-trash mr-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
