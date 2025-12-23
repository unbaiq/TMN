@extends('layouts.app')

@section('title', 'Add Investor')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6 space-y-6">

    {{-- ==== HEADER ==== --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500
                rounded-2xl shadow-2xl px-10 py-8
                flex flex-col md:flex-row md:items-center md:justify-between
                text-white">

        <div>
            <h2 class="text-3xl font-semibold tracking-tight">
                Add New Investor
            </h2>
            <p class="text-white/80 text-sm mt-1 max-w-xl">
                Capture investor details, investment focus, and funding capacity.
            </p>
        </div>

        <a href="{{ route('member.investors.index') }}"
           class="mt-4 md:mt-0 inline-flex items-center gap-2
                  bg-white text-red-600 px-5 py-2.5
                  rounded-xl font-medium shadow
                  hover:bg-gray-100 transition">
            <i data-feather="arrow-left" class="w-4 h-4"></i>
            Back
        </a>
    </div>

    {{-- ==== FORM CARD ==== --}}
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">

        {{-- ERROR DISPLAY --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('member.investors.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="text-sm font-medium text-gray-600">Investor Name *</label>
                    <input type="text" name="investor_name" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2
                                  focus:ring-1 focus:ring-red-600 focus:border-red-600">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-600">Company Name</label>
                    <input type="text" name="company_name"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2
                                  focus:ring-1 focus:ring-red-600 focus:border-red-600">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-600">Email</label>
                    <input type="email" name="email"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2
                                  focus:ring-1 focus:ring-red-600 focus:border-red-600">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-600">Phone</label>
                    <input type="text" name="phone"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2
                                  focus:ring-1 focus:ring-red-600 focus:border-red-600">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-600">City</label>
                    <input type="text" name="city" placeholder="e.g. Delhi, Mumbai, Noida"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2
                                  focus:ring-1 focus:ring-red-600 focus:border-red-600">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-600">Investment Focus</label>
                    <input type="text" name="investment_focus"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2
                                  focus:ring-1 focus:ring-red-600 focus:border-red-600">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-600">Investment Capacity (₹)</label>
                    <input type="number" step="0.01" name="investment_capacity"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2
                                  focus:ring-1 focus:ring-red-600 focus:border-red-600">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-600">Status</label>
                    <select name="status"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2
                                   focus:ring-1 focus:ring-red-600 focus:border-red-600">
                        <option value="potential">Potential</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm font-medium text-gray-600">Notes</label>
                    <textarea name="notes" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2
                                     focus:ring-1 focus:ring-red-600 focus:border-red-600"></textarea>
                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="mt-8 flex justify-end">
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white
                               px-6 py-2.5 rounded-xl font-medium shadow transition">
                    Save Investor
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
