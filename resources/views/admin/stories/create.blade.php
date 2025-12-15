@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Add New Story</h2>

    <form action="{{ route('admin.stories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        <div>
            <label class="block text-gray-700 font-medium">Title <span class="text-red-500">*</span></label>
            <input name="title" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Short Description</label>
            <textarea name="short_description" rows="2" class="w-full border rounded px-3 py-2"></textarea>
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Description</label>
            <textarea name="description" rows="6" class="w-full border rounded px-3 py-2"></textarea>
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Category</label>
            <input name="category" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Industry</label>
            <input name="industry" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Status</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="draft">Draft</option>
                <option value="review">Review</option>
                <option value="published">Published</option>
                <option value="archived">Archived</option>
            </select>
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Image</label>
            <input type="file" name="image" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Banner</label>
            <input type="file" name="banner" class="w-full border rounded px-3 py-2">
        </div>

        <div class="pt-4 flex justify-end space-x-3">
            <a href="{{ route('admin.stories.index') }}" class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200 text-gray-700">Cancel</a>
            <button type="submit" class="px-4 py-2 rounded bg-[#CF2031] hover:bg-[#b81b2a] text-white">Create</button>
        </div>
    </form>
</div>
@endsection
