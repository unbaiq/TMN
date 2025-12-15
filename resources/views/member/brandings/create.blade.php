@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-4 space-y-6">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 text-white rounded-2xl px-8 py-6 shadow-lg">
        <h2 class="text-2xl font-semibold">Add Branding & Media Activity</h2>
        <p class="text-sm text-white/80 mt-1">
            Log Articles, Stories, Video Shoots, Podcasts, PR and more for TMN visibility.
        </p>
    </div>

    {{-- FORM --}}
    <form action="{{ route('member.brandings.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white border border-gray-200 shadow rounded-2xl p-8 space-y-6">
        @csrf

        {{-- Branding Type --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="text-sm font-medium text-gray-700">Branding Type *</label>
                <select id="branding_type" name="branding_type"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-1 focus:ring-red-600" required>
                    @foreach($brandingTypes as $key => $label)
                        <option value="{{ $key }}" {{ old('branding_type') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">Activity Date</label>
                <input type="date" name="activity_date" value="{{ old('activity_date') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-1 focus:ring-red-600">
            </div>
        </div>

        {{-- Common Fields --}}
        <div id="common_fields" class="space-y-6">
            <div>
                <label class="text-sm font-medium text-gray-700">Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-1 focus:ring-red-600">
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">Headline / Tagline</label>
                <input type="text" name="headline" value="{{ old('headline') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" rows="4"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-1 focus:ring-red-600">{{ old('description') }}</textarea>
            </div>
        </div>

        {{-- Article / PR Fields --}}
        <div id="article_fields" class="space-y-6 hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm font-medium text-gray-700">Publication Name</label>
                    <input type="text" name="publication_name" value="{{ old('publication_name') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Journalist Name</label>
                    <input type="text" name="journalist_name" value="{{ old('journalist_name') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">
                </div>
            </div>
        </div>

        {{-- Video / Podcast Fields --}}
        <div id="media_fields" class="space-y-6 hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm font-medium text-gray-700">Media Platform</label>
                    <input type="text" name="media_platform" value="{{ old('media_platform') }}"
                           placeholder="YouTube, Spotify, Instagram..."
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Media Link</label>
                    <input type="url" name="media_link" value="{{ old('media_link') }}"
                           placeholder="https://..."
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">
                </div>
            </div>
        </div>

        {{-- Performance Metrics --}}
        <div id="metrics_fields" class="grid grid-cols-1 md:grid-cols-3 gap-6 hidden">
            <div>
                <label class="text-sm font-medium text-gray-700">Reach Count</label>
                <input type="number" name="reach_count" value="{{ old('reach_count') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">Engagement Count</label>
                <input type="number" name="engagement_count" value="{{ old('engagement_count') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">Estimated PR Value (₹)</label>
                <input type="number" step="0.01" name="estimated_value" value="{{ old('estimated_value') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">
            </div>
        </div>

        {{-- Files --}}
        <div id="file_fields" class="grid grid-cols-1 md:grid-cols-2 gap-6 hidden">
            <div>
                <label class="text-sm font-medium text-gray-700">Proof Document (Image/PDF)</label>
                <input type="file" name="proof_document"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">Thumbnail Image</label>
                <input type="file" name="thumbnail_image"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium">
                Save Branding Activity
            </button>
        </div>
    </form>
</div>

{{-- Script for Dynamic Field Display --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('branding_type');
    const articleFields = document.getElementById('article_fields');
    const mediaFields = document.getElementById('media_fields');
    const metricsFields = document.getElementById('metrics_fields');
    const fileFields = document.getElementById('file_fields');

    function updateVisibility() {
        const type = typeSelect.value;

        // Hide all first
        articleFields.classList.add('hidden');
        mediaFields.classList.add('hidden');
        metricsFields.classList.add('hidden');
        fileFields.classList.add('hidden');

        // Show relevant sections
        if (['article', 'story', 'pr', 'media_release'].includes(type)) {
            articleFields.classList.remove('hidden');
            fileFields.classList.remove('hidden');
        }

        if (['video_shoot', 'podcast'].includes(type)) {
            mediaFields.classList.remove('hidden');
            metricsFields.classList.remove('hidden');
            fileFields.classList.remove('hidden');
        }
    }

    typeSelect.addEventListener('change', updateVisibility);
    updateVisibility(); // Initial run
});
</script>
@endsection
