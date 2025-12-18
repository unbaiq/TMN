@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-10 space-y-8">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 text-white rounded-2xl px-8 py-6 shadow-lg">
        <h2 class="text-2xl font-semibold">{{ $csr->csr_title }}</h2>
        <p class="text-sm text-white/80 mt-1">
            Complete details of this CSR activity
        </p>
    </div>

    {{-- MAIN DETAILS --}}
    <div class="bg-white border border-gray-200 shadow rounded-2xl p-8 space-y-6">

        {{-- BASIC INFO --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500">CSR Type</p>
                <p class="font-medium text-gray-800 capitalize">
                    {{ $csr->csr_type }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Date</p>
                <p class="font-medium text-gray-800">
                    {{ $csr->csr_date ? \Carbon\Carbon::parse($csr->csr_date)->format('d M Y') : '—' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Location</p>
                <p class="font-medium text-gray-800">
                    {{ $csr->location ?? '—' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Visibility</p>
                <p class="font-medium">
                    @if($csr->is_public)
                        <span class="text-green-700 bg-green-100 px-2 py-1 rounded-full text-xs">
                            Public
                        </span>
                    @else
                        <span class="text-gray-600 bg-gray-100 px-2 py-1 rounded-full text-xs">
                            Private
                        </span>
                    @endif
                </p>
            </div>
        </div>

        {{-- DESCRIPTION --}}
        <div>
            <p class="text-sm text-gray-500">Description</p>
            <p class="text-gray-800 mt-1 whitespace-pre-line">
                {{ $csr->csr_description ?? 'No description provided.' }}
            </p>
        </div>

        {{-- IMPACT METRICS --}}
        <div class="border-t pt-6">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">
                Impact Summary
            </h4>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Amount Spent</p>
                    <p class="font-medium text-gray-800">
                        {{ $csr->amount_spent !== null ? '₹' . number_format($csr->amount_spent, 2) : '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Volunteer Hours</p>
                    <p class="font-medium text-gray-800">
                        {{ $csr->volunteer_hours ?? '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Beneficiaries</p>
                    <p class="font-medium text-gray-800">
                        {{ $csr->beneficiaries_count ?? '—' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- STATUS --}}
        <div class="border-t pt-6">
            <p class="text-sm text-gray-500 mb-1">Approval Status</p>

            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                {{ $csr->status === 'approved'
                    ? 'bg-green-100 text-green-700'
                    : ($csr->status === 'pending'
                        ? 'bg-yellow-100 text-yellow-700'
                        : 'bg-red-100 text-red-700') }}">
                {{ ucfirst($csr->status) }}
            </span>
        </div>

        {{-- PROOF DOCUMENT --}}
        @if($csr->proof_document)
            <div class="border-t pt-6">
                <p class="text-sm text-gray-500 mb-1">Proof Document</p>
                <a href="{{ asset('storage/' . $csr->proof_document) }}"
                   target="_blank"
                   class="inline-flex items-center gap-2 text-blue-600 hover:underline">
                    View Uploaded Document
                </a>
            </div>
        @endif

        {{-- ACTIONS --}}
        <div class="border-t pt-6 flex justify-end gap-3">
            <a href="{{ route('member.csrs.index') }}"
               class="px-5 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700">
                Back
            </a>

            <a href="{{ route('member.csrs.edit', $csr) }}"
               class="px-5 py-2 rounded-lg bg-blue-100 hover:bg-blue-200 text-blue-700">
                Edit
            </a>
        </div>

    </div>
</div>
@endsection
