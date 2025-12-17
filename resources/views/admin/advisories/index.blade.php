@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold text-gray-800">Advisories</h2>
    <a href="{{ route('admin.advisories.create') }}" class="px-4 py-2 rounded bg-[#CF2031] hover:bg-[#b81b2a] text-white">+ Add Advisory</a>
  </div>

  @if(session('success'))
    <div class="mb-4 text-green-600 font-medium">{{ session('success') }}</div>
  @endif

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

  <div class="mt-4">{{ $advisories->links() }}</div>
</div>
@endsection
