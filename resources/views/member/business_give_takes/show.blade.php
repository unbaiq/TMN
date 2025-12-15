@extends('layouts.app')

@section('content')
<div class="w-full px-4 sm:px-8 py-6">

    {{-- ==== HEADER ==== --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 rounded-2xl shadow-2xl px-10 py-8 flex flex-col md:flex-row md:items-center md:justify-between text-white">
        <div>
            <h2 class="text-3xl font-semibold">Business Details</h2>
            <p class="text-white/80 text-sm mt-1">Complete summary of the given or taken business transaction.</p>
        </div>
        <a href="{{ route('member.business.index') }}"
           class="mt-4 md:mt-0 inline-flex items-center gap-2 bg-white text-red-600 px-5 py-2.5 rounded-xl font-medium shadow hover:bg-gray-100 transition">
            <i data-feather="arrow-left" class="w-4 h-4"></i> Back
        </a>
    </div>

    {{-- ==== DETAILS CARD ==== --}}
    <div class="mt-10 bg-white rounded-2xl shadow-xl border border-gray-100 p-8 md:p-10 w-full space-y-8">

        {{-- Top Summary --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <h4 class="text-gray-500 text-xs uppercase">Service</h4>
                <p class="text-gray-800 text-base font-semibold">{{ $businessGiveTake->service_name }}</p>
            </div>

            <div>
                <h4 class="text-gray-500 text-xs uppercase">Referral Type</h4>
                <p class="capitalize text-gray-800 font-medium">{{ $businessGiveTake->referral_type_label }}</p>
            </div>

            <div>
                <h4 class="text-gray-500 text-xs uppercase">Status</h4>
                @if($businessGiveTake->status === 'accepted')
                    <span class="inline-block px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Accepted</span>
                @elseif($businessGiveTake->status === 'rejected')
                    <span class="inline-block px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">Rejected</span>
                @elseif($businessGiveTake->status === 'closed')
                    <span class="inline-block px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-full">Closed</span>
                @else
                    <span class="inline-block px-3 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded-full">Pending</span>
                @endif
            </div>
        </div>

        {{-- Participants --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-gray-100 pt-6">
            <div>
                <h4 class="text-gray-500 text-xs uppercase mb-1">Given By</h4>
                <p class="text-gray-800 font-medium">
                    {{ $businessGiveTake->giver?->name ?? '—' }}
                </p>
            </div>

            <div>
                <h4 class="text-gray-500 text-xs uppercase mb-1">Received By</h4>
                <p class="text-gray-800 font-medium">
                    {{ $businessGiveTake->taker?->name ?? '—' }}
                </p>
            </div>

            <div>
                <h4 class="text-gray-500 text-xs uppercase mb-1">Chapter</h4>
                <p class="text-gray-800 font-medium">
                    {{ $businessGiveTake->chapter?->name ?? '—' }}
                </p>
            </div>

            <div>
                <h4 class="text-gray-500 text-xs uppercase mb-1">Business Value (₹)</h4>
                <p class="text-gray-800 font-medium">
                    {{ $businessGiveTake->business_value ? '₹ ' . number_format($businessGiveTake->business_value, 2) : '—' }}
                </p>
            </div>
        </div>

        {{-- Description --}}
        <div class="border-t border-gray-100 pt-6">
            <h4 class="text-gray-500 text-xs uppercase mb-1">Description</h4>
            <p class="text-gray-800 text-sm leading-relaxed">
                {{ $businessGiveTake->description ?: 'No description provided.' }}
            </p>
        </div>

        {{-- Referral Contact Details --}}
        @if($businessGiveTake->referral_company || $businessGiveTake->referral_contact_person || $businessGiveTake->referral_contact_phone)
        <div class="border-t border-gray-100 pt-6">
            <h4 class="text-gray-500 text-xs uppercase mb-3">Referral Contact Details</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-800">
                @if($businessGiveTake->referral_company)
                <p><strong>Company:</strong> {{ $businessGiveTake->referral_company }}</p>
                @endif
                @if($businessGiveTake->referral_contact_person)
                <p><strong>Person:</strong> {{ $businessGiveTake->referral_contact_person }}</p>
                @endif
                @if($businessGiveTake->referral_contact_phone)
                <p><strong>Phone:</strong> {{ $businessGiveTake->referral_contact_phone }}</p>
                @endif
                @if($businessGiveTake->referral_contact_email)
                <p><strong>Email:</strong> {{ $businessGiveTake->referral_contact_email }}</p>
                @endif
            </div>
        </div>
        @endif

        {{-- Rejection Reason --}}
        @if($businessGiveTake->status === 'rejected' && $businessGiveTake->reject_reason)
        <div class="border-t border-gray-100 pt-6">
            <h4 class="text-gray-500 text-xs uppercase mb-1">Rejection Reason</h4>
            <p class="text-red-700 text-sm font-medium">{{ $businessGiveTake->reject_reason }}</p>
        </div>
        @endif

        {{-- Document --}}
        @if($businessGiveTake->reference_document)
        <div class="border-t border-gray-100 pt-6">
            <h4 class="text-gray-500 text-xs uppercase mb-1">Attached Document</h4>
            <a href="{{ asset('storage/' . $businessGiveTake->reference_document) }}"
               target="_blank"
               class="inline-flex items-center gap-2 text-sm text-blue-600 hover:underline">
                <i data-feather="file" class="w-4 h-4"></i> View Document
            </a>
        </div>
        @endif

        {{-- Footer Actions --}}
        <div class="pt-8 flex flex-wrap items-center justify-end gap-3 border-t border-gray-100">
            @if(Auth::id() === $businessGiveTake->taker_id && $businessGiveTake->status === 'pending')
                <form action="{{ route('member.business.accept', $businessGiveTake) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        Accept
                    </button>
                </form>

                <form action="{{ route('member.business.reject', $businessGiveTake) }}" method="POST">
                    @csrf
                    <input type="hidden" name="reject_reason" value="No longer relevant">
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        Reject
                    </button>
                </form>
            @endif

            @if(Auth::id() === $businessGiveTake->giver_id)
                <a href="{{ route('member.business.edit', $businessGiveTake) }}"
                   class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    <i data-feather="edit-3" class="w-4 h-4"></i> Edit
                </a>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  if (window.feather) feather.replace();
});
</script>
@endsection
