@extends('layouts.app')

@section('content')
    <div class="max-w-8xl mx-auto px-4 py-4 space-y-6">

        {{-- ==== HEADER ==== --}}
        <div
            class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 rounded-2xl shadow-2xl px-10 py-8 flex flex-col md:flex-row md:items-center md:justify-between text-white relative overflow-hidden border border-red-600/30">
            <div class="relative z-10">
                <h2 class="text-3xl font-bold tracking-tight">🔥 TMN Chapter Event Management</h2>
                <p class="text-red-100 mt-2 text-sm md:text-base">
                    Manage, review, and explore full details of chapter events.
                </p>
            </div>
            <div class="absolute right-0 top-0 w-72 h-72 bg-white/10 rounded-full blur-3xl opacity-25"></div>
        </div>

        {{-- ==== FILTER + SEARCH ==== --}}
        <div
            class="bg-white border border-gray-200 shadow-md rounded-xl p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="relative w-full md:w-1/2">
                <i data-feather="search" class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-500"></i>
                <input id="searchInput" type="text" placeholder="Search events by name, venue, or city..."
                    class="pl-10 pr-4 py-2.5 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 outline-none text-sm" />
            </div>
            <div
                class="flex flex-wrap items-center justify-start gap-1.5 md:gap-2 bg-gray-50 border border-gray-200 rounded-full px-2 py-1.5 shadow-sm">
                <button
                    class="filter-btn active-filter text-xs font-medium px-3 py-1.5 rounded-full transition-all duration-200 bg-gradient-to-r from-[#E53935] to-[#FF7043] text-white shadow-sm"
                    data-filter="all">
                    All
                </button>
                <button
                    class="filter-btn text-xs font-medium px-3 py-1.5 rounded-full transition-all duration-200 bg-white hover:bg-red-50 text-gray-700 border border-gray-300 hover:border-[#E53935] hover:text-[#E53935]"
                    data-filter="upcoming">
                    Upcoming
                </button>
                <button
                    class="filter-btn text-xs font-medium px-3 py-1.5 rounded-full transition-all duration-200 bg-white hover:bg-red-50 text-gray-700 border border-gray-300 hover:border-[#E53935] hover:text-[#E53935]"
                    data-filter="active">
                    Active
                </button>
                <button
                    class="filter-btn text-xs font-medium px-3 py-1.5 rounded-full transition-all duration-200 bg-white hover:bg-red-50 text-gray-700 border border-gray-300 hover:border-[#E53935] hover:text-[#E53935]"
                    data-filter="completed">
                    Completed
                </button>
            </div>


        </div>

        {{-- ==== EVENT GRID ==== --}}
        <div id="eventsGrid" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 mt-4">
            @forelse ($events as $event)
                @php
                    $status = $event->status ?? ($event->isPast ? 'completed' : 'upcoming');
                    $badgeColor = match ($status) {
                        'completed' => 'bg-gray-100 text-gray-700 border border-gray-300',
                        'active' => 'bg-green-100 text-green-700 border border-green-300',
                        'upcoming' => 'bg-yellow-100 text-yellow-700 border border-yellow-300',
                        default => 'bg-gray-100 text-gray-600 border border-gray-200',
                    };

                    $eventData = [
                        'title' => $event->title,
                        'status' => $status,
                        'formatted_date' => $event->formatted_date,
                        'start_time' => $event->start_time,
                        'end_time' => $event->end_time,
                        'venue_name' => $event->venue_name,
                        'full_address' => $event->full_address,
                        'chapter' => $event->chapter->name ?? null,
                        'host_name' => $event->host_name,
                        'host_contact' => $event->host_contact,
                        'host_email' => $event->host_email,
                        'event_type' => $event->event_type,
                        'description' => $event->description,
                        'agenda' => $event->agenda,
                        'notes' => $event->notes,
                        'is_online' => $event->is_online,
                        'meeting_link' => $event->meeting_link,
                        'meeting_password' => $event->meeting_password,
                        'banner_image' => $event->banner_image,
                    ];
                @endphp

                <div class="event-card bg-white border border-gray-200 p-6 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 hover:border-red-400"
                    data-status="{{ strtolower($status) }}">
                    <div class="flex items-center justify-between mb-3 gap-2">
                        <h3 class="text-lg font-semibold text-gray-800 truncate">
                            {{ $event->title }}
                        </h3>

                        <div class="flex items-center gap-2 shrink-0">

                            {{-- EVENT TYPE --}}
                            <span class="text-[10px] px-2 py-1 rounded-full font-semibold
                        {{ $event->event_type === 'general'
                ? 'bg-blue-100 text-blue-700 border border-blue-300'
                : 'bg-purple-100 text-purple-700 border border-purple-300' }}">
                                {{ strtoupper($event->event_type) }}
                            </span>

                            {{-- STATUS --}}
                            <span class="text-xs px-2 py-1 rounded-full font-medium {{ $badgeColor }}">
                                {{ ucfirst($status) }}
                            </span>

                        </div>
                    </div>


                    <div class="text-sm text-gray-600 space-y-1">
                        <p class="flex items-center gap-2"><i data-feather="map-pin" class="w-4"></i>
                            {{ $event->venue_name ?? '—' }}</p>
                        <p class="flex items-center gap-2"><i data-feather="calendar" class="w-4"></i>
                            {{ $event->formatted_date }}</p>
                        @if($event->start_time && $event->end_time)
                            <p class="flex items-center gap-2"><i data-feather="clock" class="w-4"></i>
                                {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }} –
                                {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}
                            </p>
                        @endif
                    </div>

                    <div class="mt-5">
                        <button
                            class="view-btn w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white py-2.5 rounded-lg flex items-center justify-center gap-2 transition shadow-md"
                            data-event='{{ json_encode($eventData, JSON_HEX_APOS | JSON_HEX_QUOT) }}'>
                            <i data-feather="eye"></i> View Details
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16 text-gray-500">
                    <i data-feather="calendar" class="w-10 h-10 mx-auto mb-3 text-gray-400"></i>
                    <p class="text-sm">No events found for your chapter.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- ==== MODAL ==== --}}
    <div id="eventModal"
        class="hidden fixed inset-0 z-50 bg-black/60 flex items-center justify-center backdrop-blur-sm transition-opacity duration-300">
        <div
            class="modal-card bg-white w-full max-w-3xl rounded-2xl shadow-2xl overflow-hidden border border-red-100 transform scale-90 opacity-0 transition-all duration-300 relative">
            <button onclick="closeEventModal()"
                class="absolute top-4 right-4 bg-white/90 hover:bg-red-600 hover:text-white text-gray-700 p-2 rounded-full shadow-md transition">
                <i data-feather="x" class="w-5 h-5"></i>
            </button>

            <img id="modalBannerImg" src="" class="w-full h-56 object-cover hidden" alt="Event Banner">

            <div class="p-6 space-y-5">
                <div>
                    <h3 id="modalTitle" class="text-2xl font-bold text-gray-800"></h3>
                    <p id="modalStatus"
                        class="inline-block mt-1 text-xs px-3 py-1 rounded-full font-semibold bg-red-50 text-red-600"></p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-gray-700">
                    <p><strong>📅 Date:</strong> <span id="modalDate"></span></p>
                    <p><strong>⏰ Time:</strong> <span id="modalTime"></span></p>
                    <p><strong>📍 Venue:</strong> <span id="modalVenue"></span></p>
                    <p><strong>🏢 Chapter:</strong> <span id="modalChapter"></span></p>
                    <p><strong>👤 Host:</strong> <span id="modalHost"></span></p>
                    <p><strong>📞 Contact:</strong> <span id="modalContact"></span></p>
                    <p><strong>📧 Email:</strong> <span id="modalEmail"></span></p>
                    <p><strong>🎯 Type:</strong> <span id="modalType"></span></p>
                </div>

                <div class="border-t border-gray-200 pt-4 space-y-3 text-sm">
                    <p><strong>🧾 Agenda:</strong> <span id="modalAgenda"></span></p>
                    <p><strong>🗒 Notes:</strong> <span id="modalNotes"></span></p>
                    <p><strong>🌐 Online:</strong> <span id="modalOnline"></span></p>
                    <p id="modalLinkWrapper" class="hidden"><strong>🔗 Meeting Link:</strong> <a id="modalLink" href="#"
                            target="_blank" class="text-red-600 underline"></a></p>
                    <p id="modalPassWrapper" class="hidden"><strong>🔑 Meeting Password:</strong> <span
                            id="modalPass"></span></p>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <strong>📝 Description:</strong>
                    <p id="modalDescription" class="mt-1 text-gray-600 leading-relaxed"></p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-3">
                    <button onclick="confirmAttendance()"
                        class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg shadow-md flex items-center justify-center gap-2 transition">
                        <i data-feather="check"></i> Confirm Attendance
                    </button>
                    <button onclick="closeEventModal()"
                        class="flex-1 bg-gray-800 hover:bg-gray-900 text-white py-2 rounded-lg shadow-md flex items-center justify-center gap-2 transition">
                        <i data-feather="x"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        feather.replace();

        /* ==== Filter Logic (with Active Highlight) ==== */
        const filterButtons = document.querySelectorAll(".filter-btn");

        filterButtons.forEach((btn) => {
            btn.addEventListener("click", () => {
                filterButtons.forEach(b => {
                    b.classList.remove("bg-red-600", "text-white", "shadow-md", "border-red-700");
                    b.classList.add("bg-gray-50", "text-gray-700", "border-gray-300");
                });

                btn.classList.remove("bg-gray-50", "text-gray-700", "border-gray-300");
                btn.classList.add("bg-red-600", "text-white", "shadow-md", "border-red-700");

                const filter = btn.dataset.filter;
                document.querySelectorAll(".event-card").forEach((card) => {
                    const status = card.dataset.status;
                    card.classList.toggle("hidden", filter !== "all" && status !== filter);
                });
            });
        });

        /* ==== Search ==== */
        document.getElementById("searchInput").addEventListener("input", function () {
            const query = this.value.toLowerCase();
            document.querySelectorAll(".event-card").forEach(card => {
                card.classList.toggle("hidden", !card.innerText.toLowerCase().includes(query));
            });
        });

        /* ==== Modal Logic ==== */
        document.querySelectorAll(".view-btn").forEach(btn => {
            btn.addEventListener("click", () => {
                const event = JSON.parse(btn.dataset.event);
                document.getElementById("modalTitle").innerText = event.title ?? '—';
                document.getElementById("modalStatus").innerText = event.status ? event.status.toUpperCase() : 'N/A';
                document.getElementById("modalDate").innerText = event.formatted_date ?? '—';
                document.getElementById("modalTime").innerText = event.start_time && event.end_time
                    ? `${event.start_time} - ${event.end_time}` : '—';
                document.getElementById("modalVenue").innerText = event.full_address ?? event.venue_name ?? '—';
                document.getElementById("modalChapter").innerText = event.chapter ?? '—';
                document.getElementById("modalHost").innerText = event.host_name ?? '—';
                document.getElementById("modalContact").innerText = event.host_contact ?? '—';
                document.getElementById("modalEmail").innerText = event.host_email ?? '—';
                document.getElementById("modalType").innerText = event.event_type ?? '—';
                document.getElementById("modalAgenda").innerText = event.agenda ?? '—';
                document.getElementById("modalNotes").innerText = event.notes ?? '—';
                document.getElementById("modalOnline").innerText = event.is_online ? 'Yes' : 'No';
                document.getElementById("modalDescription").innerText = event.description ?? '—';

                const banner = document.getElementById("modalBannerImg");
                if (event.banner_image) {
                    banner.src = event.banner_image;
                    banner.classList.remove("hidden");
                } else banner.classList.add("hidden");

                const linkWrap = document.getElementById("modalLinkWrapper");
                const passWrap = document.getElementById("modalPassWrapper");
                if (event.is_online && event.meeting_link) {
                    linkWrap.classList.remove("hidden");
                    document.getElementById("modalLink").href = event.meeting_link;
                    document.getElementById("modalLink").innerText = event.meeting_link;
                } else linkWrap.classList.add("hidden");

                if (event.is_online && event.meeting_password) {
                    passWrap.classList.remove("hidden");
                    document.getElementById("modalPass").innerText = event.meeting_password;
                } else passWrap.classList.add("hidden");

                const modal = document.getElementById("eventModal");
                const card = modal.querySelector(".modal-card");
                modal.classList.remove("hidden");
                setTimeout(() => {
                    card.classList.remove("scale-90", "opacity-0");
                    card.classList.add("scale-100", "opacity-100");
                }, 50);
            });
        });

        function closeEventModal() {
            const modal = document.getElementById("eventModal");
            const card = modal.querySelector(".modal-card");
            card.classList.add("scale-90", "opacity-0");
            setTimeout(() => modal.classList.add("hidden"), 200);
        }

        function confirmAttendance() {
            alert("✅ Attendance Confirmed!");
            closeEventModal();
        }
    </script>

    <style>
        .filter-btn {
            @apply px-5 py-2.5 rounded-full text-sm font-medium border transition-all duration-200;
        }

        .event-card:hover {
            transform: translateY(-3px);
        }

        .modal-card {
            transition: all 0.25s ease-in-out;
        }
    </style>
@endsection