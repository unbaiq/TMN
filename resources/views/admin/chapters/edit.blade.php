@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Chapter</h2>

    <form action="{{ route('admin.chapters.update', $chapter->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf @method('PUT')

        <div>
            <label class="block text-gray-700 font-medium">Name</label>
            <input name="name" value="{{ old('name', $chapter->name) }}" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2" required>
        </div>

        <div>
            <label class="block text-gray-700 font-medium">City</label>
            <input name="city" value="{{ old('city', $chapter->city) }}" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Pincode</label>
            <input name="pincode" value="{{ old('pincode', $chapter->pincode) }}" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Capacity</label>
            <input name="capacity_no" type="number" min="0" value="{{ old('capacity_no', $chapter->capacity_no) }}" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Logo</label>
            @if($chapter->logo)
                <img src="{{ asset('storage/'.$chapter->logo) }}" alt="Logo" class="h-16 w-auto mb-2 rounded">
            @endif
            <input type="file" name="logo" accept="image/*" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Description</label>
            <textarea name="description" rows="3" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">{{ old('description', $chapter->description) }}</textarea>
        </div>

        <label class="inline-flex items-center">
            <input type="checkbox" name="is_active" {{ $chapter->is_active ? 'checked' : '' }} class="h-4 w-4 text-[#CF2031]">
            <span class="ml-2 text-gray-700">Active Chapter</span>
        </label>

        <div class="pt-4 flex justify-end space-x-3">
            <a href="{{ route('admin.chapters.index') }}" class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200 text-gray-700">Cancel</a>
            <button type="submit" class="px-4 py-2 rounded bg-[#CF2031] hover:bg-[#b81b2a] text-white">Update</button>
        </div>
    </form>
</div>
@endsection
