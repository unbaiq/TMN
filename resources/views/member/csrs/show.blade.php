@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10 space-y-8">

    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 text-white rounded-2xl px-8 py-6 shadow-lg">
        <h2 class="text-2xl font-semibold">{{ $csr->csr_title }}</h2>
        <p class="text-sm text-white/80 mt-1">Detailed information about this CSR activity.</p>
    </div>

    <div class="bg-white border border-gray-200 shadow rounded-2xl p-8 space-y-4">
        <div><strong>Type:</strong> {{ ucfirst($csr->csr_type) }}</div>
        <div><strong>Description:</strong> {{ $csr->csr_description ?? '—' }}</div>
        <div><strong>Date:</strong> {{ $csr->csr_date?->format('d M Y') ?? '—' }}</div>
        <div><strong>Location:</strong> {{ $csr->location ?? '—' }}</div>
        <div><strong>Amount Spent:</strong> ₹{{ number_format($csr->amount_spent,2) ?? '—' }}</div>
        <div><strong>Volunteer Hours:</strong> {{ $csr->volunteer_hours ?? '—' }}</div>
        <div><strong>Beneficiaries:</strong> {{ $csr->beneficiaries_count ?? '—' }}</div>
        <div><strong>Status:</strong> 
            <span class="px-2 py-1 rounded-full text-xs {{ $csr->status=='approved'?'bg-green-100 text-green-700':($csr->status=='pending'?'bg-yellow-100 text-yellow-700':'bg-gray-100 text-gray-600') }}">
                {{ ucfirst($csr->status) }}
            </span>
        </div>
        @if($csr->proof_document)
            <div><strong>Proof Document:</strong> 
                <a href="{{ asset('storage/'.$csr->proof_document) }}" target="_blank" class="text-blue-600 underline">View</a>
            </div>
        @endif
    </div>
</div>
@endsection
