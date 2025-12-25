<?php

namespace App\Http\Controllers;

use App\Models\MemberRecognition;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MemberRecognitionController extends Controller
{
    /**
     * Display a listing of recognitions.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = MemberRecognition::with(['member', 'giver', 'chapter'])
            ->when($user->role === 'member', function ($q) use ($user) {
                // Members see only recognitions from their chapter
                $q->where('chapter_id', $user->chapter_id);
            })
            ->when($request->category, fn($q) => $q->where('category', $request->category))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('title', 'like', "%$search%")
                        ->orWhereHas('member', fn($u) => $u->where('name', 'like', "%$search%"))
                        ->orWhereHas('giver', fn($u) => $u->where('name', 'like', "%$search%"));
                });
            })
            ->latest();

        $recognitions = $query->paginate(10);

        return view('member.recognitions.index', compact('recognitions'));
    }

    /**
     * Show the form for creating a new recognition.
     */
    public function create()
    {
        $user = Auth::user();
        $members = User::where('chapter_id', $user->chapter_id)
            ->where('id', '!=', $user->id)
            ->orderBy('name')
            ->get();

        return view('member.recognitions.create', compact('members'));
    }

    /**
     * Store a newly created recognition in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'member_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'category' => 'required|string|in:referral,thank_you,visitor,leadership,training,testimony,support,milestone,other',
            'description' => 'nullable|string',
            'recognized_on' => 'required|date',
            'business_value' => 'nullable|numeric',
            'points' => 'nullable|integer|min:0',
            'evidence_file' => 'nullable|file|max:2048|mimes:jpg,jpeg,png,pdf',
        ]);

        if ($request->hasFile('evidence_file')) {
            $validated['evidence_file'] = $request->file('evidence_file')->store('recognitions', 'public');
        }

        $validated['chapter_id'] = $user->chapter_id;
        $validated['given_by'] = $user->id;
        $validated['status'] = 'approved'; // Auto-approved for now

        MemberRecognition::create($validated);

        return redirect()->route($this->recognitionIndexRoute())
    ->with('success', 'Recognition added successfully!');

    }

    /**
     * Show a specific recognition.
     */
    public function show(MemberRecognition $recognition)
    {
        $recognition->load(['member', 'giver', 'chapter', 'approver']);
        return view('member.recognitions.show', compact('recognition'));
    }

    /**
     * Edit a recognition.
     */
    public function edit(MemberRecognition $recognition)
    {
        $this->authorizeAccess($recognition);

        $user = Auth::user();
        $members = User::where('chapter_id', $user->chapter_id)
            ->where('id', '!=', $user->id)
            ->orderBy('name')
            ->get();

        return view('member.recognitions.edit', compact('recognition', 'members'));
    }

    /**
     * Update a recognition.
     */
    public function update(Request $request, MemberRecognition $recognition)
    {
        $this->authorizeAccess($recognition);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'recognized_on' => 'required|date',
            'business_value' => 'nullable|numeric',
            'points' => 'nullable|integer|min:0',
            'status' => 'in:pending,approved,rejected',
        ]);

        if ($request->hasFile('evidence_file')) {
            if ($recognition->evidence_file) {
                Storage::disk('public')->delete($recognition->evidence_file);
            }
            $validated['evidence_file'] = $request->file('evidence_file')->store('recognitions', 'public');
        }

        $recognition->update($validated);

       return redirect()->route($this->recognitionIndexRoute())
    ->with('success', 'Recognition updated successfully.');

    }

    /**
     * Delete a recognition.
     */
    public function destroy(MemberRecognition $recognition)
    {
        $this->authorizeAccess($recognition);

        if ($recognition->evidence_file) {
            Storage::disk('public')->delete($recognition->evidence_file);
        }

        $recognition->delete();

       return redirect()->route($this->recognitionIndexRoute())
    ->with('success', 'Recognition deleted.');

    }

    /**
     * Authorize member access.
     */
    protected function authorizeAccess(MemberRecognition $recognition)
    {
        $user = Auth::user();
        if ($recognition->chapter_id !== $user->chapter_id && $user->role === 'member') {
            abort(403, 'You are not authorized to modify this recognition.');
        }
        
    }
    protected function recognitionIndexRoute(): string
{
    $user = Auth::user();

    return $user->role === 'admin'
        ? 'admin.recognitions.index'
        : 'member.recognitions.index';
}


}
