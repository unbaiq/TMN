@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-4 space-y-6">

    {{-- ==== HEADER ==== --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 rounded-2xl shadow-lg px-8 py-8 flex flex-col md:flex-row md:items-center md:justify-between text-white">
        <div>
            <h2 class="text-2xl font-semibold">Give &amp; Take of Business</h2>
            <p class="text-white/80 text-sm mt-1">
                Track all business given and received within your BNI chapter.
            </p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('member.business.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-white text-red-600 rounded-lg font-medium hover:bg-gray-100 transition">
                <i data-feather="plus-circle" class="w-4 h-4"></i> Add New
            </a>
        </div>
    </div>

    {{-- ==== FILTER BAR ==== --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4">
        <form method="GET" action="{{ route('member.business.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs text-gray-600 mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-500 focus:border-red-500"
                       placeholder="Service, member...">
            </div>

            <div>
                <label class="block text-xs text-gray-600 mb-1">Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-500 focus:border-red-500">
                    <option value="">Any</option>
                    <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                    <option value="accepted" {{ request('status')=='accepted'?'selected':'' }}>Accepted</option>
                    <option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>Rejected</option>
                    <option value="closed" {{ request('status')=='closed'?'selected':'' }}>Closed</option>
                </select>
            </div>

            <div>
                <label class="block text-xs text-gray-600 mb-1">Referral Type</label>
                <select name="referral_type" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-500 focus:border-red-500">
                    <option value="">Any</option>
                    <option value="referral" {{ request('referral_type')=='referral'?'selected':'' }}>Referral</option>
                    <option value="thank_you" {{ request('referral_type')=='thank_you'?'selected':'' }}>Thank You</option>
                    <option value="1to1" {{ request('referral_type')=='1to1'?'selected':'' }}>1-to-1</option>
                    <option value="visitor" {{ request('referral_type')=='visitor'?'selected':'' }}>Visitor</option>
                    <option value="training" {{ request('referral_type')=='training'?'selected':'' }}>Training</option>
                    <option value="testimony" {{ request('referral_type')=='testimony'?'selected':'' }}>Testimony</option>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white rounded-lg px-4 py-2 text-sm font-medium">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    {{-- ==== TABLE ==== --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow overflow-hidden">
        @if($records->count() > 0)
        <table class="w-full text-sm text-gray-700">
            <thead class="bg-gray-50 border-b text-gray-600">
                <tr>
                    <th class="px-4 py-3 text-left">Service</th>
                    <th class="px-4 py-3 text-left">Type</th>
                    <th class="px-4 py-3 text-left">Receiver</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-right">Value</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($records as $item)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 font-medium text-gray-800">
                        {{ $item->service_name }}
                    </td>
                    <td class="px-4 py-3 capitalize">{{ $item->referral_type_label }}</td>
                    <td class="px-4 py-3">
                        {{ $item->taker?->name ?? '—' }}
                    </td>
                    <td class="px-4 py-3">
                        @if($item->status == 'accepted')
                            <span class="px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-medium">Accepted</span>
                        @elseif($item->status == 'rejected')
                            <span class="px-2 py-1 rounded-full bg-red-100 text-red-700 text-xs font-medium">Rejected</span>
                        @elseif($item->status == 'closed')
                            <span class="px-2 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-medium">Closed</span>
                        @else
                            <span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-medium">Pending</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $item->formatted_business_value }}
                    </td>
                    <td class="px-4 py-3 text-right space-x-2">
                        <a href="{{ route('member.business.show', $item) }}" class="text-blue-600 hover:underline text-sm">View</a>
                        @if($item->giver_id == Auth::id())
                            <a href="{{ route('member.business.edit', $item) }}" class="text-red-600 hover:underline text-sm">Edit</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-6 py-4 border-t bg-gray-50">
            {{ $records->links() }}
        </div>
        @else
            <div class="p-8 text-center text-gray-500">
                No business records found.
            </div>
        @endif
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  if (window.feather) feather.replace();
});
</script>
@endsection
