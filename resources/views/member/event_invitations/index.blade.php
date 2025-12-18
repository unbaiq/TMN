@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-4 space-y-6">

    {{-- ==== HEADER ==== --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 rounded-2xl shadow-2xl px-10 py-8 flex flex-col md:flex-row md:items-center md:justify-between text-white relative overflow-hidden border border-red-600/30">
        <div class="relative z-10">
            <h2 class="text-3xl font-bold tracking-tight">📩 Invite Guests to Events</h2>
            <p class="text-red-100 mt-2 text-sm md:text-base">
                Invite professionals and guests to attend your TMN chapter events.
            </p>
        </div>
        <div class="absolute right-0 top-0 w-72 h-72 bg-white/10 rounded-full blur-3xl opacity-25"></div>
    </div>

    {{-- ==== INVITATION FORM ==== --}}
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-10">
        <div class="mb-6 border-b border-gray-100 pb-3 flex justify-between items-center">
            <h3 class="text-xl font-semibold text-gray-800">Send Guest Invitation</h3>
            <i data-feather="mail" class="w-6 h-6 text-red-600 opacity-70"></i>
        </div>

        <form id="inviteForm" action="{{ route('member.invitations.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- EVENT SELECTION --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Select Event <span class="text-red-500">*</span></label>
                <select name="event_id"
                    class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none"
                    required>
                    <option value="">-- Choose an Event --</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}">{{ $event->title }}</option>
                    @endforeach
                </select>
            </div>

            {{-- GUEST DETAILS --}}
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Guest Name <span class="text-red-500">*</span></label>
                    <input type="text" name="guest_name"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600 focus:outline-none transition placeholder-gray-400"
                        placeholder="Enter guest name" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Guest Email</label>
                    <input type="email" name="guest_email"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600 focus:outline-none transition placeholder-gray-400"
                        placeholder="Enter guest email">
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Guest Phone</label>
                    <input type="text" name="guest_phone"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600 focus:outline-none transition placeholder-gray-400"
                        placeholder="Enter guest phone">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Profession</label>
                    <input type="text" name="profession"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600 focus:outline-none transition placeholder-gray-400"
                        placeholder="Enter guest profession">
                </div>
            </div>

            {{-- ACTION BUTTON --}}
            <div class="pt-4 flex justify-end">
                <button id="submitBtn" type="submit"
                    class="flex items-center gap-2 bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white text-sm px-6 py-2.5 rounded-lg shadow-md hover:shadow-lg transition-all">
                    <svg id="spinner" class="hidden w-5 h-5 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <i id="sendIcon" data-feather="send" class="w-4 h-4"></i>
                    <span id="btnText">Send Invitation</span>
                </button>
            </div>
        </form>
    </div>

    {{-- ==== INVITATIONS LIST ==== --}}
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-10">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-semibold text-gray-800">Your Invitations</h3>
            @if(session('success'))
                <span class="text-green-600 text-sm font-medium bg-green-50 px-3 py-1 rounded-lg border border-green-100">
                    {{ session('success') }}
                </span>
            @endif
        </div>

        <div class="overflow-x-auto rounded-xl border border-gray-200">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs border-b">
                    <tr>
                        <th class="px-5 py-3 font-semibold">Event</th>
                        <th class="px-5 py-3 font-semibold">Guest Name</th>
                        <th class="px-5 py-3 font-semibold">Contact</th>
                        <th class="px-5 py-3 font-semibold">Profession</th>
                        <th class="px-5 py-3 font-semibold">Status</th>
                        <th class="px-5 py-3 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invitations as $invite)
                        <tr class="border-t hover:bg-red-50/40 transition">
                            <td class="px-5 py-3 font-medium text-gray-800">{{ $invite->event->title ?? '—' }}</td>
                            <td class="px-5 py-3">{{ $invite->guest_name }}</td>
                            <td class="px-5 py-3">
                                <div>{{ $invite->guest_email ?? '—' }}</div>
                                <div class="text-gray-500 text-xs">{{ $invite->guest_phone ?? '' }}</div>
                            </td>
                            <td class="px-5 py-3 text-gray-700">{{ $invite->profession ?? '—' }}</td>
                            <td class="px-5 py-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($invite->status === 'attended') bg-green-100 text-green-700
                                    @elseif($invite->status === 'accepted') bg-blue-100 text-blue-700
                                    @elseif($invite->status === 'declined') bg-red-100 text-red-700
                                    @else bg-yellow-100 text-yellow-700
                                    @endif">
                                    {{ ucfirst($invite->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <form action="{{ route('member.invitations.updateStatus', $invite->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()"
                                        class="border border-gray-300 text-xs rounded-lg px-2 py-1 focus:ring-1 focus:ring-red-600 focus:border-red-600 transition">
                                        <option {{ $invite->status=='invited'?'selected':'' }}>invited</option>
                                        <option {{ $invite->status=='accepted'?'selected':'' }}>accepted</option>
                                        <option {{ $invite->status=='attended'?'selected':'' }}>attended</option>
                                        <option {{ $invite->status=='declined'?'selected':'' }}>declined</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6 text-gray-500">No invitations yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
feather.replace();

// Loading spinner logic
document.getElementById('inviteForm').addEventListener('submit', function() {
    const submitBtn = document.getElementById('submitBtn');
    const spinner = document.getElementById('spinner');
    const sendIcon = document.getElementById('sendIcon');
    const btnText = document.getElementById('btnText');

    // Disable button and show spinner
    submitBtn.disabled = true;
    spinner.classList.remove('hidden');
    sendIcon.classList.add('hidden');
    btnText.textContent = 'Sending...';
});
</script>
@endsection
