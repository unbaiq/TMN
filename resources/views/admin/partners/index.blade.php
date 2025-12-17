@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold text-gray-800">Partners</h2>
    <a href="{{ route('admin.partners.create') }}" class="px-4 py-2 rounded bg-[#CF2031] hover:bg-[#b81b2a] text-white">+ Add Partner</a>
  </div>

  @if(session('success'))
    <div class="mb-4 text-green-600 font-medium">{{ session('success') }}</div>
  @endif

  <table class="min-w-full bg-white shadow rounded-lg overflow-hidden">
    <thead>
      <tr class="bg-gray-100 text-left uppercase text-gray-600 text-xs">
        <th class="px-4 py-3 border">Name</th>
        <th class="px-4 py-3 border">Company</th>
        <th class="px-4 py-3 border">Type</th>
        <th class="px-4 py-3 border">Level</th>
        <th class="px-4 py-3 text-right border">Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($partners as $partner)
        <tr class="border-b hover:bg-gray-50">
          <td class="px-4 py-3 border font-medium">{{ $partner->name }}</td>
          <td class="px-4 py-3 border">{{ $partner->company_name ?? '—' }}</td>
          <td class="px-4 py-3 border capitalize">{{ $partner->partner_type }}</td>
          <td class="px-4 py-3 border capitalize">{{ $partner->level }}</td>
          <td class="px-4 py-3 border text-right space-x-2">
            <a href="{{ route('admin.partners.show', $partner->id) }}" class="text-gray-700 hover:text-gray-900">View</a>
            <a href="{{ route('admin.partners.edit', $partner->id) }}" class="text-blue-600 hover:underline">Edit</a>
            <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this partner?')">
              @csrf @method('DELETE')
              <button class="text-red-600 hover:underline">Delete</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="5" class="text-center py-4 text-gray-500">No partners found.</td></tr>
      @endforelse
    </tbody>
  </table>

  <div class="mt-4">{{ $partners->links() }}</div>
</div>
@endsection
