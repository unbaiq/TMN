@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-4 space-y-6">

    {{-- ==== HEADER ==== --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 rounded-2xl shadow-xl px-8 py-6 flex justify-between items-center text-white">
        <div>
            <h2 class="text-3xl font-semibold">Add Recognition</h2>
            <p class="text-sm text-white/80 mt-1">Appreciate a fellow member for contribution or achievement.</p>
        </div>
        <a href="{{ route('member.recognitions.index') }}"
           class="bg-white text-red-600 px-4 py-2 rounded-lg font-medium shadow hover:bg-gray-100 transition">
           <i data-feather="arrow-left" class="inline w-4 h-4 mr-1"></i> Back
        </a>
    </div>

    {{-- ==== FORM ==== --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-lg p-8">
        <form method="POST" action="{{ route('member.recognitions.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Member Selection --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Member <span class="text-red-600">*</span></label>
                <select name="member_id" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
                    <option value="">-- Choose Member --</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                            {{ $member->name }}
                        </option>
                    @endforeach
                </select>
                @error('member_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Title --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Recognition Title <span class="text-red-600">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g., Top Referrer of the Month"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600" required>
                @error('title') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Category --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-600">*</span></label>
                <select name="category" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
                    <option value="">-- Select Category --</option>
                    @foreach ([
                        'referral' => 'Referral',
                        'thank_you' => 'Thank You',
                        'visitor' => 'Invited Visitor',
                        'leadership' => 'Leadership / Role',
                        'training' => 'Training',
                        'testimony' => 'Testimony',
                        'support' => 'Support / Helped Member',
                        'milestone' => 'Milestone',
                        'other' => 'Other'
                    ] as $key => $label)
                        <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('category') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description / Notes</label>
                <textarea name="description" rows="3" placeholder="Briefly describe the reason for this recognition..."
                          class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">{{ old('description') }}</textarea>
            </div>

            {{-- Date --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Recognition Date <span class="text-red-600">*</span></label>
                <input type="date" name="recognized_on" value="{{ old('recognized_on', now()->toDateString()) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600" required>
                @error('recognized_on') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Business Value --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Business Value (₹)</label>
                    <input type="number" step="0.01" name="business_value" value="{{ old('business_value') }}"
                           placeholder="e.g., 50000"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Points</label>
                    <input type="number" name="points" value="{{ old('points', 0) }}"
                           placeholder="e.g., 10"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
                </div>
            </div>

            {{-- File Upload --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Evidence (optional)</label>
                <input type="file" name="evidence_file" accept=".jpg,.jpeg,.png,.pdf"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm file:mr-3 file:px-4 file:py-2 file:rounded-md file:border-0 file:bg-red-600 file:text-white hover:file:bg-red-700 focus:ring-1 focus:ring-red-600 focus:border-red-600">
                @error('evidence_file') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Submit --}}
            <div class="pt-4 flex justify-end">
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-lg font-medium shadow transition">
                    <i data-feather="check-circle" class="inline w-4 h-4 mr-1"></i> Save Recognition
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (window.feather) feather.replace();
});
</script>
@endsection
