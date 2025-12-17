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
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Create Chapter</h2>

    <form action="{{ route('admin.chapters.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        <div>
            <label class="block text-gray-700 font-medium">Name</label>
            <input name="name" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2" required>
        </div>

        <div>
            <label class="block text-gray-700 font-medium">City</label>
            <input name="city" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Pincode</label>
            <input name="pincode" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Capacity</label>
            <input name="capacity_no" type="number" min="0" value="0" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Logo</label>
            <input type="file" name="logo" accept="image/*" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2">
        </div>

        <div>
            <label class="block text-gray-700 font-medium">Description</label>
            <textarea name="description" rows="3" class="w-full bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none px-3 py-2"></textarea>
        </div>

        <label class="inline-flex items-center">
            <input type="checkbox" name="is_active" checked class="h-4 w-4 text-[#CF2031]">
            <span class="ml-2 text-gray-700">Active Chapter</span>
        </label>

        <div class="pt-4 flex justify-end space-x-3">
            <a href="{{ route('admin.chapters.create') }}" class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200 text-gray-700">Cancel</a>
            <button type="submit" class="px-4 py-2 rounded bg-[#CF2031] hover:bg-[#b81b2a] text-white">Create</button>
        </div>
    </form>
</div>
@endsection
