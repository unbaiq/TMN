@extends('layouts.app')

@section('content')
    <div class="max-w-8xl mx-auto px-6 py-10 space-y-10">

        {{-- ==== HEADER ==== --}}
        <div
            class="bg-white border border-gray-200 rounded-2xl shadow-xl px-8 py-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <i data-feather="calendar" class="w-7 h-7 text-red-600"></i>
                    Create New Event
                </h2>
                <p class="text-gray-500 mt-1">Plan, manage, and publish upcoming chapter or general events with ERP-grade
                    clarity.</p>

            </div>
            <a href="{{ route('admin.events.index') }}"
                class="inline-flex items-center bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-xl text-sm font-medium shadow-sm transition">
                <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Back to Event List
            </a>
        </div>
@if ($errors->any())
    <div class="mb-4 rounded-lg bg-red-50 p-3 text-red-700">
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        {{-- ==== FORM ==== --}}
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white border border-gray-100 rounded-2xl shadow-2xl p-10 space-y-10">
            @csrf

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
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 bg-white text-gray-800 focus:ring-2 focus:ring-red-500 focus:border-red-500 shadow-sm">
                            <option value="general">General</option>
                            <option value="chapter">Chapter</option>
                        </select>
                    </div>

                    {{-- Chapter (Disabled until Chapter selected) --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Chapter
                            <span class="text-xs text-gray-400">(Enabled after selecting Event Type)</span>
                        </label>
                        <select name="chapter_id" id="chapterSelect" disabled
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 bg-gray-100 text-gray-500 cursor-not-allowed focus:ring-0 transition shadow-sm">
                            <option value="">-- Select Chapter --</option>
                            @foreach($chapters as $ch)
                                <option value="{{ $ch->id }}">{{ $ch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Event Title</label>
                        <input type="text" name="title"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-red-500 focus:border-red-500 shadow-sm"
                            placeholder="e.g., Annual General Meeting" required>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Event Description</label>
                        <textarea name="description" rows="4"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-red-500 focus:border-red-500 shadow-sm"
                            placeholder="Write a short description..."></textarea>
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
                        <input type="text" name="host_name"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-gray-800 focus:ring-2 focus:ring-red-500 focus:border-red-500 shadow-sm"
                            placeholder="John Doe">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Host Contact</label>
                        <input type="text" name="host_contact"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-gray-800 focus:ring-2 focus:ring-red-500 focus:border-red-500 shadow-sm"
                            placeholder="+91 98765 43210">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Host Email</label>
                        <input type="email" name="host_email"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-gray-800 focus:ring-2 focus:ring-red-500 focus:border-red-500 shadow-sm"
                            placeholder="host@email.com">
                    </div>
                </div>
            </div>

            {{-- ==== VENUE & SCHEDULE ==== --}}
            <div class="grid lg:grid-cols-2 gap-4">
                {{-- Venue --}}
                <div>
                    <h3 class="text-xl font-bold text-gray-800 border-b border-gray-200 pb-3 mb-6 flex items-center gap-3">
                        <i data-feather="map-pin" class="w-5 h-5 text-red-600"></i> Venue & Location
                    </h3>
                    <div class="space-y-4">
                        <div><label class="block text-sm font-semibold text-gray-700 mb-1">Venue Name</label>
                            <input type="text" name="venue_name"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm">
                        </div>
                        <div><label class="block text-sm font-semibold text-gray-700 mb-1">Address Line 1</label>
                            <input type="text" name="address_line1"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm">
                        </div>
                        <div><label class="block text-sm font-semibold text-gray-700 mb-1">Address Line 2</label>
                            <input type="text" name="address_line2"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm">
                        </div>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div><label class="block text-sm font-semibold text-gray-700 mb-1">City</label>
                                <input type="text" name="city"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm">
                            </div>
                            <div><label class="block text-sm font-semibold text-gray-700 mb-1">State</label>
                                <input type="text" name="state"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm">
                            </div>
                        </div>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div><label class="block text-sm font-semibold text-gray-700 mb-1">Country</label>
                                <input type="text" name="country"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm"
                                    placeholder="India">
                            </div>
                            <div><label class="block text-sm font-semibold text-gray-700 mb-1">Pincode</label>
                                <input type="text" name="pincode"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Schedule --}}
                <div>
                    {{-- ================= SCHEDULE ================= --}}
                    <h3 class="text-xl font-bold text-gray-800 border-b border-gray-200 pb-3 mb-6 flex items-center gap-3">
                        <i data-feather="clock" class="w-5 h-5 text-red-600"></i>
                        Schedule
                    </h3>

                    <div class="grid md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Event Date</label>
                            <input type="date" name="event_date"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Start Time</label>
                            <input type="time" name="start_time"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">End Time</label>
                            <input type="time" name="end_time"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm">
                        </div>
                    </div>

                    {{-- ================= ONLINE MEETING ================= --}}
                    <div class="mt-10">
                        <h3
                            class="text-xl font-bold text-gray-800 border-b border-gray-200 pb-3 mb-5 flex items-center gap-3">
                            <i data-feather="video" class="w-5 h-5 text-red-600"></i>
                            Online Meeting
                        </h3>

                        <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 rounded-xl mb-6">
                            <input type="checkbox" id="is_online" name="is_online" value="1"
                                class="h-5 w-5 text-red-600 border-gray-300 rounded focus:ring-red-500">
                            <label for="is_online" class="text-red-700 text-sm font-medium">
                                Mark as Online Event
                            </label>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Meeting Link</label>
                                <input type="url" name="meeting_link"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Meeting Password</label>
                                <input type="text" name="meeting_password"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm">
                            </div>
                        </div>
                    </div>

                    {{-- ================= VISIBILITY ================= --}}
                    <div class="mt-10 grid md:grid-cols-2 gap-6">
                        {{-- Public --}}
                        <div class="flex items-start gap-4 p-4 bg-green-50 border border-green-200 rounded-xl">
                            <input type="checkbox" name="is_public" value="1" checked
                                class="h-5 w-5 mt-1 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <div>
                                <label class="text-sm font-semibold text-green-700 block">
                                    Public Event
                                </label>
                                <p class="text-xs text-green-600">
                                    Visible to non-members & website
                                </p>
                            </div>
                        </div>

                        {{-- Featured --}}
                        <div class="flex items-start gap-4 p-4 bg-red-50 border border-red-200 rounded-xl">
                            <input type="checkbox" name="is_featured" value="1"
                                class="h-5 w-5 mt-1 text-red-600 border-gray-300 rounded focus:ring-red-500">
                            <div>
                                <label class="text-sm font-semibold text-red-700 block">
                                    Featured Event
                                </label>
                                <p class="text-xs text-red-500">
                                    Featured events appear on top & homepage
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6 items-start">

                    {{-- Status --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Event Status</label>
                       <select name="status" required
        class="w-full border rounded-lg px-3 py-2">
    <option value="">-- Select Status --</option>
    <option value="upcoming">Upcoming</option>
    <option value="ongoing">Ongoing</option>
    <option value="completed">Completed</option>
    <option value="cancelled">Cancelled</option>
</select>

                    </div>

                    {{-- Banner Image --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Event Banner Image</label>
                        <input type="file" name="banner_image" accept="image/*"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 shadow-sm">
                        <p class="text-xs text-gray-400 mt-1">Recommended: 1200×600 JPG/PNG</p>
                    </div>



                </div>

            </div>

            {{-- ==== SUBMIT ==== --}}
            <div class="flex justify-end pt-8 border-t border-gray-200">
                <button type="submit"
                    class="bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white px-10 py-3 rounded-xl font-semibold shadow-md hover:shadow-lg transition transform hover:scale-[1.02] flex items-center gap-2">
                    <i data-feather="save" class="w-5 h-5"></i>
                    Create & Publish Event
                </button>
            </div>
        </form>
    </div>
    <script>
        feather.replace();

        const eventType = document.getElementById('eventType');
        const chapterSelect = document.getElementById('chapterSelect');

        function toggleChapter() {
            if (eventType.value === 'chapter') {
                chapterSelect.disabled = false;
                chapterSelect.classList.remove(
                    'bg-gray-100',
                    'text-gray-500',
                    'cursor-not-allowed',
                    'focus:ring-0'
                );
                chapterSelect.classList.add(
                    'bg-white',
                    'text-gray-800',
                    'focus:ring-2',
                    'focus:ring-red-500'
                );
            } else {
                chapterSelect.disabled = true;
                chapterSelect.value = '';
                chapterSelect.classList.add(
                    'bg-gray-100',
                    'text-gray-500',
                    'cursor-not-allowed',
                    'focus:ring-0'
                );
                chapterSelect.classList.remove(
                    'bg-white',
                    'text-gray-800',
                    'focus:ring-2',
                    'focus:ring-red-500'
                );
            }
        }

        eventType.addEventListener('change', toggleChapter);
        toggleChapter(); // run on page load
    </script>

    <script>feather.replace();</script>
@endsection