@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-8">

    <div class="bg-white rounded-2xl shadow p-6 space-y-6">

        {{-- HEADER --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">
                    Update Consultation Status
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Change the current status of this consultation request.
                </p>
            </div>

            <a href="{{ route('admin.consultation-requests.index') }}"
               class="text-sm text-gray-600 hover:text-red-600 font-medium">
                ← Back
            </a>
        </div>

        {{-- DETAILS --}}
        <div class="bg-gray-50 rounded-lg p-4 text-sm">
            <p><strong>Name:</strong> {{ $consultationRequest->first_name }} {{ $consultationRequest->last_name }}</p>
            <p><strong>Email:</strong> {{ $consultationRequest->email }}</p>
            <p><strong>Phone:</strong> {{ $consultationRequest->phone }}</p>
        </div>

        {{-- FORM --}}
        <form method="POST"
              action="{{ route('admin.consultation-request.update', $consultationRequest) }}"
              class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Status
                </label>
                <select name="status"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-red-500 focus:border-red-500">
                    <option value="new" @selected($consultationRequest->status === 'new')>
                        New
                    </option>
                    <option value="contacted" @selected($consultationRequest->status === 'contacted')>
                        Contacted
                    </option>
                    <option value="closed" @selected($consultationRequest->status === 'closed')>
                        Closed
                    </option>
                </select>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white
                               px-6 py-2.5 rounded-lg font-medium shadow transition">
                    Update Status
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
