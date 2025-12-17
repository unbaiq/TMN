@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-10 bg-white shadow-xl rounded-2xl p-8 space-y-8">

<<<<<<< Updated upstream
  <form action="{{ route('admin.advisories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
    @csrf

    <div>
      <label class="block text-gray-700 font-medium">Title <span class="text-red-500">*</span></label>
      <input name="title" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2" required>
    </div>

    <div>
      <label class="block text-gray-700 font-medium">Advisor Name</label>
      <input name="advisor_name" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-gray-700 font-medium">Category</label>
        <input name="category" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
      </div>
      <div>
        <label class="block text-gray-700 font-medium">Type</label>
        <input name="type" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
      </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-gray-700 font-medium">Session Date</label>
        <input type="date" name="session_date" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
      </div>
      <div>
        <label class="block text-gray-700 font-medium">Mode</label>
        <select name="mode" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
          <option value="online">Online</option>
          <option value="offline">Offline</option>
          <option value="hybrid">Hybrid</option>
        </select>
      </div>
    </div>

    <div>
      <label class="block text-gray-700 font-medium">Venue</label>
      <input name="venue" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
    </div>

    <div>
      <label class="block text-gray-700 font-medium">Banner</label>
      <input type="file" name="banner" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
    </div>

    <div>
      <label class="block text-gray-700 font-medium">Thumbnail</label>
      <input type="file" name="thumbnail" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
    </div>

    <div>
      <label class="block text-gray-700 font-medium">Status</label>
      <select name="status" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
        <option value="scheduled">Scheduled</option>
        <option value="ongoing">Ongoing</option>
        <option value="completed">Completed</option>
        <option value="cancelled">Cancelled</option>
      </select>
    </div>
=======
    {{-- HEADER --}}
    <div class="flex items-center justify-between border-b pb-4">
        <h2 class="text-2xl font-bold text-gray-800">Add New Advisory</h2>
        <a href="{{ route('admin.advisories.index') }}"
           class="text-sm text-gray-600 hover:text-red-600">← Back to list</a>
    </div>

    {{-- ERROR MESSAGE --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4">
            <ul class="list-disc pl-5 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.advisories.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-6">
        @csrf

        {{-- BASIC DETAILS --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Title <span class="text-red-500">*</span>
            </label>
            <input name="title"
                   value="{{ old('title') }}"
                   required
                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Advisor Name</label>
            <input name="advisor_name"
                   value="{{ old('advisor_name') }}"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
        </div>

        {{-- CATEGORY & TYPE --}}
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
                <input name="category"
                       value="{{ old('category') }}"
                       placeholder="Business, Finance, Legal"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Type</label>
                <input name="type"
                       value="{{ old('type') }}"
                       placeholder="Webinar, One-on-One"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
            </div>
        </div>

        {{-- SESSION DETAILS --}}
        <div class="grid md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Session Date</label>
                <input type="date"
                       name="session_date"
                       value="{{ old('session_date') }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
            </div>
>>>>>>> Stashed changes

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Mode</label>
                <select name="mode"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
                    <option value="online" @selected(old('mode')==='online')>Online</option>
                    <option value="offline" @selected(old('mode')==='offline')>Offline</option>
                    <option value="hybrid" @selected(old('mode')==='hybrid')>Hybrid</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Venue</label>
                <input name="venue"
                       value="{{ old('venue') }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
            </div>
        </div>

        {{-- ADVISOR EXPERIENCE --}}
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Advisor Experience (Years)
                </label>
                <input type="number"
                       name="advisor_experience_years"
                       min="0"
                       max="60"
                       value="{{ old('advisor_experience_years') }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Experience Summary
                </label>
                <input name="advisor_experience_summary"
                       value="{{ old('advisor_experience_summary') }}"
                       placeholder="15+ years in Strategy & Finance"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
            </div>
        </div>

        {{-- MEDIA --}}
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Banner</label>
                <input type="file"
                       name="banner"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Thumbnail</label>
                <input type="file"
                       name="thumbnail"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
            </div>
        </div>

        {{-- STATUS --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
            <select name="status"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
                <option value="draft" @selected(old('status')==='draft')>Draft</option>
                <option value="scheduled" @selected(old('status','scheduled')==='scheduled')>Scheduled</option>
                <option value="ongoing" @selected(old('status')==='ongoing')>Ongoing</option>
                <option value="completed" @selected(old('status')==='completed')>Completed</option>
                <option value="cancelled" @selected(old('status')==='cancelled')>Cancelled</option>
            </select>
        </div>

        {{-- ACTIONS --}}
        <div class="pt-6 flex justify-end gap-3 border-t">
            <a href="{{ route('admin.advisories.index') }}"
               class="px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium">
                Cancel
            </a>
            <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-[#CF2031] hover:bg-[#b81b2a] text-white text-sm font-semibold shadow">
                Create Advisory
            </button>
        </div>

    </form>
</div>
@endsection
