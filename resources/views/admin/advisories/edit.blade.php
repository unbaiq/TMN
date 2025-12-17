@extends('layouts.app')

@section('content')
<<<<<<< Updated upstream
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
        class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2"
        required>
    </div>

    {{-- Advisor Name --}}
    <div>
      <label class="block text-gray-700 font-medium">Advisor Name</label>
      <input
        name="advisor_name"
        value="{{ old('advisor_name', $advisory->advisor_name ?? '') }}"
        class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
    </div>

    {{-- Category & Type --}}
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-gray-700 font-medium">Category</label>
        <input
          name="category"
          value="{{ old('category', $advisory->category ?? '') }}"
          class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
      </div>

      <div>
        <label class="block text-gray-700 font-medium">Type</label>
        <input
          name="type"
          value="{{ old('type', $advisory->type ?? '') }}"
          class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
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
          class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
      </div>

      <div>
        <label class="block text-gray-700 font-medium">Mode</label>
        <select name="mode" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
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
        class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
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

      <input type="file" name="banner" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
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

      <input type="file" name="thumbnail" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
    </div>

    {{-- Status --}}
    <div>
      <label class="block text-gray-700 font-medium">Status</label>
      <select name="status" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
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
=======
<div class="max-w-5xl mx-auto mt-10 bg-white shadow-xl rounded-2xl p-8 space-y-8">

    {{-- HEADER --}}
    <div class="flex items-center justify-between border-b pb-4">
        <h2 class="text-2xl font-bold text-gray-800">Edit Advisory</h2>
        <a href="{{ route('admin.advisories.index') }}"
           class="text-sm text-gray-600 hover:text-red-600">← Back to list</a>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4">
            <ul class="list-disc pl-5 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.advisories.update', $advisory) }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-6">
        @csrf
        @method('PUT')

        {{-- TITLE --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Title <span class="text-red-500">*</span>
            </label>
            <input name="title"
                   value="{{ old('title', $advisory->title) }}"
                   required
                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
        </div>

        {{-- ADVISOR --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Advisor Name</label>
            <input name="advisor_name"
                   value="{{ old('advisor_name', $advisory->advisor_name) }}"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
        </div>

        {{-- CATEGORY & TYPE --}}
        <div class="grid md:grid-cols-2 gap-6">
            <input name="category"
                   value="{{ old('category', $advisory->category) }}"
                   placeholder="Category"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5">

            <input name="type"
                   value="{{ old('type', $advisory->type) }}"
                   placeholder="Type"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
        </div>

        {{-- DATE / MODE / VENUE --}}
        <div class="grid md:grid-cols-3 gap-6">
            <input type="date"
                   name="session_date"
                   value="{{ old('session_date', optional($advisory->session_date)->format('Y-m-d')) }}"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5">

            <select name="mode"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
                <option value="online" @selected($advisory->mode==='online')>Online</option>
                <option value="offline" @selected($advisory->mode==='offline')>Offline</option>
                <option value="hybrid" @selected($advisory->mode==='hybrid')>Hybrid</option>
            </select>

            <input name="venue"
                   value="{{ old('venue', $advisory->venue) }}"
                   placeholder="Venue"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
        </div>

        {{-- EXPERIENCE --}}
        <div class="grid md:grid-cols-2 gap-6">
            <input type="number"
                   name="advisor_experience_years"
                   value="{{ old('advisor_experience_years', $advisory->advisor_experience_years) }}"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5">

            <input name="advisor_experience_summary"
                   value="{{ old('advisor_experience_summary', $advisory->advisor_experience_summary) }}"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
        </div>

        {{-- STATUS --}}
        <select name="status"
                class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
            @foreach(['draft','scheduled','ongoing','completed','cancelled'] as $status)
                <option value="{{ $status }}" @selected($advisory->status === $status)>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>

        {{-- ACTIONS --}}
        <div class="pt-6 flex justify-end gap-3 border-t">
            <a href="{{ route('admin.advisories.index') }}"
               class="px-5 py-2.5 rounded-xl bg-gray-100 text-gray-700">
                Cancel
            </a>
            <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-[#CF2031] text-white font-semibold">
                Update Advisory
            </button>
        </div>

    </form>
>>>>>>> Stashed changes
</div>
@endsection
