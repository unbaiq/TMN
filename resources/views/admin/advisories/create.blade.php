@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">
  <h2 class="text-2xl font-semibold text-gray-800 mb-6">Add New Advisory</h2>

  <form action="{{ route('admin.advisories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
    @csrf

    <div>
      <label class="block text-gray-700 font-medium">Title <span class="text-red-500">*</span></label>
      <input name="title" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2" required>
    </div>

    <div>
      <label class="block text-gray-700 font-medium">Advisor Name</label>
      <input name="advisor_name" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-gray-700 font-medium">Category</label>
        <input name="category" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
      </div>
      <div>
        <label class="block text-gray-700 font-medium">Type</label>
        <input name="type" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
      </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-gray-700 font-medium">Session Date</label>
        <input type="date" name="session_date" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
      </div>
      <div>
        <label class="block text-gray-700 font-medium">Mode</label>
        <select name="mode" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
          <option value="online">Online</option>
          <option value="offline">Offline</option>
          <option value="hybrid">Hybrid</option>
        </select>
      </div>
    </div>

    <div>
      <label class="block text-gray-700 font-medium">Venue</label>
      <input name="venue" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
    </div>

    <div>
      <label class="block text-gray-700 font-medium">Banner</label>
      <input type="file" name="banner" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
    </div>

    <div>
      <label class="block text-gray-700 font-medium">Thumbnail</label>
      <input type="file" name="thumbnail" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
    </div>

    <div>
      <label class="block text-gray-700 font-medium">Status</label>
      <select name="status" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
        <option value="scheduled">Scheduled</option>
        <option value="ongoing">Ongoing</option>
        <option value="completed">Completed</option>
        <option value="cancelled">Cancelled</option>
      </select>
    </div>

    <div class="pt-4 flex justify-end space-x-3">
      <a href="{{ route('admin.advisories.index') }}" class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200 text-gray-700">Cancel</a>
      <button type="submit" class="px-4 py-2 rounded bg-[#CF2031] hover:bg-[#b81b2a] text-white">Create</button>
    </div>
  </form>
</div>
@endsection
