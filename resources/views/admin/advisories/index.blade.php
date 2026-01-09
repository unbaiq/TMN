@extends('layouts.app')

@section('content')
<div class="max-w-full mx-auto px-6 py-6 bg-gray-50 text-[13px]">

    {{-- ================= SINGLE CONTAINER ================= --}}
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 space-y-6">

        {{-- ================= HEADER ================= --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-base font-semibold text-gray-900">
                    Advisories
                </h2>
                <p class="text-[11px] text-gray-500">
                    Manage all advisory sessions
                </p>
            </div>

            <a href="{{ route('admin.advisories.create') }}"
               class="inline-flex items-center px-4 py-2 rounded-md bg-[#CF2031] hover:bg-[#b81b2a]
                      text-white text-xs font-semibold shadow-sm">
                <i data-feather="plus" class="w-3.5 h-3.5 mr-1.5"></i>
                Add Advisory
            </a>
        </div>

        {{-- ================= TABLE ================= --}}
        <div class="border border-gray-300 rounded-md overflow-hidden">

            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse text-sm">

                    <thead class="bg-gray-50 text-gray-600 text-[11px] uppercase tracking-wide">
                        <tr>
                            <th class="px-4 py-3 text-left">Title</th>
                            <th class="px-4 py-3 text-left">Advisor</th>
                            <th class="px-4 py-3 text-left">Experience</th>
                            <th class="px-4 py-3 text-left">Date</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-right">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @forelse($advisories as $advisory)
                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-4 py-3 font-medium text-gray-800">
                                    {{ $advisory->title }}
                                </td>

                                <td class="px-4 py-3 text-gray-700">
                                    {{ $advisory->advisor_display ?? '—' }}
                                </td>

                                <td class="px-4 py-3">
                                    @if($advisory->advisor_experience_years)
                                        <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold
                                                     bg-red-50 text-red-600">
                                            {{ $advisory->advisor_experience_label }}
                                        </span>
                                    @else
                                        —
                                    @endif
                                </td>

                                <td class="px-4 py-3 text-gray-600">
                                    {{ $advisory->formatted_date ?? '—' }}
                                </td>

                                <td class="px-4 py-3">
                                    @php
                                        $statusClasses = match($advisory->status) {
                                            'scheduled' => 'bg-blue-50 text-blue-600',
                                            'ongoing'   => 'bg-yellow-50 text-yellow-700',
                                            'completed' => 'bg-green-50 text-green-600',
                                            'cancelled' => 'bg-red-50 text-red-600',
                                            default     => 'bg-gray-100 text-gray-700',
                                        };
                                    @endphp

                                    <span class="px-3 py-1 rounded-full text-[11px] font-semibold {{ $statusClasses }}">
                                        {{ ucfirst($advisory->status) }}
                                    </span>
                                </td>

                                <td class="px-4 py-3 text-right whitespace-nowrap space-x-2">
                                    <a href="{{ route('admin.advisories.show', $advisory) }}"
                                       class="text-gray-600 hover:text-gray-900 text-[11px] font-semibold">
                                        View
                                    </a>

                                    <a href="{{ route('admin.advisories.edit', $advisory) }}"
                                       class="text-blue-600 hover:underline text-[11px] font-semibold">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.advisories.destroy', $advisory) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Delete this advisory?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline text-[11px] font-semibold">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500 text-sm">
                                    No advisories found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

        {{-- ================= PAGINATION ================= --}}
        <div class="pt-1">
            {{ $advisories->links() }}
        </div>

    </div>
</div>

<script>
    if (window.feather) feather.replace();
</script>
@endsection
