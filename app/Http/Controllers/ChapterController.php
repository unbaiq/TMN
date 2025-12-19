<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ChapterController extends Controller
{
    /**
     * Display a listing of chapters.
     */
    public function index()
    {
        $chapters = Chapter::latest()->paginate(10);
        return view('admin.chapters.index', compact('chapters'));
    }

    /**
     * Show the form for creating a new chapter.
     */
    public function create()
    {
        return view('admin.chapters.create');
    }

    /**
     * Store a newly created chapter.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:chapters,slug',
            'city'        => 'nullable|string|max:255',
            'state'       => 'nullable|string|max:255',
            'country'     => 'nullable|string|max:255',
            'pincode'     => 'nullable|string|max:20',
            'capacity_no' => 'nullable|integer|min:0|max:100000',
            'description' => 'nullable|string|max:1000',
            'is_active'   => 'nullable',
        ]);
        
        if ($request->hasFile('logo')) {
            $request->validate([
                'logo' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);
        }

        // Slug fallback
        $validated['slug'] = $validated['slug']
            ?? Str::slug($validated['name']) . '-' . Str::random(4);

        // Unique chapter code (safe)
        $validated['chapter_code'] = 'CHP-' . str_pad(
            Chapter::max('id') + 1,
            3,
            '0',
            STR_PAD_LEFT
        );

        // Checkbox → boolean
        $validated['is_active'] = $request->boolean('is_active');

        // Logo upload
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('chapters', 'public');
        }

        Chapter::create($validated);

        return redirect()
            ->route('admin.chapters.index')
            ->with('success', 'Chapter created successfully.');
    }

    /**
     * Show edit form.
     */
    public function edit(Chapter $chapter)
    {
        return view('admin.chapters.edit', compact('chapter'));
    }

    /**
     * Update the specified chapter.
     */
    public function update(Request $request, Chapter $chapter)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('chapters', 'slug')->ignore($chapter->id),
            ],
            'city'        => 'nullable|string|max:255',
            'state'       => 'nullable|string|max:255',
            'country'     => 'nullable|string|max:255',
            'pincode'     => 'nullable|string|max:20',
            'capacity_no' => 'nullable|integer|min:0|max:100000',
            'description' => 'nullable|string|max:1000',
            'is_active'   => 'nullable',
            'logo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        // Replace logo if uploaded
        if ($request->hasFile('logo')) {
            if ($chapter->logo && Storage::disk('public')->exists($chapter->logo)) {
                Storage::disk('public')->delete($chapter->logo);
            }
            $validated['logo'] = $request->file('logo')->store('chapters', 'public');
        }

        $chapter->update($validated);

        return redirect()
            ->route('admin.chapters.index')
            ->with('success', 'Chapter updated successfully.');
    }

    /**
     * Delete chapter.
     */
    public function destroy(Chapter $chapter)
    {
        if ($chapter->logo && Storage::disk('public')->exists($chapter->logo)) {
            Storage::disk('public')->delete($chapter->logo);
        }

        $chapter->delete();

        return redirect()
            ->route('admin.chapters.index')
            ->with('success', 'Chapter deleted successfully.');
    }

    /**
     * Show members assignment page.
     */
    public function members(Chapter $chapter)
    {
        $members = \App\Models\User::where('role', 'member')
            ->where(function ($q) use ($chapter) {
                $q->whereNull('chapter_id')
                  ->orWhere('chapter_id', $chapter->id);
            })
            ->orderBy('name')
            ->get();

        return view('admin.chapters.members', compact('chapter', 'members'));
    }

    /**
     * Assign members to chapter.
     */
    public function assignMembers(Request $request, Chapter $chapter)
    {
        $validated = $request->validate([
            'member_ids'   => 'array',
            'member_ids.*' => 'exists:users,id',
        ]);

        // Members already assigned to other chapters
        $blockedIds = \App\Models\User::whereNotNull('chapter_id')
            ->where('chapter_id', '!=', $chapter->id)
            ->pluck('id')
            ->toArray();

        $allowedIds = collect($validated['member_ids'] ?? [])
            ->diff($blockedIds)
            ->values()
            ->all();

        // Remove existing members of this chapter
        \App\Models\User::where('chapter_id', $chapter->id)
            ->update(['chapter_id' => null]);

        // Assign allowed members
        if (!empty($allowedIds)) {
            \App\Models\User::whereIn('id', $allowedIds)
                ->update(['chapter_id' => $chapter->id]);
        }

        $skipped = count($validated['member_ids'] ?? []) - count($allowedIds);

        $message = 'Members updated successfully.';
        if ($skipped > 0) {
            $message .= " {$skipped} member(s) were skipped (already assigned).";
        }

        return redirect()
            ->route('admin.chapters.members', $chapter->id)
            ->with('success', $message);
    }

    /**
     * Show chapter details.
     */
    public function show(Chapter $chapter)
    {
        $chapter->load(['members.basicInfo']);
        return view('admin.chapters.show', compact('chapter'));
    }
}
