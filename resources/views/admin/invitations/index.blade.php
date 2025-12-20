@extends('layouts.app')
@section('title', 'Event Invitations')

@section('content')
<div class="max-w-8xl mx-auto px-6 py-8 space-y-8">

    {{-- ===== Header Card ===== --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm px-8 py-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-semibold text-gray-900 flex items-center gap-3">
                <span class="p-2 bg-red-100 rounded-lg">
                    <i data-feather="send" class="w-5 h-5 text-red-600"></i>
                </span>
                Event Invitations
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Manage and track all event invitation activities
            </p>
        </div>

        <a href="{{ route('admin.invitations.create') }}"
           class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium shadow transition">
            <i data-feather="plus" class="w-4 h-4"></i>
            Create Invitation
        </a>
    </div>

    {{-- ===== Stats ===== --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
        @foreach ($invitationStats as $label => $count)
            <div class="bg-white border border-gray-200 rounded-xl p-5 text-center shadow-sm hover:shadow transition">
                <p class="text-xs text-gray-500 uppercase tracking-wide">
                    {{ str_replace('_', ' ', $label) }}
                </p>
                <p class="mt-2 text-3xl font-bold text-red-600">
                    {{ $count }}
                </p>
            </div>
        @endforeach
    </div>

    {{-- ===== Table ===== --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4 text-left">Guest</th>
                    <th class="px-6 py-4 text-left">Event</th>
                    <th class="px-6 py-4 text-left">Inviter</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($invitations as $invite)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">
                                {{ $invite->guest_name }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $invite->guest_email ?? '—' }}
                            </div>
                        </td>

                        <td class="px-6 py-4 text-gray-700">
                            {{ $invite->event->title ?? '—' }}
                        </td>

                        <td class="px-6 py-4 text-gray-700">
                            {{ $invite->inviter->name ?? '—' }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium
                                {{ $invite->status === 'accepted' ? 'bg-green-100 text-green-700' :
                                   ($invite->status === 'declined' ? 'bg-gray-200 text-gray-700' :
                                   'bg-red-100 text-red-700') }}">
                                {{ ucfirst($invite->status) }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-right space-x-2">
                            @if(empty($invite->membership_token))
                                <button onclick="sendInviteLink({{ $invite->id }})"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs rounded-lg
                                           bg-red-600 hover:bg-red-700 text-white shadow transition">
                                    <i data-feather="mail" class="w-3 h-3"></i>
                                    Send Link
                                </button>
                            @else
                                <span class="inline-flex items-center px-3 py-1.5 text-xs rounded-lg
                                             bg-green-100 text-green-700 font-medium">
                                    Closed
                                </span>
                            @endif

                            <a href="{{ route('admin.invitations.edit', $invite) }}"
                               class="text-xs text-red-600 hover:underline font-medium">
                                Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                            <i data-feather="inbox" class="mx-auto mb-3 w-8 h-8 text-gray-400"></i>
                            No invitations found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="pt-4">
        {{ $invitations->links() }}
    </div>
</div>

{{-- ===== AJAX ===== --}}
<script>
    function sendInviteLink(id) {
        if (!confirm('Send membership invitation link?')) return;

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
        .catch(() => alert('Something went wrong'));
    }
</script>
@endsection
