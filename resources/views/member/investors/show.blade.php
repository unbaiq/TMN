@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-10 bg-white shadow-lg rounded-2xl p-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Investor Details</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
        <div><strong>Investor Name:</strong> {{ $investor->investor_name }}</div>
        <div><strong>Company:</strong> {{ $investor->company_name ?? '—' }}</div>
        <div><strong>Email:</strong> {{ $investor->email ?? '—' }}</div>
        <div><strong>Phone No:</strong> {{ $investor->phone ?? '—' }}</div>
        <div><strong>Investment Focus:</strong> {{ $investor->investment_focus ?? '—' }}</div>
        <div><strong>Capacity:</strong> ₹{{ number_format($investor->investment_capacity,2) ?? '—' }}</div>
        <div><strong>Status:</strong> <span class="font-semibold capitalize">{{ $investor->status }}</span></div>
        <div><strong>City:</strong> {{ $investor->city ?? '—' }}</div>
        <div class="md:col-span-2"><strong>Notes:</strong> <p class="mt-1 text-gray-700">{{ $investor->notes ?? '—' }}</p></div>
    </div>

    <div class="mt-8 flex justify-end gap-3">
        <a href="{{ route('member.investors.edit', $investor) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium">Edit</a>
        <a href="{{ route('member.investors.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-medium">Back</a>
    </div>
</div>
@endsection
