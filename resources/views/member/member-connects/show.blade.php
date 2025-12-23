@extends('layouts.app')
@section('title', 'View Business Connect')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

    {{-- ==== HEADER ==== --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500
                text-white rounded-2xl px-8 py-6
                flex flex-col md:flex-row md:items-center md:justify-between
                shadow-lg">

        <div>
            <h2 class="text-3xl font-semibold">Business Connect Details</h2>
            <p class="text-sm text-white/80 mt-1">
                View professional connection information
            </p>
        </div>

        <a href="{{ route('member.connects.index') }}"
           class="mt-4 md:mt-0 inline-flex items-center gap-2
                  bg-white text-red-600 px-5 py-2.5
                  rounded-xl font-medium shadow hover:bg-gray-100 transition">
            ← Back
        </a>
    </div>

    {{-- ==== DETAILS CARD ==== --}}
    <div class="bg-white rounded-2xl shadow border border-gray-100 p-8">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">

            @php
                $fields = [
                    'Person Name' => $memberConnect->person_name,
                    'Designation' => $memberConnect->designation,
                    'Company Name' => $memberConnect->company_name,
                    'Industry' => $memberConnect->industry,
                    'Profession' => $memberConnect->profession,
                    'Website' => $memberConnect->website,
                    'Phone' => $memberConnect->contact_phone,
                    'Email' => $memberConnect->contact_email,
                ];
            @endphp

            @foreach($fields as $label => $value)
                <div>
                    <p class="text-gray-500">{{ $label }}</p>
                    <p class="font-medium text-gray-900">
                        {{ $value ?: '—' }}
                    </p>
                </div>
            @endforeach

            <div class="md:col-span-2">
                <p class="text-gray-500">Services</p>
                <p class="font-medium text-gray-900 whitespace-pre-line">
                    {{ $memberConnect->services ?: '—' }}
                </p>
            </div>
        </div>

        {{-- ACTIONS --}}
        @if(auth()->id() === $memberConnect->user_id)
        <div class="mt-8 flex justify-end gap-3">
            <a href="{{ route('member.connects.edit', $memberConnect) }}"
               class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-xl font-medium shadow">
                Edit
            </a>
        </div>
        @endif

    </div>
</div>
@endsection
