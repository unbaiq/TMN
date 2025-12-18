@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500
                text-white rounded-2xl px-8 py-6 shadow-lg">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-2xl font-semibold">{{ $branding->title }}</h2>
                <p class="text-sm text-white/80 mt-1">
                    {{ ucfirst(str_replace('_',' ',$branding->branding_type)) }} branding activity
                </p>
            </div>

            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $branding->status_color }}">
                {{ ucfirst(str_replace('_',' ',$branding->status)) }}
            </span>
        </div>
    </div>

    {{-- MAIN CARD --}}
    <div class="bg-white border border-gray-200 shadow rounded-2xl p-8 space-y-8">

        {{-- THUMBNAIL --}}
        <div class="flex items-center gap-6">
            <img src="{{ $branding->thumbnail_url }}"
                 class="w-28 h-28 rounded-lg object-cover border"
                 alt="Thumbnail">

            <div>
                <h3 class="text-lg font-semibold">{{ $branding->headline ?? '—' }}</h3>
                <p class="text-sm text-gray-600 mt-1">
                    {{ $branding->description ?? '—' }}
                </p>
            </div>
        </div>

        {{-- BASIC INFO --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-xs text-gray-500">Branding Type</p>
                <p class="font-medium">
                    {{ ucfirst(str_replace('_',' ',$branding->branding_type)) }}
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-500">Activity Date</p>
                <p class="font-medium">{{ $branding->formatted_date }}</p>
            </div>

            <div>
                <p class="text-xs text-gray-500">Location</p>
                <p class="font-medium">{{ $branding->location ?? '—' }}</p>
            </div>

            <div>
                <p class="text-xs text-gray-500">Duration</p>
                <p class="font-medium">{{ $branding->duration ?? '—' }}</p>
            </div>
        </div>

        {{-- MEDIA DETAILS --}}
        <div class="border-t pt-6 space-y-4">
            <h4 class="font-semibold text-gray-800">Media Information</h4>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs text-gray-500">Media Platform</p>
                    <p class="font-medium">{{ $branding->media_platform ?? '—' }}</p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Publication / Channel</p>
                    <p class="font-medium">{{ $branding->publication_name ?? '—' }}</p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Media Link</p>
                    @if($branding->media_link)
                        <a href="{{ $branding->media_link }}" target="_blank"
                           class="text-blue-600 underline">
                            View Media
                        </a>
                    @else
                        <p class="font-medium">—</p>
                    @endif
                </div>

                <div>
                    <p class="text-xs text-gray-500">Media Type</p>
                    <p class="font-medium">{{ $branding->media_type ?? '—' }}</p>
                </div>
            </div>
        </div>

        {{-- IMPACT --}}
        <div class="border-t pt-6 space-y-4">
            <h4 class="font-semibold text-gray-800">Impact & Metrics</h4>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div>
                    <p class="text-xs text-gray-500">Reach</p>
                    <p class="font-medium">{{ $branding->reach_count ?? '—' }}</p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Engagement</p>
                    <p class="font-medium">{{ $branding->engagement_count ?? '—' }}</p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Views</p>
                    <p class="font-medium">{{ $branding->views_count ?? '—' }}</p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Estimated Value</p>
                    <p class="font-medium">{{ $branding->formatted_value }}</p>
                </div>
            </div>

            <p class="text-sm text-gray-600 mt-3">
                {{ $branding->impact_summary }}
            </p>
        </div>

        {{-- PRESS / COLLAB --}}
        <div class="border-t pt-6 space-y-4">
            <h4 class="font-semibold text-gray-800">Press & Collaboration</h4>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs text-gray-500">Journalist</p>
                    <p class="font-medium">{{ $branding->journalist_name ?? '—' }}</p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Sponsor / Agency</p>
                    <p class="font-medium">
                        {{ $branding->sponsor_name ?? $branding->agency_name ?? '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Member Quote</p>
                    <p class="font-medium">{{ $branding->member_quote ?? '—' }}</p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Key Highlights</p>
                    <p class="font-medium">{{ $branding->key_highlights ?? '—' }}</p>
                </div>
            </div>
        </div>

        {{-- FILES --}}
        @if($branding->proof_document_url)
        <div class="border-t pt-6">
            <h4 class="font-semibold text-gray-800 mb-2">Proof Document</h4>
            <a href="{{ $branding->proof_document_url }}"
               target="_blank"
               class="text-blue-600 underline">
                View Uploaded Proof
            </a>
        </div>
        @endif

        {{-- ACTIONS --}}
        <div class="border-t pt-6 flex justify-end gap-4">
            <a href="{{ route('member.brandings.index') }}"
               class="px-5 py-2 rounded-lg border text-gray-700 hover:bg-gray-50">
                Back
            </a>

            <a href="{{ route('member.brandings.edit', $branding) }}"
               class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">
                Edit
            </a>
        </div>

    </div>
</div>
@endsection
