@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10 space-y-8">

    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 text-white rounded-2xl px-8 py-6 shadow-lg">
        <h2 class="text-2xl font-semibold">Edit Branding Activity</h2>
        <p class="text-sm text-white/80 mt-1">Update your TMN branding and media details.</p>
    </div>

    <form action="{{ route('member.brandings.update', $branding) }}" method="POST" enctype="multipart/form-data"
          class="bg-white border border-gray-200 shadow rounded-2xl p-8 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="text-sm font-medium text-gray-700">Branding Type *</label>
                <select name="branding_type"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-1 focus:ring-red-600" required>
                    @foreach($brandingTypes as $key => $label)
                        <option value="{{ $key }}" {{ $branding->branding_type == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">Activity Date</label>
                <input type="date" name="activity_date" value="{{ $branding->activity_date?->format('Y-m-d') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-1 focus:ring-red-600">
            </div>
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700">Title *</label>
            <input type="text" name="title" value="{{ old('title', $branding->title) }}" required
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-1 focus:ring-red-600">
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700">Headline / Tagline</label>
            <input type="text" name="headline" value="{{ old('headline', $branding->headline) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" rows="4"
                      class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">{{ old('description', $branding->description) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="text-sm font-medium text-gray-700">Media Platform</label>
                <input type="text" name="media_platform" value="{{ old('media_platform', $branding->media_platform) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">Media Link</label>
                <input type="url" name="media_link" value="{{ old('media_link', $branding->media_link) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="text-sm font-medium text-gray-700">Reach Count</label>
                <input type="number" name="reach_count" value="{{ old('reach_count', $branding->reach_count) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">Engagement Count</label>
                <input type="number" name="engagement_count" value="{{ old('engagement_count', $branding->engagement_count) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">Estimated PR Value (₹)</label>
                <input type="number" step="0.01" name="estimated_value" value="{{ old('estimated_value', $branding->estimated_value) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">
            </div>
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700">Status</label>
            <select name="status"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-1 focus:ring-red-600">
                @foreach(['draft','submitted','under_review','approved','rejected'] as $status)
                    <option value="{{ $status }}" {{ $branding->status == $status ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_',' ',$status)) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="text-sm font-medium text-gray-700">Proof Document</label>
                <input type="file" name="proof_document"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">
                @if($branding->proof_document_url)
                    <p class="text-xs mt-2">
                        <a href="{{ $branding->proof_document_url }}" target="_blank" class="text-blue-600 underline">
                            View current proof
                        </a>
                    </p>
                @endif
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">Thumbnail Image</label>
                <input type="file" name="thumbnail_image"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">
                @if($branding->thumbnail_url)
                    <div class="mt-2">
                        <img src="{{ $branding->thumbnail_url }}" class="w-20 h-20 rounded border object-cover" alt="">
                    </div>
                @endif
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium">
                Update Branding
            </button>
        </div>
    </form>
</div>
@endsection
