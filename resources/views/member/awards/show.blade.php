@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10 space-y-8">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 text-white rounded-2xl px-8 py-6 flex justify-between items-center shadow-lg">
        <div>
            <h2 class="text-3xl font-semibold">{{ $award->title }}</h2>
            <p class="text-sm text-white/80 mt-1">Award Details</p>
        </div>
       <a href="{{ auth()->user()->role === 'admin'
        ? route('admin.awards.index')
        : route('member.awards.index') }}"
   class="bg-white text-red-600 px-4 py-2 rounded-lg font-medium shadow hover:bg-gray-100 transition">
    <i data-feather="arrow-left" class="inline w-4 h-4 mr-1"></i> Back
</a>

    </div>

    {{-- DETAILS --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-lg p-8 space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500">Awarded Member</p>
                <p class="font-medium text-gray-800">{{ $award->member->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Chapter</p>
                <p class="font-medium text-gray-800">{{ $award->chapter->name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Award Type</p>
                <p class="font-medium text-gray-800 capitalize">{{ $award->award_type }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Month & Year</p>
                <p class="font-medium text-gray-800">{{ $award->month }} {{ $award->year }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Business Value</p>
                <p class="font-medium text-gray-800">{{ $award->business_value ? '₹'.number_format($award->business_value,2) : '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Points</p>
                <p class="font-medium text-gray-800">{{ $award->points ?? '—' }}</p>
            </div>
        </div>

        @if($award->description)
        <div>
            <p class="text-sm text-gray-500 mb-1">Description / Reason</p>
            <p class="text-gray-700">{{ $award->description }}</p>
        </div>
        @endif

        @if($award->certificate_file)
        <div>
            <p class="text-sm text-gray-500 mb-1">Certificate / Proof</p>
            <a href="{{ asset('storage/'.$award->certificate_file) }}" target="_blank" class="text-blue-600 underline text-sm">View or Download</a>
        </div>
        @endif

        <div class="border-t pt-4 text-sm text-gray-500">
            <p>Created by: <span class="font-medium text-gray-800">{{ $award->creator->name ?? 'System' }}</span></p>
            <p>Created on: {{ $award->created_at->format('d M Y') }}</p>
        </div>
    </div>
</div>
<script>document.addEventListener('DOMContentLoaded',()=>{if(window.feather)feather.replace();});</script>
@endsection
