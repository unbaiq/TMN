@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto bg-white shadow-md rounded-xl p-6 mt-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">TMN Members</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm border border-gray-200 rounded-lg">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-semibold">
                <tr>
                    <th class="py-3 px-4 border text-left">#</th>
                    <th class="py-3 px-4 border text-left">Name</th>
                    <th class="py-3 px-4 border text-left">Email</th>
                    <th class="py-3 px-4 border text-left">Phone</th>
                    <th class="py-3 px-4 border text-left">Profession</th>
                    <th class="py-3 px-4 border text-left">Company</th>
                    <th class="py-3 px-4 border text-left">Status</th>
                    <th class="py-3 px-4 border text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $i => $m)
                <tr class="hover:bg-gray-50" id="member-row-{{ $m->id }}">
                    <td class="py-3 px-4 border">{{ $i + 1 }}</td>
                    <td class="py-3 px-4 border font-medium text-gray-800">
                        {{ $m->basicInfo->full_name ?? $m->name }}
                    </td>
                    <td class="py-3 px-4 border text-gray-600">{{ $m->email }}</td>
                    <td class="py-3 px-4 border text-gray-600">
                        {{ $m->basicInfo->contact_mobile ?? '—' }}
                    </td>
                    <td class="py-3 px-4 border text-gray-600">
                        {{ $m->basicInfo->profession ?? '—' }}
                    </td>
                    <td class="py-3 px-4 border text-gray-600">
                        {{ $m->businessInfo->company_name ?? '—' }}
                    </td>
                    <td class="py-3 px-4 border" id="status-{{ $m->id }}">
                        @if(optional($m->adminData)->status === 'active')
                            <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700 font-medium">Active</span>
                        @else
                            <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-700 font-medium">Inactive</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 border text-right space-x-2">
                        <a href="{{ route('admin.members.show', $m->id) }}"
                           class="text-blue-600 hover:underline text-sm font-semibold">View</a>

                        @if(optional($m->adminData)->status !== 'active')
                            <button onclick="activateMember({{ $m->id }})"
                                    class="text-sm bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded transition">
                                Activate
                            </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="py-6 text-center text-gray-500">No members found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $members->links() }}
    </div>
</div>

<!-- ✅ JS for Activation -->
<script>
    async function activateMember(userId) {
        if (!confirm('Are you sure you want to activate this member account?')) return;

        try {
            const response = await fetch(`/admin/members/${userId}/activate`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                // Update status badge
                document.getElementById(`status-${userId}`).innerHTML =
                    `<span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700 font-medium">Active</span>`;
                
                // Remove the button
                const row = document.getElementById(`member-row-${userId}`);
                const btn = row.querySelector('button');
                if (btn) btn.remove();

                alert('Member account activated successfully.');
            } else {
                alert(data.message || 'Failed to activate member.');
            }
        } catch (error) {
            console.error(error);
            alert('An error occurred. Please try again.');
        }
    }
</script>
@endsection
