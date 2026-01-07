<?php

namespace App\Http\Controllers;

use App\Models\ContactQuery;
use Illuminate\Http\Request;

class ContactQueryController extends Controller
{
    /* =========================================================
     | USER SIDE
     ========================================================= */

    /**
     * Store contact form submission (Public Contact Page)
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'required|email|max:255',
        'phone'   => 'nullable|string|max:20',
        'message' => 'required|string|min:10',
    ]);

    ContactQuery::create([
        'name'       => $validated['name'],
        'email'      => $validated['email'],
        'phone'      => $validated['phone'] ?? null,
        'message'    => $validated['message'],
        'source'     => 'contact_page',
        'ip_address' => $request->ip(),
        'status'     => 'new',
        'is_read'    => false,
    ]);

    return back()->with('success', 'Thank you! We will contact you shortly.');
}

    /* =========================================================
     | ADMIN SIDE
     ========================================================= */

    /**
     * List all contact queries
     */
    public function index(Request $request)
    {
        $query = ContactQuery::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $contacts = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.contact.index', compact('contacts'));
    }

    /**
     * View single contact query
     */
    public function show(ContactQuery $contact)
    {
        if (!$contact->is_read) {
            $contact->update(['is_read' => true]);
        }

        return view('admin.contact.show', compact('contact'));
    }

    /**
     * Edit contact query (status only)
     */
    public function edit(ContactQuery $contact)
    {
        return view('admin.contact.edit', compact('contact'));
    }

    /**
     * Update contact query (status)
     */
    public function update(Request $request, ContactQuery $contact)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,contacted,resolved,closed',
        ]);

        $contact->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('admin.contact.index')
            ->with('success', 'Contact status updated successfully.');
    }

    /**
     * Delete contact query
     */
    public function destroy(ContactQuery $contact)
    {
        $contact->delete();

        return redirect()
            ->route('admin.contact.index')
            ->with('success', 'Contact query deleted successfully.');
    }
}
