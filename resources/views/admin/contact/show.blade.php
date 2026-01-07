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

        <div class="grid md:grid-cols-2 gap-6">
            <p><strong>Name:</strong> {{ $contactQuery->name }}</p>
            <p><strong>Email:</strong> {{ $contactQuery->email }}</p>
            <p><strong>Phone:</strong> {{ $contactQuery->phone ?? '-' }}</p>
            <p><strong>Status:</strong>
                <span class="font-semibold text-red-600">
                    {{ ucfirst(str_replace('_',' ', $contactQuery->status)) }}
                </span>
            </p>
        </div>

        <div>
            <h4 class="font-semibold mb-2">Message</h4>
            <p class="text-gray-700 leading-relaxed">
                {{ $contactQuery->message }}
            </p>
        </div>

        <div class="flex gap-4">
            <a href="{{ route('admin.contact.edit', $contactQuery) }}"
               class="bg-green-600 text-white px-6 py-2 rounded-xl">
                Edit
            </a>

            <form method="POST" action="{{ route('admin.contact.destroy', $contactQuery) }}"
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
