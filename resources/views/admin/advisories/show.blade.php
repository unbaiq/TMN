@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">

  {{-- Header --}}
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold text-gray-800">Advisory Details</h2>
    <a href="{{ route('admin.advisories.index') }}" class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">
      ← Back to List
    </a>
  </div>

  {{-- Title & Status --}}
  <div class="mb-6 border-b pb-4">
    <h3 class="text-xl font-bold text-gray-800">{{ $advisory->title }}</h3>
    <p class="text-sm text-gray-600 mt-1">Category: {{ $advisory->category ?? 'N/A' }}</p>

    <span class="inline-block mt-3 px-3 py-1 rounded-full text-xs font-semibold
      @switch($advisory->status)
        @case('scheduled') bg-blue-100 text-blue-700 @break
        @case('ongoing') bg-yellow-100 text-yellow-700 @break
        @case('completed') bg-green-100 text-green-700 @break
        @case('cancelled') bg-red-100 text-red-700 @break
        @default bg-gray-100 text-gray-700
      @endswitch">
      {{ ucfirst($advisory->status) }}
    </span>
  </div>

  {{-- Banner --}}
  @if($advisory->banner)
    <div class="mb-6">
      <img src="{{ asset('storage/'.$advisory->banner) }}" alt="Advisory Banner" class="w-full h-60 object-cover rounded-lg">
    </div>
  @endif

  {{-- Details Grid --}}
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div>
      <h4 class="font-semibold text-gray-800 mb-1">Session Date</h4>
      <p class="text-gray-600">{{ $advisory->formatted_date }}</p>
    </div>

    <div>
      <h4 class="font-semibold text-gray-800 mb-1">Time</h4>
      <p class="text-gray-600">{{ $advisory->time_range ?? '—' }}</p>
    </div>

    <div>
      <h4 class="font-semibold text-gray-800 mb-1">Mode</h4>
      <p class="text-gray-600 capitalize">{{ $advisory->mode ?? '—' }}</p>
    </div>

    <div>
      <h4 class="font-semibold text-gray-800 mb-1">Venue</h4>
      <p class="text-gray-600">{{ $advisory->venue ?? '—' }}</p>
    </div>
  </div>

  {{-- Advisor Info --}}
  <div class="border-t pt-6 mt-6">
    <h4 class="text-lg font-semibold text-gray-800 mb-3">Advisor Information</h4>
    <p><span class="font-medium text-gray-700">Name:</span> {{ $advisory->advisor_display }}</p>
    <p><span class="font-medium text-gray-700">Email:</span> {{ $advisory->advisor_email ?? '—' }}</p>
    <p><span class="font-medium text-gray-700">Phone:</span> {{ $advisory->advisor_phone ?? '—' }}</p>
    <p><span class="font-medium text-gray-700">Organization:</span> {{ $advisory->organization ?? '—' }}</p>
  </div>

  {{-- Description --}}
  @if($advisory->description)
  <div class="border-t pt-6 mt-6">
    <h4 class="text-lg font-semibold text-gray-800 mb-3">Description</h4>
    <p class="text-gray-600 whitespace-pre-line">{{ $advisory->description }}</p>
  </div>
  @endif

  {{-- Footer --}}
  <div class="pt-8 mt-6 flex justify-end space-x-3 border-t">
    <a href="{{ route('admin.advisories.edit', $advisory->id) }}" class="px-4 py-2 rounded bg-blue-100 hover:bg-blue-200 text-blue-700">Edit</a>
    <form action="{{ route('admin.advisories.destroy', $advisory->id) }}" method="POST" onsubmit="return confirm('Delete this advisory?')" class="inline">
      @csrf @method('DELETE')
      <button type="submit" class="px-4 py-2 rounded bg-red-100 hover:bg-red-200 text-red-700">Delete</button>
    </form>
  </div>

</div>
@endsection
