@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-4 space-y-6">

    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 text-white rounded-2xl px-8 py-6 shadow-lg">
        <h2 class="text-2xl font-semibold">Edit CSR Record</h2>
        <p class="text-sm text-white/80 mt-1">Update your community initiative details.</p>
    </div>

    <form method="POST" action="{{ route('member.csrs.update', $csr) }}" enctype="multipart/form-data"
          class="bg-white border border-gray-200 shadow rounded-2xl p-8 space-y-6">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700">Title *</label>
            <input type="text" name="csr_title" value="{{ old('csr_title', $csr->csr_title) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-1 focus:ring-red-600">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Type *</label>
            <select name="csr_type" class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-1 focus:ring-red-600">
                @foreach(['donation','volunteering','education','environment','health','charity','community_support','other'] as $type)
                    <option value="{{ $type }}" {{ $csr->csr_type==$type?'selected':'' }}>{{ ucfirst($type) }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="csr_description" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">{{ old('csr_description',$csr->csr_description) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Date</label>
                <input type="date" name="csr_date" value="{{ $csr->csr_date }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Location</label>
                <input type="text" name="location" value="{{ $csr->location }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Proof Document</label>
            <input type="file" name="proof_document" class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">
            @if($csr->proof_document)
                <p class="text-sm mt-2"><a href="{{ asset('storage/'.$csr->proof_document) }}" target="_blank" class="text-blue-600 underline">View existing proof</a></p>
            @endif
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium">Update CSR</button>
        </div>
    </form>
</div>
@endsection
