@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-4 space-y-6">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 text-white rounded-2xl px-8 py-6 shadow-lg">
        <h2 class="text-2xl font-semibold">Edit CSR Record</h2>
        <p class="text-sm text-white/80 mt-1">
            Update your community initiative details.
        </p>
    </div>

    {{-- FORM --}}
    <form method="POST"
          action="{{ route('member.csrs.update', $csr) }}"
          enctype="multipart/form-data"
          class="bg-white border border-gray-200 shadow rounded-2xl p-8 space-y-6">

        @csrf
        @method('PUT')

        {{-- TITLE --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">
                Title <span class="text-red-600">*</span>
            </label>
            <input type="text"
                   name="csr_title"
                   value="{{ old('csr_title', $csr->csr_title) }}"
                   required
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1
                          focus:ring-1 focus:ring-red-600 focus:border-red-600">
        </div>

        {{-- TYPE --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">
                Type <span class="text-red-600">*</span>
            </label>
            <select name="csr_type"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1
                           focus:ring-1 focus:ring-red-600 focus:border-red-600">
                @foreach([
                    'donation',
                    'volunteering',
                    'education',
                    'environment',
                    'health',
                    'charity',
                    'community_support',
                    'other'
                ] as $type)
                    <option value="{{ $type }}"
                        {{ old('csr_type', $csr->csr_type) === $type ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_',' ', $type)) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- DESCRIPTION --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">
                Description
            </label>
            <textarea name="csr_description"
                      rows="4"
                      class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1
                             focus:ring-1 focus:ring-red-600 focus:border-red-600">{{ old('csr_description', $csr->csr_description) }}</textarea>
        </div>

        {{-- DATE & LOCATION --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Date
                </label>
                <input type="date"
                       name="csr_date"
                       value="{{ old('csr_date', $csr->csr_date) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1
                              focus:ring-1 focus:ring-red-600 focus:border-red-600">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Location
                </label>
                <input type="text"
                       name="location"
                       value="{{ old('location', $csr->location) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1
                              focus:ring-1 focus:ring-red-600 focus:border-red-600">
            </div>
        </div>

        {{-- STATUS --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">
                Status
            </label>
            <select name="status"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1
                           focus:ring-1 focus:ring-red-600 focus:border-red-600">
                @foreach(['pending','approved','rejected'] as $status)
                    <option value="{{ $status }}"
                        {{ old('status', $csr->status) === $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- VISIBILITY --}}
        <div class="flex items-center gap-3">
            <input type="checkbox"
                   name="is_public"
                   value="1"
                   {{ old('is_public', $csr->is_public) ? 'checked' : '' }}
                   class="h-4 w-4 text-red-600 border-gray-300 rounded focus:ring-red-600">
            <label class="text-sm font-medium text-gray-700">
                Make this CSR visible to others
            </label>
        </div>

        {{-- PROOF DOCUMENT --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">
                Proof Document
            </label>
            <input type="file"
                   name="proof_document"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">

            @if($csr->proof_document)
                <p class="text-sm mt-2">
                    <a href="{{ asset('storage/'.$csr->proof_document) }}"
                       target="_blank"
                       class="text-blue-600 underline">
                        View existing proof
                    </a>
                </p>
            @endif
        </div>

        {{-- ACTIONS --}}
        <div class="flex justify-end gap-3 pt-4 border-t">
            <a href="{{ route('member.csrs.index') }}"
               class="px-5 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700">
                Cancel
            </a>

            <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium shadow">
                Update CSR
            </button>
        </div>

    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (window.feather) feather.replace();
});
</script>
@endsection
