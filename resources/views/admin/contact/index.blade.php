@extends('layouts.app')

@section('content')
@php
    $statusClasses = [
        'new'         => 'bg-red-100 text-red-700',
        'in_progress' => 'bg-yellow-100 text-yellow-700',
        'resolved'    => 'bg-green-100 text-green-700',
        'closed'      => 'bg-gray-200 text-gray-700',
    ];
@endphp

<div class="max-w-7xl mx-auto px-6 py-8">

    {{-- SINGLE CONTAINER --}}
    <div class="bg-white rounded-2xl shadow-sm p-6 space-y-6">

        {{-- HEADER --}}
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">
                Contact Queries
            </h2>
        </div>

        {{-- FILTER BAR --}}
        <form method="GET" class="flex flex-wrap items-center gap-3 text-sm">

            {{-- SEARCH --}}
            <div class="relative w-full md:w-80">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search name, email or phone"
                    class="w-full pl-9 pr-3 py-2 border rounded-lg text-sm
                           focus:ring-red-500 focus:border-red-500">

                <i data-feather="search"
                   class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
            </div>

            {{-- STATUS --}}
            <select name="status"
                class="border rounded-lg px-3 py-2 text-sm">
                <option value="">All Status</option>
                @foreach(['new','in_progress','resolved','closed'] as $status)
                    <option value="{{ $status }}"
                        @selected(request('status') === $status)>
                        {{ ucfirst(str_replace('_',' ', $status)) }}
                    </option>
                @endforeach
            </select>

            {{-- SEARCH BUTTON --}}
            <button
                type="submit"
                class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700 transition">
                Search
            </button>

            {{-- CLEAR --}}
            @if(request()->filled('search') || request()->filled('status'))
                <a href="{{ route('admin.contact.index') }}"
                   class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-200 transition">
                    Clear
                </a>
            @endif
        </form>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-sm">
                <thead class="bg-gray-50 text-[11px] uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">Phone</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-right">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($contacts as $contact)
                        <tr class="hover:bg-gray-50">

                            <td class="px-4 py-3">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-4 py-3 font-medium text-gray-800">
                                {{ $contact->name }}
                                @if(!$contact->is_read)
                                    <span class="ml-2 text-[10px] bg-red-100 text-red-600 px-2 py-0.5 rounded">
                                        New
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-gray-600">
                                {{ $contact->email }}
                            </td>

                            <td class="px-4 py-3 text-gray-600">
                                {{ $contact->phone ?? '-' }}
                            </td>

                            <td class="px-4 py-3">
                                <span class="px-3 py-1 text-[11px] rounded-full font-semibold
                                    {{ $statusClasses[$contact->status] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ ucfirst(str_replace('_',' ', $contact->status)) }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-right space-x-3 text-sm">
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
                            <td colspan="6" class="text-center py-10 text-gray-500 text-sm">
                                No contact queries found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="pt-2">
            {{ $contacts->links() }}
        </div>

    </div>
</div>
@endsection
