@extends('layouts.app')

@section('content')


<div class="max-w-4xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">
  <h2 class="text-2xl font-semibold text-gray-800 mb-6">Add New Partner</h2>

  <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
    @csrf

    <div>
      <label class="block text-gray-700 font-medium">Name <span class="text-red-500">*</span></label>
      <input name="name" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2" required>
    </div>

    <div>
      <label class="block text-gray-700 font-medium">Company Name</label>
      <input name="company_name" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-gray-700 font-medium">Partner Type</label>
        <select name="partner_type" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
          <option value="strategic">Strategic</option>
          <option value="sponsor">Sponsor</option>
          <option value="vendor">Vendor</option>
          <option value="associate">Associate</option>
          <option value="technology">Technology</option>
        </select>
      </div>
      <div>
        <label class="block text-gray-700 font-medium">Level</label>
        <select name="level" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
          <option value="platinum">Platinum</option>
          <option value="gold">Gold</option>
          <option value="silver" selected>Silver</option>
          <option value="bronze">Bronze</option>
        </select>
      </div>
    </div>

    <div>
      <label class="block text-gray-700 font-medium">Logo</label>
      <input type="file" name="logo" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
    </div>

    <div>
      <label class="block text-gray-700 font-medium">Banner</label>
      <input type="file" name="banner" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
    </div>

    <div class="pt-4 flex justify-end space-x-3">
      <a href="{{ route('admin.partners.index') }}" class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200 text-gray-700">Cancel</a>
      <button type="submit" class="px-4 py-2 rounded bg-[#CF2031] hover:bg-[#b81b2a] text-white">Create</button>
    </div>
  </form>
</div>
@endsection
