@extends('layouts.app')
@section('title', 'Add Connect')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow border">

    <h2 class="text-xl font-bold mb-4">➕ Add Business Connect</h2>

    {{-- ERROR DISPLAY --}}
    @if ($errors->any())
        <div class="mb-4 bg-red-50 p-3 rounded text-sm text-red-700">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('member.connects.store') }}">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div>
                <label>Person Name *</label>
                <input name="person_name" required class="w-full border px-3 py-2">
            </div>

            <div>
                <label>Designation</label>
                <input name="designation" class="w-full border px-3 py-2">
            </div>

            <div>
                <label>Company Name *</label>
                <input name="company_name" required class="w-full border px-3 py-2">
            </div>

            <div>
                <label>Industry *</label>
                <input name="industry" required class="w-full border px-3 py-2">
            </div>

            <div>
                <label>Profession *</label>
                <input name="profession" required class="w-full border px-3 py-2">
            </div>

            <div>
                <label>Website</label>
                <input name="website" class="w-full border px-3 py-2">
            </div>

            <div>
                <label>Phone</label>
                <input name="contact_phone" class="w-full border px-3 py-2">
            </div>

            <div>
                <label>Email</label>
                <input name="contact_email" class="w-full border px-3 py-2">
            </div>

            <div class="md:col-span-2">
                <label>Services</label>
                <textarea name="services" class="w-full border px-3 py-2"></textarea>
            </div>

        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded">
                Save Connect
            </button>
        </div>

    </form>
</div>
@endsection
