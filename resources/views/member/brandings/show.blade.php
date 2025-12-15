@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10 space-y-8">

    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 text-white rounded-2xl px-8 py-6 shadow-lg flex items-center gap-4">
        @if($branding->thumbnail_url)
            <img src="{{ $branding->thumbnail_url }}" class="w-16 h-16 rounded border object-cover bg-white/10" alt="">
        @endif
        <div>
            <h2 class="text-2xl font-semibold">{{ $branding->title ?? 'Branding Activity' }}</h2>
            <p class="text-sm text-white/80 mt-1">
                {{ $branding->headline ?? 'Branding & Media Detail' }}
            </p>
        </div>
    </div>

    <div class="bg-white border border-gray-200 shadow rounded-2xl p-8 space-y-4 text-sm">
        <div><strong>Type:</strong> {{ ucfirst(str_replace('_',' ',$branding->branding_type)) }}</div>
        <div><strong>Date:</strong> {{ $branding->formatted_date }}</div>
        <div><strong>Media Platform:</strong> {{ $branding->media_platform ?? '—' }}</div>
        <div><strong>Media Link:</strong>
            @if($branding->media_link)
                <a href="{{ $branding->media_link }}" target="_blank" class="text-blue-600 underline">Open Media</a>
            @else
                —
            @endif
        </div>
        <div><strong>Publication:</strong> {{ $branding->publication_name ?? '—' }}</div>
        <div><strong>Journalist:</strong> {{ $branding->journalist_name ?? '—' }}</div>
        <div><strong>Reach:</strong> {{ $branding->reach_count ?? '—' }}</div>
        <div><strong>Engagement:</strong> {{ $branding->engagement_count ?? '—' }}</div>
        <div><strong>Estimated PR Value:</strong> {{ $branding->formatted_value }}</div>
        <div>
            <strong>Status:</strong>
            <span class="px-2 py-1 rounded-full text-xs {{ $branding->status_color }}">
                {{ ucfirst(str_replace('_',' ',$branding->status)) }}
            </span>
        </div>
        <div>
            <strong>Description:</strong>
            <p class="mt-1 text-gray-700">
                {{ $branding->description ?: 'No detailed description provided.' }}
            </p>
        </div>
        @if($branding->proof_document_url)
            <div>
                <strong>Proof Document:</strong>
                <a href="{{ $branding->proof_document_url }}" target="_blank" class="text-blue-600 underline">
                    View Proof
                </a>
            </div>
        @endif
        @if($branding->member_quote)
            <div>
                <strong>Member Quote:</strong>
                <p class="mt-1 italic text-gray-700">“{{ $branding->member_quote }}”</p>
            </div>
        @endif
    </div>

    <div class="flex justify-between">
        <a href="{{ route('member.brandings.index') }}"
           class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-medium">
            ← Back to Branding List
        </a>
        <a href="{{ route('member.brandings.edit', $branding) }}"
           class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium">
            Edit Branding
        </a>
    </div>
</div>
@endsection
