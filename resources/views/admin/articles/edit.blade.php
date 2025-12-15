@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Article</h2>

    @if($errors->any())
        <div class="bg-red-50 text-red-600 p-4 rounded mb-4">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div>
            <label class="block text-gray-700 font-medium">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $article->title) }}" class="w-full border rounded px-3 py-2" required>
        </div>

        {{-- Short Description --}}
        <div>
            <label class="block text-gray-700 font-medium">Short Description</label>
            <textarea name="short_description" rows="2" class="w-full border rounded px-3 py-2">{{ old('short_description', $article->short_description) }}</textarea>
        </div>

        {{-- Content --}}
        <div>
            <label class="block text-gray-700 font-medium">Content</label>
            <textarea name="content" rows="6" class="w-full border rounded px-3 py-2">{{ old('content', $article->content) }}</textarea>
        </div>

        {{-- Category --}}
        <div>
            <label class="block text-gray-700 font-medium">Category</label>
            <input type="text" name="category" value="{{ old('category', $article->category) }}" class="w-full border rounded px-3 py-2">
        </div>

        {{-- Tags --}}
        <div>
            <label class="block text-gray-700 font-medium">Tags</label>
            <input type="text" name="tags" value="{{ old('tags', $article->tags) }}" class="w-full border rounded px-3 py-2" placeholder="e.g. leadership, growth, marketing">
        </div>

        {{-- Video URL --}}
        <div>
            <label class="block text-gray-700 font-medium">Video URL</label>
            <input type="text" name="video_url" value="{{ old('video_url', $article->video_url) }}" class="w-full border rounded px-3 py-2" placeholder="https://youtube.com/...">
        </div>

        {{-- Publish Date --}}
        <div>
            <label class="block text-gray-700 font-medium">Publish Date</label>
            <input type="date" name="publish_date" value="{{ old('publish_date', $article->publish_date) }}" class="w-full border rounded px-3 py-2">
        </div>

        {{-- Status --}}
        <div>
            <label class="block text-gray-700 font-medium">Status</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="draft" {{ $article->status == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="review" {{ $article->status == 'review' ? 'selected' : '' }}>Review</option>
                <option value="published" {{ $article->status == 'published' ? 'selected' : '' }}>Published</option>
                <option value="archived" {{ $article->status == 'archived' ? 'selected' : '' }}>Archived</option>
            </select>
        </div>

        {{-- Thumbnail --}}
        <div>
            <label class="block text-gray-700 font-medium">Thumbnail</label>
            @if($article->thumbnail)
                <div class="mb-3">
                    <img src="{{ asset('storage/'.$article->thumbnail) }}" alt="Thumbnail" class="w-32 h-32 object-cover rounded-lg border">
                </div>
            @endif
            <input type="file" name="thumbnail" accept="image/*" class="w-full border rounded px-3 py-2">
        </div>

        {{-- Banner --}}
        <div>
            <label class="block text-gray-700 font-medium">Banner</label>
            @if($article->banner)
                <div class="mb-3">
                    <img src="{{ asset('storage/'.$article->banner) }}" alt="Banner" class="w-full h-40 object-cover rounded-lg border">
                </div>
            @endif
            <input type="file" name="banner" accept="image/*" class="w-full border rounded px-3 py-2">
        </div>

        {{-- Feature and Active Toggles --}}
        <div class="flex flex-wrap gap-6">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_featured" {{ $article->is_featured ? 'checked' : '' }} class="h-4 w-4 text-[#CF2031]">
                <span class="ml-2 text-gray-700">Featured</span>
            </label>

            <label class="inline-flex items-center">
                <input type="checkbox" name="is_trending" {{ $article->is_trending ? 'checked' : '' }} class="h-4 w-4 text-[#CF2031]">
                <span class="ml-2 text-gray-700">Trending</span>
            </label>

            <label class="inline-flex items-center">
                <input type="checkbox" name="is_active" {{ $article->is_active ? 'checked' : '' }} class="h-4 w-4 text-[#CF2031]">
                <span class="ml-2 text-gray-700">Active</span>
            </label>
        </div>

        {{-- Action Buttons --}}
        <div class="pt-4 flex justify-end space-x-3">
            <a href="{{ route('admin.articles.index') }}" class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200 text-gray-700">Cancel</a>
            <button type="submit" class="px-4 py-2 rounded bg-[#CF2031] hover:bg-[#b81b2a] text-white">Update</button>
        </div>
    </form>
</div>
@endsection
