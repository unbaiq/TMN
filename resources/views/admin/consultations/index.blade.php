@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8 space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Website Feed Sections</h2>
            <p class="text-sm text-gray-500">Manage homepage & website feed content</p>
        </div>

        <a href="{{ route('admin.consultations.create') }}"
           class="inline-flex items-center px-5 py-2.5 rounded-xl bg-[#CF2031] hover:bg-[#b81b2a] text-white text-sm font-semibold shadow">
            + Add Section
        </a>
    </div>

    {{-- TABLE --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 text-left">Order</th>
                    <th class="px-6 py-4 text-left">Title</th>
                    <th class="px-6 py-4 text-left">Key</th>
                    <th class="px-6 py-4 text-left">Visibility</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>

<<<<<<< Updated upstream
    <table class="min-w-full bg-white shadow rounded-lg overflow-hidden">
      <thead class="bg-gray-100 sticky top-0 z-10">
        <tr class="uppercase text-gray-600 text-xs">
          <th class="px-4 py-3 border text-left whitespace-nowrap">Title</th>
          <th class="px-4 py-3 border text-left whitespace-nowrap">Consultant</th>
          <th class="px-4 py-3 border text-left whitespace-nowrap">Date</th>
          <th class="px-4 py-3 border text-left whitespace-nowrap">Status</th>
          <th class="px-4 py-3 border text-right whitespace-nowrap">Actions</th>
        </tr>
      </thead>
=======
            <tbody class="divide-y">
                @forelse($consultations as $section)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-gray-700 font-medium">
                            {{ $section->display_order }}
                        </td>
>>>>>>> Stashed changes

                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">
                                {{ $section->title }}
                            </div>
                            @if($section->subtitle)
                                <div class="text-xs text-gray-500">
                                    {{ $section->subtitle }}
                                </div>
                            @endif
                        </td>

<<<<<<< Updated upstream
            <td class="px-4 py-3 border whitespace-nowrap">
              {{ $consultation->title }}
            </td>

            <td class="px-4 py-3 border whitespace-nowrap">
              {{ $consultation->consultant_name ?? '-' }}
            </td>

            <td class="px-4 py-3 border whitespace-nowrap">
              {{ $consultation->formatted_date ?? '-' }}
            </td>

            <td class="px-4 py-3 border whitespace-nowrap">
              <span class="px-2 py-1 rounded text-xs font-medium
                {{ $consultation->status === 'scheduled'
                    ? 'bg-blue-100 text-blue-700'
                    : 'bg-gray-100 text-gray-700' }}">
                {{ ucfirst($consultation->status) }}
              </span>
            </td>
=======
                        <td class="px-6 py-4 text-gray-600 text-xs">
                            {{ $section->key }}
                        </td>

                        <td class="px-6 py-4">
                            @if($section->is_public)
                                <span class="px-3 py-1 text-xs rounded-full bg-green-50 text-green-600 font-semibold">
                                    Public
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-600 font-semibold">
                                    Private
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            @if($section->is_active)
                                <span class="px-3 py-1 text-xs rounded-full bg-blue-50 text-blue-600 font-semibold">
                                    Active
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs rounded-full bg-red-50 text-red-600 font-semibold">
                                    Disabled
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-right space-x-3">
                            <a href="{{ route('admin.consultations.edit', $section) }}"
                               class="text-sm text-blue-600 hover:underline">
                                Edit
                            </a>
>>>>>>> Stashed changes

                            <form action="{{ route('admin.consultations.destroy', $section) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Delete this section?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-sm text-red-600 hover:underline">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            No feed sections found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div>
        {{ $consultations->links() }}
    </div>

</div>
@endsection
