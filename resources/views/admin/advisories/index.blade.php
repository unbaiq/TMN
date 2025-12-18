@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8 space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Advisories</h2>
            <p class="text-sm text-gray-500">Manage all advisory sessions</p>
        </div>

        <a href="{{ route('admin.advisories.create') }}"
           class="inline-flex items-center bg-red-600 hover:bg-red-700
                  text-white px-4 py-2 rounded-lg text-sm font-medium shadow">
            <i data-feather="plus" class="w-4 h-4 mr-2"></i>
            Add Advisory
        </a>
    </div>

    {{-- TABLE --}}
    <div class="bg-white shadow rounded-xl overflow-x-auto border border-gray-200">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-left uppercase text-gray-600 text-xs tracking-wide">
                    <th class="px-5 py-3">Title</th>
                    <th class="px-5 py-3">Advisor</th>
                    <th class="px-5 py-3">Date</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3 text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($advisories as $advisory)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-4 font-medium text-gray-900">
                            {{ $advisory->title }}
                        </td>

                        <td class="px-5 py-4 text-gray-700">
                            {{ $advisory->advisor_display ?? '—' }}
                        </td>

                        <td class="px-5 py-4 text-gray-600">
                            {{ $advisory->formatted_date ?? '—' }}
                        </td>

                        <td class="px-5 py-4">
                            @php
                                $statusClasses = match($advisory->status) {
                                    'scheduled' => 'bg-blue-100 text-blue-700',
                                    'ongoing'   => 'bg-yellow-100 text-yellow-700',
                                    'completed' => 'bg-green-100 text-green-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                    default     => 'bg-gray-100 text-gray-700',
                                };
                            @endphp

                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusClasses }}">
                                {{ ucfirst($advisory->status) }}
                            </span>
                        </td>

                        <td class="px-5 py-4 text-right whitespace-nowrap space-x-3">
                            <a href="{{ route('admin.advisories.show', $advisory->id) }}"
                               class="text-gray-600 hover:text-gray-900 font-medium">
                                View
                            </a>

                            <a href="{{ route('admin.advisories.edit', $advisory->id) }}"
                               class="text-blue-600 hover:underline font-medium">
                                Edit
                            </a>

                            <form action="{{ route('admin.advisories.destroy', $advisory->id) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Delete this advisory?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline font-medium">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-10 text-gray-500">
                            No advisories found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<script>
    if (window.feather) feather.replace();
</script>
@endsection
