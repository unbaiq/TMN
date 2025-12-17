@extends('layouts.app')

@section('content')
<style>
/* Modern Button Style */
button {
    transition: all 0.25s ease;
}
button:hover {
    transform: translateY(-2px);
}

/* INPUTS */
input,
select,
textarea {
    transition: all .2s ease-in-out;
}

input:focus,
select:focus,
textarea:focus {
    border-color: #e11d48 !important;
    box-shadow: 0 0 0 3px rgba(225,29,72,0.25);
    outline: none;
}
</style>
<div class="max-w-7xl mx-auto px-6 py-10 space-y-10">

    {{-- ==== HEADER ==== --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-xl px-8 py-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <i data-feather="edit-3" class="w-7 h-7 text-red-600"></i>
                Edit Event
            </h2>
            <p class="text-gray-500 mt-1">Update details, schedule, venue, or visibility of this event.</p>
        </div>
        <a href="{{ route('admin.events.index') }}"
           class="inline-flex items-center bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-xl text-sm font-medium shadow-sm transition">
           <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Back to Event List
        </a>
    </div>

    {{-- ==== FORM ==== --}}
    <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data"
          class="bg-white border border-gray-100 rounded-2xl shadow-2xl p-10 space-y-10">
        @csrf
        @method('PUT')

        {{-- ==== BASIC DETAILS ==== --}}
        <div>
            <h3 class="text-xl font-bold text-gray-800 border-b border-gray-200 pb-3 mb-6 flex items-center gap-3">
                <i data-feather="info" class="w-5 h-5 text-red-600"></i> Basic Details
            </h3>
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Event Type</label>
                    <select name="event_type" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm">
                        <option value="general" {{ $event->event_type == 'general' ? 'selected' : '' }}>General</option>
                        <option value="chapter" {{ $event->event_type == 'chapter' ? 'selected' : '' }}>Chapter</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Chapter</label>
                    <select name="chapter_id" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm">
                        <option value="">-- None --</option>
                        @foreach($chapters as $ch)
                            <option value="{{ $ch->id }}" {{ $event->chapter_id == $ch->id ? 'selected' : '' }}>
                                {{ $ch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Title</label>
                    <input type="text" name="title" value="{{ old('title', $event->title) }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm" required>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="4"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm">{{ old('description', $event->description) }}</textarea>
                </div>
            </div>
        </div>

        {{-- ==== ORGANIZER ==== --}}
        <div>
            <h3 class="text-xl font-bold text-gray-800 border-b border-gray-200 pb-3 mb-6 flex items-center gap-3">
                <i data-feather="user" class="w-5 h-5 text-red-600"></i> Organizer Information
            </h3>
            <div class="grid md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Host Name</label>
                    <input type="text" name="host_name" value="{{ old('host_name', $event->host_name) }}" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Host Contact</label>
                    <input type="text" name="host_contact" value="{{ old('host_contact', $event->host_contact) }}" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Host Email</label>
                    <input type="email" name="host_email" value="{{ old('host_email', $event->host_email) }}" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm">
                </div>
            </div>
        </div>

        {{-- ==== VENUE ==== --}}
        <div>
            <h3 class="text-xl font-bold text-gray-800 border-b border-gray-200 pb-3 mb-6 flex items-center gap-3">
                <i data-feather="map-pin" class="w-5 h-5 text-red-600"></i> Venue & Location
            </h3>
            <div class="grid md:grid-cols-2 gap-6">
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Venue Name</label><input type="text" name="venue_name" value="{{ old('venue_name', $event->venue_name) }}" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Address Line 1</label><input type="text" name="address_line1" value="{{ old('address_line1', $event->address_line1) }}" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Address Line 2</label><input type="text" name="address_line2" value="{{ old('address_line2', $event->address_line2) }}" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">City</label><input type="text" name="city" value="{{ old('city', $event->city) }}" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">State</label><input type="text" name="state" value="{{ old('state', $event->state) }}" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Country</label><input type="text" name="country" value="{{ old('country', $event->country) }}" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Pincode</label><input type="text" name="pincode" value="{{ old('pincode', $event->pincode) }}" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm"></div>
            </div>
        </div>

        {{-- ==== SCHEDULE ==== --}}
        <div>
            <h3 class="text-xl font-bold text-gray-800 border-b border-gray-200 pb-3 mb-6 flex items-center gap-3">
                <i data-feather="clock" class="w-5 h-5 text-red-600"></i> Schedule
            </h3>
            <div class="grid md:grid-cols-3 gap-6">
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Event Date</label><input type="date" name="event_date" value="{{ old('event_date', $event->event_date) }}" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Start Time</label><input type="time" name="start_time" value="{{ old('start_time', $event->start_time) }}" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">End Time</label><input type="time" name="end_time" value="{{ old('end_time', $event->end_time) }}" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm"></div>
            </div>
        </div>

        {{-- ==== ONLINE MEETING ==== --}}
        <div>
            <h3 class="text-xl font-bold text-gray-800 border-b border-gray-200 pb-3 mb-6 flex items-center gap-3">
                <i data-feather="video" class="w-5 h-5 text-red-600"></i> Online Meeting (Optional)
            </h3>
            <div class="space-y-4">
                <div class="flex items-center gap-3 p-3 bg-red-50 border border-red-200 rounded-xl">
                    <input type="checkbox" id="is_online" name="is_online" value="1" {{ $event->is_online ? 'checked' : '' }} class="h-5 w-5 text-red-600 border-gray-300 rounded focus:ring-red-500">
                    <label for="is_online" class="text-red-700 text-sm font-medium">Mark as Online Event</label>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Meeting Link</label>
                    <input type="url" name="meeting_link" value="{{ old('meeting_link', $event->meeting_link) }}" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Meeting Password</label>
                    <input type="text" name="meeting_password" value="{{ old('meeting_password', $event->meeting_password) }}" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm">
                </div>
            </div>
        </div>

        {{-- ==== VISIBILITY & STATUS ==== --}}
        <div>
            <h3 class="text-xl font-bold text-gray-800 border-b border-gray-200 pb-3 mb-6 flex items-center gap-3">
                <i data-feather="eye" class="w-5 h-5 text-red-600"></i> Visibility & Status
            </h3>
            <div class="grid md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm">
                        <option value="upcoming" {{ $event->status == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="ongoing" {{ $event->status == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="completed" {{ $event->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $event->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="flex items-center gap-2 mt-6">
                    <input type="checkbox" name="is_public" value="1" {{ $event->is_public ? 'checked' : '' }} class="h-5 w-5 text-red-600 border-gray-300 rounded focus:ring-red-500">
                    <label class="text-gray-700 font-medium text-sm">Public Event</label>
                </div>
                <div class="flex items-center gap-2 mt-6">
                    <input type="checkbox" name="is_featured" value="1" {{ $event->is_featured ? 'checked' : '' }} class="h-5 w-5 text-red-600 border-gray-300 rounded focus:ring-red-500">
                    <label class="text-gray-700 font-medium text-sm">Featured</label>
                </div>
            </div>
        </div>

        {{-- ==== EVENT BANNER ==== --}}
        <div>
            <h3 class="text-xl font-bold text-gray-800 border-b border-gray-200 pb-3 mb-6 flex items-center gap-3">
                <i data-feather="image" class="w-5 h-5 text-red-600"></i> Event Banner
            </h3>
            @if($event->banner_image)
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $event->banner_image) }}" alt="Banner" class="rounded-xl w-full max-h-64 object-cover border border-gray-200 shadow-sm">
                    <p class="text-sm text-gray-500 mt-2">Current banner image</p>
                </div>
            @endif
            <input type="file" name="banner_image" accept="image/*"
                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-600 hover:file:bg-red-100">
        </div>

        {{-- ==== SUBMIT ==== --}}
        <div class="flex justify-end pt-8 border-t border-gray-200">
            <button type="submit"
                class="bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white px-10 py-3 rounded-xl font-semibold shadow-md hover:shadow-lg transition flex items-center gap-2">
                <i data-feather="save" class="w-5 h-5"></i>
                Update Event
            </button>
        </div>
    </form>
</div>

<script>feather.replace();</script>
@endsection
