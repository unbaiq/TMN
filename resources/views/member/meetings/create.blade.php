@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-8 space-y-8">

    {{-- ================= HEADER ================= --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500
                text-white rounded-2xl shadow-xl px-8 py-6
                flex flex-col md:flex-row md:items-center md:justify-between">

        <div>
            <h2 class="text-3xl font-semibold">
                {{ $type === 'cluster' ? 'Create Cluster Meeting' : 'Create 1-to-1 Meeting' }}
            </h2>

            <p class="text-white/80 mt-1 text-sm">
                {{ $type === 'cluster'
                    ? 'Record a chapter-level cluster meeting'
                    : 'Record a personal one-to-one networking meeting'
                }}
            </p>
        </div>

        <a href="{{ $type === 'cluster'
                    ? route('member.meetings.cluster')
                    : route('member.meetings.onetoone') }}"
           class="mt-4 md:mt-0 inline-flex items-center gap-2
                  bg-white text-red-600 px-4 py-2.5 rounded-lg
                  font-medium shadow hover:bg-gray-100">
            <i data-feather="arrow-left" class="w-4 h-4"></i>
            Back
        </a>
    </div>

    {{-- ================= FORM ================= --}}
    <div class="bg-white rounded-2xl shadow p-8">

        <form method="POST"
              action="{{ route('member.meetings.store') }}"
              class="space-y-8">

            @csrf

            {{-- 🔒 TYPE FROM URL (NO LOGIC HERE) --}}
            <input type="hidden" name="meeting_type" value="{{ $type }}">

            {{-- ================= BASIC DETAILS ================= --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Meeting Date <span class="text-red-600">*</span>
                    </label>
                    <input type="date" name="meeting_date" required
                           class="w-full mt-1 border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Meeting Time
                    </label>
                    <input type="time" name="meeting_time"
                           class="w-full mt-1 border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Venue
                    </label>
                    <input type="text" name="venue"
                           placeholder="Zoom / Office / Café"
                           class="w-full mt-1 border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Title
                    </label>
                    <input type="text" name="title"
                           placeholder="Business Discussion"
                           class="w-full mt-1 border rounded-lg px-3 py-2">
                </div>
            </div>

            {{-- ================= AGENDA ================= --}}
            <div>
                <label class="text-sm font-medium text-gray-700">
                    Agenda
                </label>
                <textarea name="agenda" rows="3"
                          class="w-full mt-1 border rounded-lg px-3 py-2"
                          placeholder="Purpose of the meeting"></textarea>
            </div>

           {{-- ================= PARTICIPANTS ================= --}}
<div>
    <label class="text-sm font-medium text-gray-700">
        Participants <span class="text-red-600">*</span>
    </label>

    @if($type === 'cluster')
        {{-- CLUSTER: MULTIPLE PARTICIPANTS --}}
        <select name="participants[]" multiple required
                class="w-full mt-1 border rounded-lg px-3 py-2 h-48">
            @foreach($members as $member)
                <option value="{{ $member->id }}">
                    {{ $member->name }}
                </option>
            @endforeach
        </select>

        <p class="text-xs text-gray-500 mt-2">
            Hold <strong>Ctrl</strong> (Windows) or <strong>Cmd</strong> (Mac) to select multiple members.
        </p>

    @else
        {{-- 1-TO-1: SINGLE PARTICIPANT --}}
        <select name="participants[]" required
                class="w-full mt-1 border rounded-lg px-3 py-2">
            <option value="">Select one member</option>
            @foreach($members as $member)
                <option value="{{ $member->id }}">
                    {{ $member->name }}
                </option>
            @endforeach
        </select>

        <p class="text-xs text-gray-500 mt-2">
            Select exactly <strong>one</strong> member for a 1-to-1 meeting.
        </p>
    @endif

    @error('participants')
        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

            {{-- ================= SUBMIT ================= --}}
            <div class="flex justify-end">
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700
                               text-white px-6 py-3 rounded-lg shadow">
                    <i data-feather="save" class="inline w-4 h-4 mr-2"></i>
                    Save Meeting
                </button>
            </div>

        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (window.feather) feather.replace();
});
</script>
@endsection
