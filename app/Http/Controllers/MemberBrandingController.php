<?php

namespace App\Http\Controllers;

use App\Models\MemberBranding;
use App\Models\Chapter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MemberBrandingController extends Controller
{
    /**
     * Display a listing of branding records (Articles, Stories, etc.)
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = MemberBranding::with(['member', 'chapter'])
            ->when($user->role === 'member', fn($q) => $q->where('member_id', $user->id))
            ->search($request->search)
            ->ofType($request->branding_type)
            ->ofStatus($request->status)
            ->when($request->chapter_id, fn($q) => $q->where('chapter_id', $request->chapter_id))
            ->latest();

        $brandings = $query->paginate(10);

        $chapters = Chapter::orderBy('name')->get();

        return view('member.brandings.index', compact('brandings', 'chapters'));
    }

    /**
     * Show the form for creating a new branding record
     */
    public function create()
    {
        $user = Auth::user();
        $chapters = Chapter::orderBy('name')->get();
        $brandingTypes = [
            'article' => 'Article',
            'story' => 'Story',
            'video_shoot' => 'Video Shoot',
            'podcast' => 'Podcast',
            'pr_activity' => 'PR Activity',
            'media_release' => 'Media Release',
            'magazine_feature' => 'Magazine Feature',
            'award_mention' => 'Award Mention',
            'social_campaign' => 'Social Campaign',
            'other' => 'Other',
        ];

        return view('member.brandings.create', compact('chapters', 'brandingTypes'));
    }

    /**
     * Store a newly created branding record
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'branding_type' => 'required|string',
            'title' => 'required|string|max:255',
            'headline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'theme' => 'nullable|string|max:255',
            'activity_date' => 'nullable|date',
            'duration' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'collaborators' => 'nullable|string|max:255',
            'sponsor_name' => 'nullable|string|max:255',
            'agency_name' => 'nullable|string|max:255',
            'media_platform' => 'nullable|string|max:255',
            'media_link' => 'nullable|url|max:255',
            'media_type' => 'nullable|string|max:255',
            'reach_count' => 'nullable|integer',
            'engagement_count' => 'nullable|integer',
            'estimated_value' => 'nullable|numeric',
            'publication_name' => 'nullable|string|max:255',
            'journalist_name' => 'nullable|string|max:255',
            'video_length' => 'nullable|string|max:255',
            'series_name' => 'nullable|string|max:255',
            'proof_document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'thumbnail_image' => 'nullable|file|mimes:jpg,jpeg,png|max:4096',
        ]);

        // File uploads
        if ($request->hasFile('proof_document')) {
            $validated['proof_document'] = $request->file('proof_document')->store('branding_docs', 'public');
        }
        if ($request->hasFile('thumbnail_image')) {
            $validated['thumbnail_image'] = $request->file('thumbnail_image')->store('branding_thumbnails', 'public');
        }

        $validated['member_id'] = $user->id;
        $validated['chapter_id'] = $user->chapter_id;
        $validated['created_by'] = $user->id;
        $validated['status'] = 'submitted';

        MemberBranding::create($validated);

        return redirect()->route('member.brandings.index')->with('success', 'Branding activity added successfully!');
    }

    /**
     * Display a specific branding record
     */
    public function show(MemberBranding $branding)
    {
        $branding->load(['member', 'chapter', 'approver']);
        $this->authorizeAccess($branding);

        return view('member.brandings.show', compact('branding'));
    }

    /**
     * Show the form for editing a branding record
     */
    public function edit(MemberBranding $branding)
    {
        $this->authorizeAccess($branding);

        $chapters = Chapter::orderBy('name')->get();
        $brandingTypes = [
            'article' => 'Article',
            'story' => 'Story',
            'video_shoot' => 'Video Shoot',
            'podcast' => 'Podcast',
            'pr_activity' => 'PR Activity',
            'media_release' => 'Media Release',
            'magazine_feature' => 'Magazine Feature',
            'award_mention' => 'Award Mention',
            'social_campaign' => 'Social Campaign',
            'other' => 'Other',
        ];

        return view('member.brandings.edit', compact('branding', 'chapters', 'brandingTypes'));
    }

    /**
     * Update a branding record
     */
    public function update(Request $request, MemberBranding $branding)
    {
        $this->authorizeAccess($branding);

        $validated = $request->validate([
            'branding_type' => 'required|string',
            'title' => 'required|string|max:255',
            'headline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'theme' => 'nullable|string|max:255',
            'activity_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'reach_count' => 'nullable|integer',
            'engagement_count' => 'nullable|integer',
            'estimated_value' => 'nullable|numeric',
            'status' => 'nullable|string|in:draft,submitted,under_review,approved,rejected',
            'proof_document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'thumbnail_image' => 'nullable|file|mimes:jpg,jpeg,png|max:4096',
        ]);

        // Replace files if uploaded
        if ($request->hasFile('proof_document')) {
            if ($branding->proof_document) Storage::disk('public')->delete($branding->proof_document);
            $validated['proof_document'] = $request->file('proof_document')->store('branding_docs', 'public');
        }
        if ($request->hasFile('thumbnail_image')) {
            if ($branding->thumbnail_image) Storage::disk('public')->delete($branding->thumbnail_image);
            $validated['thumbnail_image'] = $request->file('thumbnail_image')->store('branding_thumbnails', 'public');
        }

        $branding->update($validated);

        return redirect()->route('member.brandings.index')->with('success', 'Branding record updated successfully!');
    }

    /**
     * Remove the specified record
     */
    public function destroy(MemberBranding $branding)
    {
        $this->authorizeAccess($branding);

        if ($branding->proof_document) Storage::disk('public')->delete($branding->proof_document);
        if ($branding->thumbnail_image) Storage::disk('public')->delete($branding->thumbnail_image);

        $branding->delete();

        return back()->with('success', 'Branding activity deleted successfully.');
    }

    /**
     * Admin/Chapter approval
     */
    public function approve(MemberBranding $branding)
    {
        $branding->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Branding approved successfully.');
    }

    public function reject(Request $request, MemberBranding $branding)
    {
        $branding->update([
            'status' => 'rejected',
            'review_notes' => $request->input('review_notes'),
        ]);

        return back()->with('success', 'Branding rejected.');
    }

    /**
     * Authorization: members can edit their own, admins can view all
     */
    protected function authorizeAccess(MemberBranding $branding)
    {
        $user = Auth::user();
        if ($user->role === 'member' && $branding->member_id !== $user->id) {
            abort(403, 'You are not authorized to access this record.');
        }
    }
}
