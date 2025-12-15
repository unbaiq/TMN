@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-4 space-y-6">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 text-white rounded-2xl px-8 py-6 shadow-lg">
        <h2 class="text-2xl font-semibold">Add CSR Activity</h2>
        <p class="text-sm text-white/80 mt-1">Record your social contribution or volunteering initiative.</p>
    </div>

    <form method="POST" action="{{ route('member.csrs.store') }}" enctype="multipart/form-data"
          class="bg-white border border-gray-200 shadow rounded-2xl p-8 space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700">Title *</label>
            <input type="text" name="csr_title" required class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-1 focus:ring-red-600">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">CSR Type *</label>
            <select name="csr_type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-1 focus:ring-red-600">
                @foreach(['donation'=>'Donation','volunteering'=>'Volunteering','education'=>'Education','environment'=>'Environment','health'=>'Health','charity'=>'Charity','community_support'=>'Community Support','other'=>'Other'] as $key=>$label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="csr_description" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-1 focus:ring-red-600"></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Date</label>
                <input type="date" name="csr_date" class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-1 focus:ring-red-600">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Location</label>
                <input type="text" name="location" placeholder="City or Venue" class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-1 focus:ring-red-600">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Amount Spent (₹)</label>
                <input type="number" step="0.01" name="amount_spent" class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-1 focus:ring-red-600">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Volunteer Hours</label>
                <input type="number" name="volunteer_hours" class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-1 focus:ring-red-600">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Beneficiaries Count</label>
                <input type="number" name="beneficiaries_count" class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-1 focus:ring-red-600">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Proof Document (optional)</label>
            <input type="file" name="proof_document" class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium">Submit CSR</button>
        </div>
    </form>
</div>
@endsection
