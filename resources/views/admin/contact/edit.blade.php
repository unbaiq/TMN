@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-8 space-y-6">

    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-semibold">Edit Contact Query</h2>

        <a href="{{ route('admin.contact.index') }}"
           class="bg-gray-100 px-4 py-2 rounded-xl">
            ← Back
        </a>
    </div>

    <form method="POST"
          action="{{ route('admin.contact.update', $contact) }}"
          class="bg-white rounded-2xl shadow p-8 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="text-sm font-medium">Name</label>
                <input type="text"
                       value="{{ $contact->name }}"
                       disabled
                       class="w-full mt-1 border rounded-xl px-4 py-2 bg-gray-100">
            </div>

            <div>
                <label class="text-sm font-medium">Email</label>
                <input type="text"
                       value="{{ $contact->email }}"
                       disabled
                       class="w-full mt-1 border rounded-xl px-4 py-2 bg-gray-100">
            </div>
        </div>

        <div>
            <label class="text-sm font-medium">Status</label>
            <select name="status"
                    class="w-full mt-1 border rounded-xl px-4 py-2">
                @foreach(['new','in_progress','resolved','closed'] as $status)
                    <option value="{{ $status }}"
                        @selected($contact->status === $status)>
                        {{ ucfirst(str_replace('_',' ', $status)) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-sm font-medium">Message</label>
            <textarea rows="5"
                      disabled
                      class="w-full mt-1 border rounded-xl px-4 py-2 bg-gray-100">{{ $contact->message }}</textarea>
        </div>

        <div class="flex justify-end pt-4">
            <button class="bg-red-600 text-white px-6 py-3 rounded-xl font-semibold">
                Update Status
            </button>
        </div>

    </form>
</div>
@endsection
