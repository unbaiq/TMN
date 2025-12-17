@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-6 md:mt-10 bg-white shadow-lg rounded-xl p-4 md:p-8">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
    <h2 class="text-xl md:text-2xl font-semibold text-gray-800">
      Consultations
    </h2>

    <a href="{{ route('admin.consultations.create') }}"
       class="px-4 py-2 rounded bg-[#CF2031] hover:bg-[#b81b2a] text-white text-center">
      + Add Consultation
    </a>
  </div>

  {{-- Flash --}}
  @if(session('success'))
    <div class="mb-4 text-green-600 font-medium">
      {{ session('success') }}
    </div>
  @endif

  {{-- ================= RESPONSIVE TABLE ================= --}}
  <div class="relative overflow-x-auto rounded-lg border">

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

      <tbody>
        @forelse($consultations as $consultation)
          <tr class="border-b hover:bg-gray-50">

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

            <td class="px-4 py-3 text-right whitespace-nowrap">
              <div class="inline-flex gap-3">
                <a href="{{ route('admin.consultations.edit', $consultation->id) }}"
                   class="text-blue-600 hover:underline">
                  Edit
                </a>

                <form action="{{ route('admin.consultations.destroy', $consultation->id) }}"
                      method="POST"
                      onsubmit="return confirm('Delete this consultation?')">
                  @csrf
                  @method('DELETE')
                  <button class="text-red-600 hover:underline">
                    Delete
                  </button>
                </form>
              </div>
            </td>

          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center py-6 text-gray-500">
              No consultations found.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>

  </div>

  {{-- Pagination --}}
  <div class="mt-6">
    {{ $consultations->links() }}
  </div>

</div>
@endsection
