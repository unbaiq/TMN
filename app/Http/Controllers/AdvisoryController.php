<?php

namespace App\Http\Controllers;

use App\Models\Advisory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdvisoryController extends Controller
{
    /**
     * ===============================
     * ADMIN SECTION
     * ===============================
     */

    /**
     * Display all advisories (ADMIN).
     */
    public function index()
    {
        $advisories = Advisory::latest()->paginate(10);
        return view('admin.advisories.index', compact('advisories'));
    }

    /**
     * Show form for creating a new advisory (ADMIN).
     */
    public function create()
    {
        return view('admin.advisories.create');
    }

    /**
     * Store a new advisory (ADMIN).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',

            'category' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',

            'session_date' => 'nullable|date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'mode' => 'required|in:online,offline,hybrid',
            'venue' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',

            'advisor_name' => 'nullable|string|max:255',
            'advisor_designation' => 'nullable|string|max:255',
            'advisor_email' => 'nullable|email',
            'advisor_phone' => 'nullable|string|max:50',
            'organization' => 'nullable|string|max:255',

            'advisor_experience_years' => 'nullable|integer|min:0|max:60',
            'advisor_experience_summary' => 'nullable|string',

            'status' => 'required|in:draft,scheduled,ongoing,completed,cancelled',

            'banner' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['created_by'] = auth()->id();
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_public'] = $request->boolean('is_public', true);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['is_registration_open'] = $request->boolean('is_registration_open', true);

        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')
                ->store('advisories/banners', 'public');
        }

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')
                ->store('advisories/thumbnails', 'public');
        }

        Advisory::create($validated);

        return redirect()
            ->route('admin.advisories.index')
            ->with('success', 'Advisory created successfully.');
    }

    /**
     * Show advisory details (ADMIN – ID based).
     */
    public function show(Advisory $advisory)
    {
        return view('admin.advisories.show', compact('advisory'));
    }

    /**
     * Show form to edit advisory (ADMIN).
     */
    public function edit(Advisory $advisory)
    {
        return view('admin.advisories.edit', compact('advisory'));
    }

    /**
     * Update an advisory (ADMIN).
     */
    public function update(Request $request, Advisory $advisory)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',

            'category' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',

            'session_date' => 'nullable|date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'mode' => 'required|in:online,offline,hybrid',
            'venue' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',

            'advisor_name' => 'nullable|string|max:255',
            'advisor_designation' => 'nullable|string|max:255',
            'advisor_email' => 'nullable|email',
            'advisor_phone' => 'nullable|string|max:50',
            'organization' => 'nullable|string|max:255',

            'advisor_experience_years' => 'nullable|integer|min:0|max:60',
            'advisor_experience_summary' => 'nullable|string',

            'status' => 'required|in:draft,scheduled,ongoing,completed,cancelled',

            'banner' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($advisory->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['updated_by'] = auth()->id();
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_public'] = $request->boolean('is_public', true);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['is_registration_open'] = $request->boolean('is_registration_open', true);

        if ($request->hasFile('banner')) {
            Storage::disk('public')->delete($advisory->banner);
            $validated['banner'] = $request->file('banner')
                ->store('advisories/banners', 'public');
        }

        if ($request->hasFile('thumbnail')) {
            Storage::disk('public')->delete($advisory->thumbnail);
            $validated['thumbnail'] = $request->file('thumbnail')
                ->store('advisories/thumbnails', 'public');
        }

        $advisory->update($validated);

        return redirect()
            ->route('admin.advisories.index')
            ->with('success', 'Advisory updated successfully.');
    }

    /**
     * Delete advisory (ADMIN).
     */
    public function destroy(Advisory $advisory)
    {
        Storage::disk('public')->delete([
            $advisory->banner,
            $advisory->thumbnail,
        ]);

        $advisory->delete();

        return redirect()
            ->route('admin.advisories.index')
            ->with('success', 'Advisory deleted successfully.');
    }

    /**
     * ===============================
     * PUBLIC SECTION
     * ===============================
     */

    /**
     * Show advisory details (PUBLIC – slug based).
     */
    public function showBySlug(string $slug)
    {
        $advisory = Advisory::where('slug', $slug)
            ->where('is_public', true)
            ->where('is_active', true)
            ->firstOrFail();

        return view('user.detail-advisory', compact('advisory'));
    }
}
