@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-4 space-y-6">

    {{-- ==== HEADER ==== --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 rounded-2xl shadow-xl px-8 py-6 flex justify-between items-center text-white">
        <div>
            <h2 class="text-3xl font-semibold">{{ $recognition->title }}</h2>
            <p class="text-sm text-white/80 mt-1">
                Recognition Details
            </p>
        </div>

        <a href="{{ route('member.recognitions.index') }}"
           class="bg-white text-red-600 px-4 py-2 rounded-lg font-medium shadow hover:bg-gray-100 transition">
            <i data-feather="arrow-left" class="inline w-4 h-4 mr-1"></i>
            Back
        </a>
    </div>

    {{-- ==== CONTENT CARD ==== --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-lg p-8 space-y-6">

        {{-- Member --}}
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Recognized Member</label>
            <p class="text-gray-800 font-medium text-sm">
                {{ $recognition->member?->name ?? '—' }}
            </p>
        </div>

        {{-- Title --}}
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Title</label>
            <p class="text-gray-800 font-medium text-sm">
                {{ $recognition->title }}
            </p>
        </div>

        {{-- Category --}}
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Category</label>
            <p class="text-gray-800 font-medium text-sm capitalize">
                {{ str_replace('_', ' ', $recognition->category) }}
            </p>
        </div>

        {{-- Description --}}
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Description</label>
            <p class="text-gray-700 text-sm leading-relaxed">
                {{ $recognition->description ?? '—' }}
            </p>
        </div>

        {{-- Date --}}
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Recognition Date</label>
            <p class="text-gray-800 font-medium text-sm">
                {{ \Carbon\Carbon::parse($recognition->recognized_on)->format('d M Y') }}
            </p>
        </div>

        {{-- Business Value & Points --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Business Value</label>
                <p class="text-gray-800 font-medium text-sm">
                    ₹ {{ number_format($recognition->business_value ?? 0, 2) }}
                </p>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Points</label>
                <p class="text-gray-800 font-medium text-sm">
                    {{ $recognition->points ?? 0 }}
                </p>
            </div>
        </div>

        {{-- Status --}}
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Status</label>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                {{ $recognition->status === 'approved'
                    ? 'bg-green-100 text-green-700'
                    : 'bg-gray-100 text-gray-700' }}">
                {{ ucfirst($recognition->status) }}
            </span>
        </div>

        {{-- Evidence --}}
        @if($recognition->evidence_file)
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Evidence</label>
                <a href="{{ asset('storage/'.$recognition->evidence_file) }}"
                   target="_blank"
                   class="inline-flex items-center gap-2 text-red-600 font-medium hover:underline">
                    <i data-feather="paperclip" class="w-4 h-4"></i>
                    View Attachment
                </a>
            </div>
        @endif

        {{-- Footer --}}
        <div class="pt-6 flex justify-end">
            <a href="{{ route('member.recognitions.edit', $recognition->id) }}"
               class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-lg font-medium shadow transition">
                <i data-feather="edit" class="inline w-4 h-4 mr-1"></i>
                Edit Recognition
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (window.feather) feather.replace();
});
</script>
@endsection
