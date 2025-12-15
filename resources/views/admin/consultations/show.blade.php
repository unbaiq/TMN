@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">

  {{-- Header --}}
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold text-gray-800">
      Consultation Details
    </h2>
    <a href="{{ route('admin.consultations.index') }}" class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">
      ← Back to List
    </a>
  </div>

  {{-- Title & Status --}}
  <div class="mb-6 border-b pb-4">
    <h3 class="text-xl font-bold text-gray-800">{{ $consultation->title }}</h3>
    <p class="text-sm text-gray-600 mt-1">Type: {{ $consultation->type ?? 'N/A' }}</p>

    <span class="inline-block mt-3 px-3 py-1 rounded-full text-xs font-semibold
      @switch($consultation->status)
        @case('scheduled') bg-blue-100 text-blue-700 @break
        @case('completed') bg-green-100 text-green-700 @break
        @case('cancelled') bg-red-100 text-red-700 @break
        @case('rescheduled') bg-yellow-100 text-yellow-700 @break
        @default bg-gray-100 text-gray-700
      @endswitch">
      {{ ucfirst($consultation->status) }}
    </span>
  </div>

  {{-- Schedule --}}
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div>
      <h4 class="font-semibold text-gray-800 mb-1">Consultation Date</h4>
      <p class="text-gray-600">{{ $consultation->formatted_date ?? '-' }}</p>
    </div>

    <div>
      <h4 class="font-semibold text-gray-800 mb-1">Timing</h4>
      <p class="text-gray-600">{{ $consultation->session_timing ?? '-' }}</p>
    </div>

    <div>
      <h4 class="font-semibold text-gray-800 mb-1">Mode</h4>
      <p class="text-gray-600 capitalize">{{ $consultation->mode ?? '-' }}</p>
    </div>

    @if($consultation->mode === 'online' && $consultation->meeting_link)
      <div>
        <h4 class="font-semibold text-gray-800 mb-1">Meeting Link</h4>
        <a href="{{ $consultation->meeting_link_url }}" target="_blank" class="text-red-600 hover:underline">
          Join Meeting
        </a>
      </div>
    @elseif($consultation->venue)
      <div>
        <h4 class="font-semibold text-gray-800 mb-1">Venue</h4>
        <p class="text-gray-600">{{ $consultation->venue }}</p>
      </div>
    @endif
  </div>

  {{-- Consultant & Client Info --}}
  <div class="border-t pt-6 mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
      <h4 class="text-lg font-semibold text-gray-800 mb-3">Consultant Information</h4>
      <p><span class="font-medium text-gray-700">Name:</span> {{ $consultation->consultant_display }}</p>
      <p><span class="font-medium text-gray-700">Email:</span> {{ $consultation->consultant_email ?? '—' }}</p>
      <p><span class="font-medium text-gray-700">Phone:</span> {{ $consultation->consultant_phone ?? '—' }}</p>
    </div>

    <div>
      <h4 class="text-lg font-semibold text-gray-800 mb-3">Client Information</h4>
      <p><span class="font-medium text-gray-700">Name:</span> {{ $consultation->client_name ?? '—' }}</p>
      <p><span class="font-medium text-gray-700">Email:</span> {{ $consultation->client_email ?? '—' }}</p>
      <p><span class="font-medium text-gray-700">Phone:</span> {{ $consultation->client_phone ?? '—' }}</p>
      <p><span class="font-medium text-gray-700">Organization:</span> {{ $consultation->organization ?? '—' }}</p>
    </div>
  </div>

  {{-- Notes & Takeaways --}}
  @if($consultation->notes || $consultation->key_takeaways)
  <div class="border-t pt-6 mt-6">
    <h4 class="text-lg font-semibold text-gray-800 mb-3">Session Notes</h4>
    @if($consultation->notes)
      <div class="mb-4">
        <h5 class="font-medium text-gray-700 mb-1">Notes:</h5>
        <p class="text-gray-600 whitespace-pre-line">{{ $consultation->notes }}</p>
      </div>
    @endif
    @if($consultation->key_takeaways)
      <div>
        <h5 class="font-medium text-gray-700 mb-1">Key Takeaways:</h5>
        <p class="text-gray-600 whitespace-pre-line">{{ $consultation->key_takeaways }}</p>
      </div>
    @endif
  </div>
  @endif

  {{-- Feedback & Follow-up --}}
  <div class="border-t pt-6 mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
      <h4 class="font-semibold text-gray-800 mb-2">Rating</h4>
      <p class="text-yellow-500">{{ $consultation->star_rating ?: '—' }}</p>
    </div>

    <div>
      <h4 class="font-semibold text-gray-800 mb-2">Follow-Up Required</h4>
      <p class="text-gray-600">
        {{ $consultation->follow_up_required ? 'Yes' : 'No' }}
        @if($consultation->follow_up_date)
          — <span class="text-sm text-gray-500">Next: {{ $consultation->follow_up_date->format('d M Y') }}</span>
        @endif
      </p>
    </div>
  </div>

  {{-- Footer Buttons --}}
  <div class="pt-8 mt-6 flex justify-end space-x-3 border-t">
    <a href="{{ route('admin.consultations.edit', $consultation->id) }}" class="px-4 py-2 rounded bg-blue-100 hover:bg-blue-200 text-blue-700">Edit</a>
    <form action="{{ route('admin.consultations.destroy', $consultation->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this consultation?')" class="inline">
      @csrf @method('DELETE')
      <button type="submit" class="px-4 py-2 rounded bg-red-100 hover:bg-red-200 text-red-700">Delete</button>
    </form>
  </div>

</div>
@endsection
