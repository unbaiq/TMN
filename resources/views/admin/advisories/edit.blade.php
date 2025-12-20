@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-10 bg-white shadow-xl rounded-2xl p-8 space-y-8">

    {{-- HEADER --}}
    <div class="flex items-center justify-between border-b pb-4">
        <h2 class="text-2xl font-bold text-gray-800">Edit Advisory</h2>
        <a href="{{ route('admin.advisories.index') }}"
           class="text-sm text-gray-600 hover:text-red-600">
            ← Back to list
        </a>
    </div>

    {{-- VALIDATION ERRORS --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4">
            <ul class="list-disc pl-5 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM --}}
    <form action="{{ route('admin.advisories.update', $advisory->id) }}"
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
                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-400 outline-none">
        </div>

        {{-- ADVISOR NAME --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Advisor Name</label>
            <input name="advisor_name"
                   value="{{ old('advisor_name', $advisory->advisor_name) }}"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
        </div>

        {{-- CATEGORY & TYPE --}}
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
                <input name="category"
                       value="{{ old('category', $advisory->category) }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Type</label>
                <input name="type"
                       value="{{ old('type', $advisory->type) }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
            </div>
        </div>

        {{-- DATE / MODE / VENUE --}}
        <div class="grid md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Session Date</label>
                <input type="date"
                       name="session_date"
                       value="{{ old('session_date', optional($advisory->session_date)->format('Y-m-d')) }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Mode</label>
                <select name="mode"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
                    @foreach(['online','offline','hybrid'] as $mode)
                        <option value="{{ $mode }}"
                            @selected(old('mode', $advisory->mode) === $mode)>
                            {{ ucfirst($mode) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Venue</label>
                <input name="venue"
                       value="{{ old('venue', $advisory->venue) }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
            </div>
        </div>

        {{-- BANNER --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Banner</label>
            @if($advisory->banner)
                <img src="{{ asset('storage/'.$advisory->banner) }}"
                     class="h-24 rounded border mb-2">
            @endif
            <input type="file"
                   name="banner"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
        </div>

        {{-- THUMBNAIL --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Thumbnail</label>
            @if($advisory->thumbnail)
                <img src="{{ asset('storage/'.$advisory->thumbnail) }}"
                     class="h-20 rounded border mb-2">
            @endif
            <input type="file"
                   name="thumbnail"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
        </div>

        {{-- STATUS --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
            <select name="status"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
                @foreach(['draft','scheduled','ongoing','completed','cancelled'] as $status)
                    <option value="{{ $status }}"
                        @selected(old('status', $advisory->status) === $status)>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- ACTIONS --}}
        <div class="pt-6 flex justify-end gap-3 border-t">
            <a href="{{ route('admin.advisories.index') }}"
               class="px-5 py-2.5 rounded-xl bg-gray-100 text-gray-700 hover:bg-gray-200">
                Cancel
            </a>
            <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-[#CF2031] text-white font-semibold hover:bg-[#b81b2a]">
                Update Advisory
            </button>
        </div>

    </form>
</div>
@endsection
