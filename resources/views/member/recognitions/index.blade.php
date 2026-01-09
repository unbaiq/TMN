@extends('layouts.app')

@section('content')
@php
    $isAdmin = auth()->check() && auth()->user()->role === 'admin';
@endphp

@if($isAdmin)

    {{-- ================= ADMIN VIEW (ENQUIRY MANAGEMENT THEME) ================= --}}
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="bg-white rounded-2xl shadow p-6 space-y-6">

            {{-- HEADER --}}
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-900">
                    Recognitions Management
                </h2>

                <a href="{{ route('admin.recognitions.create') }}"
                   class="bg-red-600 hover:bg-red-700 text-white
                          px-5 py-2 rounded-lg text-sm font-medium">
                    + Add Recognition
                </a>
            </div>

            {{-- SEARCH + FILTER --}}
            <form method="GET" class="flex flex-wrap items-center gap-4">

                <div class="relative flex-1 min-w-[260px]">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search by member or title..."
                           class="w-full pl-10 pr-4 py-2 border rounded-xl
                                  focus:ring-red-500 focus:border-red-500">
                    <i data-feather="search"
                       class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
                </div>

                <select name="status" class="border rounded-xl px-4 py-2 text-sm">
                    <option value="">All Status</option>
                    <option value="approved" @selected(request('status') === 'approved')>Approved</option>
                    <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                    <option value="rejected" @selected(request('status') === 'rejected')>Rejected</option>
                </select>

                <select name="category" class="border rounded-xl px-4 py-2 text-sm">
                    <option value="">All Categories</option>
                    @foreach([
                        'referral'=>'Referral','thank_you'=>'Thank You','visitor'=>'Visitor',
                        'leadership'=>'Leadership','training'=>'Training',
                        'testimony'=>'Testimony','support'=>'Support',
                        'milestone'=>'Milestone','other'=>'Other'
                    ] as $key => $label)
                        <option value="{{ $key }}" @selected(request('category') === $key)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </form>

            {{-- TABLE --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-5 py-3 text-left">#</th>
                            <th class="px-5 py-3 text-left">Member</th>
                            <th class="px-5 py-3 text-left">Title</th>
                            <th class="px-5 py-3 text-center">Status</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @forelse($recognitions as $rec)
                            <tr>
                                <td class="px-5 py-3">{{ $loop->iteration }}</td>
                                <td class="px-5 py-3 font-medium">{{ $rec->member->name }}</td>
                                <td class="px-5 py-3">{{ $rec->title }}</td>
                                <td class="px-5 py-3 text-center">
                                    <span class="px-3 py-1 text-xs rounded-full {{ $rec->status_badge }}">
                                        {{ ucfirst($rec->status) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-right space-x-3">

    {{-- VIEW --}}
    <a href="{{ route('admin.recognitions.show', $rec) }}"
       class="text-blue-600 hover:underline">
        View
    </a>

    {{-- EDIT --}}
    <a href="{{ route('admin.recognitions.edit', $rec) }}"
       class="text-green-600 hover:underline">
        Edit
    </a>

    {{-- DELETE --}}
    <form method="POST"
          action="{{ route('admin.recognitions.destroy', $rec) }}"
          class="inline"
          onsubmit="return confirm('Are you sure you want to delete this recognition?');">
        @csrf
        @method('DELETE')

        <button type="submit"
                class="text-red-600 hover:underline">
            Delete
        </button>
    </form>

</td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-gray-500">
                                    No recognitions found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $recognitions->links() }}
        </div>
    </div>

@else

    {{-- ================= MEMBER RECOGNITIONS VIEW ================= --}}
    <div class="max-w-7xl mx-auto px-6 py-6 space-y-6">

        {{-- HEADER CARD --}}
        <div class="bg-gradient-to-r from-red-700 to-red-500
                    rounded-2xl px-8 py-6 text-white shadow">
            <h2 class="text-2xl font-semibold">Recognitions</h2>
            <p class="text-sm text-white/80 mt-1">
                Appreciate members for contributions and track recognitions.
            </p>
        </div>

        {{-- FILTER CARD --}}
        <form method="GET"
              class="bg-white rounded-xl shadow border p-5 flex flex-wrap items-end gap-4">

            <div class="flex-1 min-w-[260px]">
                <label class="text-sm text-gray-600 mb-1 block">Search</label>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Member or title..."
                       class="w-full border rounded-lg px-4 py-2
                              focus:ring-red-500 focus:border-red-500">
            </div>

            <div>
                <label class="text-sm text-gray-600 mb-1 block">Category</label>
                <select name="category"
                        class="border rounded-lg px-4 py-2 min-w-[140px]">
                    <option value="">All</option>
                    @foreach([
                        'referral'=>'Referral','thank_you'=>'Thank You','visitor'=>'Visitor',
                        'leadership'=>'Leadership','training'=>'Training',
                        'testimony'=>'Testimony','support'=>'Support',
                        'milestone'=>'Milestone','other'=>'Other'
                    ] as $key => $label)
                        <option value="{{ $key }}" @selected(request('category') === $key)>
                            {{ ucfirst($label) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm text-gray-600 mb-1 block">Status</label>
                <select name="status"
                        class="border rounded-lg px-4 py-2 min-w-[120px]">
                    <option value="">Any</option>
                    <option value="approved" @selected(request('status') === 'approved')>Approved</option>
                    <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                    <option value="rejected" @selected(request('status') === 'rejected')>Rejected</option>
                </select>
            </div>

            <button class="bg-red-600 hover:bg-red-700
                           text-white px-6 py-2 rounded-lg font-medium">
                Apply
            </button>
        </form>

        {{-- TABLE CARD --}}
        <div class="bg-white rounded-xl shadow border overflow-hidden">

            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b text-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-left">Member</th>
                        <th class="px-6 py-4 text-left">Title</th>
                        <th class="px-6 py-4 text-left">Category</th>
                        <th class="px-6 py-4 text-center">Points</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($recognitions as $rec)
                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4 flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gray-200
                                            flex items-center justify-center
                                            font-semibold text-gray-700">
                                    {{ strtoupper(substr($rec->member->name,0,1)) }}
                                </div>
                                <span class="font-medium text-gray-900">
                                    {{ $rec->member->name }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-gray-800">
                                {{ $rec->title }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs
                                             bg-gray-100 text-gray-700 capitalize">
                                    {{ str_replace('_',' ',$rec->category) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center font-medium">
                                {{ $rec->points ?? '—' }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                             {{ $rec->status_badge }}">
                                    {{ ucfirst($rec->status) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('member.recognitions.show',$rec) }}"
                                   class="text-blue-600 hover:underline font-medium">
                                    View
                                </a>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-10 text-gray-500">
                                No recognitions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="p-4 border-t bg-gray-50">
                {{ $recognitions->links() }}
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
