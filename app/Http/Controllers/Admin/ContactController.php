<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * Display a paginated list of contact messages.
     */
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(20);

        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Show a single contact message.
     */
    public function show(Contact $contact)
    {
        if (! $contact->is_read) {
            $contact->markAsRead();
        }

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Mark a contact message as read.
     */
    public function markAsRead(Contact $contact)
    {
        $contact->markAsRead();

        return redirect()->route('admin.contacts.index')->with('success', 'Message marked as read.');
    }

    /**
     * Delete a contact message.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('success', 'Message deleted successfully.');
    }
}
