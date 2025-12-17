@extends('layouts.app')

@section('content')
<style>
/* Modern Button Style */
button {
    transition: all 0.25s ease;
}
button:hover {
    transform: translateY(-2px);
}

/* INPUTS */
input,
select,
textarea {
    transition: all .2s ease-in-out;
}

input:focus,
select:focus,
textarea:focus {
    border-color: #e11d48 !important;
    box-shadow: 0 0 0 3px rgba(225,29,72,0.25);
    outline: none;
}
</style>

<div class="max-w-4xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">
  <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Meetup</h2>

  @if($errors->any())
    <div class="bg-red-50 text-red-600 p-4 rounded mb-4">
      <ul class="list-disc list-inside text-sm">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.meetups.update', $meetup->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
    @csrf
    @method('PUT')

    {{-- Title --}}
    <div>
      <label class="block text-gray-700 font-medium">Title <span class="text-red-500">*</span></label>
      <input type="text" name="title" value="{{ old('title', $meetup->title) }}" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2" required>
    </div>

    {{-- Short Description --}}
    <div>
      <label class="block text-gray-700 font-medium">Short Description</label>
      <textarea name="short_description" rows="2" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">{{ old('short_description', $meetup->short_description) }}</textarea>
    </div>

    {{-- Description --}}
    <div>
      <label class="block text-gray-700 font-medium">Description</label>
      <textarea name="description" rows="6" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">{{ old('description', $meetup->description) }}</textarea>
    </div>

    {{-- Event Date, City, Venue --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label class="block text-gray-700 font-medium">Event Date</label>
        <input type="date" name="event_date" value="{{ old('event_date', $meetup->event_date) }}" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
      </div>

      <div>
        <label class="block text-gray-700 font-medium">City</label>
        <input type="text" name="city" value="{{ old('city', $meetup->city) }}" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
      </div>

      <div>
        <label class="block text-gray-700 font-medium">Venue Name</label>
        <input type="text" name="venue_name" value="{{ old('venue_name', $meetup->venue_name) }}" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
      </div>
    </div>

    {{-- Timing --}}
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-gray-700 font-medium">Start Time</label>
        <input type="time" name="start_time" value="{{ old('start_time', $meetup->start_time) }}" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
      </div>

      <div>
        <label class="block text-gray-700 font-medium">End Time</label>
        <input type="time" name="end_time" value="{{ old('end_time', $meetup->end_time) }}" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
      </div>
    </div>

    {{-- Status --}}
    <div>
      <label class="block text-gray-700 font-medium">Status</label>
      <select name="status" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
        <option value="draft" {{ $meetup->status == 'draft' ? 'selected' : '' }}>Draft</option>
        <option value="upcoming" {{ $meetup->status == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
        <option value="ongoing" {{ $meetup->status == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
        <option value="completed" {{ $meetup->status == 'completed' ? 'selected' : '' }}>Completed</option>
        <option value="cancelled" {{ $meetup->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
      </select>
    </div>

    {{-- Banner Image --}}
    <div>
      <label class="block text-gray-700 font-medium">Banner</label>
      @if($meetup->banner)
        <div class="mb-3">
          <img src="{{ asset('storage/'.$meetup->banner) }}" alt="Banner" class="w-full h-40 object-cover rounded-lg border">
        </div>
      @endif
      <input type="file" name="banner" accept="image/*" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
    </div>

    {{-- Thumbnail Image --}}
    <div>
      <label class="block text-gray-700 font-medium">Thumbnail</label>
      @if($meetup->thumbnail)
        <div class="mb-3">
          <img src="{{ asset('storage/'.$meetup->thumbnail) }}" alt="Thumbnail" class="w-32 h-32 object-cover rounded-lg border">
        </div>
      @endif
      <input type="file" name="thumbnail" accept="image/*" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
    </div>

    {{-- Feature + Active Toggles --}}
    <div class="flex flex-wrap gap-6">
      <label class="inline-flex items-center">
        <input type="checkbox" name="is_featured" {{ $meetup->is_featured ? 'checked' : '' }} class="h-4 w-4 text-[#CF2031]">
        <span class="ml-2 text-gray-700">Featured Event</span>
      </label>

      <label class="inline-flex items-center">
        <input type="checkbox" name="is_public" {{ $meetup->is_public ? 'checked' : '' }} class="h-4 w-4 text-[#CF2031]">
        <span class="ml-2 text-gray-700">Public Event</span>
      </label>

      <label class="inline-flex items-center">
        <input type="checkbox" name="is_active" {{ $meetup->is_active ? 'checked' : '' }} class="h-4 w-4 text-[#CF2031]">
        <span class="ml-2 text-gray-700">Active</span>
      </label>
    </div>

    {{-- Buttons --}}
    <div class="pt-4 flex justify-end space-x-3">
      <a href="{{ route('admin.meetups.index') }}" class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200 text-gray-700">Cancel</a>
      <button type="submit" class="px-4 py-2 rounded bg-[#CF2031] hover:bg-[#b81b2a] text-white">Update</button>
    </div>
  </form>
</div>
@endsection
