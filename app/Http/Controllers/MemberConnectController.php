<?php

namespace App\Http\Controllers;

use App\Models\MemberConnect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberConnectController extends Controller
{
    /**
     * Display all connects
     * type = all | my
     */
    public function index(Request $request)
    {
        $type = $request->get('type', 'all');

        $query = MemberConnect::with('member');

        // Show only my connects
        if ($type === 'my') {
            $query->where('user_id', Auth::id());
        }

        // Search
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
     * Store new connect
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'person_name'     => 'required|string|max:255',
            'designation'     => 'nullable|string|max:255',
            'company_name'    => 'required|string|max:255',
            'industry'        => 'required|string|max:255',
            'profession'      => 'required|string|max:255',
            'services'        => 'nullable|string',
            'website'         => 'nullable|string',
            'contact_phone'   => 'nullable|string|max:20',
            'contact_email'   => 'nullable|email|max:255',
            'whatsapp_number' => 'nullable|string|max:20',
            'location'        => 'nullable|string|max:255',
            'chapter_name'    => 'nullable|string|max:255',
        ]);

        $data['user_id'] = Auth::id();
        $data['is_verified'] = false;
        $data['is_active'] = true;
        $data['recommendation_count'] = 0;

        MemberConnect::create($data);

        return redirect()
            ->route('member.connects.index')
            ->with('success', 'Business connect added successfully.');
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
     * Update connect
     */
    public function update(Request $request, MemberConnect $memberConnect)
    {
        $this->authorizeOwner($memberConnect);

        $data = $request->validate([
            'person_name'     => 'required|string|max:255',
            'designation'     => 'nullable|string|max:255',
            'company_name'    => 'required|string|max:255',
            'industry'        => 'required|string|max:255',
            'profession'      => 'required|string|max:255',
            'services'        => 'nullable|string',
            'website'         => 'nullable|string',
            'contact_phone'   => 'nullable|string|max:20',
            'contact_email'   => 'nullable|email|max:255',
            'whatsapp_number' => 'nullable|string|max:20',
            'location'        => 'nullable|string|max:255',
            'chapter_name'    => 'nullable|string|max:255',
            'is_active'       => 'nullable|boolean',
        ]);

        // Reset verification on edit
        $data['is_verified'] = false;

        $memberConnect->update($data);

        return redirect()
            ->route('member.connects.index')
            ->with('success', 'Business connect updated successfully.');
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
