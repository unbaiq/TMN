@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">

    <h2 class="text-2xl font-semibold text-gray-800 mb-6">
        Edit Chapter
    </h2>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4 text-sm text-red-700">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.chapters.update', $chapter->id) }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-5">

        @csrf
        @method('PUT')

        {{-- Name --}}
        <div>
            <label class="block text-gray-700 font-medium">Name</label>
            <input
                name="name"
                value="{{ old('name', $chapter->name) }}"
                required
                class="w-full border border-gray-300 rounded-xl px-3 py-2
                       focus:ring-2 focus:ring-red-400 outline-none">
        </div>

        {{-- City / State / Country --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-gray-700 font-medium">City</label>
                <input
                    name="city"
                    value="{{ old('city', $chapter->city) }}"
                    class="w-full border border-gray-300 rounded-xl px-3 py-2
                           focus:ring-2 focus:ring-red-400 outline-none">
            </div>

            <div>
                <label class="block text-gray-700 font-medium">State</label>
                <input
                    name="state"
                    value="{{ old('state', $chapter->state) }}"
                    class="w-full border border-gray-300 rounded-xl px-3 py-2
                           focus:ring-2 focus:ring-red-400 outline-none">
            </div>

            <div>
                <label class="block text-gray-700 font-medium">Country</label>
                <input
                    name="country"
                    value="{{ old('country', $chapter->country ?? 'India') }}"
                    class="w-full border border-gray-300 rounded-xl px-3 py-2
                           focus:ring-2 focus:ring-red-400 outline-none">
            </div>
        </div>

        {{-- Pincode --}}
        <div>
            <label class="block text-gray-700 font-medium">Pincode</label>
            <input
                name="pincode"
                value="{{ old('pincode', $chapter->pincode) }}"
                class="w-full border border-gray-300 rounded-xl px-3 py-2
                       focus:ring-2 focus:ring-red-400 outline-none">
        </div>

        {{-- Capacity --}}
        <div>
            <label class="block text-gray-700 font-medium">Capacity</label>
            <input
                name="capacity_no"
                type="number"
                min="0"
                value="{{ old('capacity_no', $chapter->capacity_no) }}"
                class="w-full border border-gray-300 rounded-xl px-3 py-2
                       focus:ring-2 focus:ring-red-400 outline-none">
        </div>

        {{-- Logo --}}
        <div>
            <label class="block text-gray-700 font-medium">Logo</label>

            @if ($chapter->logo)
                <img src="{{ asset('storage/'.$chapter->logo) }}"
                     alt="Chapter Logo"
                     class="h-16 w-auto mb-2 rounded shadow">
            @endif

            <input
                type="file"
                name="logo"
                accept="image/*"
                class="w-full border border-gray-300 rounded-xl px-3 py-2
                       focus:ring-2 focus:ring-red-400 outline-none">
        </div>

        {{-- Description --}}
        <div>
            <label class="block text-gray-700 font-medium">Description</label>
            <textarea
                name="description"
                rows="3"
                class="w-full border border-gray-300 rounded-xl px-3 py-2
                       focus:ring-2 focus:ring-red-400 outline-none">{{ old('description', $chapter->description) }}</textarea>
        </div>

        {{-- Active --}}
        <label class="inline-flex items-center gap-2">
            <input
                type="checkbox"
                name="is_active"
                value="1"
                {{ old('is_active', $chapter->is_active) ? 'checked' : '' }}
                class="h-4 w-4 text-[#CF2031] rounded">
            <span class="text-gray-700">Active Chapter</span>
        </label>

        {{-- Actions --}}
        <div class="pt-4 flex justify-end gap-3">
            <a href="{{ route('admin.chapters.index') }}"
               class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200 text-gray-700">
                Cancel
            </a>

            <button type="submit"
                class="px-4 py-2 rounded bg-[#CF2031] hover:bg-[#b81b2a] text-white">
                Update Chapter
            </button>
        </div>

    </form>
</div>
@endsection
