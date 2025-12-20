@extends('layouts.app')
@section('title', 'Edit Invitation')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow">

    <h2 class="text-xl font-semibold mb-6 text-red-700 flex items-center gap-2">
        <i data-feather="edit"></i> Edit Invitation
    </h2>

    <form method="POST"
          action="{{ route('admin.invitations.update', $invitation) }}"
          class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium">Guest Name *</label>
            <input type="text" name="guest_name"
                   value="{{ $invitation->guest_name }}"
                   class="w-full border rounded-lg px-3 py-2 focus:ring-red-500">
        </div>

        <div>
            <label class="block text-sm font-medium">Guest Email *</label>
            <input type="email" name="guest_email"
                   value="{{ $invitation->guest_email }}"
                   class="w-full border rounded-lg px-3 py-2 focus:ring-red-500">
        </div>

        <div>
            <label class="block text-sm font-medium">Status</label>
            <select name="status" class="w-full border rounded-lg px-3 py-2 focus:ring-red-500">
                @foreach(['invited','accepted','attended','declined'] as $status)
                    <option value="{{ $status }}"
                        @selected($status === $invitation->status)>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('admin.invitations.index') }}"
               class="px-4 py-2 bg-gray-100 rounded-lg">
                Cancel
            </a>

            <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg">
                Update Invitation
            </button>
        </div>
    </form>
</div>
@endsection
