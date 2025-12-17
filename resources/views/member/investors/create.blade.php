@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white shadow-lg rounded-2xl p-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Add New Investor</h2>

    <form action="{{ route('member.investors.store') }}" method="POST">
        @csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="text-sm text-gray-600">Investor Name *</label>
        <input type="text" name="investor_name" required class="w-full border rounded-lg px-3 py-2">
    </div>

    <div>
        <label class="text-sm text-gray-600">Company Name</label>
        <input type="text" name="company_name" class="w-full border rounded-lg px-3 py-2">
    </div>

    <div>
        <label class="text-sm text-gray-600">Email</label>
        <input type="email" name="email" class="w-full border rounded-lg px-3 py-2">
    </div>

    <div>
        <label class="text-sm text-gray-600">Phone</label>
        <input type="text" name="phone" class="w-full border rounded-lg px-3 py-2">
    </div>

    {{-- ✅ City --}}
   <div>
    <label class="text-sm text-gray-600">City</label>
    <input
        type="text"
        name="city"
        placeholder="e.g. Delhi, Mumbai, Noida"
        class="w-full border border-gray-300 rounded-lg px-3 py-2
               focus:ring-1 focus:ring-red-600 focus:border-red-600">
</div>


    <div>
        <label class="text-sm text-gray-600">Investment Focus</label>
        <input type="text" name="investment_focus" class="w-full border rounded-lg px-3 py-2">
    </div>

    <div>
        <label class="text-sm text-gray-600">Investment Capacity (₹)</label>
        <input type="number" step="0.01" name="investment_capacity" class="w-full border rounded-lg px-3 py-2">
    </div>

    <div>
        <label class="text-sm text-gray-600">Status</label>
        <select name="status" class="w-full border rounded-lg px-3 py-2">
            <option value="potential">Potential</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>

    <div class="md:col-span-2">
        <label class="text-sm text-gray-600">Notes</label>
        <textarea name="notes" rows="3" class="w-full border rounded-lg px-3 py-2"></textarea>
    </div>
</div>


        <div class="mt-6 flex justify-end">
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg font-medium">Save Investor</button>
        </div>
    </form>
</div>
@endsection
