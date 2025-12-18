@extends('layouts.app')

@section('content')
<div class="w-full px-4 sm:px-8 py-10">

    {{-- ==== HEADER ==== --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 rounded-2xl shadow-2xl px-10 py-8 flex flex-col md:flex-row md:items-center md:justify-between text-white">
        <div>
            <h2 class="text-3xl font-semibold">Edit Business</h2>
            <p class="text-white/80 text-sm mt-1">
                Update referral, thank you slip, or business exchange details.
            </p>
        </div>
        <a href="{{ route('member.business.index') }}"
           class="mt-4 md:mt-0 inline-flex items-center gap-2 bg-white text-red-600 px-5 py-2.5 rounded-xl font-medium shadow hover:bg-gray-100 transition">
            <i data-feather="arrow-left" class="w-4 h-4"></i> Back
        </a>
    </div>

    {{-- ==== FORM ==== --}}
    <div class="mt-10 bg-white rounded-2xl shadow-xl border border-gray-100 p-8 md:p-10 w-full">
        <form action="{{ route('member.business.update', $businessGiveTake) }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-8">

            @csrf
            @method('PUT')

            {{-- BASIC DETAILS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Receiver (Member)</label>
                    <select name="taker_id" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-600">
                        <option value="">-- Select Member --</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}"
                                {{ old('taker_id', $businessGiveTake->taker_id) == $member->id ? 'selected' : '' }}>
                                {{ $member->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Chapter</label>
                    <select name="chapter_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-600">
                        <option value="">-- Optional --</option>
                        @foreach($chapters as $chapter)
                            <option value="{{ $chapter->id }}"
                                {{ old('chapter_id', $businessGiveTake->chapter_id) == $chapter->id ? 'selected' : '' }}>
                                {{ $chapter->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Referral Type</label>
                    <select name="referral_type" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-600">
                        @foreach([
                            'referral' => 'Referral',
                            'thank_you' => 'Thank You Slip',
                            '1to1' => '1-to-1 Meeting',
                            'visitor' => 'Visitor',
                            'training' => 'Training',
                            'testimony' => 'Testimony'
                        ] as $key => $label)
                            <option value="{{ $key }}"
                                {{ old('referral_type', $businessGiveTake->referral_type) == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- SERVICE DETAILS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Service Name</label>
                    <input type="text" name="service_name" required
                        value="{{ old('service_name', $businessGiveTake->service_name) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-1 focus:ring-red-600">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Business Value (₹)</label>
                    <input type="number" step="0.01" name="business_value"
                        value="{{ old('business_value', $businessGiveTake->business_value) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-1 focus:ring-red-600">
                </div>
            </div>

            {{-- DESCRIPTION --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-1 focus:ring-red-600">{{ old('description', $businessGiveTake->description) }}</textarea>
            </div>

            {{-- CONTACT DETAILS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Referral Company</label>
                    <input type="text" name="referral_company"
                        value="{{ old('referral_company', $businessGiveTake->referral_company) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contact Person</label>
                    <input type="text" name="referral_contact_person"
                        value="{{ old('referral_contact_person', $businessGiveTake->referral_contact_person) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contact Phone</label>
                    <input type="text" name="referral_contact_phone"
                        value="{{ old('referral_contact_phone', $businessGiveTake->referral_contact_phone) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contact Email</label>
                    <input type="email" name="referral_contact_email"
                        value="{{ old('referral_contact_email', $businessGiveTake->referral_contact_email) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Replace Document</label>
                    <input type="file" name="reference_document"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm bg-gray-50">
                    @if($businessGiveTake->reference_document)
                        <p class="text-xs mt-1">
                            <a href="{{ asset('storage/'.$businessGiveTake->reference_document) }}"
                               target="_blank"
                               class="text-blue-600 underline">
                                View existing document
                            </a>
                        </p>
                    @endif
                </div>
            </div>

            {{-- SUBMIT --}}
            <div class="pt-4 flex justify-end">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-medium px-8 py-3 rounded-xl text-sm shadow">
                    <i data-feather="save" class="w-4 h-4"></i> Update Record
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
