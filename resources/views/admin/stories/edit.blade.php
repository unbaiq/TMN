@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Story</h2>

    @if($errors->any())
        <div class="bg-red-50 text-red-600 p-4 rounded mb-4">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.stories.update', $story->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-gray-700 font-medium">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $story->title) }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Short Description</label>
            <textarea name="short_description" rows="2" class="w-full border rounded px-3 py-2">{{ old('short_description', $story->short_description) }}</textarea>
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Description</label>
            <textarea name="description" rows="6" class="w-full border rounded px-3 py-2">{{ old('description', $story->description) }}</textarea>
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Category</label>
            <input type="text" name="category" value="{{ old('category', $story->category) }}" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Industry</label>
            <input type="text" name="industry" value="{{ old('industry', $story->industry) }}" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Tags</label>
            <input type="text" name="tags" value="{{ old('tags', $story->tags) }}" class="w-full border rounded px-3 py-2" placeholder="e.g. leadership, success, growth">
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Video URL</label>
            <input type="text" name="video_url" value="{{ old('video_url', $story->video_url) }}" class="w-full border rounded px-3 py-2" placeholder="https://youtube.com/...">
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Publish Date</label>
            <input type="date" name="publish_date" value="{{ old('publish_date', $story->publish_date) }}" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Status</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="draft" {{ $story->status == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="review" {{ $story->status == 'review' ? 'selected' : '' }}>Review</option>
                <option value="published" {{ $story->status == 'published' ? 'selected' : '' }}>Published</option>
                <option value="archived" {{ $story->status == 'archived' ? 'selected' : '' }}>Archived</option>
            </select>
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Image</label>
            @if($story->image)
                <div class="mb-3">
                    <img src="{{ asset('storage/'.$story->image) }}" alt="Story Image" class="w-32 h-32 object-cover rounded-lg border">
                </div>
            @endif
            <input type="file" name="image" accept="image/*" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Banner</label>
            @if($story->banner)
                <div class="mb-3">
                    <img src="{{ asset('storage/'.$story->banner) }}" alt="Story Banner" class="w-full h-40 object-cover rounded-lg border">
                </div>
            @endif
            <input type="file" name="banner" accept="image/*" class="w-full border rounded px-3 py-2">
        </div>

        <div class="flex items-center">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_featured" {{ $story->is_featured ? 'checked' : '' }} class="h-4 w-4 text-[#CF2031]">
                <span class="ml-2 text-gray-700">Featured Story</span>
            </label>
            <label class="inline-flex items-center ml-6">
                <input type="checkbox" name="is_active" {{ $story->is_active ? 'checked' : '' }} class="h-4 w-4 text-[#CF2031]">
                <span class="ml-2 text-gray-700">Active</span>
            </label>
        </div>

        <div class="pt-4 flex justify-end space-x-3">
            <a href="{{ route('admin.stories.index') }}" class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200 text-gray-700">Cancel</a>
            <button type="submit" class="px-4 py-2 rounded bg-[#CF2031] hover:bg-[#b81b2a] text-white">Update</button>
        </div>
    </form>
</div>
@endsection
