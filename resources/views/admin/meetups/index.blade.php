@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold text-gray-800">Meetups</h2>
    <a href="{{ route('admin.meetups.create') }}" class="px-4 py-2 rounded bg-[#CF2031] hover:bg-[#b81b2a] text-white">+ Add Meetup</a>
  </div>

  @if(session('success'))
    <div class="mb-4 text-green-600 font-medium">{{ session('success') }}</div>
  @endif

  <table class="min-w-full bg-white shadow rounded-lg overflow-hidden">
    <thead>
      <tr class="bg-gray-100 text-left uppercase text-gray-600 text-xs">
        <th class="px-4 py-3 border">Title</th>
        <th class="px-4 py-3 border">City</th>
        <th class="px-4 py-3 border">Date</th>
        <th class="px-4 py-3 border">Status</th>
        <th class="px-4 py-3 text-right border">Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($meetups as $meetup)
        <tr class="border-b hover:bg-gray-50">
          <td class="px-4 py-3 border">{{ $meetup->title }}</td>
          <td class="px-4 py-3 border">{{ $meetup->city ?? '-' }}</td>
          <td class="px-4 py-3 border">{{ $meetup->event_date ? $meetup->event_date->format('d M Y') : '-' }}</td>
          <td class="px-4 py-3 border">
            <span class="px-2 py-1 rounded text-xs {{ $meetup->status == 'upcoming' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
              {{ ucfirst($meetup->status) }}
            </span>
          </td>
          <td class="px-4 py-3 border text-right space-x-2">
            <a href="{{ route('admin.meetups.edit', $meetup->id) }}" class="text-blue-600 hover:underline">Edit</a>
            <form action="{{ route('admin.meetups.destroy', $meetup->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this meetup?')">
              @csrf @method('DELETE')
              <button class="text-red-600 hover:underline">Delete</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="5" class="text-center py-4 text-gray-500">No meetups found.</td></tr>
      @endforelse
    </tbody>
  </table>

  <div class="mt-4">{{ $meetups->links() }}</div>
</div>
@endsection
