@extends('layouts.app')

@section('content')
<div class="w-full px-6 py-10">

    {{-- ==== HEADER ==== --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 text-white rounded-2xl shadow-xl px-10 py-8 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-semibold">
                {{ $type == 'cluster' ? 'Record Cluster Meeting' : 'Record 1-to-1 Meetup' }}
            </h2>
            <p class="text-white/80 mt-1 text-sm">Log your meeting details and participants from your chapter.</p>
        </div>
        <a href="{{ $type == 'cluster' ? route('member.meetings.cluster') : route('member.meetings.onetoone') }}"
           class="inline-flex items-center gap-2 bg-white text-red-600 px-4 py-2.5 rounded-lg font-medium shadow hover:bg-gray-100">
            <i data-feather="arrow-left" class="w-4 h-4"></i> Back
        </a>
    </div>

    {{-- ==== FORM CARD ==== --}}
    <div class="bg-white mt-10 rounded-2xl shadow-xl p-8 border border-gray-100 max-w-5xl mx-auto">
        <form action="{{ route('member.meetings.store') }}" method="POST" class="space-y-10">
            @csrf
            <input type="hidden" name="meeting_type" value="{{ $type == 'cluster' ? 'cluster' : '1to1' }}">

            {{-- === MEETING DETAILS === --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Meeting Date <span class="text-red-600">*</span></label>
                    <input type="date" name="meeting_date" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
                    @error('meeting_date')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Meeting Time</label>
                    <input type="time" name="meeting_time"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Venue</label>
                    <input type="text" name="venue" placeholder="E.g., Zoom / Café / Office"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Title (optional)</label>
                    <input type="text" name="title" placeholder="E.g., Business Growth Discussion"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
                </div>
            </div>

            {{-- === AGENDA === --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Agenda</label>
                <textarea name="agenda" rows="3" placeholder="What will you discuss or achieve in this meeting?"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600"></textarea>
            </div>

            {{-- === PARTICIPANTS === --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Select Participants <span class="text-red-600">*</span>
                </label>
                <select name="participants[]" multiple required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600 h-48">
                    @foreach($members as $member)
                        <option value="{{ $member->id }}">
                            {{ $member->name }}
                            @if($member->businessInfo && $member->businessInfo->company_name)
                                — {{ $member->businessInfo->company_name }}
                            @endif
                        </option>
                    @endforeach
                </select>

                @error('participants')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror

                <p class="text-xs text-gray-500 mt-2">
                    Hold <kbd>Ctrl</kbd> or <kbd>Cmd</kbd> to select multiple members.
                    @if($type == '1to1')
                        (Select exactly <strong>1 member</strong> for 1-to-1 meeting)
                    @else
                        (You can select multiple members for cluster meeting)
                    @endif
                </p>
            </div>

            {{-- === SUBMIT BUTTON === --}}
            <div class="flex justify-end">
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-medium px-6 py-3 rounded-lg shadow">
                    <i data-feather="save" class="w-4 h-4 inline mr-2"></i> Save Meeting
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
