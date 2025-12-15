@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">

  {{-- Header --}}
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold text-gray-800">Sponsor Details</h2>
    <a href="{{ route('admin.sponsors.index') }}" class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">
      ← Back to List
    </a>
  </div>

  {{-- Logo --}}
  @if($sponsor->logo)
    <div class="flex justify-center mb-6">
      <img src="{{ asset('storage/'.$sponsor->logo) }}" alt="Sponsor Logo" class="h-28 object-contain rounded-lg border">
    </div>
  @endif

  {{-- Basic Details --}}
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
      <h4 class="font-semibold text-gray-800 mb-1">Name</h4>
      <p class="text-gray-600">{{ $sponsor->name }}</p>
    </div>

    <div>
      <h4 class="font-semibold text-gray-800 mb-1">Company</h4>
      <p class="text-gray-600">{{ $sponsor->company_name ?? '—' }}</p>
    </div>

    <div>
      <h4 class="font-semibold text-gray-800 mb-1">Type</h4>
      <p class="text-gray-600 capitalize">{{ $sponsor->sponsor_type }}</p>
    </div>

    <div>
      <h4 class="font-semibold text-gray-800 mb-1">Level</h4>
      <p class="text-gray-600 capitalize">{{ $sponsor->sponsorship_level }}</p>
    </div>
  </div>

  {{-- Banner --}}
  @if($sponsor->banner)
    <div class="mt-8">
      <h4 class="font-semibold text-gray-800 mb-2">Banner</h4>
      <img src="{{ asset('storage/'.$sponsor->banner) }}" alt="Banner" class="w-full h-64 object-cover rounded-lg">
    </div>
  @endif

  {{-- About --}}
  @if($sponsor->about)
    <div class="mt-8">
      <h4 class="font-semibold text-gray-800 mb-2">About Sponsor</h4>
      <p class="text-gray-600 whitespace-pre-line">{{ $sponsor->about }}</p>
    </div>
  @endif

  {{-- Status --}}
  <div class="mt-8">
    <h4 class="font-semibold text-gray-800 mb-2">Status</h4>
    <span class="px-3 py-1 rounded-full text-xs font-semibold
      @switch($sponsor->status)
        @case('approved') bg-green-100 text-green-700 @break
        @case('pending') bg-yellow-100 text-yellow-700 @break
        @case('rejected') bg-red-100 text-red-700 @break
        @case('expired') bg-gray-100 text-gray-700 @break
        @default bg-gray-100 text-gray-700
      @endswitch">
      {{ ucfirst($sponsor->status) }}
    </span>
  </div>

  {{-- Footer --}}
  <div class="pt-8 mt-6 flex justify-end space-x-3 border-t">
    <a href="{{ route('admin.sponsors.edit', $sponsor->id) }}" class="px-4 py-2 rounded bg-blue-100 hover:bg-blue-200 text-blue-700">Edit</a>
    <form action="{{ route('admin.sponsors.destroy', $sponsor->id) }}" method="POST" onsubmit="return confirm('Delete this sponsor?')" class="inline">
      @csrf @method('DELETE')
      <button type="submit" class="px-4 py-2 rounded bg-red-100 hover:bg-red-200 text-red-700">Delete</button>
    </form>
  </div>

</div>
@endsection
