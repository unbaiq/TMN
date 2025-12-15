@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">

  {{-- Header --}}
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold text-gray-800">Partner Details</h2>
    <a href="{{ route('admin.partners.index') }}" class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">
      ← Back to List
    </a>
  </div>

  {{-- Logo --}}
  @if($partner->logo)
    <div class="flex justify-center mb-6">
      <img src="{{ asset('storage/'.$partner->logo) }}" alt="Partner Logo" class="h-28 object-contain rounded-lg border">
    </div>
  @endif

  {{-- Partner Info --}}
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
      <h4 class="font-semibold text-gray-800 mb-1">Name</h4>
      <p class="text-gray-600">{{ $partner->name }}</p>
    </div>

    <div>
      <h4 class="font-semibold text-gray-800 mb-1">Company</h4>
      <p class="text-gray-600">{{ $partner->company_name ?? '—' }}</p>
    </div>

    <div>
      <h4 class="font-semibold text-gray-800 mb-1">Type</h4>
      <p class="text-gray-600 capitalize">{{ $partner->partner_type }}</p>
    </div>

    <div>
      <h4 class="font-semibold text-gray-800 mb-1">Level</h4>
      <p class="text-gray-600 capitalize">{{ $partner->level }}</p>
    </div>

    <div>
      <h4 class="font-semibold text-gray-800 mb-1">Email</h4>
      <p class="text-gray-600">{{ $partner->email ?? '—' }}</p>
    </div>

    <div>
      <h4 class="font-semibold text-gray-800 mb-1">Phone</h4>
      <p class="text-gray-600">{{ $partner->phone ?? '—' }}</p>
    </div>
  </div>

  {{-- Banner --}}
  @if($partner->banner)
    <div class="mt-8">
      <h4 class="font-semibold text-gray-800 mb-2">Banner</h4>
      <img src="{{ asset('storage/'.$partner->banner) }}" alt="Banner" class="w-full h-64 object-cover rounded-lg">
    </div>
  @endif

  {{-- About --}}
  @if($partner->about)
    <div class="mt-8">
      <h4 class="font-semibold text-gray-800 mb-2">About Partner</h4>
      <p class="text-gray-600 whitespace-pre-line">{{ $partner->about }}</p>
    </div>
  @endif

  {{-- Status --}}
  <div class="mt-8">
    <h4 class="font-semibold text-gray-800 mb-2">Status</h4>
    <span class="px-3 py-1 rounded-full text-xs font-semibold
      @switch($partner->status)
        @case('approved') bg-green-100 text-green-700 @break
        @case('pending') bg-yellow-100 text-yellow-700 @break
        @case('rejected') bg-red-100 text-red-700 @break
        @case('expired') bg-gray-100 text-gray-700 @break
        @default bg-gray-100 text-gray-700
      @endswitch">
      {{ ucfirst($partner->status) }}
    </span>
  </div>

  {{-- Footer --}}
  <div class="pt-8 mt-6 flex justify-end space-x-3 border-t">
    <a href="{{ route('admin.partners.edit', $partner->id) }}" class="px-4 py-2 rounded bg-blue-100 hover:bg-blue-200 text-blue-700">Edit</a>
    <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" onsubmit="return confirm('Delete this partner?')" class="inline">
      @csrf @method('DELETE')
      <button type="submit" class="px-4 py-2 rounded bg-red-100 hover:bg-red-200 text-red-700">Delete</button>
    </form>
  </div>

</div>
@endsection
