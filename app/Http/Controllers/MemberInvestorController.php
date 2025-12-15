<?php

namespace App\Http\Controllers;

use App\Models\MemberInvestor;
use App\Models\User;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberInvestorController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = MemberInvestor::with(['member', 'chapter'])
            ->when($user->role === 'member', fn($q) => $q->where('member_id', $user->id))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('investor_name', 'like', "%$search%")
                        ->orWhere('company_name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                });
            })
            ->latest();

        $investors = $query->paginate(10);

        return view('member.investors.index', compact('investors'));
    }

    public function create()
    {
        $user = Auth::user();
        $chapters = Chapter::orderBy('name')->get();

        return view('member.investors.create', compact('chapters'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'investor_name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'alternate_phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'linkedin_profile' => 'nullable|string|max:255',
            'investment_focus' => 'nullable|string|max:255',
            'investment_capacity' => 'nullable|numeric',
            'invested_value' => 'nullable|numeric',
            'preferred_stage' => 'nullable|string|max:255',
            'preferred_ticket_size' => 'nullable|string|max:255',
            'years_of_experience' => 'nullable|integer',
            'relationship_type' => 'nullable|string|in:personal,professional,referral',
            'referral_source' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'status' => 'nullable|string|in:potential,active,inactive',
        ]);

        $validated['member_id'] = $user->id;
        $validated['chapter_id'] = $user->chapter_id;
        $validated['created_by'] = $user->id;

        MemberInvestor::create($validated);

        return redirect()->route('member.investors.index')->with('success', 'Investor added successfully!');
    }

    public function show(MemberInvestor $investor)
    {
        $this->authorizeAccess($investor);
        return view('member.investors.show', compact('investor'));
    }

    public function edit(MemberInvestor $investor)
    {
        $this->authorizeAccess($investor);
        $chapters = Chapter::orderBy('name')->get();

        return view('member.investors.edit', compact('investor', 'chapters'));
    }

    public function update(Request $request, MemberInvestor $investor)
    {
        $this->authorizeAccess($investor);

        $validated = $request->validate([
            'investor_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'investment_focus' => 'nullable|string|max:255',
            'investment_capacity' => 'nullable|numeric',
            'status' => 'nullable|string|in:potential,active,inactive',
            'notes' => 'nullable|string',
        ]);

        $investor->update($validated);

        return redirect()->route('member.investors.index')->with('success', 'Investor updated successfully!');
    }

    public function destroy(MemberInvestor $investor)
    {
        $this->authorizeAccess($investor);
        $investor->delete();

        return back()->with('success', 'Investor deleted successfully.');
    }

    protected function authorizeAccess(MemberInvestor $investor)
    {
        $user = Auth::user();
        if ($user->role === 'member' && $investor->member_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }
    }
}
