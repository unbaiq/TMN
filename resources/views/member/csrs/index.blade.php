@extends('layouts.app')

@section('content')
<div class="max-w-8xl mx-auto px-4 py-4 space-y-6">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 text-white rounded-2xl px-8 py-6 flex justify-between items-center shadow-lg">
        <div>
            <h2 class="text-3xl font-semibold">Member CSR Activities</h2>
            <p class="text-sm text-white/80 mt-1">Track your community contributions and social impact.</p>
        </div>
        <a href="{{ route('member.csrs.create') }}" class="bg-white text-red-600 px-4 py-2 rounded-lg font-medium shadow hover:bg-gray-100 transition">
            <i data-feather="plus" class="inline w-4 h-4 mr-1"></i> Add CSR
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex justify-between items-center shadow-sm">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-700 font-semibold">✕</button>
        </div>
    @endif

    {{-- FILTERS --}}
    <form method="GET" class="bg-white border border-gray-200 shadow rounded-xl p-4 flex flex-wrap gap-4 items-end">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title or member..."
               class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-600 focus:border-red-600">
        <select name="csr_type" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-600">
            <option value="">All Types</option>
            @foreach(['donation'=>'Donation','volunteering'=>'Volunteering','education'=>'Education','environment'=>'Environment','health'=>'Health','charity'=>'Charity','community_support'=>'Community Support','other'=>'Other'] as $key=>$label)
                <option value="{{ $key }}" {{ request('csr_type')==$key?'selected':'' }}>{{ $label }}</option>
            @endforeach
        </select>
        <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-red-600">
            <option value="">All Status</option>
            @foreach(['pending'=>'Pending','approved'=>'Approved','rejected'=>'Rejected'] as $key=>$label)
                <option value="{{ $key }}" {{ request('status')==$key?'selected':'' }}>{{ $label }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Filter</button>
    </form>

    {{-- TABLE --}}
    <div class="bg-white border border-gray-200 shadow rounded-2xl overflow-hidden">
        @if($csrs->count())
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 border-b">
                <tr>
                    <th class="px-4 py-3 text-left">Title</th>
                    <th class="px-4 py-3 text-left">Type</th>
                    <th class="px-4 py-3 text-left">Impact</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($csrs as $csr)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $csr->csr_title }}</td>
                    <td class="px-4 py-3 capitalize">{{ $csr->csr_type }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $csr->impact_summary ?: '—' }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 rounded-full text-xs
                            {{ $csr->status=='approved'?'bg-green-100 text-green-700':($csr->status=='pending'?'bg-yellow-100 text-yellow-700':'bg-gray-100 text-gray-600') }}">
                            {{ ucfirst($csr->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right space-x-3">
                        <a href="{{ route('member.csrs.show',$csr) }}" class="text-blue-600 hover:underline">View</a>
                        <a href="{{ route('member.csrs.edit',$csr) }}" class="text-green-600 hover:underline">Edit</a>
                        <form action="{{ route('member.csrs.destroy',$csr) }}" method="POST" class="inline">@csrf @method('DELETE')
                            <button onclick="return confirm('Delete this CSR?')" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4 border-t bg-gray-50">{{ $csrs->links() }}</div>
        @else
        <div class="p-10 text-center text-gray-500">No CSR records found.</div>
        @endif
    </div>
</div>

<script>document.addEventListener('DOMContentLoaded',()=>{if(window.feather) feather.replace();});</script>
@endsection
