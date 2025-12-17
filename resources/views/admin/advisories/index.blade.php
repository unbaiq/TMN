@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8 space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Advisories</h2>
            <p class="text-sm text-gray-500">Manage all advisory sessions</p>
        </div>

<<<<<<< Updated upstream
  <table class="min-w-full bg-white shadow rounded-lg overflow-hidden">
    <thead>
      <tr class="bg-gray-100 text-left uppercase text-gray-600 text-xs">
        <th class="px-4 py-3 border">Title</th>
        <th class="px-4 py-3 border">Advisor</th>
        <th class="px-4 py-3 border">Date</th>
        <th class="px-4 py-3 border">Status</th>
        <th class="px-4 py-3 text-right border">Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($advisories as $advisory)
        <tr class="border-b hover:bg-gray-50">
          <td class="px-4 py-3 border font-medium">{{ $advisory->title }}</td>
          <td class="px-4 py-3 border">{{ $advisory->advisor_display }}</td>
          <td class="px-4 py-3 border">{{ $advisory->formatted_date }}</td>
          <td class="px-4 py-3 border">
            <span class="px-2 py-1 rounded text-xs {{ $advisory->status == 'scheduled' ? 'bg-blue-100 text-blue-700' : ($advisory->status == 'completed' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700') }}">
              {{ ucfirst($advisory->status) }}
            </span>
          </td>
          <td class="px-4 py-3 border text-right space-x-2">
            <a href="{{ route('admin.advisories.show', $advisory->id) }}" class="text-gray-700 hover:text-gray-900">View</a>
            <a href="{{ route('admin.advisories.edit', $advisory->id) }}" class="text-blue-600 hover:underline">Edit</a>
            <form action="{{ route('admin.advisories.destroy', $advisory->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this advisory?')">
              @csrf @method('DELETE')
              <button class="text-red-600 hover:underline">Delete</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="5" class="text-center py-4 text-gray-500">No advisories found.</td></tr>
      @endforelse
    </tbody>
  </table>
=======
        <a href="{{ route('admin.advisories.create') }}"
           class="inline-flex items-center px-5 py-2.5 rounded-xl bg-[#CF2031] hover:bg-[#b81b2a] text-white text-sm font-semibold shadow">
            + Add Advisory
        </a>
    </div>

    {{-- TABLE --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4 text-left">Title</th>
                    <th class="px-6 py-4 text-left">Advisor</th>
                    <th class="px-6 py-4 text-left">Experience</th>
                    <th class="px-6 py-4 text-left">Date</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($advisories as $advisory)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $advisory->title }}
                        </td>

                        <td class="px-6 py-4 text-gray-700">
                            {{ $advisory->advisor_display }}
                        </td>

                        <td class="px-6 py-4">
                            @if($advisory->advisor_experience_years)
                                <span class="px-2 py-1 text-xs rounded bg-red-50 text-red-600 font-medium">
                                    {{ $advisory->advisor_experience_label }}
                                </span>
                            @else
                                —
                            @endif
                        </td>

                        <td class="px-6 py-4 text-gray-600">
                            {{ $advisory->formatted_date }}
                        </td>

                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($advisory->status === 'scheduled') bg-blue-50 text-blue-600
                                @elseif($advisory->status === 'ongoing') bg-green-50 text-green-600
                                @elseif($advisory->status === 'completed') bg-gray-100 text-gray-700
                                @elseif($advisory->status === 'cancelled') bg-red-50 text-red-600
                                @else bg-yellow-50 text-yellow-600 @endif">
                                {{ ucfirst($advisory->status) }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.advisories.edit', $advisory) }}"
                               class="text-sm text-blue-600 hover:underline">Edit</a>

                            <form action="{{ route('admin.advisories.destroy', $advisory) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Delete this advisory?')">
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
                            No advisories found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div>
        {{ $advisories->links() }}
    </div>
>>>>>>> Stashed changes

</div>
@endsection
