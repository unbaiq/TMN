@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-8">

    <div class="bg-white rounded-2xl shadow p-6 space-y-6">

        {{-- HEADER --}}
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-900">
                Consultation Request Details
            </h2>

            <a href="{{ route('admin.consultation-requests.index') }}"
               class="text-sm text-red-600 hover:underline">
                ← Back
            </a>
        </div>

        {{-- DETAILS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">

            <div>
                <label class="text-gray-500">First Name</label>
                <div class="font-medium">{{ $consultationRequest->first_name }}</div>
            </div>

            <div>
                <label class="text-gray-500">Last Name</label>
                <div class="font-medium">{{ $consultationRequest->last_name }}</div>
            </div>

            <div>
                <label class="text-gray-500">Email</label>
                <div class="font-medium">{{ $consultationRequest->email }}</div>
            </div>

            <div>
                <label class="text-gray-500">Phone</label>
                <div class="font-medium">{{ $consultationRequest->phone }}</div>
            </div>

            <div>
                <label class="text-gray-500">City</label>
                <div class="font-medium">{{ $consultationRequest->city ?? '—' }}</div>
            </div>

            <div>
                <label class="text-gray-500">Zip Code</label>
                <div class="font-medium">{{ $consultationRequest->zip_code ?? '—' }}</div>
            </div>

        </div>

        {{-- ACTION --}}
        <div class="pt-4 text-right">
            <form method="POST"
                  action="{{ route('admin.consultation-requests.destroy', $consultationRequest) }}"
                  onsubmit="return confirm('Delete this request?')">
                @csrf
                @method('DELETE')

                <button class="bg-red-600 hover:bg-red-700 text-white
                               px-5 py-2 rounded-lg text-sm font-medium">
                    Delete Request
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
