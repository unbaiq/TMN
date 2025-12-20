<?php

namespace App\Http\Controllers;

use App\Models\MemberConnect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberConnectController extends Controller
{
    /**
     * Display all visible connects (BNI-style global directory)
     */
    public function index(Request $request)
    {
        $type = $request->get('type', 'all'); // all | my
    
        $query = MemberConnect::with('member');
    
        // ✅ MY CONNECTS (only logged-in user, no visibility restriction)
        if ($type === 'my') {
            $query->where('user_id', auth()->id());
        }
        // ✅ ALL CONNECTS (global BNI directory)
        else {
            $query->where('is_active', true)
                  ->whereIn('visibility', ['members', 'public']);
        }
    
        // 🔍 SEARCH (works for both)
        if ($request->filled('search')) {
            $search = $request->search;
    
            $query->where(function ($q) use ($search) {
                $q->where('person_name', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('industry', 'like', "%{$search}%")
                  ->orWhere('profession', 'like', "%{$search}%");
            });
        }
    
        $connects = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();
    
        return view('member.member-connects.index', compact('connects', 'type'));
    }


    /**
     * Show create form
     */
    public function create()
    {
        return view('member.member-connects.create');
    }

    /**
     * Store new member connect
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            // Personal
            'person_name'       => 'required|string|max:255',
            'designation'       => 'nullable|string|max:255',

            // Business
            'company_name'      => 'required|string|max:255',
            'industry'          => 'required|string|max:255',
            'profession'        => 'required|string|max:255',
            'services'          => 'nullable|string',
            'website'           => 'nullable|url',

            // Contact
            'contact_phone'     => 'nullable|string|max:20',
            'contact_email'     => 'nullable|email|max:255',
            'whatsapp_number'   => 'nullable|string|max:20',

            // Location & chapter
            'location'          => 'nullable|string|max:255',
            'chapter_name'      => 'nullable|string|max:255',

            // Visibility
            'visibility'        => 'required|in:public,members',
        ]);

        $data['user_id'] = Auth::id();

        // Newly created connects are unverified by default
        $data['is_verified'] = false;

        MemberConnect::create($data);

        return redirect()
            ->route('member.connects.index')
            ->with('success', 'Business connect added successfully. Pending verification.');
    }

    /**
     * Show edit form
     */
    public function edit(MemberConnect $memberConnect)
    {
        $this->authorizeOwner($memberConnect);

        return view('member.member-connects.edit', compact('memberConnect'));
    }

    /**
     * Update existing connect
     */
    public function update(Request $request, MemberConnect $memberConnect)
    {
        $this->authorizeOwner($memberConnect);

        $data = $request->validate([
            // Personal
            'person_name'       => 'required|string|max:255',
            'designation'       => 'nullable|string|max:255',

            // Business
            'company_name'      => 'required|string|max:255',
            'industry'          => 'required|string|max:255',
            'profession'        => 'required|string|max:255',
            'services'          => 'nullable|string',
            'website'           => 'nullable|url',

            // Contact
            'contact_phone'     => 'nullable|string|max:20',
            'contact_email'     => 'nullable|email|max:255',
            'whatsapp_number'   => 'nullable|string|max:20',

            // Location & chapter
            'location'          => 'nullable|string|max:255',
            'chapter_name'      => 'nullable|string|max:255',

            // Visibility
            'visibility'        => 'required|in:public,members',
            'is_active'         => 'nullable|boolean',
        ]);

        // Editing resets verification (BNI-style safety)
        $data['is_verified'] = false;

        $memberConnect->update($data);

        return redirect()
            ->route('member.connects.index')
            ->with('success', 'Business connect updated. Re-verification required.');
    }

    /**
     * Delete connect
     */
    public function destroy(MemberConnect $memberConnect)
    {
        $this->authorizeOwner($memberConnect);

        $memberConnect->delete();

        return back()->with('success', 'Business connect deleted successfully.');
    }

    /**
     * Ownership check
     */
    private function authorizeOwner(MemberConnect $connect): void
    {
        abort_if($connect->user_id !== Auth::id(), 403, 'Unauthorized action.');
    }
}
