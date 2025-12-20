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
        </div>

        <form id="inviteForm" action="{{ route('member.invitations.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Select Event *</label>
                <select name="event_id" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-400">
                    <option value="">-- Choose Event --</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}">{{ $event->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Guest Name *</label>
                    <input name="guest_name" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-red-500"
                        placeholder="Guest name">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Guest Email</label>
                    <input name="guest_email" type="email"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-red-500"
                        placeholder="Email">
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Guest Phone</label>
                    <input name="guest_phone"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-red-500"
                        placeholder="Phone">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Profession</label>
                    <input name="profession"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-red-500"
                        placeholder="Profession">
                </div>
            </div>

            <div class="pt-4 text-right">
                <button class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-lg shadow">
                    Send Invitation
                </button>
            </div>
        </form>
    </div>

    {{-- ==== INVITATIONS LIST ==== --}}
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-10">

        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-gray-800">Your Invitations</h3>
            @if(session('success'))
                <span class="text-green-600 text-sm bg-green-50 px-3 py-1 rounded">
                    {{ session('success') }}
                </span>
            @endif
        </div>

        {{-- ==== SEARCH & FILTER BAR ==== --}}
        <div class="flex flex-col md:flex-row gap-4 mb-4">

            <input id="tableSearch" type="text"
                placeholder="Search guest, email, phone, profession, event..."
                class="flex-1 px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-400">

            <select id="statusFilter"
                class="px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-400">
                <option value="">All Status</option>
                <option value="invited">Invited</option>
                <option value="accepted">Accepted</option>
                <option value="attended">Attended</option>
                <option value="declined">Declined</option>
            </select>

            <select id="eventFilter"
                class="px-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-400">
                <option value="">All Events</option>
                @foreach($events as $event)
                    <option value="{{ strtolower($event->title) }}">{{ $event->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="overflow-x-auto rounded-xl border border-gray-200">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-5 py-3">Event</th>
                        <th class="px-5 py-3">Guest</th>
                        <th class="px-5 py-3">Contact</th>
                        <th class="px-5 py-3">Profession</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($invitations as $invite)
                    <tr class="border-t invitation-row"
                        data-event="{{ strtolower($invite->event->title ?? '') }}"
                        data-status="{{ strtolower($invite->status) }}"
                        data-search="{{ strtolower(
                            ($invite->event->title ?? '') . ' ' .
                            $invite->guest_name . ' ' .
                            ($invite->guest_email ?? '') . ' ' .
                            ($invite->guest_phone ?? '') . ' ' .
                            ($invite->profession ?? '')
                        ) }}">

                        <td class="px-5 py-3 font-medium">{{ $invite->event->title ?? '—' }}</td>
                        <td class="px-5 py-3">{{ $invite->guest_name }}</td>
                        <td class="px-5 py-3">
                            <div>{{ $invite->guest_email ?? '—' }}</div>
                            <div class="text-xs text-gray-500">{{ $invite->guest_phone ?? '' }}</div>
                        </td>
                        <td class="px-5 py-3">{{ $invite->profession ?? '—' }}</td>
                        <td class="px-5 py-3">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($invite->status==='attended') bg-green-100 text-green-700
                                @elseif($invite->status==='accepted') bg-blue-100 text-blue-700
                                @elseif($invite->status==='declined') bg-red-100 text-red-700
                                @else bg-yellow-100 text-yellow-700 @endif">
                                {{ ucfirst($invite->status) }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-right">
                            <form action="{{ route('member.invitations.updateStatus',$invite->id) }}" method="POST">
                                @csrf
                                <select name="status" onchange="this.form.submit()"
                                    class="text-xs border border-gray-300 rounded-lg px-2 py-1">
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
                        <td colspan="6" class="py-6 text-center text-gray-500">No invitations found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ==== SEARCH & FILTER SCRIPT ==== --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('tableSearch');
    const statusFilter = document.getElementById('statusFilter');
    const eventFilter = document.getElementById('eventFilter');
    const rows = document.querySelectorAll('.invitation-row');

    function filterTable() {
        const search = searchInput.value.toLowerCase();
        const status = statusFilter.value.toLowerCase();
        const eventVal = eventFilter.value.toLowerCase();

        rows.forEach(row => {
            const matchSearch = row.dataset.search.includes(search);
            const matchStatus = !status || row.dataset.status === status;
            const matchEvent = !eventVal || row.dataset.event === eventVal;

            row.classList.toggle('hidden', !(matchSearch && matchStatus && matchEvent));
        });
    }

    searchInput.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);
    eventFilter.addEventListener('change', filterTable);
});
</script>
@endsection
