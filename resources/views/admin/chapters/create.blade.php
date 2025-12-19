@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Create Chapter</h2>
    @if ($errors->any())
    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">
        <h4 class="text-red-700 font-semibold mb-2">
            ❌ Please fix the following errors:
        </h4>
        <ul class="list-disc list-inside text-red-600 text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form action="{{ route('admin.chapters.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        {{-- Name & City --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-medium">Name</label>
                <input name="name" required
                       class="w-full border border-gray-300 rounded-xl px-3 py-2
                              focus:ring-2 focus:ring-red-400 outline-none">
            </div>

            <div>
                <label class="block text-gray-700 font-medium">City</label>
                <input name="city"
                       class="w-full border border-gray-300 rounded-xl px-3 py-2
                              focus:ring-2 focus:ring-red-400 outline-none">
            </div>
        </div>

        {{-- State & Country --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-medium">State</label>
                <input name="state" placeholder="e.g. Haryana"
                       class="w-full border border-gray-300 rounded-xl px-3 py-2
                              focus:ring-2 focus:ring-red-400 outline-none">
            </div>

            <div>
                <label class="block text-gray-700 font-medium">Country</label>
                <input name="country" value="India"
                       class="w-full border border-gray-300 rounded-xl px-3 py-2
                              focus:ring-2 focus:ring-red-400 outline-none">
            </div>
        </div>

        {{-- Pincode & Capacity --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-medium">Pincode</label>
                <input name="pincode"
                       class="w-full border border-gray-300 rounded-xl px-3 py-2
                              focus:ring-2 focus:ring-red-400 outline-none">
            </div>

            <div>
                <label class="block text-gray-700 font-medium">Capacity</label>
                <input name="capacity_no" type="number" min="0" value="0"
                       class="w-full border border-gray-300 rounded-xl px-3 py-2
                              focus:ring-2 focus:ring-red-400 outline-none">
            </div>
        </div>

        {{-- Logo --}}
        <div>
            <label class="block text-gray-700 font-medium">Logo</label>
            <input type="file" name="logo" accept="image/*"
                   class="w-full border border-gray-300 rounded-xl px-3 py-2
                          focus:ring-2 focus:ring-red-400 outline-none">
        </div>

        {{-- Description --}}
        <div>
            <label class="block text-gray-700 font-medium">Description</label>
            <textarea name="description" rows="3"
                      class="w-full border border-gray-300 rounded-xl px-3 py-2
                             focus:ring-2 focus:ring-red-400 outline-none"></textarea>
        </div>

        {{-- Active --}}
        <label class="inline-flex items-center">
            <input type="checkbox" name="is_active" checked class="h-4 w-4 text-[#CF2031]">
            <span class="ml-2 text-gray-700">Active Chapter</span>
        </label>

        {{-- Actions --}}
        <div class="pt-4 flex justify-end gap-3">
            <a href="{{ route('admin.chapters.index') }}"
               class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200 text-gray-700">
                Cancel
            </a>
            <button type="submit"
                    class="px-4 py-2 rounded bg-[#CF2031] hover:bg-[#b81b2a] text-white">
                Create
            </button>
        </div>
    </form>
</div>
@endsection
