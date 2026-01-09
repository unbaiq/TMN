@extends('layouts.app')

@section('content')
@php
    $isAdmin = auth()->check() && auth()->user()->role === 'admin';
@endphp

@if($isAdmin)
    {{-- ================= ADMIN VIEW (MANAGEMENT THEME) ================= --}}
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="bg-white rounded-2xl shadow p-6 space-y-6">

            {{-- HEADER --}}
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">
                        Member Awards
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Manage awards across all members.
                    </p>
                </div>

                <a href="{{ route('admin.awards.create') }}"
                   class="bg-red-600 hover:bg-red-700 text-white
                          px-5 py-2 rounded-lg text-sm font-medium">
                    + Add Award
                </a>
            </div>

            {{-- FILTERS --}}
            <form method="GET" class="flex flex-wrap items-center gap-4">

                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search title or member..."
                       class="border rounded-xl px-4 py-2 text-sm
                              focus:ring-red-500 focus:border-red-500">

                <select name="award_type" class="border rounded-xl px-4 py-2 text-sm">
                    <option value="">All Types</option>
                    @foreach([
                        'performance'=>'Performance',
                        'leadership'=>'Leadership',
                        'referral'=>'Referral',
                        'training'=>'Training',
                        'visitor'=>'Visitor',
                        'support'=>'Support',
                        'special'=>'Special',
                        'milestone'=>'Milestone'
                    ] as $key=>$label)
                        <option value="{{ $key }}" @selected(request('award_type') === $key)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>

                <input type="text"
                       name="month"
                       value="{{ request('month') }}"
                       placeholder="Month"
                       class="border rounded-xl px-4 py-2 text-sm">

                <input type="number"
                       name="year"
                       value="{{ request('year') }}"
                       placeholder="Year"
                       class="border rounded-xl px-4 py-2 text-sm">

                <button class="bg-red-600 hover:bg-red-700 text-white
                               px-4 py-2 rounded-lg text-sm font-medium">
                    Filter
                </button>
            </form>

            {{-- TABLE --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600 border-b">
                        <tr>
                            <th class="px-5 py-3 text-left">Member</th>
                            <th class="px-5 py-3 text-left">Title</th>
                            <th class="px-5 py-3 text-left">Type</th>
                            <th class="px-5 py-3 text-center">Points</th>
                            <th class="px-5 py-3 text-center">Month</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @forelse($awards as $award)
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-3 font-medium">
                                    {{ $award->member->name ?? '—' }}
                                </td>
                                <td class="px-5 py-3">{{ $award->title }}</td>
                                <td class="px-5 py-3 capitalize">{{ $award->award_type }}</td>
                                <td class="px-5 py-3 text-center">{{ $award->points ?? '—' }}</td>
                                <td class="px-5 py-3 text-center">{{ $award->month }} {{ $award->year }}</td>
                                <td class="px-5 py-3 text-right space-x-3">
                                    <a href="{{ route('admin.awards.show', $award) }}"
                                       class="text-blue-600 hover:underline">View</a>
                                    <a href="{{ route('admin.awards.edit', $award) }}"
                                       class="text-green-600 hover:underline">Edit</a>
                                    <form method="POST"
                                          action="{{ route('admin.awards.destroy', $award) }}"
                                          class="inline"
                                          onsubmit="return confirm('Delete this award?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-500">
                                    No awards found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $awards->links() }}
        </div>
    </div>

@else
    {{-- ================= MEMBER VIEW (RECOGNITION THEME) ================= --}}
    <div class="max-w-7xl mx-auto px-6 py-8 space-y-6">

        {{-- GRADIENT HEADER --}}
        <div class="bg-gradient-to-r from-red-700 to-red-500
                    rounded-2xl px-10 py-7 text-white shadow">
            <h2 class="text-2xl font-semibold">Member Awards</h2>
            <p class="text-sm text-white/80 mt-1">
                Celebrate achievements and top performers within your chapter.
            </p>
        </div>

        {{-- TABLE CARD --}}
        <div class="bg-white rounded-2xl shadow border overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b text-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-left">Title</th>
                        <th class="px-6 py-4 text-left">Type</th>
                        <th class="px-6 py-4 text-center">Points</th>
                        <th class="px-6 py-4 text-center">Month</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($awards as $award)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium">{{ $award->title }}</td>
                            <td class="px-6 py-4 capitalize">{{ $award->award_type }}</td>
                            <td class="px-6 py-4 text-center font-semibold">{{ $award->points ?? '—' }}</td>
                            <td class="px-6 py-4 text-center">{{ $award->month }} {{ $award->year }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('member.awards.show', $award) }}"
                                   class="text-blue-600 hover:underline font-medium">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-500">
                                No awards found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="px-6 py-4 border-t bg-gray-50">
                {{ $awards->links() }}
            </div>
        </div>
    </div>
@endif

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (window.feather) feather.replace();
});
</script>
@endsection
