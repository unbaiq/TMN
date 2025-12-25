@extends('layouts.app')

@section('content')
<div class="max-w-full mx-auto px-6 py-6 space-y-6 text-[13px] bg-gray-50">

    {{-- ================= PAGE HEADER ================= --}}
    <div class="bg-white border border-gray-200 rounded-md px-6 py-4 flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <i data-feather="edit-3" class="w-4 h-4 text-red-600"></i>
                Edit Event
            </h1>
            <p class="text-xs text-gray-500 mt-1">
                Update event details, schedule, venue, or visibility
            </p>
        </div>

        <a href="{{ route('admin.events.index') }}"
           class="text-xs font-medium text-gray-600 hover:text-red-600 flex items-center gap-1">
            <i data-feather="arrow-left" class="w-4 h-4"></i>
            Back to Events
        </a>
    </div>

    {{-- ================= FORM ================= --}}
    <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data"
          class="bg-white border border-gray-200 rounded-md">
        @csrf
        @method('PUT')

        {{-- ================= BASIC DETAILS ================= --}}
        <div class="px-6 py-5 border-b">
            <h3 class="text-sm font-semibold text-gray-800 mb-4 uppercase tracking-wide">
                Basic Details
            </h3>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="label">Event Type</label>
                    <select name="event_type" id="eventType" class="erp-input">
                        <option value="general" {{ $event->event_type === 'general' ? 'selected' : '' }}>General</option>
                        <option value="chapter" {{ $event->event_type === 'chapter' ? 'selected' : '' }}>Chapter</option>
                    </select>
                </div>

                <div>
                    <label class="label">Chapter</label>
                    <select name="chapter_id" id="chapterSelect" class="erp-input">
                        <option value="">Select Chapter</option>
                        @foreach($chapters as $ch)
                            <option value="{{ $ch->id }}" {{ $event->chapter_id == $ch->id ? 'selected' : '' }}>
                                {{ $ch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="label">Event Title</label>
                    <input type="text" name="title" value="{{ old('title', $event->title) }}" class="erp-input" required>
                </div>

                <div class="md:col-span-2">
                    <label class="label">Description</label>
                    <textarea name="description" rows="3" class="erp-input">{{ old('description', $event->description) }}</textarea>
                </div>
            </div>
        </div>

        {{-- ================= ORGANIZER ================= --}}
        <div class="px-6 py-5 border-b bg-gray-50">
            <h3 class="text-sm font-semibold text-gray-800 mb-4 uppercase tracking-wide">
                Organizer Information
            </h3>

            <div class="grid md:grid-cols-3 gap-4">
                <input type="text" name="host_name" value="{{ $event->host_name }}" placeholder="Host Name" class="erp-input">
                <input type="text" name="host_contact" value="{{ $event->host_contact }}" placeholder="Contact Number" class="erp-input">
                <input type="email" name="host_email" value="{{ $event->host_email }}" placeholder="Email Address" class="erp-input">
            </div>
        </div>

        {{-- ================= VENUE & SCHEDULE ================= --}}
        <div class="grid lg:grid-cols-2 gap-6 px-6 py-5 border-b">

            {{-- Venue --}}
            <div>
                <h3 class="text-sm font-semibold text-gray-800 mb-4 uppercase tracking-wide">
                    Venue
                </h3>

                <div class="space-y-3">
                    <input type="text" name="venue_name" value="{{ $event->venue_name }}" placeholder="Venue Name" class="erp-input">
                    <input type="text" name="address_line1" value="{{ $event->address_line1 }}" placeholder="Address Line 1" class="erp-input">
                    <input type="text" name="address_line2" value="{{ $event->address_line2 }}" placeholder="Address Line 2" class="erp-input">

                    <div class="grid grid-cols-2 gap-3">
                        <input type="text" name="city" value="{{ $event->city }}" placeholder="City" class="erp-input">
                        <input type="text" name="state" value="{{ $event->state }}" placeholder="State" class="erp-input">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <input type="text" name="country" value="{{ $event->country }}" placeholder="Country" class="erp-input">
                        <input type="text" name="pincode" value="{{ $event->pincode }}" placeholder="Pincode" class="erp-input">
                    </div>
                </div>
            </div>

            {{-- Schedule --}}
            <div>
                <h3 class="text-sm font-semibold text-gray-800 mb-4 uppercase tracking-wide">
                    Schedule
                </h3>

                <div class="grid grid-cols-3 gap-3">
                    <input type="date" name="event_date" value="{{ $event->event_date }}" class="erp-input">
                    <input type="time" name="start_time" value="{{ $event->start_time }}" class="erp-input">
                    <input type="time" name="end_time" value="{{ $event->end_time }}" class="erp-input">
                </div>

                <div class="mt-4 p-3 border border-red-200 bg-red-50 rounded">
                    <label class="flex items-center gap-2 text-xs font-medium text-red-700">
                        <input type="checkbox" name="is_online" value="1" {{ $event->is_online ? 'checked' : '' }}>
                        Online Event
                    </label>
                </div>

                <div class="grid grid-cols-2 gap-3 mt-3">
                    <input type="url" name="meeting_link" value="{{ $event->meeting_link }}" placeholder="Meeting Link" class="erp-input">
                    <input type="text" name="meeting_password" value="{{ $event->meeting_password }}" placeholder="Meeting Password" class="erp-input">
                </div>
            </div>
        </div>

        {{-- ================= STATUS ================= --}}
        <div class="px-6 py-5 border-b bg-gray-50 grid md:grid-cols-2 gap-4">
           <select name="status" class="erp-input" required>
    <option value="upcoming" {{ $event->status === 'upcoming' ? 'selected' : '' }}>
        Upcoming
    </option>

    <option value="ongoing" {{ $event->status === 'ongoing' ? 'selected' : '' }}>
        Ongoing
    </option>

    <option value="completed" {{ $event->status === 'completed' ? 'selected' : '' }}>
        Completed
    </option>

    <option value="cancelled" {{ $event->status === 'cancelled' ? 'selected' : '' }}>
        Cancelled
    </option>
</select>


            <div class="flex gap-6 items-center text-xs text-gray-700">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_public" value="1" {{ $event->is_public ? 'checked' : '' }}>
                    Public
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_featured" value="1" {{ $event->is_featured ? 'checked' : '' }}>
                    Featured
                </label>
            </div>
        </div>

        {{-- ================= BANNER ================= --}}
        <div class="px-6 py-5">
            @if($event->banner_image)
                <img src="{{ asset('storage/'.$event->banner_image) }}" class="h-40 rounded mb-3 border">
            @endif
            <input type="file" name="banner_image" class="erp-input">
        </div>

        {{-- ================= ACTIONS ================= --}}
        <div class="px-6 py-4 border-t bg-gray-50 flex justify-end">
            <button class="bg-red-600 hover:bg-red-700 text-white px-8 py-2 rounded text-xs font-semibold flex items-center gap-2">
                <i data-feather="save" class="w-4 h-4"></i>
                Update Event
            </button>
        </div>

    </form>
</div>

{{-- ================= STYLES ================= --}}
<style>
    .erp-input {
        width: 100%;
        border: 1px solid #d1d5db;
        border-radius: 4px;
        padding: 6px 8px;
        font-size: 13px;
        background: #fff;
    }
    .erp-input:focus {
        outline: none;
        border-color: #dc2626;
        box-shadow: 0 0 0 1px rgba(220,38,38,.15);
    }
    .label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 4px;
    }
</style>

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
