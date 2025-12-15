<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Advisory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdvisoryController extends Controller
{
    /**
     * Display all advisories.
     */
    public function index()
    {
        $advisories = Advisory::latest()->paginate(10);
        return view('admin.advisories.index', compact('advisories'));
    }

    /**
     * Show form for creating a new advisory.
     */
    public function create()
    {
        return view('admin.advisories.create');
    }

    /**
     * Store a new advisory.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'session_date' => 'nullable|date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'mode' => 'required|in:online,offline,hybrid',
            'advisor_name' => 'nullable|string|max:255',
            'venue' => 'nullable|string|max:255',
            'status' => 'required|in:draft,scheduled,ongoing,completed,cancelled',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('advisories/banners', 'public');
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('advisories/thumbnails', 'public');
        }

        Advisory::create($data);

        return redirect()->route('admin.advisories.index')->with('success', 'Advisory created successfully.');
    }

    /**
     * Show form to edit advisory.
     */
    public function edit(Advisory $advisory)
    {
        return view('admin.advisories.edit', compact('advisory'));
    }

    /**
     * Update an advisory.
     */
    public function update(Request $request, Advisory $advisory)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'session_date' => 'nullable|date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'mode' => 'required|in:online,offline,hybrid',
            'advisor_name' => 'nullable|string|max:255',
            'venue' => 'nullable|string|max:255',
            'status' => 'required|in:draft,scheduled,ongoing,completed,cancelled',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('banner')) {
            if ($advisory->banner) Storage::disk('public')->delete($advisory->banner);
            $data['banner'] = $request->file('banner')->store('advisories/banners', 'public');
        }

        if ($request->hasFile('thumbnail')) {
            if ($advisory->thumbnail) Storage::disk('public')->delete($advisory->thumbnail);
            $data['thumbnail'] = $request->file('thumbnail')->store('advisories/thumbnails', 'public');
        }

        $advisory->update($data);

        return redirect()->route('admin.advisories.index')->with('success', 'Advisory updated successfully.');
    }

    /**
     * Show full advisory details.
     */
    public function show(Advisory $advisory)
    {
        return view('admin.advisories.show', compact('advisory'));
    }

    /**
     * Delete advisory.
     */
    public function destroy(Advisory $advisory)
    {
        if ($advisory->banner) Storage::disk('public')->delete($advisory->banner);
        if ($advisory->thumbnail) Storage::disk('public')->delete($advisory->thumbnail);
        $advisory->delete();

        return redirect()->route('admin.advisories.index')->with('success', 'Advisory deleted successfully.');
    }
}
