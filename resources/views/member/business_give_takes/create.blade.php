@extends('layouts.app')

@section('content')
<div class="w-full px-4 sm:px-8 py-10">

    {{-- ==== HEADER ==== --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 rounded-2xl shadow-2xl px-10 py-8 flex flex-col md:flex-row md:items-center md:justify-between text-white">
        <div>
            <h2 class="text-3xl font-semibold">Add New Business</h2>
            <p class="text-white/80 text-sm mt-1">Record a new referral, thank you slip, or business exchange within your chapter.</p>
        </div>
        <a href="{{ route('member.business.index') }}"
           class="mt-4 md:mt-0 inline-flex items-center gap-2 bg-white text-red-600 px-5 py-2.5 rounded-xl font-medium shadow hover:bg-gray-100 transition">
            <i data-feather="arrow-left" class="w-4 h-4"></i> Back
        </a>
    </div>

    {{-- ==== FORM ==== --}}
    <div class="mt-10 bg-white rounded-2xl shadow-xl border border-gray-100 p-8 md:p-10 w-full">
        <form action="{{ route('member.business.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- BASIC DETAILS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Receiver (Member)</label>
                    <select name="taker_id" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
                        <option value="">-- Select Member --</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}" {{ old('taker_id') == $member->id ? 'selected' : '' }}>
                                {{ $member->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('taker_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Chapter</label>
                    <select name="chapter_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
                        <option value="">-- Optional --</option>
                        @foreach($chapters as $chapter)
                            <option value="{{ $chapter->id }}" {{ old('chapter_id') == $chapter->id ? 'selected' : '' }}>
                                {{ $chapter->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Referral Type</label>
                    <select name="referral_type" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
                        <option value="">-- Select Type --</option>
                        <option value="referral" {{ old('referral_type')=='referral'?'selected':'' }}>Referral</option>
                        <option value="thank_you" {{ old('referral_type')=='thank_you'?'selected':'' }}>Thank You Slip</option>
                        <option value="1to1" {{ old('referral_type')=='1to1'?'selected':'' }}>1-to-1 Meeting</option>
                        <option value="visitor" {{ old('referral_type')=='visitor'?'selected':'' }}>Visitor</option>
                        <option value="training" {{ old('referral_type')=='training'?'selected':'' }}>Training</option>
                        <option value="testimony" {{ old('referral_type')=='testimony'?'selected':'' }}>Testimony</option>
                    </select>
                </div>
            </div>

            {{-- SERVICE DETAILS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Service Name</label>
                    <input type="text" name="service_name" value="{{ old('service_name') }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600"
                        placeholder="E.g., Website Design for ABC Pvt Ltd">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Business Value (₹)</label>
                    <input type="number" step="0.01" name="business_value" value="{{ old('business_value') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600"
                        placeholder="Optional">
                </div>
            </div>

            {{-- DESCRIPTION --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600"
                    placeholder="Add details about this business/referral...">{{ old('description') }}</textarea>
            </div>

            {{-- REFERRAL CONTACT DETAILS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Referral Company</label>
                    <input type="text" name="referral_company" value="{{ old('referral_company') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600"
                        placeholder="E.g., ABC Pvt Ltd">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contact Person</label>
                    <input type="text" name="referral_contact_person" value="{{ old('referral_contact_person') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600"
                        placeholder="E.g., Mr. Sharma">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contact Phone</label>
                    <input type="text" name="referral_contact_phone" value="{{ old('referral_contact_phone') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600"
                        placeholder="+91-9876543210">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contact Email</label>
                    <input type="email" name="referral_contact_email" value="{{ old('referral_contact_email') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600"
                        placeholder="contact@example.com">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Attach Document</label>
                    <input type="file" name="reference_document"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600 bg-gray-50">
                    <p class="text-xs text-gray-500 mt-1">Accepted: PDF, JPG, PNG, DOCX (max 2MB)</p>
                </div>
            </div>

            {{-- SUBMIT BUTTON --}}
            <div class="pt-4 flex justify-end">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-medium px-8 py-3 rounded-xl text-sm shadow">
                    <i data-feather="save" class="w-4 h-4"></i> Save Record
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
