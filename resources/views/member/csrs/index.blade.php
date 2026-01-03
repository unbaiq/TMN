@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

    {{-- ================= HEADER ================= --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500
                text-white rounded-2xl px-8 py-6
                flex justify-between items-center shadow-lg">

        <div>
            <h2 class="text-3xl font-semibold">CSR Activities</h2>
            <p class="text-sm text-white/80 mt-1">
                Corporate Social Responsibility activities
            </p>
        </div>

        {{-- ADD CSR : ADMIN ONLY --}}
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.csrs.create') }}"
               class="bg-white text-red-600 px-4 py-2 rounded-lg
                      font-medium shadow hover:bg-gray-100 transition">
                <i data-feather="plus" class="inline w-4 h-4 mr-1"></i>
                Add CSR
            </a>
        @endif
    </div>

    {{-- ================= SUCCESS MESSAGE ================= --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800
                    px-4 py-3 rounded-lg flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()">✕</button>
        </div>
    @endif

    {{-- ================= FILTERS ================= --}}
    <form method="GET"
      action="{{ url()->current() }}"
      class="bg-white border border-gray-200 shadow rounded-xl
             p-4 flex flex-wrap gap-4 items-end">

    {{-- SEARCH --}}
    <div class="relative">
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Search title or member…"
               class="pl-10 border border-gray-300 rounded-lg px-3 py-2 text-sm
                      focus:ring-1 focus:ring-red-600 focus:border-red-600">
        <i data-feather="search"
           class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
    </div>

    {{-- TYPE --}}
    <select name="csr_type"
            class="border border-gray-300 rounded-lg px-3 py-2 text-sm
                   focus:ring-1 focus:ring-red-600 focus:border-red-600">
        <option value="">All CSR Types</option>
        @foreach(['education','health','environment','community','donation','other'] as $type)
            <option value="{{ $type }}" @selected(request('csr_type') == $type)>
                {{ ucfirst($type) }}
            </option>
        @endforeach
    </select>

    {{-- STATUS --}}
    <select name="status"
            class="border border-gray-300 rounded-lg px-3 py-2 text-sm
                   focus:ring-1 focus:ring-red-600 focus:border-red-600">
        <option value="">All Status</option>
        @foreach(['pending','approved','rejected'] as $status)
            <option value="{{ $status }}" @selected(request('status') == $status)>
                {{ ucfirst($status) }}
            </option>
        @endforeach
    </select>

    {{-- ACTION BUTTONS --}}
    <div class="flex gap-2">
        {{-- SEARCH / FILTER --}}
        <button type="submit"
                class="bg-red-600 hover:bg-red-700 text-white
                       px-5 py-2 rounded-lg text-sm font-medium flex items-center gap-1">
            <i data-feather="filter" class="w-4 h-4"></i>
            Search
        </button>

        {{-- CLEAR --}}
        <a href="{{ url()->current() }}"
           class="border border-gray-300 text-gray-700 hover:bg-gray-100
                  px-5 py-2 rounded-lg text-sm font-medium flex items-center gap-1">
            <i data-feather="x-circle" class="w-4 h-4"></i>
            Clear
        </a>
    </div>
</form>


    {{-- ================= TABLE ================= --}}
    <div class="bg-white border border-gray-200 shadow rounded-2xl overflow-hidden">

        @if(isset($csrs) && $csrs->count())
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

                <tbody class="divide-y">
                    @foreach($csrs as $csr)
                        <tr class="hover:bg-gray-50">

                            {{-- CSR --}}
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
                                        'rejected' => 'bg-red-50 text-red-700',
                                    ];
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs
                                      {{ $colors[$csr->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($csr->status) }}
                                </span>
                            </td>

                            {{-- ================= ACTIONS ================= --}}
                            <td class="px-4 py-3 text-right space-x-3">

                                {{-- VIEW : ALL --}}
                                <a href="{{ route(
                                    auth()->user()->role === 'admin'
                                        ? 'admin.csrs.show'
                                        : 'member.csrs.show',
                                    $csr
                                ) }}"
                                   class="text-blue-600 hover:underline">
                                    View
                                </a>

                                {{-- ADMIN ONLY --}}
                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('admin.csrs.edit', $csr) }}"
                                       class="text-green-600 hover:underline">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.csrs.destroy', $csr) }}"
                                          method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Delete this CSR record?')"
                                                class="text-red-600 hover:underline">
                                            Delete
                                        </button>
                                    </form>
                                @endif

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
