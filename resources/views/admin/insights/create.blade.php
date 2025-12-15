@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Create Insight</h2>

    @if($errors->any())
        <div class="bg-red-50 text-red-600 p-4 rounded mb-4">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.insights.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <div>
            <label class="block text-gray-700 font-medium">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Short Description</label>
            <textarea name="short_description" rows="2" class="w-full border rounded px-3 py-2">{{ old('short_description') }}</textarea>
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Description</label>
            <textarea name="description" rows="6" class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Category</label>
            <input type="text" name="category" value="{{ old('category') }}" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Author Name</label>
            <input type="text" name="author_name" value="{{ old('author_name') }}" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Publish Date</label>
            <input type="date" name="publish_date" value="{{ old('publish_date') }}" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Status</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
            </select>
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Image</label>
            <input type="file" name="image" accept="image/*" class="w-full border rounded px-3 py-2">
        </div>

        <label class="inline-flex items-center">
            <input type="checkbox" name="is_active" checked class="h-4 w-4 text-[#CF2031]">
            <span class="ml-2 text-gray-700">Active Insight</span>
        </label>

        <div class="pt-4 flex justify-end space-x-3">
            <a href="{{ route('admin.insights.index') }}" class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200 text-gray-700">Cancel</a>
            <button type="submit" class="px-4 py-2 rounded bg-[#CF2031] hover:bg-[#b81b2a] text-white">Create</button>
        </div>
    </form>
</div>
@endsection
