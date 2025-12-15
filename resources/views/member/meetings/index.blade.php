@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-4 space-y-6">

    {{-- ==== HEADER ==== --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 text-white rounded-2xl shadow-xl px-10 py-8 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-3xl font-semibold">
                {{ $type == '1to1' ? '1-to-1 Meetups' : 'Cluster Meetings' }}
            </h2>
            <p class="text-white/80 mt-1 text-sm">
                {{ $type == '1to1' ? 'Your personal 1-1 networking sessions' : 'Your chapter-based cluster networking sessions' }}
            </p>
        </div>
        <a href="{{ route('member.meetings.create', ['type' => $type]) }}"
           class="mt-4 md:mt-0 inline-flex items-center gap-2 bg-white text-red-600 px-5 py-2.5 rounded-lg font-medium shadow hover:bg-gray-100 transition">
            <i data-feather="plus-circle" class="w-4 h-4"></i> Add Meeting
        </a>
    </div>

    {{-- ==== TABLE ==== --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow overflow-hidden">
        @if($meetings->count() > 0)
        <table class="w-full text-sm text-gray-700">
            <thead class="bg-gray-50 text-gray-600 border-b">
                <tr>
                    <th class="px-4 py-3 text-left">Title</th>
                    <th class="px-4 py-3 text-left">Date</th>
                    <th class="px-4 py-3 text-left">Venue</th>
                    <th class="px-4 py-3 text-left">Participants</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($meetings as $meeting)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $meeting->title ?? 'Untitled Meeting' }}</td>
                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($meeting->meeting_date)->format('d M Y') }}</td>
                    <td class="px-4 py-3">{{ $meeting->venue ?? '—' }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">
                        {{ $meeting->participants->pluck('name')->take(3)->join(', ') }}
                        @if($meeting->participants->count() > 3)
                            <span class="text-gray-400 text-xs">+{{ $meeting->participants->count() - 3 }} more</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('member.meetings.show', $meeting) }}" class="text-blue-600 hover:underline text-sm">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-6 py-4 border-t bg-gray-50">
            {{ $meetings->links() }}
        </div>
        @else
        <div class="p-8 text-center text-gray-500">
            No {{ $type == '1to1' ? '1-to-1 meetups' : 'cluster meetings' }} found.
        </div>
        @endif
    </div>
</div>

<script>document.addEventListener('DOMContentLoaded',()=>{if(window.feather)feather.replace();});</script>
@endsection
