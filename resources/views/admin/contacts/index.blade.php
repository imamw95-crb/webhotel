@extends('layouts.admin')
@section('title', 'Contact Messages')
@section('page_title', 'Contact Messages')

@section('content')
<div class="flex justify-between items-center mb-6">
    <p class="text-gray-500">Messages from the website contact form.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Sender</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Subject</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Message</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Date</th>
                    <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($contacts as $contact)
                    <tr class="hover:bg-gray-50 {{ $contact->is_read ? '' : 'bg-yellow-50/50 font-medium' }}">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-navy-800 text-white rounded-full flex items-center justify-center flex-shrink-0 text-sm font-medium">
                                    {{ strtoupper(substr($contact->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-gray-800 {{ $contact->is_read ? '' : 'font-semibold' }}">{{ $contact->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $contact->email }}</p>
                                    @if($contact->phone)
                                        <p class="text-xs text-gray-400">{{ $contact->phone }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 max-w-[200px] truncate">
                            {{ $contact->subject ?? '(No subject)' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 max-w-[250px] truncate">
                            {{ $contact->message }}
                        </td>
                        <td class="px-6 py-4">
                            @if($contact->is_read)
                                <span class="px-2.5 py-1 text-xs rounded-full bg-gray-100 text-gray-600">Read</span>
                            @else
                                <span class="px-2.5 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">New</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-400 whitespace-nowrap">{{ $contact->created_at->format('d M Y H:i') }}</td>
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <a href="{{ route('admin.contacts.show', $contact) }}" class="text-blue-500 hover:text-blue-700 mr-2" title="View">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            @if(!$contact->is_read)
                                <form action="{{ route('admin.contacts.mark-read', $contact) }}" method="POST" class="inline mr-2">
                                    @csrf
                                    <button type="submit" class="text-green-500 hover:text-green-700" title="Mark as read">
                                        <i class="fa-solid fa-envelope-open"></i>
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="inline" onsubmit="return confirm('Delete this message?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600" title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">No messages yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($contacts->hasPages())
        <div class="p-4 border-t">{{ $contacts->links() }}</div>
    @endif
</div>
@endsection
