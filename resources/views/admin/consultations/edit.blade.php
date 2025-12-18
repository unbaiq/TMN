@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-10 bg-white shadow-xl rounded-2xl p-8 space-y-8">

    {{-- HEADER --}}
    <div class="flex items-center justify-between border-b pb-4">
        <h2 class="text-2xl font-bold text-gray-800">Edit Feed Section</h2>
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

    <form action="{{ route('admin.consultations.update', $consultation) }}"
          method="POST"
          class="space-y-6">
        @csrf
        @method('PUT')

        {{-- KEY --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Section Key
            </label>
            <input name="key"
                   value="{{ old('key', $consultation->key) }}"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
        </div>

        {{-- TITLE --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Title <span class="text-red-500">*</span>
            </label>
            <input name="title"
                   value="{{ old('title', $consultation->title) }}"
                   required
                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
        </div>

        {{-- SUBTITLE --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Subtitle
            </label>
            <input name="subtitle"
                   value="{{ old('subtitle', $consultation->subtitle) }}"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
        </div>

        {{-- CONTENT --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Content
            </label>
            <textarea name="content"
                      rows="5"
                      class="w-full border border-gray-300 rounded-xl px-4 py-3">{{ old('content', $consultation->content) }}</textarea>
        </div>

        {{-- CTA --}}
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">CTA Text</label>
                <input name="cta_text"
                       value="{{ old('cta_text', $consultation->cta_text) }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">CTA Link</label>
                <input name="cta_link"
                       value="{{ old('cta_link', $consultation->cta_link) }}"
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
                       value="{{ old('display_order', $consultation->display_order) }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5">
            </div>

            <div class="flex items-center gap-3 mt-7">
                <input type="checkbox"
                       name="is_featured"
                       value="1"
                       class="rounded border-gray-300"
                       @checked(old('is_featured', $consultation->is_featured))>
                <label class="text-sm font-medium text-gray-700">Featured</label>
            </div>

            <div class="flex items-center gap-3 mt-7">
                <input type="checkbox"
                       name="is_public"
                       value="1"
                       class="rounded border-gray-300"
                       @checked(old('is_public', $consultation->is_public))>
                <label class="text-sm font-medium text-gray-700">Public</label>
            </div>
        </div>

        {{-- ACTIVE --}}
        <div class="flex items-center gap-3">
            <input type="checkbox"
                   name="is_active"
                   value="1"
                   class="rounded border-gray-300"
                   @checked(old('is_active', $consultation->is_active))>
            <label class="text-sm font-medium text-gray-700">Active</label>
        </div>

        {{-- ACTIONS --}}
        <div class="pt-6 flex justify-end gap-3 border-t">
            <a href="{{ route('admin.consultations.index') }}"
               class="px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium">
                Cancel
            </a>
            <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-[#CF2031] hover:bg-[#b81b2a] text-white text-sm font-semibold shadow">
                Update Section
            </button>
        </div>

    </form>
</div>
@endsection
