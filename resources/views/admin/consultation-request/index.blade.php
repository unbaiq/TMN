@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">

    {{-- ================= SINGLE CONTAINER ================= --}}
    <div class="bg-white rounded-2xl shadow p-6 space-y-6">

        {{-- HEADER --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">
                    Consultation Requests
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Manage incoming consultation enquiries.
                </p>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600 border-b">
                    <tr>
                        <th class="px-5 py-3 text-left">Name</th>
                        <th class="px-5 py-3 text-left">Email</th>
                        <th class="px-5 py-3 text-left">Phone</th>
                        <th class="px-5 py-3 text-left">City</th>
                        <th class="px-5 py-3 text-center">Status</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($requests as $request)
                        <tr class="hover:bg-gray-50">

                            {{-- NAME --}}
                            <td class="px-5 py-3 font-medium text-gray-900">
                                {{ $request->first_name }} {{ $request->last_name }}
                            </td>

                            {{-- EMAIL --}}
                            <td class="px-5 py-3 text-gray-700">
                                {{ $request->email }}
                            </td>

                            {{-- PHONE --}}
                            <td class="px-5 py-3 text-gray-700">
                                {{ $request->phone }}
                            </td>

                            {{-- CITY --}}
                            <td class="px-5 py-3 text-gray-700">
                                {{ $request->city ?? '—' }}
                            </td>

                            {{-- STATUS --}}
                            <td class="px-5 py-3 text-center">
                                @php
                                    $statusColors = [
                                        'new'         => 'bg-blue-50 text-blue-700',
                                        'contacted'   => 'bg-yellow-50 text-yellow-700',
                                        'in_progress' => 'bg-indigo-50 text-indigo-700',
                                        'completed'   => 'bg-green-50 text-green-700',
                                        'rejected'    => 'bg-red-50 text-red-700',
                                    ];
                                @endphp

                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $statusColors[$request->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                </span>
                            </td>

                            {{-- ACTIONS --}}
                            <td class="px-5 py-3 text-right space-x-3">

                                {{-- VIEW --}}
                                <a href="{{ route('admin.consultation-requests.show', $request) }}"
                                   class="text-blue-600 hover:underline">
                                    View
                                </a>

                                {{-- EDIT STATUS --}}
                                <a href="{{ route('admin.consultation-request.edit', $request) }}"
                                   class="text-green-600 hover:underline font-medium">
                                    Edit
                                </a>

                                {{-- DELETE --}}
                                <form method="POST"
                                      action="{{ route('admin.consultation-requests.destroy', $request) }}"
                                      class="inline"
                                      onsubmit="return confirm('Delete this consultation request?')">
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
                            <td colspan="6" class="text-center py-8 text-gray-500">
                                No consultation requests found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="pt-4">
            {{ $requests->links() }}
        </div>

    </div>
</div>
@endsection
