<?php

namespace App\Http\Controllers;

use App\Models\MemberAward;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MemberAwardController extends Controller
{
    /**
     * Display list of awards
     */
    public function index(Request $request)
{
    $user = Auth::user();

    $query = \App\Models\MemberAward::with(['member', 'chapter'])
        ->when($user->role === 'member', fn($q) => $q->where('chapter_id', $user->chapter_id))
        ->when($request->search, function ($q, $search) {
            $q->where(function ($sub) use ($search) {
                $sub->where('title', 'like', "%$search%")
                    ->orWhereHas('member', fn($u) => $u->where('name', 'like', "%$search%"));
            });
        })
        ->when($request->award_type, fn($q) => $q->where('award_type', $request->award_type))
        ->when($request->month, fn($q) => $q->where('month', $request->month))
        ->when($request->year, fn($q) => $q->where('year', $request->year))
        ->latest();

    // ✅ This variable must exist
    $awards = $query->paginate(10);

    // ✅ Make sure view name matches folder exactly
    return view('member.awards.index', compact('awards'));
}

    /**
     * Show create form
     */
    public function create()
    {
        $user = Auth::user();
        $members = User::where('chapter_id', $user->chapter_id)
            ->where('id', '!=', $user->id)
            ->orderBy('name')
            ->get();

        return view('member.awards.create', compact('members'));
    }

    /**
     * Store new award
     */
    public function store(Request $request)
    {
  
        $user = Auth::user();

        $validated = $request->validate([
            'member_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'award_type' => 'required|string',
            'description' => 'nullable|string',
            'month' => 'nullable|string|max:20',
            'year' => 'nullable|integer|min:2000|max:2100',
            'business_value' => 'nullable|numeric',
            'points' => 'nullable|integer|min:0',
            'certificate_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
      

        if ($request->hasFile('certificate_file')) {
            $validated['certificate_file'] = $request->file('certificate_file')->store('awards', 'public');
        }

        $validated['chapter_id'] = $user->chapter_id;
        $validated['created_by'] = $user->id;
        $validated['status'] = 'approved';

        MemberAward::create($validated);

        return redirect()->route($this->awardIndexRoute())
        ->with('success', 'Award created successfully!');

    }

    /**
     * Show specific award
     */
    public function show(MemberAward $award)
    {
        $award->load(['member', 'chapter', 'creator']);
        return view('member.awards.show', compact('award'));
    }

    /**
     * Edit form
     */
    public function edit(MemberAward $award)
    {
        $this->authorizeAccess($award);
        $user = Auth::user();

        $members = User::where('chapter_id', $user->chapter_id)
            ->where('id', '!=', $user->id)
            ->orderBy('name')
            ->get();

        return view('member.awards.edit', compact('award', 'members'));
    }

    /**
     * Update award
     */
    public function update(Request $request, MemberAward $award)
    {
        $this->authorizeAccess($award);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'month' => 'nullable|string|max:20',
            'year' => 'nullable|integer|min:2000|max:2100',
            'business_value' => 'nullable|numeric',
            'points' => 'nullable|integer|min:0',
            'status' => 'nullable|string|in:pending,approved,rejected',
        ]);

        if ($request->hasFile('certificate_file')) {
            if ($award->certificate_file) Storage::disk('public')->delete($award->certificate_file);
            $validated['certificate_file'] = $request->file('certificate_file')->store('awards', 'public');
        }

        $award->update($validated);

        return redirect()->route($this->awardIndexRoute())
    ->with('success', 'Award updated successfully!');

    }

    /**
     * Delete award
     */
    public function destroy(MemberAward $award)
    {
        $this->authorizeAccess($award);

        if ($award->certificate_file) Storage::disk('public')->delete($award->certificate_file);
        $award->delete();

        return redirect()->route($this->awardIndexRoute())
    ->with('success', 'Award deleted successfully!');

    }

    /**
     * Simple access rule: only same chapter or creator can edit
     */
    protected function authorizeAccess(MemberAward $award)
    {
        $user = Auth::user();
        if ($user->role === 'member' && $award->chapter_id !== $user->chapter_id) {
            abort(403, 'You are not authorized to manage this award.');
        }
    }
    protected function awardIndexRoute(): string
{
    $user = Auth::user();

    return $user->role === 'admin'
        ? 'admin.awards.index'
        : 'member.awards.index';
}

}
