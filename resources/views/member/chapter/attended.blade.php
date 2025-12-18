@extends('layouts.app')

@section('content')
    <style>
        /* =========================
       ERP-STYLE TABLE DESIGN
       ========================= */
        thead tr {
            background: #f9fafb;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        tbody tr {
            transition: all 0.15s ease-in-out;
        }

        tbody tr:hover {
            background: #fff6f6;
        }

        .status-green {
            background: #e6f9ed;
            color: #137333;
        }

        .status-red {
            background: #ffe8e8;
            color: #cc0000;
        }

        .status-gray {
            background: #e5e7eb;
            color: #374151;
        }
    </style>

    <main class="max-w-8xl mx-auto px-4 py-4 space-y-6">

        {{-- ==== HEADER ==== --}}
        <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 rounded-2xl shadow-2xl px-10 py-8 flex flex-col md:flex-row md:items-center md:justify-between text-white relative overflow-hidden border border-red-600/30">
        <div class="relative z-10">
            <h2 class="text-3xl font-bold tracking-tight">🎟️ Attended Chapter Events</h2>
            <p class="text-red-100 mt-2 text-sm md:text-base">
                View all TMN chapter events you have successfully attended.
            </p>
        </div>
        <div class="relative z-10 mt-6 md:mt-0">
            <button id="exportBtn"
    class="bg-white text-red-700 hover:bg-red-50 hover:text-red-800 font-medium text-sm px-6 py-2.5 rounded-full shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2">
    <i data-feather='download'></i> Export Report
</button>

        </div>
        <div class="absolute right-0 top-0 w-72 h-72 bg-white/10 rounded-full blur-3xl opacity-25"></div>
    </div>
{{-- ==== SEARCH BAR ==== --}}
<div class="bg-white border border-gray-100 shadow-sm rounded-xl px-4 py-3 flex items-center gap-3">
    <div class="relative w-full max-w-md">
        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
            <i data-feather="search" class="w-4 h-4"></i>
        </span>
        <input
            type="text"
            id="tableSearch"
            placeholder="Search by chapter, event, city or status..."
            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm
                   focus:ring-1 focus:ring-red-600 focus:border-red-600"
        >
    </div>
</div>


        {{-- ==== TABLE CONTAINER ==== --}}
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-gray-600 border-b border-gray-200">
                        <th class="py-3 px-5 text-left font-semibold">#</th>
                        <th class="py-3 px-5 text-left font-semibold">Chapter</th>
                        <th class="py-3 px-5 text-left font-semibold">Event</th>
                        <th class="py-3 px-5 text-left font-semibold">Status</th>
                        <th class="py-3 px-5 text-left font-semibold">Date</th>
                        <th class="py-3 px-5 text-left font-semibold">City</th>
                        <th class="py-3 px-5 text-right font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendances as $index => $attendance)
                        <tr class="border-b border-gray-100 hover:shadow-sm transition">
                            <td class="py-3 px-5 text-gray-600">{{ $index + 1 }}</td>
                            <td class="py-3 px-5 font-semibold text-gray-800">
                                {{ $attendance->event->chapter->name ?? 'N/A' }}
                            </td>
                            <td class="py-3 px-5 text-gray-700">
                                {{ $attendance->event->title ?? '—' }}
                            </td>
                            <td class="py-3 px-5">
                                @php
                                    $statusClass = match (strtolower($attendance->status)) {
                                        'attended' => 'status-green',
                                        'missed' => 'status-red',
                                        default => 'status-gray',
                                    };
                                @endphp
                                <span class="inline-block px-2.5 py-1 text-xs rounded-full font-medium {{ $statusClass }}">
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-5 text-gray-600">
                                {{ \Carbon\Carbon::parse($attendance->event->event_date)->format('d M Y') }}
                            </td>
                            <td class="py-3 px-5 text-gray-600">
                                {{ $attendance->event->city ?? '—' }}
                            </td>
                            <td class="py-3 px-5 text-right">
                                <button
                                    onclick="openModal('{{ $attendance->event->title }}', '{{ $attendance->event->description }}', '{{ $attendance->event->formatted_date }}')"
                                    class="text-[#E53935] font-medium hover:underline hover:text-[#C62828] transition">
                                    View
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-gray-500">
                                <i data-feather="calendar" class="w-6 h-6 mx-auto mb-2 text-gray-400"></i>
                                No attended events found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    {{-- ==== MODAL ==== --}}
    <div id="eventModal"
        class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50 backdrop-blur-sm transition-opacity duration-300">
        <div
            class="modal-card bg-white rounded-2xl w-full max-w-md shadow-2xl p-6 relative transform scale-90 opacity-0 transition-all duration-300 border border-gray-100">
            <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-600 hover:text-[#E53935] transition">
                <i data-feather="x"></i>
            </button>
            <h3 id="modalTitle" class="text-xl font-semibold text-gray-900 mb-3"></h3>
            <p id="modalDesc" class="text-gray-600 mb-4 leading-relaxed"></p>
            <p id="modalDate" class="text-sm text-gray-500"></p>
            <div class="mt-6 text-right">
                <button onclick="closeModal()"
                    class="px-4 py-2 bg-gradient-to-r from-[#E53935] to-[#FF7043] text-white rounded-lg hover:shadow-md transition">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        feather.replace();

        /* ==== MODAL ==== */
        function openModal(title, desc, date) {
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalDesc').textContent = desc || "No description available.";
            document.getElementById('modalDate').textContent = "📅 " + date;

            const modal = document.getElementById('eventModal');
            const card = modal.querySelector('.modal-card');

            modal.classList.remove('hidden');
            setTimeout(() => {
                card.classList.remove('scale-90', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 50);
        }

        function closeModal() {
            const modal = document.getElementById('eventModal');
            const card = modal.querySelector('.modal-card');

            card.classList.add('scale-90', 'opacity-0');
            setTimeout(() => modal.classList.add('hidden'), 200);
        }
    </script>
<script>
document.getElementById('exportBtn').addEventListener('click', () => {
    let rows = [];
    rows.push(['Chapter', 'Event', 'Status', 'Date', 'City']);

    document.querySelectorAll('tbody tr').forEach(tr => {
        const cols = tr.querySelectorAll('td');
        if (cols.length < 6) return;

        rows.push([
            cols[1].innerText.trim(),
            cols[2].innerText.trim(),
            cols[3].innerText.trim(),
            cols[4].innerText.trim(),
            cols[5].innerText.trim(),
        ]);
    });

    let csv = rows.map(r => r.join(',')).join('\n');
    let blob = new Blob([csv], { type: 'text/csv' });

    let a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'attended-events.csv';
    a.click();
});
</script>
<script>
document.getElementById('tableSearch').addEventListener('keyup', function () {
    const query = this.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(query) ? '' : 'none';
    });
});
</script>

    <style>
        .modal-card {
            transition: all 0.25s ease-in-out;
        }
    </style>
@endsection