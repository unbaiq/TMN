<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Meetup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MeetupController extends Controller
{
    /**
     * Display a listing of meetups.
     */
    public function index()
    {
        $meetups = Meetup::latest()->paginate(10);
        return view('admin.meetups.index', compact('meetups'));
    }

    /**
     * Show the form for creating a new meetup.
     */
    public function create()
    {
        return view('admin.meetups.create');
    }

    /**
     * Store a newly created meetup in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'event_date' => 'nullable|date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'venue_name' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:draft,upcoming,ongoing,completed,cancelled',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('meetups/banners', 'public');
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('meetups/thumbnails', 'public');
        }

        Meetup::create($data);

        return redirect()->route('admin.meetups.index')->with('success', 'Meetup created successfully.');
    }

    /**
     * Show the form for editing the specified meetup.
     */
    public function edit(Meetup $meetup)
    {
        return view('admin.meetups.edit', compact('meetup'));
    }

    /**
     * Update the specified meetup.
     */
    public function update(Request $request, Meetup $meetup)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'event_date' => 'nullable|date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'venue_name' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:draft,upcoming,ongoing,completed,cancelled',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('banner')) {
            if ($meetup->banner) Storage::disk('public')->delete($meetup->banner);
            $data['banner'] = $request->file('banner')->store('meetups/banners', 'public');
        }

        if ($request->hasFile('thumbnail')) {
            if ($meetup->thumbnail) Storage::disk('public')->delete($meetup->thumbnail);
            $data['thumbnail'] = $request->file('thumbnail')->store('meetups/thumbnails', 'public');
        }

        $meetup->update($data);

        return redirect()->route('admin.meetups.index')->with('success', 'Meetup updated successfully.');
    }

    /**
     * Remove the specified meetup.
     */
    public function destroy(Meetup $meetup)
    {
        if ($meetup->banner) Storage::disk('public')->delete($meetup->banner);
        if ($meetup->thumbnail) Storage::disk('public')->delete($meetup->thumbnail);
        $meetup->delete();

        return redirect()->route('admin.meetups.index')->with('success', 'Meetup deleted successfully.');
    }
}
