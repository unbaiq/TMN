<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StoryController extends Controller
{
    /**
     * Display a listing of stories.
     */
    public function index()
    {
        $stories = Story::latest()->paginate(10);
        return view('admin.stories.index', compact('stories'));
    }

    /**
     * Show the form for creating a new story.
     */
    public function create()
    {
        return view('admin.stories.create');
    }

    /**
     * Store a newly created story.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'industry' => 'nullable|string|max:255',
            'tags' => 'nullable|string|max:255',
            'status' => 'required|in:draft,review,published,archived',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'video_url' => 'nullable|string|max:500',
            'publish_date' => 'nullable|date',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('stories', 'public');
        }

        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('stories/banners', 'public');
        }

        Story::create($data);

        return redirect()->route('admin.stories.index')->with('success', 'Story created successfully.');
    }

    /**
     * Display the specified story.
     */
    public function show(Story $story)
    {
        return view('admin.stories.show', compact('story'));
    }

    /**
     * Show the form for editing the specified story.
     */
    public function edit(Story $story)
    {
        return view('admin.stories.edit', compact('story'));
    }

    /**
     * Update the specified story.
     */
    public function update(Request $request, Story $story)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'industry' => 'nullable|string|max:255',
            'tags' => 'nullable|string|max:255',
            'status' => 'required|in:draft,review,published,archived',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'video_url' => 'nullable|string|max:500',
            'publish_date' => 'nullable|date',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
            if ($story->image) Storage::disk('public')->delete($story->image);
            $data['image'] = $request->file('image')->store('stories', 'public');
        }

        if ($request->hasFile('banner')) {
            if ($story->banner) Storage::disk('public')->delete($story->banner);
            $data['banner'] = $request->file('banner')->store('stories/banners', 'public');
        }

        $story->update($data);

        return redirect()->route('admin.stories.index')->with('success', 'Story updated successfully.');
    }

    /**
     * Remove the specified story.
     */
    public function destroy(Story $story)
    {
        if ($story->image) Storage::disk('public')->delete($story->image);
        if ($story->banner) Storage::disk('public')->delete($story->banner);
        $story->delete();

        return redirect()->route('admin.stories.index')->with('success', 'Story deleted successfully.');
    }
}
