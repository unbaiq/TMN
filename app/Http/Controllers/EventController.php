<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /** ===========================
     *  INDEX: List all events
     *  =========================== */
    public function index()
    {
        $events = Event::with('chapter', 'organizer')
            ->orderByDesc('event_date')
            ->paginate(10);

        return view('admin.events.index', compact('events'));
    }

    /** ===========================
     *  CREATE: Show creation form
     *  =========================== */
    public function create()
    {
        $chapters = Chapter::all();
        return view('admin.events.create', compact('chapters'));
    }

    /** ===========================
     *  STORE: Save new event
     *  =========================== */
    public function store(Request $request)
    {

      
        $validated = $request->validate([
            'event_type'       => 'required|in:general,chapter',
            'chapter_id'       => 'nullable|exists:chapters,id',
            'title'            => 'required|string|max:255',
            'description'      => 'nullable|string',
            'venue_name'       => 'nullable|string|max:255',
            'address_line1'    => 'nullable|string|max:255',
            'address_line2'    => 'nullable|string|max:255',
            'city'             => 'nullable|string|max:255',
            'state'            => 'nullable|string|max:255',
            'country'          => 'nullable|string|max:255',
            'pincode'          => 'nullable|string|max:10',
            'event_date'       => 'required|date',
            'start_time'       => 'required',
            'end_time'         => 'required',
            'host_name'        => 'nullable|string|max:255',
            'host_contact'     => 'nullable|string|max:50',
            'host_email'       => 'nullable|email|max:255',
            'is_online'        => 'sometimes|in:0,1,on',
            'meeting_link'     => 'nullable|url|max:500',
            'meeting_password' => 'nullable|string|max:100',
            'agenda'           => 'nullable|string',
            'notes'            => 'nullable|string',
            'max_attendees'    => 'nullable|integer|min:0',
            'status'           => 'nullable|in:upcoming,ongoing,completed,cancelled',
            'is_public'        => 'sometimes|in:0,1,on',
            'is_featured'      => 'sometimes|in:0,1,on',
            'banner_image'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);
       
        // Auto-generate slug
        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        $validated['organizer_id'] = auth()->id() ?? 1; // fallback if not logged in

        // Handle banner upload if exists
        if ($request->hasFile('banner_image')) {
            $path = $request->file('banner_image')->store('events', 'public');
            $validated['banner_image'] = $path;
        }

        Event::create($validated);

        return redirect()
            ->route('admin.events.index')
            ->with('success', '✅ Event created successfully!');
    }

    /** ===========================
     *  EDIT: Show edit form
     *  =========================== */
    public function edit(Event $event)
    {
        $chapters = Chapter::all();
        return view('admin.events.edit', compact('event', 'chapters'));
    }

    /** ===========================
     *  UPDATE: Save changes
     *  =========================== */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'event_type'       => 'required|in:general,chapter',
            'chapter_id'       => 'nullable|exists:chapters,id',
            'title'            => 'required|string|max:255',
            'description'      => 'nullable|string',
            'venue_name'       => 'nullable|string|max:255',
            'address_line1'    => 'nullable|string|max:255',
            'address_line2'    => 'nullable|string|max:255',
            'city'             => 'nullable|string|max:255',
            'state'            => 'nullable|string|max:255',
            'country'          => 'nullable|string|max:255',
            'pincode'          => 'nullable|string|max:10',
            'event_date'       => 'required|date',
            'start_time'       => 'required',
            'end_time'         => 'required',
            'host_name'        => 'nullable|string|max:255',
            'host_contact'     => 'nullable|string|max:50',
            'host_email'       => 'nullable|email|max:255',
            'is_online'        => 'nullable|boolean',
            'meeting_link'     => 'nullable|url|max:500',
            'meeting_password' => 'nullable|string|max:100',
            'agenda'           => 'nullable|string',
            'notes'            => 'nullable|string',
            'max_attendees'    => 'nullable|integer|min:0',
            'status'           => 'required|in:upcoming,ongoing,completed,cancelled',
            'is_public'        => 'nullable|boolean',
            'is_featured'      => 'nullable|boolean',
            'banner_image'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        // Banner replace if new uploaded
        if ($request->hasFile('banner_image')) {
            // Delete old file
            if ($event->banner_image && Storage::disk('public')->exists($event->banner_image)) {
                Storage::disk('public')->delete($event->banner_image);
            }

            $path = $request->file('banner_image')->store('events', 'public');
            $validated['banner_image'] = $path;
        }

        $event->update($validated);

        return redirect()
            ->route('admin.events.index')
            ->with('success', '✅ Event updated successfully!');
    }

    /** ===========================
     *  DESTROY: Delete event
     *  =========================== */
    public function destroy(Event $event)
    {
        // Delete banner if exists
        if ($event->banner_image && Storage::disk('public')->exists($event->banner_image)) {
            Storage::disk('public')->delete($event->banner_image);
        }

        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('success', '🗑️ Event deleted successfully!');
    }
}
