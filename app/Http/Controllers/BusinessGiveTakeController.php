<?php

namespace App\Http\Controllers;

use App\Models\BusinessGiveTake;
use App\Models\Chapter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessGiveTakeController extends Controller
{
    /**
     * Display a listing of the business give/take records.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;
        $chapterId = $user->chapter_id ?? null;

        // Filter setup
        $type = $request->get('type', 'given'); // given | taken | all
        $status = $request->get('status');
        $referralType = $request->get('referral_type');
        $search = $request->get('search');

        $query = BusinessGiveTake::with(['giver', 'taker', 'chapter'])
            // 🧭 Restrict to user's chapter
            ->when($chapterId, fn($q) =>
                $q->where('chapter_id', $chapterId)
            )
            // 👤 Show given/taken
            ->when($type === 'given', fn($q) => $q->where('giver_id', $userId))
            ->when($type === 'taken', fn($q) => $q->where('taker_id', $userId))
            // ⚙️ Filters
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($referralType, fn($q) => $q->where('referral_type', $referralType))
            ->when($search, fn($q) =>
                $q->where(function ($sub) use ($search) {
                    $sub->where('service_name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhereHas('taker', fn($u) => $u->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('giver', fn($u) => $u->where('name', 'like', "%{$search}%"));
                })
            )
            ->latest();

        $records = $query->paginate(10);

        return view('member.business_give_takes.index', compact('records', 'type'));
    }

    /**
     * Show the form for creating a new give/take record.
     */
    public function create()
    {
        $user = Auth::user();
        $chapterId = $user->chapter_id ?? null;

        // 🔒 Only members from the same chapter
        $members = User::where('id', '!=', $user->id)
            ->when($chapterId, fn($q) => $q->where('chapter_id', $chapterId))
            ->orderBy('name')
            ->get();

        $chapters = Chapter::when($chapterId, fn($q) => $q->where('id', $chapterId))->get();

        return view('member.business_give_takes.create', compact('members', 'chapters'));
    }

    /**
     * Store a newly created record.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'taker_id' => 'required|exists:users,id',
            'chapter_id' => 'nullable|exists:chapters,id',
            'service_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'business_value' => 'nullable|numeric',
            'referral_type' => 'required|string|in:referral,thank_you,1to1,visitor,training,testimony',
            'referral_company' => 'nullable|string|max:255',
            'referral_contact_person' => 'nullable|string|max:255',
            'referral_contact_phone' => 'nullable|string|max:20',
            'referral_contact_email' => 'nullable|email|max:255',
            'reference_document' => 'nullable|file|max:2048',
        ]);

        // Auto-assign member's chapter if not manually selected
        if (!$validated['chapter_id'] && $user->chapter_id) {
            $validated['chapter_id'] = $user->chapter_id;
        }

        if ($request->hasFile('reference_document')) {
            $validated['reference_document'] = $request->file('reference_document')->store('business_docs', 'public');
        }

        $validated['giver_id'] = $user->id;
        $validated['created_by'] = $user->id;

        BusinessGiveTake::create($validated);

        return redirect()->route('member.business.index')->with('success', 'Business record added successfully.');
    }

    /**
     * Display a single record.
     */
    public function show(BusinessGiveTake $businessGiveTake)
    {
        $this->authorizeAccess($businessGiveTake);

        return view('member.business_give_takes.show', compact('businessGiveTake'));
    }

    /**
     * Show the form for editing a record.
     */
    public function edit(BusinessGiveTake $businessGiveTake)
    {
        $this->authorizeAccess($businessGiveTake);

        $user = Auth::user();
        $chapterId = $user->chapter_id ?? null;

        $members = User::where('id', '!=', $user->id)
            ->when($chapterId, fn($q) => $q->where('chapter_id', $chapterId))
            ->orderBy('name')
            ->get();

        $chapters = Chapter::when($chapterId, fn($q) => $q->where('id', $chapterId))->get();

        return view('member.business_give_takes.edit', compact('businessGiveTake', 'members', 'chapters'));
    }

    /**
     * Update the specified record.
     */
    public function update(Request $request, BusinessGiveTake $businessGiveTake)
    {
        $this->authorizeAccess($businessGiveTake);

        $validated = $request->validate([
            'service_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'business_value' => 'nullable|numeric',
            'status' => 'nullable|string|in:pending,accepted,rejected,closed,cancelled',
            'referral_type' => 'required|string|in:referral,thank_you,1to1,visitor,training,testimony',
        ]);

        $businessGiveTake->update($validated);

        return redirect()->route('member.business.index')->with('success', 'Record updated successfully.');
    }

    /**
     * Accept a request.
     */
    public function accept(BusinessGiveTake $businessGiveTake)
    {
        $this->authorizeAccess($businessGiveTake);

        $businessGiveTake->update([
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);

        return back()->with('success', 'Referral accepted successfully.');
    }

    /**
     * Reject a request.
     */
    public function reject(Request $request, BusinessGiveTake $businessGiveTake)
    {
        $this->authorizeAccess($businessGiveTake);

        $request->validate(['reject_reason' => 'nullable|string|max:500']);

        $businessGiveTake->update([
            'status' => 'rejected',
            'reject_reason' => $request->reject_reason,
            'rejected_at' => now(),
        ]);

        return back()->with('success', 'Referral rejected.');
    }

    /**
     * Delete a record.
     */
    public function destroy(BusinessGiveTake $businessGiveTake)
    {
        $this->authorizeAccess($businessGiveTake);

        $businessGiveTake->delete();

        return back()->with('success', 'Record deleted successfully.');
    }

    /**
     * Authorization: user can view/edit only if in same chapter or direct participant.
     */
    protected function authorizeAccess(BusinessGiveTake $record)
    {
        $user = Auth::user();

        // Must belong to same chapter OR be giver/taker
        if (
            ($record->chapter_id !== $user->chapter_id) &&
            ($record->giver_id !== $user->id) &&
            ($record->taker_id !== $user->id)
        ) {
            abort(403, 'You are not authorized to view this record.');
        }
    }
}
