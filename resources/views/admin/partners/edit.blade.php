@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">
  <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Partner</h2>

  @if($errors->any())
    <div class="bg-red-50 text-red-600 p-4 rounded mb-4">
      <ul class="list-disc list-inside text-sm">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
    @csrf
    @method('PUT')

    {{-- Basic Info --}}
    <div>
      <label class="block text-gray-700 font-medium">Name <span class="text-red-500">*</span></label>
      <input type="text" name="name" value="{{ old('name', $partner->name) }}" class="w-full border rounded px-3 py-2" required>
    </div>

    <div>
      <label class="block text-gray-700 font-medium">Company Name</label>
      <input type="text" name="company_name" value="{{ old('company_name', $partner->company_name) }}" class="w-full border rounded px-3 py-2">
    </div>

    {{-- Partner Type & Level --}}
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-gray-700 font-medium">Partner Type</label>
        <select name="partner_type" class="w-full border rounded px-3 py-2">
          @foreach(['strategic','sponsor','vendor','associate','technology'] as $type)
            <option value="{{ $type }}" {{ $partner->partner_type == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-gray-700 font-medium">Level</label>
        <select name="level" class="w-full border rounded px-3 py-2">
          @foreach(['platinum','gold','silver','bronze'] as $lvl)
            <option value="{{ $lvl }}" {{ $partner->level == $lvl ? 'selected' : '' }}>{{ ucfirst($lvl) }}</option>
          @endforeach
        </select>
      </div>
    </div>

    {{-- Logo --}}
    <div>
      <label class="block text-gray-700 font-medium">Logo</label>
      @if($partner->logo)
        <div class="mb-3">
          <img src="{{ asset('storage/'.$partner->logo) }}" class="w-32 h-32 object-cover rounded-lg border">
        </div>
      @endif
      <input type="file" name="logo" class="w-full border rounded px-3 py-2">
    </div>

    {{-- Banner --}}
    <div>
      <label class="block text-gray-700 font-medium">Banner</label>
      @if($partner->banner)
        <div class="mb-3">
          <img src="{{ asset('storage/'.$partner->banner) }}" class="w-full h-48 object-cover rounded-lg border">
        </div>
      @endif
      <input type="file" name="banner" class="w-full border rounded px-3 py-2">
    </div>

    {{-- Active & Featured --}}
    <div class="flex flex-wrap gap-6">
      <label class="inline-flex items-center">
        <input type="checkbox" name="is_featured" {{ $partner->is_featured ? 'checked' : '' }} class="h-4 w-4 text-[#CF2031]">
        <span class="ml-2 text-gray-700">Featured Partner</span>
      </label>

      <label class="inline-flex items-center">
        <input type="checkbox" name="is_active" {{ $partner->is_active ? 'checked' : '' }} class="h-4 w-4 text-[#CF2031]">
        <span class="ml-2 text-gray-700">Active</span>
      </label>
    </div>

    {{-- Status --}}
    <div>
      <label class="block text-gray-700 font-medium">Status</label>
      <select name="status" class="w-full border rounded px-3 py-2">
        @foreach(['pending','approved','rejected','expired'] as $st)
          <option value="{{ $st }}" {{ $partner->status == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
        @endforeach
      </select>
    </div>

    {{-- Buttons --}}
    <div class="pt-4 flex justify-end space-x-3">
      <a href="{{ route('admin.partners.index') }}" class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200 text-gray-700">Cancel</a>
      <button type="submit" class="px-4 py-2 rounded bg-[#CF2031] hover:bg-[#b81b2a] text-white">Update</button>
    </div>
  </form>
</div>
@endsection
