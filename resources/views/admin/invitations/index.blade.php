@extends('layouts.app')
@section('title', 'Event Invitations')

@section('content')
<div class="max-w-full mx-auto px-6 py-6 space-y-6 text-[13px] bg-gray-50">

    {{-- ================= PAGE HEADER ================= --}}
    <div class="bg-white border border-gray-200 rounded-md px-6 py-4 flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-900">
                Event Invitations
            </h1>
            <p class="text-xs text-gray-500">
                BNI invitation tracking & membership follow-ups
            </p>
        </div>

        <a href="{{ route('admin.invitations.create') }}"
           class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-xs font-semibold tracking-wide">
            + CREATE INVITATION
        </a>
    </div>

    {{-- ================= KPI STRIP ================= --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach ($invitationStats as $label => $count)
            <div class="bg-white border border-gray-200 rounded-md px-5 py-4">
                <p class="text-[11px] text-gray-500 uppercase tracking-wide">
                    {{ str_replace('_', ' ', $label) }}
                </p>
                <p class="text-2xl font-semibold text-gray-900 mt-1">
                    {{ $count }}
                </p>
            </div>
        @endforeach
    </div>

    {{-- ================= TABLE ================= --}}
    <div class="bg-white border border-gray-300 rounded-md overflow-hidden">

        {{-- Table Title --}}
        <div class="px-6 py-3 border-b bg-gray-100 text-xs font-semibold text-gray-700 uppercase tracking-wide">
            Invitation Records
        </div>

        <table class="min-w-full border-collapse">
            <thead class="bg-gray-50 text-gray-600 text-xs">
                <tr>
                    <th class="px-5 py-3 border-b text-left">Guest</th>
                    <th class="px-5 py-3 border-b text-left">Contact</th>
                    <th class="px-5 py-3 border-b text-left">Event</th>
                    <th class="px-5 py-3 border-b text-left">Inviter</th>
                    <th class="px-5 py-3 border-b text-center">Status</th>
                    <th class="px-5 py-3 border-b text-right">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($invitations as $invite)
                    <tr class="hover:bg-red-50/40 transition">
                        <td class="px-5 py-3 border-b">
                            <div class="font-semibold text-gray-900">
                                {{ $invite->guest_name }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $invite->guest_email ?? '—' }}
                            </div>
                        </td>

                        <td class="px-5 py-3 border-b text-gray-700">
                            {{ $invite->guest_phone ?? '—' }}
                        </td>

                        <td class="px-5 py-3 border-b text-gray-700">
                            {{ $invite->event->title ?? '—' }}
                        </td>

                        <td class="px-5 py-3 border-b text-gray-700">
                            {{ $invite->inviter->name ?? '—' }}
                        </td>

                        <td class="px-5 py-3 border-b text-center">
                        @if(empty($invite->membership_token))
                        <span class="px-4 py-1.5 text-xs rounded bg-yellow-100 text-green-700 font-semibold">
                                   Pending
                                </span>
                            @else
                                <span class="px-4 py-1.5 text-xs rounded bg-green-100 text-green-700 font-semibold">
                                    CLOSED
                                </span>
                            @endif
                        </td>

                        <td class="px-5 py-3 border-b text-right space-x-2">
                          
                                <button onclick="sendInviteLink({{ $invite->id }})"
                                    class="px-4 py-1.5 text-xs rounded bg-red-600 hover:bg-red-700 text-white font-semibold">
                                    SEND
                                </button>
                          

                            <a href="{{ route('admin.invitations.edit', $invite) }}"
                               class="text-xs text-gray-600 hover:text-red-600 font-semibold">
                                EDIT
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            No invitation records available
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ================= PAGINATION ================= --}}
    <div class="pt-2">
        {{ $invitations->links() }}
    </div>
</div>

{{-- ================= AJAX ================= --}}
<script>
    function sendInviteLink(id) {
        if (!confirm('Send BNI membership invitation link?')) return;

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
