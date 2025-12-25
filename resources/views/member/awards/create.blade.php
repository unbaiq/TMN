@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-4 space-y-6">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 rounded-2xl shadow-xl px-8 py-6 flex justify-between items-center text-white">
        <div>
            <h2 class="text-3xl font-semibold">Add Member Award</h2>
            <p class="text-sm text-white/80 mt-1">Record and celebrate outstanding member achievements.</p>
        </div>
        <a href="{{ route('admin.awards.index') }}" class="bg-white text-red-600 px-4 py-2 rounded-lg font-medium shadow hover:bg-gray-100 transition">
            <i data-feather="arrow-left" class="inline w-4 h-4 mr-1"></i> Back
        </a>
    </div>
@if ($errors->any())
    <div class="mb-4 rounded-lg border border-red-300 bg-red-50 p-4">
        <ul class="list-disc list-inside text-sm text-red-700">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    {{-- FORM --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-lg p-8">
        <form method="POST" action="{{ route('admin.awards.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Member --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Member</label>
                <select name="member_id" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
                    <option value="">Choose...</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}">{{ $member->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Title --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Award Title</label>
                <input type="text" name="title" required placeholder="e.g., Member of the Month"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
            </div>

            {{-- Award Type --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Award Type</label>
                <select name="award_type" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
                    @foreach(['performance'=>'Performance','leadership'=>'Leadership','referral'=>'Referral','training'=>'Training','visitor'=>'Visitor','support'=>'Support','special'=>'Special','milestone'=>'Milestone','other'=>'Other'] as $key=>$label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description / Reason</label>
                <textarea name="description" rows="3" placeholder="Reason or description for the award"
                          class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600"></textarea>
            </div>

            {{-- Month / Year --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Month</label>
                    <input type="text" name="month" placeholder="e.g., December"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                    <input type="number" name="year" value="{{ date('Y') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
                </div>
            </div>

            {{-- Business Value & Points --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Business Value (₹)</label>
                    <input type="number" step="0.01" name="business_value"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Points</label>
                    <input type="number" name="points" min="0"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
                </div>
            </div>

            {{-- Certificate --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Certificate / Proof (optional)</label>
                <input type="file" name="certificate_file" accept=".jpg,.jpeg,.png,.pdf"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm file:bg-red-600 file:text-white hover:file:bg-red-700 focus:ring-1 focus:ring-red-600 focus:border-red-600">
            </div>

            {{-- Submit --}}
            <div class="pt-4 flex justify-end">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-lg font-medium shadow transition">
                    <i data-feather="award" class="inline w-4 h-4 mr-1"></i> Save Award
                </button>
            </div>
        </form>
    </div>
</div>
<script>document.addEventListener('DOMContentLoaded',()=>{if(window.feather)feather.replace();});</script>
@endsection
