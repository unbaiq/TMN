@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500
                text-white rounded-2xl px-8 py-6 shadow-lg">
        <h2 class="text-2xl font-semibold">Add Branding Activity</h2>
        <p class="text-sm text-white/80 mt-1">
            Record articles, stories, PR, media or branding activities.
        </p>
    </div>

    {{-- FORM --}}
    <form method="POST"
          action="{{ route('member.brandings.store') }}"
          enctype="multipart/form-data"
          class="bg-white border border-gray-200 shadow rounded-2xl p-8 space-y-6">
        @csrf

        {{-- BASIC INFO --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block text-sm font-medium text-gray-700">Branding Type *</label>
                <select name="branding_type" required
                        class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-red-600">
                    @foreach([
                        'article','story','video_shoot','podcast','pr_activity',
                        'media_release','magazine_feature','award_mention',
                        'social_campaign','other'
                    ] as $type)
                        <option value="{{ $type }}">
                            {{ ucfirst(str_replace('_',' ',$type)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Title *</label>
                <input type="text" name="title" required
                       class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-red-600">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Headline</label>
            <input type="text" name="headline"
                   class="w-full border rounded-lg px-3 py-2 mt-1">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" rows="4"
                      class="w-full border rounded-lg px-3 py-2 mt-1"></textarea>
        </div>

        {{-- ACTIVITY DETAILS --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Activity Date</label>
                <input type="date" name="activity_date"
                       class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Location</label>
                <input type="text" name="location"
                       class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Duration</label>
                <input type="text" name="duration" placeholder="e.g. 30 mins"
                       class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>
        </div>

        {{-- MEDIA INFO --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Media Platform</label>
                <input type="text" name="media_platform"
                       class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Media Link</label>
                <input type="url" name="media_link"
                       class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>
        </div>

        {{-- METRICS --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Reach</label>
                <input type="number" name="reach_count"
                       class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Engagement</label>
                <input type="number" name="engagement_count"
                       class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Views</label>
                <input type="number" name="views_count"
                       class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Estimated Value (₹)</label>
                <input type="number" step="0.01" name="estimated_value"
                       class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>
        </div>

        {{-- FILES --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Thumbnail Image</label>
                <input type="file" name="thumbnail_image"
                       class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Proof Document</label>
                <input type="file" name="proof_document"
                       class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>
        </div>

        {{-- STATUS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status"
                        class="w-full border rounded-lg px-3 py-2 mt-1">
                    <option value="draft">Draft</option>
                    <option value="submitted">Submitted</option>
                </select>
            </div>

            <div class="flex items-center gap-3 mt-6">
                <input type="checkbox" name="featured_by_tmn" value="1"
                       class="rounded border-gray-300">
                <span class="text-sm text-gray-700">Featured by TMN</span>
            </div>
        </div>

        {{-- ACTIONS --}}
        <div class="flex justify-end gap-4 pt-4">
            <a href="{{ route('member.brandings.index') }}"
               class="px-5 py-2 rounded-lg border text-gray-700 hover:bg-gray-50">
                Cancel
            </a>

            <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium">
                Save Branding
            </button>
        </div>

    </form>
</div>
@endsection
