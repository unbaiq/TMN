@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-8 space-y-6">

    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-semibold">Contact Query Details</h2>

        <a href="{{ route('admin.contact.index') }}"
           class="bg-gray-100 px-4 py-2 rounded-xl">
            ← Back
        </a>
    </div>

<div class="bg-white rounded-2xl shadow p-8 space-y-6">

    {{-- DETAILS --}}
    <div class="grid md:grid-cols-2 gap-6">
        <p><strong>Name:</strong> {{ $contact->name }}</p>
        <p><strong>Email:</strong> {{ $contact->email }}</p>
        <p><strong>Phone:</strong> {{ $contact->phone ?? '-' }}</p>
    </div>

    {{-- MESSAGE --}}
    <div>
        <h4 class="font-semibold mb-2">Message</h4>
        <p class="text-gray-700 leading-relaxed">
            {{ $contact->message }}
        </p>
    </div>

    {{-- STATUS UPDATE FORM --}}
    <form method="POST"
          action="{{ route('admin.contact.update', $contact) }}"
          class="flex flex-wrap items-center gap-4 bg-gray-50 p-4 rounded-xl">

        @csrf
        @method('PUT')

        <label class="font-semibold">Status:</label>

        <select name="status"
                class="border rounded-lg px-4 py-2">
            @foreach(['new','in_progress','resolved','closed'] as $status)
                <option value="{{ $status }}"
                        @selected($contact->status === $status)>
                    {{ ucfirst(str_replace('_',' ', $status)) }}
                </option>
            @endforeach
        </select>

        <button class="bg-red-600 text-white px-6 py-2 rounded-lg">
            Update Status
        </button>
    </form>

    {{-- ACTIONS --}}
    <div class="flex gap-4 pt-4">
        <a href="{{ route('admin.contact.index') }}"
           class="bg-gray-100 px-6 py-2 rounded-xl">
            ← Back
        </a>

        <form method="POST"
              action="{{ route('admin.contact.destroy', $contact) }}"
              onsubmit="return confirm('Delete this query?')">
            @csrf
            @method('DELETE')
            <button class="bg-red-600 text-white px-6 py-2 rounded-xl">
                Delete
            </button>
        </form>
    </div>

</div>

</div>
@endsection
