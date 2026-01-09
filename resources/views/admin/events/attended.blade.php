@extends('layouts.app')

@section('content')

<div class="max-w-full mx-auto px-6 py-8 bg-gray-50">

    {{-- ================= SINGLE CONTAINER ================= --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 space-y-10">

        {{-- ===== HEADER ===== --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 tracking-tight">
                    Event Attendance Dashboard
                </h1>
                <p class="text-gray-500 mt-1 text-sm">
                    Monitor all chapter events and attendance records in one place.
                </p>
            </div>

            @if(auth()->check() && auth()->user()->role === 'admin')
                <a href="{{ route('admin.events.create') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5
                          bg-gradient-to-r from-red-600 to-orange-500
                          text-white rounded-lg font-medium shadow
                          hover:shadow-md hover:scale-105 transition-all">
                    <i data-feather="plus-circle" class="w-4"></i>
                    New Event
                </a>
            @else
                <span class="inline-flex items-center gap-2 px-5 py-2.5
                             bg-gray-300 text-gray-600 rounded-lg
                             opacity-50 cursor-not-allowed">
                    <i data-feather="lock" class="w-4"></i>
                    New Event
                </span>
            @endif
        </div>

        {{-- ===== KPI / STATS ===== --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="bg-gradient-to-br from-green-500 to-green-600 text-white p-6 rounded-xl shadow-md">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm opacity-80">Total Events</p>
                        <h3 class="text-3xl font-bold mt-1">{{ $stats['total'] }}</h3>
                    </div>
                    <i data-feather="calendar" class="w-8 h-8 opacity-70"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white p-6 rounded-xl shadow-md">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm opacity-80">This Month</p>
                        <h3 class="text-3xl font-bold mt-1">{{ $stats['this_month'] }}</h3>
                    </div>
                    <i data-feather="clock" class="w-8 h-8 opacity-70"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-orange-500 to-red-500 text-white p-6 rounded-xl shadow-md">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm opacity-80">Attendance Taken</p>
                        <h3 class="text-3xl font-bold mt-1">{{ $stats['with_attendance'] }}</h3>
                    </div>
                    <i data-feather="check-circle" class="w-8 h-8 opacity-70"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-gray-700 to-gray-900 text-white p-6 rounded-xl shadow-md">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm opacity-80">Pending</p>
                        <h3 class="text-3xl font-bold mt-1">{{ $stats['pending'] }}</h3>
                    </div>
                    <i data-feather="alert-circle" class="w-8 h-8 opacity-70"></i>
                </div>
            </div>

        </div>

        {{-- ===== EVENT TABLE ===== --}}
        <div class="border border-gray-200 rounded-xl overflow-hidden">

            {{-- Table Header --}}
            <div class="px-6 py-4 flex flex-col md:flex-row md:items-center md:justify-between
                        bg-gray-50 border-b gap-3">
                <h2 class="text-lg font-semibold text-gray-800">Event List</h2>

                <div class="flex items-center gap-2">
                    <input
                        type="text"
                        id="searchInput"
                        placeholder="Search event..."
                        class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm
                               focus:ring-2 focus:ring-red-500 focus:outline-none">
                    <button
                        type="button"
                        id="searchButton"
                        class="px-4 py-1.5 bg-red-600 text-white rounded-lg
                               text-sm font-medium hover:bg-red-700 transition">
                        Search
                    </button>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-3 border font-semibold text-gray-700">#</th>
                            <th class="px-6 py-3 border font-semibold text-gray-700">Title</th>
                            <th class="px-6 py-3 border font-semibold text-gray-700">Description</th>
                            <th class="px-6 py-3 border font-semibold text-gray-700">Date</th>
                            <th class="px-6 py-3 border font-semibold text-gray-700 text-center">Status</th>
                            <th class="px-6 py-3 border font-semibold text-gray-700 text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($events as $index => $event)
                            @php $hasAttendance = $event->attendances->isNotEmpty(); @endphp
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-6 py-4 border text-gray-600">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 border font-semibold text-gray-800">{{ $event->title }}</td>
                                <td class="px-6 py-4 border text-gray-500">
                                    {{ \Illuminate\Support\Str::limit($event->description, 70) }}
                                </td>
                                <td class="px-6 py-4 border text-gray-500">
                                    {{ $event->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 border text-center">
                                    @if($hasAttendance)
                                        <span class="inline-flex items-center gap-1
                                                     bg-green-100 text-green-700
                                                     px-3 py-1 rounded-full text-xs font-medium">
                                            <i data-feather="check" class="w-3 h-3"></i>
                                            Completed
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1
                                                     bg-yellow-100 text-yellow-700
                                                     px-3 py-1 rounded-full text-xs font-medium">
                                            <i data-feather="clock" class="w-3 h-3"></i>
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.events.attendance', $event->id) }}"
                                       class="inline-flex items-center gap-2 px-4 py-2
                                              rounded-lg bg-gradient-to-r
                                              from-blue-600 to-blue-500
                                              text-white text-xs font-semibold
                                              hover:shadow-md hover:scale-105 transition-all">
                                        <i data-feather="edit" class="w-4"></i>
                                        Manage
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-10 text-gray-500 text-sm">
                                    No events found.
                                    <a href="{{ route('admin.events.create') }}"
                                       class="text-red-600 font-semibold hover:underline">
                                        Create one now
                                    </a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>



<script>
    document.addEventListener("DOMContentLoaded", () => {
        if (window.feather) feather.replace();
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput  = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        const rows         = document.querySelectorAll('table tbody tr');

        function filterTable() {
            const term = searchInput.value.trim().toLowerCase();

            rows.forEach(row => {
                // text of the entire row (title, description, etc.)
                const text = row.textContent.toLowerCase();

                // show row if search is empty or text matches
                if (!term || text.includes(term)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Click on "Search"
        searchButton.addEventListener('click', filterTable);

        // Live search + Enter support
        searchInput.addEventListener('keyup', function (e) {
            if (e.key === 'Enter') {
                filterTable();
            } else if (!searchInput.value) {
                // reset when cleared
                filterTable();
            }
        });
    });
</script>
@endsection
