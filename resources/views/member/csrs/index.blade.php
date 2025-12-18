@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500
                text-white rounded-2xl px-8 py-6 flex justify-between items-center shadow-lg">
        <div>
            <h2 class="text-3xl font-semibold">CSR Activities</h2>
            <p class="text-sm text-white/80 mt-1">
                Corporate Social Responsibility activities recorded by members
            </p>
        </div>

        <a href="{{ route('member.csrs.create') }}"
           class="bg-white text-red-600 px-4 py-2 rounded-lg font-medium shadow hover:bg-gray-100 transition">
            <i data-feather="plus" class="inline w-4 h-4 mr-1"></i>
            Add CSR
        </a>
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()">✕</button>
        </div>
    @endif

    {{-- FILTERS --}}
    <form method="GET"
          class="bg-white border border-gray-200 shadow rounded-xl p-4 flex flex-wrap gap-4 items-end">

        {{-- SEARCH --}}
        <div class="relative">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Search CSR title, description or member…"
                   class="pl-10 border border-gray-300 rounded-lg px-3 py-2 text-sm
                          focus:ring-1 focus:ring-red-600 focus:border-red-600">
            <i data-feather="search"
               class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
        </div>

        {{-- CSR TYPE --}}
        <select name="csr_type"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-red-600">
            <option value="">All CSR Types</option>
            @foreach(['education','health','environment','community','donation','other'] as $type)
                <option value="{{ $type }}" {{ request('csr_type') === $type ? 'selected' : '' }}>
                    {{ ucfirst($type) }}
                </option>
            @endforeach
        </select>

        {{-- STATUS --}}
        <select name="status"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-red-600">
            <option value="">All Status</option>
            @foreach(['pending','approved','rejected'] as $status)
                <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>

        <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm">
            Filter
        </button>
    </form>

    {{-- TABLE --}}
    <div class="bg-white border border-gray-200 shadow rounded-2xl overflow-hidden">

        @if($csrs->count())
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 border-b">
                <tr>
                    <th class="px-4 py-3 text-left">CSR</th>
                    <th class="px-4 py-3 text-left">Type</th>
                    <th class="px-4 py-3 text-left">Date</th>
                    <th class="px-4 py-3 text-left">Impact</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @foreach($csrs as $csr)
                <tr class="hover:bg-gray-50">

                    {{-- CSR TITLE --}}
                    <td class="px-4 py-3">
                        <div class="font-medium">{{ $csr->csr_title }}</div>
                        <div class="text-xs text-gray-500">
                            {{ $csr->member->name ?? '—' }}
                        </div>
                    </td>

                    {{-- TYPE --}}
                    <td class="px-4 py-3 capitalize">
                        {{ $csr->csr_type }}
                    </td>

                    {{-- DATE --}}
                    <td class="px-4 py-3">
                        {{ optional($csr->csr_date)->format('d M Y') ?? '—' }}
                    </td>

                    {{-- IMPACT --}}
                    <td class="px-4 py-3 text-gray-600">
                        {{ $csr->impact_summary ?: '—' }}
                    </td>

                    {{-- STATUS --}}
                    <td class="px-4 py-3 text-center">
                        @php
                            $colors = [
                                'pending' => 'bg-yellow-50 text-yellow-700',
                                'approved' => 'bg-green-50 text-green-700',
                                'rejected' => 'bg-red-50 text-red-700'
                            ];
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs {{ $colors[$csr->status] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ ucfirst($csr->status) }}
                        </span>
                    </td>

                    {{-- ACTIONS --}}
                    <td class="px-4 py-3 text-right space-x-3">
                        <a href="{{ route('member.csrs.show', $csr) }}"
                           class="text-blue-600 hover:underline">View</a>

                        <a href="{{ route('member.csrs.edit', $csr) }}"
                           class="text-green-600 hover:underline">Edit</a>

                        <form action="{{ route('member.csrs.destroy', $csr) }}"
                              method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Delete this CSR record?')"
                                    class="text-red-600 hover:underline">
                                Delete
                            </button>
                        </form>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-4 border-t bg-gray-50">
            {{ $csrs->links() }}
        </div>

        @else
            <div class="p-10 text-center text-gray-500">
                No CSR records found.
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (window.feather) feather.replace();
});
</script>
@endsection
