<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule; // ✅ Correct import

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
     * Store a newly created chapter in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',

            // ✅ Unique slug check, only when slug is provided
            'slug' => [
                'nullable',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (!empty($value) && Chapter::where('slug', $value)->exists()) {
                        $fail('The slug has already been taken.');
                    }
                },
            ],

            'city' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|max:20',
            'capacity_no' => 'nullable|integer|min:0|max:100000',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'nullable|in:on,off,1,0,true,false',
            'logo' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // ✅ Always define slug safely
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        // ✅ Generate unique chapter code
        $validated['chapter_code'] = 'CHP-' . str_pad(Chapter::count() + 1, 3, '0', STR_PAD_LEFT);

        // ✅ Checkbox conversion (on/off → boolean)
        $validated['is_active'] = $request->has('is_active');

        // ✅ Handle logo upload
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('chapters', 'public');
        }

        // ✅ Create chapter
        Chapter::create($validated);

        return redirect()
            ->route('admin.chapters.index')
            ->with('success', 'Chapter created successfully.');
    }
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
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('chapters', 'slug')->ignore($chapter->id),
            ],
            'city' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|max:20',
            'capacity_no' => 'nullable|integer|min:0|max:100000',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'nullable|in:on,off,1,0,true,false',
            'logo' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('logo')) {
            if ($chapter->logo) {
                Storage::disk('public')->delete($chapter->logo);
            }
            $validated['logo'] = $request->file('logo')->store('chapters', 'public');
        }

        $chapter->update($validated);

        return redirect()->route('admin.chapters.index')->with('success', 'Chapter updated successfully.');
    }

    /**
     * Remove the specified chapter from storage.
     */
    public function destroy(Chapter $chapter)
    {
        if ($chapter->logo) {
            Storage::disk('public')->delete($chapter->logo);
        }

        $chapter->delete();

        return redirect()->route('admin.chapters.index')->with('success', 'Chapter deleted successfully.');
    }

    public function members(Chapter $chapter)
    {
        $members = \App\Models\User::where('role', 'member')
            ->where(function ($q) use ($chapter) {
                $q->whereNull('chapter_id') // not in any chapter
                  ->orWhere('chapter_id', $chapter->id); // or already in this chapter
            })
            ->orderBy('name')
            ->get();
    
        return view('admin.chapters.members', compact('chapter', 'members'));
    }
    
    public function assignMembers(Request $request, Chapter $chapter)
    {
        $validated = $request->validate([
            'member_ids' => 'array',
            'member_ids.*' => 'exists:users,id',
        ]);
    
        // 1️⃣ Get all currently linked members (to any chapter)
        $alreadyAssignedIds = \App\Models\User::whereNotNull('chapter_id')
            ->where('chapter_id', '!=', $chapter->id)
            ->pluck('id')
            ->toArray();
    
        // 2️⃣ Remove those from selection
        $allowedIds = collect($validated['member_ids'] ?? [])
            ->diff($alreadyAssignedIds)
            ->values()
            ->all();
    
        // 3️⃣ Detach all existing members of this chapter
        \App\Models\User::where('chapter_id', $chapter->id)->update(['chapter_id' => null]);
    
        // 4️⃣ Assign new members only if allowed
        if (!empty($allowedIds)) {
            \App\Models\User::whereIn('id', $allowedIds)->update(['chapter_id' => $chapter->id]);
        }
    
        // 5️⃣ Show feedback if some members were skipped
        $skippedCount = count($validated['member_ids'] ?? []) - count($allowedIds);
        $message = 'Members updated successfully!';
        if ($skippedCount > 0) {
            $message .= " ($skippedCount member(s) already belong to another chapter and were skipped)";
        }
    
        return redirect()->route('admin.chapters.members', $chapter->id)
            ->with('success', $message);
    }

    public function show(Chapter $chapter)
{
    $chapter->load(['members.basicInfo']);
    return view('admin.chapters.show', compact('chapter'));
}

}
