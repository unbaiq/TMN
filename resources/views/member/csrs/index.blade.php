@extends('layouts.app')

@section('content')
@php
    $isAdmin = auth()->check() && auth()->user()->role === 'admin';
@endphp

@if($isAdmin)
  <div class="max-w-7xl mx-auto px-6 py-8">

    {{-- ================= SINGLE CONTAINER ================= --}}
    <div class="bg-white rounded-2xl shadow p-6 space-y-6">

        {{-- HEADER --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">
                    CSR Activities
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Manage Corporate Social Responsibility activities.
                </p>
            </div>

            <a href="{{ route('admin.csrs.create') }}"
               class="bg-red-600 hover:bg-red-700 text-white
                      px-5 py-2 rounded-lg text-sm font-medium">
                + Add CSR
            </a>
        </div>

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800
                        px-4 py-3 rounded-lg flex justify-between items-center">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()">✕</button>
            </div>
        @endif

        {{-- FILTERS --}}
        <form method="GET"
              action="{{ url()->current() }}"
              class="flex flex-wrap items-end gap-4">

            <div class="relative">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search title or member..."
                       class="pl-10 border rounded-lg px-3 py-2 text-sm
                              focus:ring-red-500 focus:border-red-500">
                <i data-feather="search"
                   class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
            </div>

            <select name="csr_type"
                    class="border rounded-lg px-3 py-2 text-sm">
                <option value="">All Types</option>
                @foreach(['education','health','environment','community','donation','other'] as $type)
                    <option value="{{ $type }}" @selected(request('csr_type') === $type)>
                        {{ ucfirst($type) }}
                    </option>
                @endforeach
            </select>

            <select name="status"
                    class="border rounded-lg px-3 py-2 text-sm">
                <option value="">All Status</option>
                @foreach(['pending','approved','rejected'] as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>

            <button class="bg-red-600 hover:bg-red-700 text-white
                           px-5 py-2 rounded-lg text-sm font-medium">
                Filter
            </button>
        </form>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600 border-b">
                    <tr>
                        <th class="px-5 py-3 text-left">CSR</th>
                        <th class="px-5 py-3 text-left">Type</th>
                        <th class="px-5 py-3 text-left">Date</th>
                        <th class="px-5 py-3 text-left">Impact</th>
                        <th class="px-5 py-3 text-center">Status</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($csrs as $csr)
                        <tr class="hover:bg-gray-50">

                            <td class="px-5 py-3">
                                <div class="font-medium">{{ $csr->csr_title }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ $csr->member->name ?? '—' }}
                                </div>
                            </td>

                            <td class="px-5 py-3 capitalize">
                                {{ $csr->csr_type }}
                            </td>

                            <td class="px-5 py-3">
                                {{ optional($csr->csr_date)->format('d M Y') ?? '—' }}
                            </td>

                            <td class="px-5 py-3 text-gray-600">
                                {{ $csr->impact_summary ?: '—' }}
                            </td>

                            <td class="px-5 py-3 text-center">
                                @php
                                    $colors = [
                                        'pending'  => 'bg-yellow-50 text-yellow-700',
                                        'approved' => 'bg-green-50 text-green-700',
                                        'rejected' => 'bg-red-50 text-red-700',
                                    ];
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs
                                      {{ $colors[$csr->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($csr->status) }}
                                </span>
                            </td>

                            <td class="px-5 py-3 text-right space-x-3">
                                <a href="{{ route('admin.csrs.show', $csr) }}"
                                   class="text-blue-600 hover:underline">
                                    View
                                </a>

                                <a href="{{ route('admin.csrs.edit', $csr) }}"
                                   class="text-green-600 hover:underline">
                                    Edit
                                </a>

                                <form method="POST"
                                      action="{{ route('admin.csrs.destroy', $csr) }}"
                                      class="inline"
                                      onsubmit="return confirm('Delete this CSR record?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-gray-500">
                                No CSR records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="pt-4 border-t bg-gray-50">
            {{ $csrs->links() }}
        </div>

    </div>
</div>

@else
    {{-- ================= MEMBER VIEW (RECOGNITION THEME) ================= --}}
    <div class="max-w-7xl mx-auto px-6 py-8 space-y-6">

        {{-- GRADIENT HEADER --}}
        <div class="bg-gradient-to-r from-red-700 to-red-500
                    rounded-2xl px-10 py-7 text-white shadow">
            <h2 class="text-2xl font-semibold">CSR Activities</h2>
            <p class="text-sm text-white/80 mt-1">
                Corporate Social Responsibility initiatives by members.
            </p>
        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-2xl shadow border overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b text-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-left">CSR</th>
                        <th class="px-6 py-4 text-left">Type</th>
                        <th class="px-6 py-4 text-center">Date</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($csrs as $csr)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium">
                                {{ $csr->csr_title }}
                            </td>
                            <td class="px-6 py-4 capitalize">
                                {{ $csr->csr_type }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ optional($csr->csr_date)->format('d M Y') ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $csr->status === 'approved'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($csr->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('member.csrs.show', $csr) }}"
                                   class="text-blue-600 hover:underline font-medium">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-500">
                                No CSR activities found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="px-6 py-4 border-t bg-gray-50">
                {{ $csrs->links() }}
            </div>
        </div>
    </div>
@endif

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (window.feather) feather.replace();
});
</script>
@endsection
