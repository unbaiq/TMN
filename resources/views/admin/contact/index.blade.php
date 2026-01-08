@extends('layouts.app')

@section('content')
@php
    /**
     * Status → Tailwind color map
     * (Reliable with Tailwind CDN)
     */
    $statusClasses = [
        'new'         => 'bg-red-100 text-red-700',
        'in_progress' => 'bg-yellow-100 text-yellow-700',
        'resolved'    => 'bg-green-100 text-green-700',
        'closed'      => 'bg-gray-200 text-gray-700',
    ];
@endphp

<div class="max-w-7xl mx-auto px-6 py-8 space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-semibold text-gray-800">
            Contact Queries
        </h2>
    </div>

    {{-- FILTER BAR --}}
    <form method="GET" class="flex flex-wrap items-center gap-4">

    {{-- SEARCH INPUT --}}
    <div class="relative w-full md:w-96">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search by name, email or phone..."
            class="w-full pl-10 pr-4 py-2 border rounded-xl
                   focus:ring-red-500 focus:border-red-500">

        <i data-feather="search"
           class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
    </div>

    {{-- STATUS FILTER --}}
    <select name="status" class="border rounded-xl px-4 py-2">
        <option value="">All Status</option>
        @foreach(['new','in_progress','resolved','closed'] as $status)
            <option value="{{ $status }}"
                @selected(request('status') === $status)>
                {{ ucfirst(str_replace('_',' ', $status)) }}
            </option>
        @endforeach
    </select>

    {{-- SEARCH / FILTER BUTTON --}}
    <button
        type="submit"
        class="bg-red-600 text-white px-5 py-2 rounded-xl hover:bg-red-700 transition">
        Search
    </button>

    {{-- CLEAR BUTTON --}}
    @if(request()->filled('search') || request()->filled('status'))
        <a href="{{ route('admin.contact.index') }}"
           class="bg-gray-200 text-gray-700 px-5 py-2 rounded-xl hover:bg-gray-300 transition">
            Clear
        </a>
    @endif

</form>


    {{-- TABLE --}}
    <div class="bg-white rounded-2xl shadow overflow-x-auto">
        <table class="w-full border-collapse">
            <thead class="bg-gray-50 text-xs uppercase text-gray-600">
                <tr>
                    <th class="px-5 py-3 text-left">#</th>
                    <th class="px-5 py-3 text-left">Name</th>
                    <th class="px-5 py-3 text-left">Email</th>
                    <th class="px-5 py-3 text-left">Phone</th>
                    <th class="px-5 py-3 text-left">Status</th>
                    <th class="px-5 py-3 text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($contacts as $contact)
                    <tr class="hover:bg-red-50/40">

                        <td class="px-5 py-4">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-5 py-4 font-medium">
                            {{ $contact->name }}

                            @if(!$contact->is_read)
                                <span class="ml-2 text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded">
                                    New
                                </span>
                            @endif
                        </td>

                        <td class="px-5 py-4">
                            {{ $contact->email }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $contact->phone ?? '-' }}
                        </td>

                        {{-- STATUS BADGE --}}
                        <td class="px-5 py-4">
                            <span class="px-3 py-1 text-xs rounded-full font-semibold
                                  {{ $statusClasses[$contact->status] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ ucfirst(str_replace('_',' ', $contact->status)) }}
                            </span>
                        </td>

                        {{-- ACTIONS --}}
                        <td class="px-5 py-4 text-right space-x-3">
                            <a href="{{ route('admin.contact.show', $contact) }}"
                               class="text-blue-600 hover:underline">
                                View
                            </a>

                            <a href="{{ route('admin.contact.edit', $contact) }}"
                               class="text-green-600 hover:underline">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.contact.destroy', $contact) }}"
                                  class="inline"
                                  onsubmit="return confirm('Delete this query?')">
                                @csrf
                                @method('DELETE')

                                <button class="text-red-600 hover:underline">
                                    Delete
                                </button>
                            </form>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-10 text-gray-500">
                            No contact queries found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div>
        {{ $contacts->links() }}
    </div>

</div>
@endsection
