@extends('layouts.app')
@section('title', 'Edit Business Connect')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

    {{-- ==== HEADER ==== --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500
                text-white rounded-2xl px-8 py-6
                flex flex-col md:flex-row md:items-center md:justify-between
                shadow-lg">

        <div>
            <h2 class="text-3xl font-semibold">Edit Business Connect</h2>
            <p class="text-sm text-white/80 mt-1">
                Update professional connection details
            </p>
        </div>

        <a href="{{ route('member.connects.index') }}"
           class="mt-4 md:mt-0 inline-flex items-center gap-2
                  bg-white text-red-600 px-5 py-2.5
                  rounded-xl font-medium shadow hover:bg-gray-100 transition">
            ← Back
        </a>
    </div>

    {{-- ==== FORM CARD ==== --}}
    <div class="bg-white rounded-2xl shadow border border-gray-100 p-8">

        {{-- ERRORS --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('member.connects.update', $memberConnect) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="text-sm font-medium text-gray-700">Person Name *</label>
                    <input name="person_name" required
                           value="{{ old('person_name', $memberConnect->person_name) }}"
                           class="mt-1 w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Designation</label>
                    <input name="designation"
                           value="{{ old('designation', $memberConnect->designation) }}"
                           class="mt-1 w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Company Name *</label>
                    <input name="company_name" required
                           value="{{ old('company_name', $memberConnect->company_name) }}"
                           class="mt-1 w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Industry *</label>
                    <input name="industry" required
                           value="{{ old('industry', $memberConnect->industry) }}"
                           class="mt-1 w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Profession *</label>
                    <input name="profession" required
                           value="{{ old('profession', $memberConnect->profession) }}"
                           class="mt-1 w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Website</label>
                    <input name="website"
                           value="{{ old('website', $memberConnect->website) }}"
                           class="mt-1 w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Phone</label>
                    <input name="contact_phone"
                           value="{{ old('contact_phone', $memberConnect->contact_phone) }}"
                           class="mt-1 w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Email</label>
                    <input name="contact_email"
                           value="{{ old('contact_email', $memberConnect->contact_email) }}"
                           class="mt-1 w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500">
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm font-medium text-gray-700">Services</label>
                    <textarea name="services" rows="4"
                              class="mt-1 w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500">
                        {{ old('services', $memberConnect->services) }}
                    </textarea>
                </div>

            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-xl font-medium shadow">
                    Update Connect
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
