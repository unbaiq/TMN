@extends('layouts.app')
@section('title', 'Create Invitation')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow">

    <h2 class="text-xl font-semibold mb-6 text-red-700 flex items-center gap-2">
        <i data-feather="user-plus"></i> Create Invitation
    </h2>
@if ($errors->any())
    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">
        <ul class="list-disc list-inside text-sm text-red-700">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form method="POST" action="{{ route('admin.invitations.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium">Event *</label>
            <select name="event_id" class="w-full border rounded-lg px-3 py-2 focus:ring-red-500">
                @foreach($events as $event)
                    <option value="{{ $event->id }}">{{ $event->title }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium">Inviter *</label>
            <select name="inviter_id" class="w-full border rounded-lg px-3 py-2 focus:ring-red-500">
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium">Guest Name *</label>
            <input type="text" name="guest_name"
                   class="w-full border rounded-lg px-3 py-2 focus:ring-red-500">
        </div>

        <div>
            <label class="block text-sm font-medium">Guest Email *</label>
            <input type="email" name="guest_email"
                   class="w-full border rounded-lg px-3 py-2 focus:ring-red-500">
        </div>

        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('admin.invitations.index') }}"
               class="px-4 py-2 bg-gray-100 rounded-lg">
                Cancel
            </a>

           <button type="submit"
        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg">
    Save Invitation
</button>

        </div>
    </form>
</div>
@endsection
