@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-10 bg-white rounded-2xl shadow-xl p-8">
    {{-- ==== HEADER ==== --}}
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
                <i data-feather="calendar" class="w-6 h-6 text-red-600"></i>
                All Events
            </h2>
            <p class="text-gray-500 text-sm mt-1">View, manage, and track all chapter and general events.</p>
        </div>
        <a href="{{ route('admin.events.create') }}"
           class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl shadow-md transition flex items-center gap-2 self-start md:self-auto">
           <i data-feather="plus" class="w-4 h-4"></i> Add Event
        </a>
    </div>

    {{-- ==== SUCCESS MESSAGE ==== --}}
    @if(session('success'))
        <div class="p-3 bg-green-100 text-green-800 rounded-xl mb-5 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    {{-- ==== TABLE ==== --}}
    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-inner">
        <table class="min-w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100 border text-gray-800 text-xs uppercase font-semibold border-b">
                <tr>
                    <th class="px-4 py-3 border">Banner</th>
                    <th class="px-4 py-3 border">Title & Type</th>
                    <th class="px-4 py-3 border">Schedule</th>
                    <th class="px-4 py-3 border">Venue / Online</th>
                    <th class="px-4 py-3 border">Organizer</th>
                    <th class="px-4 py-3 border">Chapter</th>
                    <th class="px-4 py-3 border">Visibility</th>
                    <th class="px-4 py-3 border">Status</th>
                    <th class="px-4 py-3 text-right border">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($events as $event)
                    <tr class="hover:bg-gray-50 transition">
                        {{-- BANNER --}}
                        <td class="px-4 py-3 border">
                            @if($event->banner_image)
                                <img src="{{ asset('storage/'.$event->banner_image) }}"
                                     class="w-16 h-10 rounded-md object-cover border border-gray-200">
                            @else
                                <div class="w-16 h-10 rounded-md bg-gray-100 flex items-center justify-center text-gray-400 text-xs border border-gray-200">N/A</div>
                            @endif
                        </td>

                        {{-- TITLE + TYPE --}}
                        <td class="px-4 py-3 border">
                            <div class="font-semibold text-gray-900">{{ $event->title }}</div>
                            <div class="text-xs text-gray-500 mt-0.5 capitalize flex items-center gap-1">
                                <i data-feather="{{ $event->event_type == 'chapter' ? 'users' : 'globe' }}" class="w-3 h-3"></i>
                                {{ ucfirst($event->event_type) }}
                            </div>
                        </td>

                        {{-- DATE & TIME --}}
                        <td class="px-4 py-3 border">
                            <div class="font-medium">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $event->start_time }} - {{ $event->end_time }}</div>
                        </td>

                        {{-- VENUE / ONLINE --}}
                        <td class="px-4 py-3 border">
                            @if($event->is_online)
                                <a href="{{ $event->meeting_link }}" target="_blank"
                                   class="text-blue-600 hover:underline text-xs flex items-center gap-1">
                                   <i data-feather="video" class="w-3 h-3"></i> Online Event
                                </a>
                                @if($event->meeting_password)
                                    <div class="text-xs text-gray-500">Pass: {{ $event->meeting_password }}</div>
                                @endif
                            @else
                                <div class="text-sm font-medium text-gray-800">{{ $event->venue_name ?? '-' }}</div>
                                <div class="text-xs text-gray-500 truncate">{{ $event->city ?? '' }}, {{ $event->state ?? '' }}</div>
                            @endif
                        </td>

                        {{-- ORGANIZER --}}
                        <td class="px-4 py-3 border">
                            <div class="text-sm font-medium text-gray-800">{{ $event->host_name ?? '-' }}</div>
                            <div class="text-xs text-gray-500">{{ $event->host_contact ?? '' }}</div>
                            <div class="text-xs text-gray-500 truncate">{{ $event->host_email ?? '' }}</div>
                        </td>

                        {{-- CHAPTER --}}
                        <td class="px-4 py-3 border">
                            {{ $event->chapter?->name ?? '-' }}
                        </td>

                        {{-- VISIBILITY --}}
                        <td class="px-4 py-3 border">
                            <div class="flex flex-col text-xs font-medium gap-1">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full
                                    {{ $event->is_public ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                    <i data-feather="{{ $event->is_public ? 'eye' : 'eye-off' }}" class="w-3 h-3"></i>
                                    {{ $event->is_public ? 'Public' : 'Private' }}
                                </span>
                                @if($event->is_featured)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-700">
                                        <i data-feather="star" class="w-3 h-3"></i> Featured
                                    </span>
                                @endif
                            </div>
                        </td>

                        {{-- STATUS --}}
                        <td class="px-4 py-3 border">
                            @php
                                $statusColors = [
                                    'upcoming' => 'bg-blue-100 text-blue-700',
                                    'ongoing' => 'bg-green-100 text-green-700',
                                    'completed' => 'bg-gray-200 text-gray-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$event->status] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ ucfirst($event->status) }}
                            </span>
                        </td>

                        {{-- ACTIONS --}}
                        <td class="px-4 py-3 text-right border">
                            <div class="flex justify-end items-center gap-3">
                                <a href="{{ route('admin.events.edit', $event) }}"
                                   class="text-blue-600 hover:text-blue-800 flex items-center gap-1 text-sm">
                                   <i data-feather="edit-3" class="w-4 h-4"></i> Edit
                                </a>
                                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" onsubmit="return confirm('Delete this event?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800 flex items-center gap-1 text-sm">
                                        <i data-feather="trash-2" class="w-4 h-4"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="py-8 text-center text-gray-500 text-sm">
                            <i data-feather="info" class="w-4 h-4 inline-block mr-1 text-gray-400"></i>
                            No events found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ==== PAGINATION ==== --}}
    <div class="mt-6">
        {{ $events->links() }}
    </div>
</div>

<script>feather.replace();</script>
@endsection
