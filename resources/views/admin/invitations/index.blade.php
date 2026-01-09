@extends('layouts.app')
@section('title', 'Event Invitations')

@section('content')
<div class="max-w-full mx-auto px-6 py-6 bg-gray-50 text-[13px]">

    {{-- ================= SINGLE CONTAINER ================= --}}
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 space-y-6">

        {{-- ================= HEADER ================= --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-base font-semibold text-gray-900">
                    Event Invitations
                </h1>
                <p class="text-[11px] text-gray-500">
                    TMN invitation tracking & membership follow-ups
                </p>
            </div>

            <a href="{{ route('admin.invitations.create') }}"
               class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-xs font-semibold tracking-wide">
                + CREATE INVITATION
            </a>
        </div>

        {{-- ================= KPI STRIP ================= --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach ($invitationStats as $label => $count)
                <div class="border border-gray-200 rounded-md px-4 py-3">
                    <p class="text-[10px] text-gray-500 uppercase tracking-wide">
                        {{ str_replace('_', ' ', $label) }}
                    </p>
                    <p class="text-xl font-semibold text-gray-900 mt-1">
                        {{ $count }}
                    </p>
                </div>
            @endforeach
        </div>

        {{-- ================= TABLE ================= --}}
        <div class="border border-gray-300 rounded-md overflow-hidden">

            {{-- Table Title --}}
            <div class="px-5 py-3 border-b bg-gray-100 text-[11px] font-semibold text-gray-700 uppercase tracking-wide">
                Invitation Records
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse text-sm">
                    <thead class="bg-gray-50 text-gray-600 text-[11px] uppercase">
                        <tr>
                            <th class="px-4 py-3 border-b text-left">Guest</th>
                            <th class="px-4 py-3 border-b text-left">Contact</th>
                            <th class="px-4 py-3 border-b text-left">Event</th>
                            <th class="px-4 py-3 border-b text-left">Inviter</th>
                            <th class="px-4 py-3 border-b text-center">Status</th>
                            <th class="px-4 py-3 border-b text-right">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @forelse ($invitations as $invite)
                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">
                                        {{ $invite->guest_name }}
                                    </div>
                                    <div class="text-[11px] text-gray-500">
                                        {{ $invite->guest_email ?? '—' }}
                                    </div>
                                </td>

                                <td class="px-4 py-3 text-gray-700">
                                    {{ $invite->guest_phone ?? '—' }}
                                </td>

                                <td class="px-4 py-3 text-gray-700">
                                    {{ $invite->event->title ?? '—' }}
                                </td>

                                <td class="px-4 py-3 text-gray-700">
                                    {{ $invite->inviter->name ?? '—' }}
                                </td>

                                {{-- STATUS --}}
                                <td class="px-4 py-3 text-center">
                                    @switch($invite->status)
                                        @case('invited')
                                            <span class="px-3 py-1 text-[11px] rounded bg-yellow-100 text-yellow-800 font-semibold">
                                                Invited
                                            </span>
                                            @break
                                        @case('accepted')
                                            <span class="px-3 py-1 text-[11px] rounded bg-blue-100 text-blue-800 font-semibold">
                                                Accepted
                                            </span>
                                            @break
                                        @case('attended')
                                            <span class="px-3 py-1 text-[11px] rounded bg-green-100 text-green-800 font-semibold">
                                                Attended
                                            </span>
                                            @break
                                        @case('declined')
                                            <span class="px-3 py-1 text-[11px] rounded bg-red-100 text-red-800 font-semibold">
                                                Declined
                                            </span>
                                            @break
                                        @default
                                            <span class="px-3 py-1 text-[11px] rounded bg-gray-100 text-gray-700 font-semibold">
                                                —
                                            </span>
                                    @endswitch
                                </td>

                                <td class="px-4 py-3 text-right space-x-2">
                                    <button onclick="sendInviteLink({{ $invite->id }})"
                                        class="px-3 py-1.5 text-[11px] rounded bg-red-600 hover:bg-red-700 text-white font-semibold">
                                        SEND
                                    </button>

                                    <a href="{{ route('admin.invitations.edit', $invite) }}"
                                       class="text-[11px] text-gray-600 hover:text-red-600 font-semibold">
                                        EDIT
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500 text-sm">
                                    No invitation records available
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ================= PAGINATION ================= --}}
        <div class="pt-1">
            {{ $invitations->links() }}
        </div>

    </div>
</div>

{{-- ================= AJAX ================= --}}
<script>
    function sendInviteLink(id) {
        if (!confirm('Send TMN membership invitation link?')) return;

        fetch(`/admin/invitations/${id}/send-link`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            if (data.success) location.reload();
        })
        .catch(() => alert('Request failed'));
    }
</script>
@endsection
