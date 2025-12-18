@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500
                text-white rounded-2xl px-8 py-6 shadow-lg">
        <h2 class="text-2xl font-semibold">Edit Branding Activity</h2>
        <p class="text-sm text-white/80 mt-1">
            Update branding, media, and impact details.
        </p>
    </div>

    {{-- FORM --}}
    <form method="POST"
          action="{{ route('member.brandings.update', $branding) }}"
          enctype="multipart/form-data"
          class="bg-white border border-gray-200 shadow rounded-2xl p-8 space-y-8">

        @csrf
        @method('PUT')

        {{-- BASIC --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium">Title *</label>
                <input type="text" name="title"
                       value="{{ old('title', $branding->title) }}"
                       required
                       class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>

            <div>
                <label class="block text-sm font-medium">Branding Type *</label>
                <select name="branding_type" required
                        class="w-full border rounded-lg px-3 py-2 mt-1">
                    @foreach([
                        'article','story','video_shoot','podcast','pr_activity',
                        'media_release','magazine_feature','award_mention',
                        'social_campaign','other'
                    ] as $type)
                        <option value="{{ $type }}"
                            {{ old('branding_type',$branding->branding_type)==$type?'selected':'' }}>
                            {{ ucfirst(str_replace('_',' ',$type)) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium">Headline</label>
            <input type="text" name="headline"
                   value="{{ old('headline', $branding->headline) }}"
                   class="w-full border rounded-lg px-3 py-2 mt-1">
        </div>

        <div>
            <label class="block text-sm font-medium">Description</label>
            <textarea name="description" rows="4"
                      class="w-full border rounded-lg px-3 py-2 mt-1">{{ old('description',$branding->description) }}</textarea>
        </div>

        {{-- ACTIVITY --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium">Activity Date</label>
                <input type="date" name="activity_date"
                       value="{{ old('activity_date', optional($branding->activity_date)->format('Y-m-d')) }}"
                       class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>

            <div>
                <label class="block text-sm font-medium">Duration</label>
                <input type="text" name="duration"
                       value="{{ old('duration',$branding->duration) }}"
                       class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>

            <div>
                <label class="block text-sm font-medium">Location</label>
                <input type="text" name="location"
                       value="{{ old('location',$branding->location) }}"
                       class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>
        </div>

        {{-- MEDIA --}}
        <div class="border-t pt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium">Media Platform</label>
                <input type="text" name="media_platform"
                       value="{{ old('media_platform',$branding->media_platform) }}"
                       class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>

            <div>
                <label class="block text-sm font-medium">Media Link</label>
                <input type="url" name="media_link"
                       value="{{ old('media_link',$branding->media_link) }}"
                       class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>

            <div>
                <label class="block text-sm font-medium">Publication Name</label>
                <input type="text" name="publication_name"
                       value="{{ old('publication_name',$branding->publication_name) }}"
                       class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>

            <div>
                <label class="block text-sm font-medium">Media Type</label>
                <input type="text" name="media_type"
                       value="{{ old('media_type',$branding->media_type) }}"
                       class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>
        </div>

        {{-- IMPACT --}}
        <div class="border-t pt-6 grid grid-cols-2 md:grid-cols-4 gap-6">
            <div>
                <label class="block text-sm font-medium">Reach</label>
                <input type="number" name="reach_count"
                       value="{{ old('reach_count',$branding->reach_count) }}"
                       class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>

            <div>
                <label class="block text-sm font-medium">Engagement</label>
                <input type="number" name="engagement_count"
                       value="{{ old('engagement_count',$branding->engagement_count) }}"
                       class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>

            <div>
                <label class="block text-sm font-medium">Views</label>
                <input type="number" name="views_count"
                       value="{{ old('views_count',$branding->views_count) }}"
                       class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>

            <div>
                <label class="block text-sm font-medium">Estimated Value (₹)</label>
                <input type="number" step="0.01" name="estimated_value"
                       value="{{ old('estimated_value',$branding->estimated_value) }}"
                       class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>
        </div>

        {{-- FILES --}}
        <div class="border-t pt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium">Thumbnail Image</label>
                <input type="file" name="thumbnail_image"
                       class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>

            <div>
                <label class="block text-sm font-medium">Proof Document</label>
                <input type="file" name="proof_document"
                       class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>
        </div>

        {{-- STATUS (MEMBER SAFE) --}}
        <div class="border-t pt-6">
            <label class="block text-sm font-medium">Status</label>
            <select name="status"
                    class="w-full md:w-1/3 border rounded-lg px-3 py-2 mt-1">
                @foreach(['draft','submitted'] as $status)
                    <option value="{{ $status }}"
                        {{ old('status',$branding->status)==$status?'selected':'' }}>
                        {{ ucfirst(str_replace('_',' ',$status)) }}
                    </option>
                @endforeach
            </select>
            <p class="text-xs text-gray-500 mt-1">
                Once submitted, admin review is required.
            </p>
        </div>

        {{-- ACTIONS --}}
        <div class="flex justify-end gap-4 pt-4">
            <a href="{{ route('member.brandings.show',$branding) }}"
               class="px-5 py-2 rounded-lg border text-gray-700 hover:bg-gray-50">
                Cancel
            </a>

            <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg">
                Update Branding
            </button>
        </div>

    </form>
</div>
@endsection
