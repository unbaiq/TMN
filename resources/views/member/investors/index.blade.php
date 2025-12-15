@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-4 space-y-6">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 text-white rounded-2xl px-8 py-6 flex justify-between items-center shadow-lg">
        <div>
            <h2 class="text-3xl font-semibold">My Investors</h2>
            <p class="text-sm text-white/80 mt-1">Manage your business investors and relationships.</p>
        </div>
        <a href="{{ route('member.investors.create') }}" class="bg-white text-red-600 px-4 py-2 rounded-lg font-medium shadow hover:bg-gray-100 transition">
            <i data-feather="plus" class="inline w-4 h-4 mr-1"></i> Add Investor
        </a>
    </div>

    {{-- ✅ SUCCESS ALERT --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex justify-between items-center shadow-sm animate-fadeIn">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800 font-semibold">✕</button>
        </div>
    @endif

    {{-- FILTERS --}}
    <form method="GET" class="bg-white border border-gray-200 shadow rounded-xl p-4 flex flex-wrap gap-4 items-end">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, company or email..."
            class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">

        <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
            <option value="">All Status</option>
            @foreach(['potential' => 'Potential', 'active' => 'Active', 'inactive' => 'Inactive'] as $key => $label)
                <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>

        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Filter</button>
    </form>

    {{-- TABLE --}}
    <div class="bg-white border border-gray-200 shadow rounded-2xl overflow-hidden">
        @if(isset($investors) && $investors->count())
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 border-b">
                <tr>
                    <th class="px-4 py-3 text-left">Investor Name</th>
                    <th class="px-4 py-3 text-left">Company</th>
                    <th class="px-4 py-3 text-left">Focus</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($investors as $investor)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $investor->investor_name }}</td>
                    <td class="px-4 py-3">{{ $investor->company_name ?? '—' }}</td>
                    <td class="px-4 py-3">{{ $investor->investment_focus ?? '—' }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 rounded-full text-xs
                            {{ $investor->status=='active'?'bg-green-100 text-green-700':($investor->status=='potential'?'bg-yellow-100 text-yellow-700':'bg-gray-100 text-gray-600') }}">
                            {{ ucfirst($investor->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right space-x-3">
                        <a href="{{ route('member.investors.show', $investor) }}" class="text-blue-600 hover:underline">View</a>
                        <a href="{{ route('member.investors.edit', $investor) }}" class="text-green-600 hover:underline">Edit</a>
                        <form action="{{ route('member.investors.destroy', $investor) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Delete this investor?')" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4 border-t bg-gray-50">{{ $investors->links() }}</div>
        @else
        <div class="p-10 text-center text-gray-500">No investors found.</div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded',()=>{
    if(window.feather) feather.replace();
});
</script>
@endsection
