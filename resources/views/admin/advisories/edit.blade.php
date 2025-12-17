@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">
  <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Advisory</h2>

  <form action="{{ route('admin.advisories.update', $advisory->id) }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-5">

    @csrf
    @method('PUT')

    {{-- Title --}}
    <div>
      <label class="block text-gray-700 font-medium">
        Title <span class="text-red-500">*</span>
      </label>
      <input
        name="title"
        value="{{ old('title', $advisory->title ?? '') }}"
        class="w-full border rounded px-3 py-2"
        required>
    </div>

    {{-- Advisor Name --}}
    <div>
      <label class="block text-gray-700 font-medium">Advisor Name</label>
      <input
        name="advisor_name"
        value="{{ old('advisor_name', $advisory->advisor_name ?? '') }}"
        class="w-full border rounded px-3 py-2">
    </div>

    {{-- Category & Type --}}
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-gray-700 font-medium">Category</label>
        <input
          name="category"
          value="{{ old('category', $advisory->category ?? '') }}"
          class="w-full border rounded px-3 py-2">
      </div>

      <div>
        <label class="block text-gray-700 font-medium">Type</label>
        <input
          name="type"
          value="{{ old('type', $advisory->type ?? '') }}"
          class="w-full border rounded px-3 py-2">
      </div>
    </div>

    {{-- Session Date & Mode --}}
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-gray-700 font-medium">Session Date</label>
        <input
          type="date"
          name="session_date"
          value="{{ old('session_date', $advisory->session_date ?? '') }}"
          class="w-full border rounded px-3 py-2">
      </div>

      <div>
        <label class="block text-gray-700 font-medium">Mode</label>
        <select name="mode" class="w-full border rounded px-3 py-2">
          @foreach(['online','offline','hybrid'] as $mode)
            <option value="{{ $mode }}"
              @selected(old('mode', $advisory->mode ?? 'online') === $mode)>
              {{ ucfirst($mode) }}
            </option>
          @endforeach
        </select>
      </div>
    </div>

    {{-- Venue --}}
    <div>
      <label class="block text-gray-700 font-medium">Venue</label>
      <input
        name="venue"
        value="{{ old('venue', $advisory->venue ?? '') }}"
        class="w-full border rounded px-3 py-2">
    </div>

    {{-- Banner --}}
    <div>
      <label class="block text-gray-700 font-medium">Banner</label>

      @if($advisory->banner)
        <div class="mb-2">
          <img src="{{ asset('storage/'.$advisory->banner) }}"
               class="h-24 rounded border">
        </div>
      @endif

      <input type="file" name="banner" class="w-full border rounded px-3 py-2">
    </div>

    {{-- Thumbnail --}}
    <div>
      <label class="block text-gray-700 font-medium">Thumbnail</label>

      @if($advisory->thumbnail)
        <div class="mb-2">
          <img src="{{ asset('storage/'.$advisory->thumbnail) }}"
               class="h-20 rounded border">
        </div>
      @endif

      <input type="file" name="thumbnail" class="w-full border rounded px-3 py-2">
    </div>

    {{-- Status --}}
    <div>
      <label class="block text-gray-700 font-medium">Status</label>
      <select name="status" class="w-full border rounded px-3 py-2">
        @foreach(['scheduled','ongoing','completed','cancelled'] as $status)
          <option value="{{ $status }}"
            @selected(old('status', $advisory->status) === $status)>
            {{ ucfirst($status) }}
          </option>
        @endforeach
      </select>
    </div>

    {{-- Actions --}}
    <div class="pt-4 flex justify-end space-x-3">
      <a href="{{ route('admin.advisories.index') }}"
         class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200 text-gray-700">
        Cancel
      </a>

      <button type="submit"
              class="px-4 py-2 rounded bg-[#CF2031] hover:bg-[#b81b2a] text-white">
        Update
      </button>
    </div>
  </form>
</div>
@endsection
