@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8 space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-semibold text-gray-800">
            Contact Queries
        </h2>
    </div>

    {{-- FILTER BAR --}}
    <form method="GET" class="flex flex-wrap items-center gap-4">
        <div class="relative w-full md:w-96">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by name, email or phone..."
                   class="w-full pl-10 pr-4 py-2 border rounded-xl focus:ring-red-500 focus:border-red-500">
            <i data-feather="search" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
        </div>

        <select name="status" class="border rounded-xl px-4 py-2">
            <option value="">All Status</option>
            @foreach(['new','in_progress','resolved','closed'] as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>
                    {{ ucfirst(str_replace('_',' ', $status)) }}
                </option>
            @endforeach
        </select>

        <button class="bg-red-600 text-white px-5 py-2 rounded-xl">
            Filter
        </button>
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
                        <td class="px-5 py-4">{{ $loop->iteration }}</td>

                        <td class="px-5 py-4 font-medium">
                            {{ $contact->name }}
                            @if(!$contact->is_read)
                                <span class="ml-2 text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded">
                                    New
                                </span>
                            @endif
                        </td>

                        <td class="px-5 py-4">{{ $contact->email }}</td>
                        <td class="px-5 py-4">{{ $contact->phone ?? '-' }}</td>

                        <td class="px-5 py-4">
                            <span class="px-3 py-1 text-xs rounded-full
                                @class([
                                    'bg-green-100 text-green-700' => $contact->status === 'resolved',
                                    'bg-yellow-100 text-yellow-700' => $contact->status === 'in_progress',
                                    'bg-red-100 text-red-700' => in_array($contact->status, ['new','closed']),
                                ])">
                                {{ ucfirst(str_replace('_',' ', $contact->status)) }}
                            </span>
                        </td>

                        <td class="px-5 py-4 text-right space-x-3">
                            <a href="{{ route('admin.contact.show', $contact) }}" class="text-blue-600">View</a>
                            <a href="{{ route('admin.contact.edit', $contact) }}" class="text-green-600">Edit</a>

                            <form method="POST"
                                  action="{{ route('admin.contact.destroy', $contact) }}"
                                  class="inline"
                                  onsubmit="return confirm('Delete this query?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600">Delete</button>
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
