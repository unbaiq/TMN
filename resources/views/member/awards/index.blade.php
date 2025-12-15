@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-4 space-y-6">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 text-white rounded-2xl px-8 py-6 flex justify-between items-center shadow-lg">
        <div>
            <h2 class="text-3xl font-semibold">Member Awards</h2>
            <p class="text-sm text-white/80 mt-1">Celebrate achievements and top performers within your chapter.</p>
        </div>
        <a href="{{ route('member.awards.create') }}" class="bg-white text-red-600 px-4 py-2 rounded-lg font-medium shadow hover:bg-gray-100 transition">
            <i data-feather="plus" class="inline w-4 h-4 mr-1"></i> Add Award
        </a>
    </div>

    {{-- FILTERS --}}
    <form method="GET" class="bg-white border border-gray-200 shadow rounded-xl p-4 flex flex-wrap gap-4 items-end">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title or member..."
               class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
        <select name="award_type" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
            <option value="">All Types</option>
            @foreach(['performance'=>'Performance','leadership'=>'Leadership','referral'=>'Referral','training'=>'Training','visitor'=>'Visitor','support'=>'Support','special'=>'Special','milestone'=>'Milestone'] as $key=>$label)
                <option value="{{ $key }}" {{ request('award_type')==$key?'selected':'' }}>{{ $label }}</option>
            @endforeach
        </select>
        <input type="text" name="month" value="{{ request('month') }}" placeholder="Month" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-600">
        <input type="number" name="year" value="{{ request('year') }}" placeholder="Year" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-600">
        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Filter</button>
    </form>

    {{-- TABLE --}}
    <div class="bg-white border border-gray-200 shadow rounded-2xl overflow-hidden">

        {{-- ✅ SAFE CHECK (prevents "Undefined variable $awards") --}}
        @if(isset($awards) && $awards->count())
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left">Member</th>
                        <th class="px-4 py-3 text-left">Title</th>
                        <th class="px-4 py-3 text-left">Type</th>
                        <th class="px-4 py-3 text-center">Points</th>
                        <th class="px-4 py-3 text-center">Month</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($awards as $award)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $award->member->name ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $award->title }}</td>
                        <td class="px-4 py-3 capitalize">{{ $award->award_type }}</td>
                        <td class="px-4 py-3 text-center">{{ $award->points ?? '—' }}</td>
                        <td class="px-4 py-3 text-center">{{ $award->month }} {{ $award->year }}</td>
                        <td class="px-4 py-3 text-right space-x-3">
                            <a href="{{ route('member.awards.show',$award) }}" class="text-blue-600 hover:underline">View</a>
                            <a href="{{ route('member.awards.edit',$award) }}" class="text-green-600 hover:underline">Edit</a>
                            <form action="{{ route('member.awards.destroy',$award) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Delete this award?')" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4 border-t bg-gray-50">{{ $awards->links() }}</div>
        @else
            <div class="p-10 text-center text-gray-500">No awards found.</div>
        @endif
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded',()=>{
    if(window.feather) feather.replace();
});
</script>
@endsection
