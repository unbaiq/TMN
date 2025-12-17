@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-10 bg-white shadow-xl rounded-2xl p-8 space-y-8">

<<<<<<< Updated upstream
  <form action="{{ route('admin.consultations.store') }}" method="POST" class="space-y-5">
    @csrf

    <div>
      <label class="block text-gray-700 font-medium">Title <span class="text-red-500">*</span></label>
      <input name="title" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2" required>
    </div>

    <div>
      <label class="block text-gray-700 font-medium">Type</label>
      <input name="type" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2" placeholder="e.g. Marketing, Finance, Strategy">
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-gray-700 font-medium">Consultation Date</label>
        <input type="date" name="consultation_date" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
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
      <label class="block text-gray-700 font-medium">Meeting Link / Venue</label>
      <input name="meeting_link" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2" placeholder="Zoom link or physical address">
    </div>

    <div>
      <label class="block text-gray-700 font-medium">Consultant Name</label>
      <input name="consultant_name" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
    </div>

    <div>
      <label class="block text-gray-700 font-medium">Client Name</label>
      <input name="client_name" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
    </div>

    <div>
      <label class="block text-gray-700 font-medium">Status</label>
      <select name="status" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
        <option value="scheduled">Scheduled</option>
        <option value="completed">Completed</option>
        <option value="cancelled">Cancelled</option>
        <option value="rescheduled">Rescheduled</option>
      </select>
    </div>
=======
    {{-- HEADER --}}
    <div class="flex items-center justify-between border-b pb-4">
        <h2 class="text-2xl font-bold text-gray-800">Add Feed Section</h2>
        <a href="{{ route('admin.consultations.index') }}"
           class="text-sm text-gray-600 hover:text-red-600">← Back to Feed</a>
    </div>

    {{-- ERRORS --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4">
            <ul class="list-disc pl-5 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.consultations.store') }}"
          method="POST"
          class="space-y-6">
        @csrf

        {{-- KEY --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Section Key <span class="text-gray-400">(optional)</span>
            </label>
            <input name="key"
                   value="{{ old('key') }}"
                   placeholder="tmn_welcome, why_tmn"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
            <p class="text-xs text-gray-400 mt-1">
                Leave blank to auto-generate from title
            </p>
        </div>

        {{-- TITLE --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Title <span class="text-red-500">*</span>
            </label>
            <input name="title"
                   value="{{ old('title') }}"
                   required
                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
        </div>

        {{-- SUBTITLE --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Subtitle
            </label>
            <input name="subtitle"
                   value="{{ old('subtitle') }}"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
        </div>

        {{-- CONTENT --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Content
            </label>
            <textarea name="content"
                      rows="5"
                      class="w-full border border-gray-300 rounded-xl px-4 py-3">{{ old('content') }}</textarea>
        </div>
>>>>>>> Stashed changes

        {{-- CTA --}}
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    CTA Text
                </label>
                <input name="cta_text"
                       value="{{ old('cta_text') }}"
                       placeholder="Join TMN Today"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    CTA Link
                </label>
                <input name="cta_link"
                       value="{{ old('cta_link') }}"
                       placeholder="/join"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
            </div>
        </div>

        {{-- FEED SETTINGS --}}
        <div class="grid md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Display Order
                </label>
                <input type="number"
                       name="display_order"
                       value="{{ old('display_order', 0) }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
            </div>

            <div class="flex items-center gap-3 mt-7">
                <input type="checkbox"
                       name="is_featured"
                       value="1"
                       class="rounded border-gray-300"
                       @checked(old('is_featured'))>
                <label class="text-sm font-medium text-gray-700">
                    Featured
                </label>
            </div>

            <div class="flex items-center gap-3 mt-7">
                <input type="checkbox"
                       name="is_public"
                       value="1"
                       checked
                       class="rounded border-gray-300">
                <label class="text-sm font-medium text-gray-700">
                    Public
                </label>
            </div>
        </div>

        {{-- ACTIVE --}}
        <div class="flex items-center gap-3">
            <input type="checkbox"
                   name="is_active"
                   value="1"
                   checked
                   class="rounded border-gray-300">
            <label class="text-sm font-medium text-gray-700">
                Active
            </label>
        </div>

        {{-- ACTIONS --}}
        <div class="pt-6 flex justify-end gap-3 border-t">
            <a href="{{ route('admin.consultations.index') }}"
               class="px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium">
                Cancel
            </a>
            <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-[#CF2031] hover:bg-[#b81b2a] text-white text-sm font-semibold shadow">
                Create Section
            </button>
        </div>

    </form>
</div>
@endsection
