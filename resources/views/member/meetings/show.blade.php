@extends('layouts.app')

@section('content')
<div class="w-full px-6 py-10">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 text-white rounded-2xl shadow-xl px-10 py-8 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-semibold">{{ $meeting->title ?? 'Meeting Details' }}</h2>
            <p class="text-white/80 text-sm mt-1 capitalize">{{ $meeting->meeting_type == '1to1' ? '1-to-1 Meetup' : 'Cluster Meeting' }}</p>
        </div>
       <a href="{{ $meeting->meeting_type === '1to1'
    ? route('member.meetings.onetoone')
    : route('member.meetings.cluster') }}"
   class="inline-flex items-center gap-2 bg-white text-red-600 px-4 py-2.5 rounded-lg font-medium shadow hover:bg-gray-100">
    <i data-feather="arrow-left" class="w-4 h-4"></i> Back
</a>

    </div>

    <div class="mt-10 bg-white rounded-2xl shadow-xl p-8 border border-gray-100 space-y-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-gray-500 text-xs uppercase mb-1">Date</h4>
                <p class="text-gray-800 font-medium">{{ \Carbon\Carbon::parse($meeting->meeting_date)->format('d M Y') }}</p>
            </div>
            <div>
                <h4 class="text-gray-500 text-xs uppercase mb-1">Time</h4>
                <p class="text-gray-800 font-medium">{{ $meeting->meeting_time ? \Carbon\Carbon::parse($meeting->meeting_time)->format('h:i A') : '—' }}</p>
            </div>
            <div>
                <h4 class="text-gray-500 text-xs uppercase mb-1">Venue</h4>
                <p class="text-gray-800 font-medium">{{ $meeting->venue ?? '—' }}</p>
            </div>
            <div>
                <h4 class="text-gray-500 text-xs uppercase mb-1">Created By</h4>
                <p class="text-gray-800 font-medium">{{ $meeting->creator?->name ?? '—' }}</p>
            </div>
        </div>

        <div class="border-t border-gray-100 pt-6">
            <h4 class="text-gray-500 text-xs uppercase mb-2">Agenda</h4>
            <p class="text-gray-700 text-sm">{{ $meeting->agenda ?? 'No agenda provided.' }}</p>
        </div>

        <div class="border-t border-gray-100 pt-6">
            <h4 class="text-gray-500 text-xs uppercase mb-2">Participants</h4>
            <ul class="list-disc list-inside text-gray-800 text-sm space-y-1">
                @foreach($meeting->participants as $p)
                    <li>{{ $p->name }}</li>
                @endforeach
            </ul>
        </div>

        @if($meeting->key_discussion_points || $meeting->outcomes)
        <div class="border-t border-gray-100 pt-6">
            @if($meeting->key_discussion_points)
            <div class="mb-4">
                <h4 class="text-gray-500 text-xs uppercase mb-2">Key Discussion Points</h4>
                <p class="text-gray-700 text-sm">{{ $meeting->key_discussion_points }}</p>
            </div>
            @endif
            @if($meeting->outcomes)
            <div>
                <h4 class="text-gray-500 text-xs uppercase mb-2">Outcomes</h4>
                <p class="text-gray-700 text-sm">{{ $meeting->outcomes }}</p>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>

<script>document.addEventListener('DOMContentLoaded',()=>{if(window.feather)feather.replace();});</script>
@endsection
