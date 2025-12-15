<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enquiry;

class EnquiryController extends Controller
{
    // ✅ List all enquiries
    public function index(Request $request)
    {
        $query = Enquiry::query();

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function($query) use ($q) {
                $query->where('name', 'like', "%$q%")
                      ->orWhere('email', 'like', "%$q%")
                      ->orWhere('profession', 'like', "%$q%");
            });
        }

        $enquiries = $query->latest()->paginate(10);
        return view('admin.enquiries.index', compact('enquiries'));
    }

    // ✅ Create new enquiry (Admin Panel)
    public function store(Request $request)
    {
       
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'nullable|email|max:255',
            'contact_number' => 'nullable|string|max:20',
            'profession'     => 'nullable|string|max:255',
            'status'         => 'required|string|in:new,closed',
        ]);

        $enquiry = Enquiry::create($validated);

        return response()->json([
            'message' => 'Enquiry created successfully.',
            'data' => $enquiry
        ], 201);
    }
    // Storr journey
    public function storeJourney(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'nullable|email|max:255',
            'contact_number' => 'nullable|string|max:20',
            'profession'     => 'nullable|string|max:255',
            'is_agreed'      => 'accepted',
        ]);

        Enquiry::create([
            'name'           => $validated['name'],
            'email'          => $validated['email'] ?? null,
            'contact_number' => $validated['contact_number'] ?? null,
            'profession'     => $validated['profession'] ?? null,
            'is_agreed'      => true,
            'source'         => 'TMN Website', // optional tracking
        ]);

        return back()->with('success', 'Thank you for your enquiry! We’ll contact you soon.');
    }

    // ✅ Show single enquiry (View / Edit)
    public function show(Enquiry $enquiry)
    {
        return response()->json($enquiry);
    }

    // ✅ Update enquiry
    public function update(Request $request, Enquiry $enquiry)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'nullable|email|max:255',
            'contact_number' => 'nullable|string|max:20',
            'profession'     => 'nullable|string|max:255',
            'status'         => 'required|string|in:new,closed',
        ]);

        $enquiry->update($validated);

        return response()->json([
            'message' => 'Enquiry updated successfully.',
            'data' => $enquiry
        ], 200);
    }

    // ✅ Delete enquiry
    public function destroy(Enquiry $enquiry)
    {
        $enquiry->delete();

        return response()->json(['message' => 'Enquiry deleted successfully.']);
    }
}
