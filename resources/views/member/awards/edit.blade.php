@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-4 space-y-6">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 rounded-2xl shadow-xl px-8 py-6 flex justify-between items-center text-white">
        <div>
            <h2 class="text-3xl font-semibold">Edit Award</h2>
            <p class="text-sm text-white/80 mt-1">Update award details or upload a new certificate.</p>
        </div>
        <a href="{{ route('admin.awards.index') }}" class="bg-white text-red-600 px-4 py-2 rounded-lg font-medium shadow hover:bg-gray-100 transition">
            <i data-feather="arrow-left" class="inline w-4 h-4 mr-1"></i> Back
        </a>
    </div>

    {{-- FORM --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-lg p-8">
        <form method="POST" action="{{ route('admin.awards.update', $award) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Title --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Award Title</label>
                <input type="text" name="title" value="{{ old('title', $award->title) }}" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">{{ old('description', $award->description) }}</textarea>
            </div>

            {{-- Month / Year --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Month</label>
                    <input type="text" name="month" value="{{ old('month', $award->month) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                    <input type="number" name="year" value="{{ old('year', $award->year) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
                </div>
            </div>

            {{-- Business Value & Points --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Business Value (₹)</label>
                    <input type="number" step="0.01" name="business_value" value="{{ old('business_value', $award->business_value) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Points</label>
                    <input type="number" name="points" value="{{ old('points', $award->points) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
                </div>
            </div>

            {{-- Replace Certificate --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Replace Certificate File</label>
                <input type="file" name="certificate_file" accept=".jpg,.jpeg,.png,.pdf"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm file:bg-red-600 file:text-white hover:file:bg-red-700 focus:ring-1 focus:ring-red-600 focus:border-red-600">
                @if($award->certificate_file)
                    <p class="text-xs text-gray-600 mt-1">Current: 
                        <a href="{{ asset('storage/'.$award->certificate_file) }}" target="_blank" class="text-blue-600 underline">View file</a>
                    </p>
                @endif
            </div>

            {{-- Submit --}}
            <div class="pt-4 flex justify-end">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-lg font-medium shadow transition">
                    <i data-feather="save" class="inline w-4 h-4 mr-1"></i> Update Award
                </button>
            </div>
        </form>
    </div>
</div>
<script>document.addEventListener('DOMContentLoaded',()=>{if(window.feather)feather.replace();});</script>
@endsection
