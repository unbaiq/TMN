@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">
    <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Insights</h1>
    <a href="{{ route('admin.insights.create') }}" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">+ Add Insight</a>
  </div>

  @if(session('success'))
    <div class="mb-4 text-green-600">{{ session('success') }}</div>
  @endif

  <table class="min-w-full bg-white shadow rounded-lg overflow-hidden">
    <thead>
      <tr class="bg-gray-100 text-left text-sm uppercase text-gray-600">
        <th class="px-4 py-3 border">Title</th>
        <th class="px-4 py-3 border">Category</th>
        <th class="px-4 py-3 border">Status</th>
        <th class="px-4 py-3 border">Date</th>
        <th class="px-4 py-3 text-right border">Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($insights as $insight)
        <tr class="border-b hover:bg-gray-50">
          <td class="px-4 py-3 border">{{ $insight->title }}</td>
          <td class="px-4 py-3 border">{{ $insight->category }}</td>
          <td class="px-4 py-3 border">
            <span class="px-2 py-1 rounded text-sm {{ $insight->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
              {{ ucfirst($insight->status) }}
            </span>
          </td>
          <td class="px-4 py-3 border">{{ $insight->publish_date }}</td>
          <td class="px-4 py-3 text-right space-x-2">
            <a href="{{ route('admin.insights.edit', $insight->id) }}" class="text-blue-600 hover:underline">Edit</a>
            <form action="{{ route('admin.insights.destroy', $insight->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this insight?')">
              @csrf @method('DELETE')
              <button class="text-red-600 hover:underline">Delete</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="5" class="text-center py-4 text-gray-500">No insights found.</td></tr>
      @endforelse
    </tbody>
  </table>

  <div class="mt-4">
    {{ $insights->links() }}
  </div>
</div>
@endsection
