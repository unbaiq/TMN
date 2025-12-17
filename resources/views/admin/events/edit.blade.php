@extends('layouts.app')

@section('content')
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
                {{-- Event Type --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Event Type</label>
                    <select name="event_type" id="eventType"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 bg-white focus:ring-2 focus:ring-red-500 shadow-sm">
                        <option value="general" {{ $event->event_type === 'general' ? 'selected' : '' }}>General</option>
                        <option value="chapter" {{ $event->event_type === 'chapter' ? 'selected' : '' }}>Chapter</option>
                    </select>
                </div>

                {{-- Chapter --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Chapter</label>
                    <select name="chapter_id" id="chapterSelect"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 shadow-sm">
                        <option value="">-- Select Chapter --</option>
                        @foreach($chapters as $ch)
                            <option value="{{ $ch->id }}" {{ $event->chapter_id == $ch->id ? 'selected' : '' }}>
                                {{ $ch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Event Title</label>
                    <input type="text" name="title" value="{{ old('title', $event->title) }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm" required>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Event Description</label>
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
                <input type="text" name="host_name" value="{{ old('host_name', $event->host_name) }}" placeholder="Host Name"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 shadow-sm">
                <input type="text" name="host_contact" value="{{ old('host_contact', $event->host_contact) }}" placeholder="Host Contact"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 shadow-sm">
                <input type="email" name="host_email" value="{{ old('host_email', $event->host_email) }}" placeholder="Host Email"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 shadow-sm">
            </div>
        </div>

        {{-- ==== VENUE & SCHEDULE ==== --}}
        <div class="grid lg:grid-cols-2 gap-6">

            {{-- Venue --}}
            <div>
                <h3 class="text-xl font-bold text-gray-800 border-b pb-3 mb-6 flex items-center gap-3">
                    <i data-feather="map-pin" class="w-5 h-5 text-red-600"></i> Venue & Location
                </h3>

                <div class="space-y-4">
                    <input type="text" name="venue_name" value="{{ $event->venue_name }}" placeholder="Venue Name" class="input">
                    <input type="text" name="address_line1" value="{{ $event->address_line1 }}" placeholder="Address Line 1" class="input">
                    <input type="text" name="address_line2" value="{{ $event->address_line2 }}" placeholder="Address Line 2" class="input">

                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="city" value="{{ $event->city }}" placeholder="City" class="input">
                        <input type="text" name="state" value="{{ $event->state }}" placeholder="State" class="input">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="country" value="{{ $event->country }}" placeholder="Country" class="input">
                        <input type="text" name="pincode" value="{{ $event->pincode }}" placeholder="Pincode" class="input">
                    </div>
                </div>
            </div>

            {{-- Schedule & Online --}}
            <div>
                <h3 class="text-xl font-bold text-gray-800 border-b pb-3 mb-6 flex items-center gap-3">
                    <i data-feather="clock" class="w-5 h-5 text-red-600"></i> Schedule
                </h3>

                <div class="grid md:grid-cols-3 gap-4">
                    <input type="date" name="event_date" value="{{ $event->event_date }}" class="input">
                    <input type="time" name="start_time" value="{{ $event->start_time }}" class="input">
                    <input type="time" name="end_time" value="{{ $event->end_time }}" class="input">
                </div>

                {{-- Online --}}
                <div class="mt-8">
                    <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 rounded-xl">
                        <input type="checkbox" name="is_online" value="1" {{ $event->is_online ? 'checked' : '' }}>
                        <span class="text-red-700 font-medium">Online Event</span>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4 mt-4">
                        <input type="url" name="meeting_link" value="{{ $event->meeting_link }}" placeholder="Meeting Link" class="input">
                        <input type="text" name="meeting_password" value="{{ $event->meeting_password }}" placeholder="Meeting Password" class="input">
                    </div>
                </div>
            </div>
        </div>

        {{-- ==== STATUS & VISIBILITY ==== --}}
        <div class="grid md:grid-cols-2 gap-6">
            <select name="status" class="input">
                <option value="upcoming" {{ $event->status === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                <option value="published" {{ $event->status === 'published' ? 'selected' : '' }}>Published</option>
                <option value="cancelled" {{ $event->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>

            <div class="flex gap-6">
                <label class="flex items-center gap-2"><input type="checkbox" name="is_public" value="1" {{ $event->is_public ? 'checked' : '' }}> Public</label>
                <label class="flex items-center gap-2"><input type="checkbox" name="is_featured" value="1" {{ $event->is_featured ? 'checked' : '' }}> Featured</label>
            </div>
        </div>

        {{-- ==== BANNER ==== --}}
        <div>
            @if($event->banner_image)
                <img src="{{ asset('storage/'.$event->banner_image) }}" class="rounded-xl mb-3">
            @endif
            <input type="file" name="banner_image" class="input">
        </div>

        {{-- ==== SUBMIT ==== --}}
        <div class="flex justify-end pt-6 border-t">
            <button class="bg-red-600 hover:bg-red-700 text-white px-10 py-3 rounded-xl font-semibold flex items-center gap-2">
                <i data-feather="save"></i> Update Event
            </button>
        </div>

    </form>
</div>

<script>
    feather.replace();

    const eventType = document.getElementById('eventType');
    const chapterSelect = document.getElementById('chapterSelect');

    function toggleChapter() {
        chapterSelect.disabled = eventType.value !== 'chapter';
    }
    eventType.addEventListener('change', toggleChapter);
    toggleChapter();
</script>

@endsection
