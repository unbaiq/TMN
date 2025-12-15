@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">
  <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Sponsor</h2>

  @if($errors->any())
    <div class="bg-red-50 text-red-600 p-4 rounded mb-4">
      <ul class="list-disc list-inside text-sm">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.sponsors.update', $sponsor->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
    @csrf
    @method('PUT')

    {{-- Name --}}
    <div>
      <label class="block text-gray-700 font-medium">Name <span class="text-red-500">*</span></label>
      <input type="text" name="name" value="{{ old('name', $sponsor->name) }}" class="w-full border rounded px-3 py-2" required>
    </div>

    {{-- Company Name --}}
    <div>
      <label class="block text-gray-700 font-medium">Company Name</label>
      <input type="text" name="company_name" value="{{ old('company_name', $sponsor->company_name) }}" class="w-full border rounded px-3 py-2">
    </div>

    {{-- Sponsor Type & Level --}}
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-gray-700 font-medium">Sponsor Type</label>
        <select name="sponsor_type" class="w-full border rounded px-3 py-2">
          @foreach(['event', 'chapter', 'network', 'brand'] as $type)
            <option value="{{ $type }}" {{ $sponsor->sponsor_type == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-gray-700 font-medium">Sponsorship Level</label>
        <select name="sponsorship_level" class="w-full border rounded px-3 py-2">
          @foreach(['platinum', 'gold', 'silver', 'bronze'] as $level)
            <option value="{{ $level }}" {{ $sponsor->sponsorship_level == $level ? 'selected' : '' }}>{{ ucfirst($level) }}</option>
          @endforeach
        </select>
      </div>
    </div>

    {{-- About --}}
    <div>
      <label class="block text-gray-700 font-medium">About</label>
      <textarea name="about" rows="4" class="w-full border rounded px-3 py-2">{{ old('about', $sponsor->about) }}</textarea>
    </div>

    {{-- Logo --}}
    <div>
      <label class="block text-gray-700 font-medium">Logo</label>
      @if($sponsor->logo)
        <div class="mb-3">
          <img src="{{ asset('storage/'.$sponsor->logo) }}" class="w-32 h-32 object-cover rounded-lg border">
        </div>
      @endif
      <input type="file" name="logo" class="w-full border rounded px-3 py-2">
    </div>

    {{-- Banner --}}
    <div>
      <label class="block text-gray-700 font-medium">Banner</label>
      @if($sponsor->banner)
        <div class="mb-3">
          <img src="{{ asset('storage/'.$sponsor->banner) }}" class="w-full h-48 object-cover rounded-lg border">
        </div>
      @endif
      <input type="file" name="banner" class="w-full border rounded px-3 py-2">
    </div>

    {{-- Status --}}
    <div>
      <label class="block text-gray-700 font-medium">Status</label>
      <select name="status" class="w-full border rounded px-3 py-2">
        @foreach(['pending', 'approved', 'rejected', 'expired'] as $status)
          <option value="{{ $status }}" {{ $sponsor->status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
        @endforeach
      </select>
    </div>

    {{-- Active & Featured --}}
    <div class="flex flex-wrap gap-6">
      <label class="inline-flex items-center">
        <input type="checkbox" name="is_featured" {{ $sponsor->is_featured ? 'checked' : '' }} class="h-4 w-4 text-[#CF2031]">
        <span class="ml-2 text-gray-700">Featured Sponsor</span>
      </label>

      <label class="inline-flex items-center">
        <input type="checkbox" name="is_active" {{ $sponsor->is_active ? 'checked' : '' }} class="h-4 w-4 text-[#CF2031]">
        <span class="ml-2 text-gray-700">Active</span>
      </label>
    </div>

    {{-- Buttons --}}
    <div class="pt-4 flex justify-end space-x-3">
      <a href="{{ route('admin.sponsors.index') }}" class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200 text-gray-700">Cancel</a>
      <button type="submit" class="px-4 py-2 rounded bg-[#CF2031] hover:bg-[#b81b2a] text-white">Update</button>
    </div>
  </form>
</div>
@endsection
