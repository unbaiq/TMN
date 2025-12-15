@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">
  <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Consultation</h2>

  <form action="{{ route('admin.consultations.update', $consultation->id) }}" method="POST" class="space-y-5">
    @csrf
    @method('PUT')

    <div>
      <label class="block text-gray-700 font-medium">Title <span class="text-red-500">*</span></label>
      <input type="text" name="title" value="{{ old('title', $consultation->title) }}" class="w-full border rounded px-3 py-2" required>
    </div>

    <div>
      <label class="block text-gray-700 font-medium">Type</label>
      <input name="type" value="{{ old('type', $consultation->type) }}" class="w-full border rounded px-3 py-2">
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-gray-700 font-medium">Consultation Date</label>
        <input type="date" name="consultation_date" value="{{ old('consultation_date', $consultation->consultation_date) }}" class="w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block text-gray-700 font-medium">Mode</label>
        <select name="mode" class="w-full border rounded px-3 py-2">
          <option value="online" {{ $consultation->mode == 'online' ? 'selected' : '' }}>Online</option>
          <option value="offline" {{ $consultation->mode == 'offline' ? 'selected' : '' }}>Offline</option>
          <option value="hybrid" {{ $consultation->mode == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
        </select>
      </div>
    </div>

    <div>
      <label class="block text-gray-700 font-medium">Meeting Link / Venue</label>
      <input name="meeting_link" value="{{ old('meeting_link', $consultation->meeting_link) }}" class="w-full border rounded px-3 py-2">
    </div>

    <div>
      <label class="block text-gray-700 font-medium">Consultant Name</label>
      <input name="consultant_name" value="{{ old('consultant_name', $consultation->consultant_name) }}" class="w-full border rounded px-3 py-2">
    </div>

    <div>
      <label class="block text-gray-700 font-medium">Client Name</label>
      <input name="client_name" value="{{ old('client_name', $consultation->client_name) }}" class="w-full border rounded px-3 py-2">
    </div>

    <div>
      <label class="block text-gray-700 font-medium">Status</label>
      <select name="status" class="w-full border rounded px-3 py-2">
        <option value="scheduled" {{ $consultation->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
        <option value="completed" {{ $consultation->status == 'completed' ? 'selected' : '' }}>Completed</option>
        <option value="cancelled" {{ $consultation->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        <option value="rescheduled" {{ $consultation->status == 'rescheduled' ? 'selected' : '' }}>Rescheduled</option>
      </select>
    </div>

    <div class="flex flex-wrap gap-6">
      <label class="inline-flex items-center">
        <input type="checkbox" name="is_featured" {{ $consultation->is_featured ? 'checked' : '' }} class="h-4 w-4 text-[#CF2031]">
        <span class="ml-2 text-gray-700">Featured</span>
      </label>

      <label class="inline-flex items-center">
        <input type="checkbox" name="is_active" {{ $consultation->is_active ? 'checked' : '' }} class="h-4 w-4 text-[#CF2031]">
        <span class="ml-2 text-gray-700">Active</span>
      </label>
    </div>

    <div class="pt-4 flex justify-end space-x-3">
      <a href="{{ route('admin.consultations.index') }}" class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200 text-gray-700">Cancel</a>
      <button type="submit" class="px-4 py-2 rounded bg-[#CF2031] hover:bg-[#b81b2a] text-white">Update</button>
    </div>
  </form>
</div>
@endsection
