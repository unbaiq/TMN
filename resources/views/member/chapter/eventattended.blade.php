@extends('layouts.app')

@section('content')
<style>
/* Reusing premium styles from your referral UI */

.nav-active {
    background: linear-gradient(to right, #ffe6e6, #ffffff);
    border-right: 4px solid #e53935;
    box-shadow: inset 0 0 10px rgba(229, 57, 53, 0.15);
}

.nav-item {
    border-radius: 0.75rem;
    transition: all 0.25s ease;
    padding: 0.75rem 1rem;
    display: flex;
    align-items: center;
}
.nav-item:hover {
    background: rgba(255, 0, 0, 0.08);
    transform: translateX(6px);
}

/* Inputs Enhancements */
input, select {
    transition: all .2s ease-in-out;
}
input:focus, select:focus {
    border-color: #e11d48 !important;
    box-shadow: 0 0 0 3px rgba(225,29,72,0.25);
}

/* Card Hover */
.bg-white.rounded-xl.shadow-md {
    transition: all 0.25s ease;
}
.bg-white.rounded-xl.shadow-md:hover {
    box-shadow: 0 12px 28px rgba(0,0,0,0.08);
}

/* Table UI */
thead tr {
    background: #f8fafc !important;
    text-transform: uppercase;
    font-size: 0.7rem;
    letter-spacing: 0.5px;
}
tbody tr:hover {
    background: #fafafa;
}

/* Status Badges */
.status-green {
    background: #d9fbe5 !important;
    color: #137333 !important;
}
.status-red {
    background: #ffe2e2 !important;
    color: #cc0000 !important;
}
.status-gray {
    background: #e5e7eb !important;
    color: #374151 !important;
}

/* Modal Animation */
.modal-card {
    animation: modalPop 0.22s ease-out;
}
@keyframes modalPop {
  from { opacity: 0; transform: translateY(10px) scale(0.95); }
  to { opacity: 1; transform: translateY(0) scale(1); }
}
</style>

<!-- MAIN WRAPPER -->
<main class="w-full p-2 h-full sm:p-8 ">
      <div class="max-w-7xl mx-auto animate-fadeIn">
        <div class="max-w-7xl mx-auto my-10 px-4 sm:px-6 lg:px-8">

    <!-- PAGE HEADER -->
    <div class="bg-white shadow-lg rounded-2xl p-6">
        <h3 class="text-xl font-semibold mb-6 text-gray-700">Chapter Attended</h3>
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-5">
            <!-- Search -->
            <div class="flex items-center gap-2 w-full md:w-1/2 relative">
        <i data-feather="search" class="w-5 h-5 text-gray-500 absolute left-3 top-1/2 -translate-y-1/2"></i>
        <input type="text" id="searchInput" placeholder="Search by chapter, city, details..." class="w-full pl-11 pr-4 py-2 bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none">
            </div>

            <!-- Chapter -->
                <select id="chapterFilter"
                    class="px-4 py-2 md:w-1/4 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-red-400 outline-none">
                    <option value="">All Chapters</option>
                    <option>Chapter A</option>
                    <option>Chapter B</option>
                    <option>Chapter C</option>
                </select>
        </div>
    

    <!-- TABLE + CARD VIEW -->
    <div class="bg-white shadow-lg rounded-2xl p-0 overflow-hidden border border-gray-100">

        <!-- Desktop Header -->
        <div class="hidden md:grid grid-cols-12 gap-4 px-6 py-3 text-xs font-semibold text-gray-600 bg-gray-50 border-b">
            <div class="col-span-1">#</div>
            <div class="col-span-2">Chapter</div>
            <div class="col-span-3">Details</div>
            <div class="col-span-2">Status</div>
            <div class="col-span-2">Date & Time</div>
            <div class="col-span-1">City</div>
            <div class="col-span-1 text-right">Actions</div>
        </div>

<!-- STATIC ROWS (DUMMY DATA NOT IN SCRIPT) -->
<div id="rowsContainer" class="divide-y">

    <!-- Row 1 -->
    <div class="p-4">
        <div class="hidden md:grid grid-cols-12 gap-4 items-center text-sm">

            <div class="col-span-1 text-gray-600">1</div>

            <div class="col-span-2 flex items-center gap-3">
                <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center font-semibold text-gray-700">A</div>
                <div class="font-semibold text-gray-800">Chapter A</div>
            </div>

            <div class="col-span-3 text-gray-600">Entrepreneurship Bootcamp</div>

            <div class="col-span-2">
                <span class="inline-block px-2 py-1 rounded-full text-xs status-green">
                    Attended
                </span>
            </div>

            <div class="col-span-2 text-gray-600">2025-11-05 • 10:00</div>

            <div class="col-span-1 text-gray-600">Delhi</div>

            <div class="col-span-1 text-right">
                <button class="text-blue-600 font-semibold hover:underline">View</button>
            </div>
        </div>

        <!-- Mobile -->
        <div class="md:hidden border bg-white rounded-xl p-4 shadow-sm">
            <div class="flex justify-between items-center">
                <div class="flex gap-3 items-center">
                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center font-semibold">A</div>
                    <div>
                        <div class="font-semibold text-gray-800">Chapter A</div>
                        <div class="text-xs text-gray-500">Entrepreneurship Bootcamp • Delhi</div>
                        <span class="inline-block px-2 py-1 mt-2 rounded-full text-xs status-green">Attended</span>
                    </div>
                </div>
                <button class="text-blue-600 font-semibold text-sm hover:underline">View</button>
            </div>
            <div class="text-xs text-gray-500 mt-2">2025-11-05 — Attended</div>
        </div>
    </div>

    <!-- Row 2 -->
    <div class="p-4">
        <div class="hidden md:grid grid-cols-12 gap-4 items-center text-sm">

            <div class="col-span-1 text-gray-600">2</div>

            <div class="col-span-2 flex items-center gap-3">
                <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center font-semibold text-gray-700">B</div>
                <div class="font-semibold text-gray-800">Chapter B</div>
            </div>

            <div class="col-span-3 text-gray-600">Marketing 101</div>

            <div class="col-span-2">
                <span class="inline-block px-2 py-1 rounded-full text-xs status-green">
                    Attended
                </span>
            </div>

            <div class="col-span-2 text-gray-600">2025-10-21 • 18:00</div>

            <div class="col-span-1 text-gray-600">Mumbai</div>

            <div class="col-span-1 text-right">
                <button class="text-blue-600 font-semibold hover:underline">View</button>
            </div>
        </div>

        <!-- Mobile -->
        <div class="md:hidden border bg-white rounded-xl p-4 shadow-sm">
            <div class="flex justify-between items-center">
                <div class="flex gap-3 items-center">
                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center font-semibold">B</div>
                    <div>
                        <div class="font-semibold text-gray-800">Chapter B</div>
                        <div class="text-xs text-gray-500">Marketing 101 • Mumbai</div>
                        <span class="inline-block px-2 py-1 mt-2 rounded-full text-xs status-green">Attended</span>
                    </div>
                </div>
                <button class="text-blue-600 font-semibold text-sm hover:underline">View</button>
            </div>
            <div class="text-xs text-gray-500 mt-2">2025-10-21 — Attended</div>
        </div>
    </div>

    <!-- Row 3 -->
    <div class="p-4">
        <div class="hidden md:grid grid-cols-12 gap-4 items-center text-sm">

            <div class="col-span-1 text-gray-600">3</div>

            <div class="col-span-2 flex items-center gap-3">
                <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center font-semibold text-gray-700">C</div>
                <div class="font-semibold text-gray-800">Chapter C</div>
            </div>

            <div class="col-span-3 text-gray-600">Finance for Founders</div>

            <div class="col-span-2">
                <span class="inline-block px-2 py-1 rounded-full text-xs status-green">
                    Attended
                </span>
            </div>

            <div class="col-span-2 text-gray-600">2025-09-15 • 15:00</div>

            <div class="col-span-1 text-gray-600">Bengaluru</div>

            <div class="col-span-1 text-right">
                <button class="text-blue-600 font-semibold hover:underline">View</button>
            </div>
        </div>

        <!-- Mobile -->
        <div class="md:hidden border bg-white rounded-xl p-4 shadow-sm">
            <div class="flex justify-between items-center">
                <div class="flex gap-3 items-center">
                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center font-semibold">C</div>
                    <div>
                        <div class="font-semibold text-gray-800">Chapter C</div>
                        <div class="text-xs text-gray-500">Finance for Founders • Bengaluru</div>
                        <span class="inline-block px-2 py-1 mt-2 rounded-full text-xs status-green">Attended</span>
                    </div>
                </div>
                <button class="text-blue-600 font-semibold text-sm hover:underline">View</button>
            </div>
            <div class="text-xs text-gray-500 mt-2">2025-09-15 — Attended</div>
        </div>
    </div>

</div>
        <!-- Pagination -->
        <div class="flex items-center justify-between px-6 py-4 border-t">
            <div class="text-sm text-gray-600">
                Showing <span id="showCount">1</span> to <span id="showEnd">3</span> of <span id="totalCount">3</span> chapters
            </div>
            <div class="flex items-center gap-2">
                <button id="firstPage" class="px-3 py-1 bg-gray-200 rounded-lg hover:bg-gray-300 disabled:opacity-50" disabled>
                    First
                </button>
                <button id="prevPage" class="px-3 py-1 bg-gray-200 rounded-lg hover:bg-gray-300 disabled:opacity-50" disabled>
                    Previous
                </button>
                <button id="nextPage" class="px-3 py-1 bg-gray-200 rounded-lg hover:bg-gray-300 disabled:opacity-50" disabled>
                    Next
                </button>
            </div>  

</div>
</main>

<!-- MODAL -->
<div id="detailModal"
     class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-50">

    <div class="bg-white rounded-2xl max-w-lg w-full shadow-xl modal-card overflow-hidden">

        <div class="flex items-center justify-between px-6 py-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Chapter Details</h3>
            <button id="closeModal" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>

        <div id="modalContent" class="p-6 text-sm text-gray-700 leading-relaxed"></div>

        <div class="p-4 border-t flex justify-end">
            <button id="modalCloseBtn"
                class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg">
                Close
            </button>
        </div>
    </div>
</div>


<!-- JAVASCRIPT (your same logic, cleaned + improved badge UI) -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    feather.replace();
    
    /* Your SAME logic from the first code
       + only badge colors upgraded to match premium colors
       + no breaking changes
    */

    // Sample data
    const sampleRows = [
        { id:1, chapter:'Chapter A', Details:'Entrepreneurship Bootcamp', Leader:'Anand', date:'2025-11-05', time:'10:00', city:'Delhi', status:'Attended', desc:'Intensive workshop on starting up.'},
        { id:2, chapter:'Chapter B', Details:'Marketing 101', Leader:'Priya', date:'2025-10-21', time:'18:00', city:'Mumbai', status:'Attended', desc:'Basics of digital marketing.'},
        { id:3, chapter:'Chapter C', Details:'Finance for Founders', Leader:'Ramesh', date:'2025-09-15', time:'15:00', city:'Bengaluru', status:'Attended', desc:'Understanding startup finance.'},
        { id:4, chapter:'Chapter D', Details:'Sales Sprint', Leader:'Anand', date:'2025-08-10', time:'11:00', city:'Delhi', status:'Attended', desc:'Practical sales strategies.'},
        { id:5, chapter:'Chapter E', Details:'Scaling', Leader:'Priya', date:'2025-07-05', time:'14:00', city:'Mumbai', status:'Attended', desc:'How to scale operations.'},
    ];

    let page = 1;
    const pageSize = 5;
    let filtered = sampleRows.slice();

    const rowsContainer = document.getElementById("rowsContainer");
    const rowTemplate = document.getElementById("rowTemplate").content;

    const showCount = document.getElementById("showCount");
    const showEnd = document.getElementById("showEnd");
    const totalCount = document.getElementById("totalCount");

    const prevBtn = document.getElementById("prevPage");
    const nextBtn = document.getElementById("nextPage");
    const firstBtn = document.getElementById("firstPage");

    const searchInput = document.getElementById("searchInput");
    const chapterFilter = document.getElementById("chapterFilter");
    const dateFilter = document.getElementById("dateFilter");

    /* Helper — Badge Colors */
    function applyBadge(el, status) {
        const s = status.toLowerCase();
        el.className = "inline-block px-2 py-1 rounded-full text-xs";

        if (s === "attended" || s === "completed" || s === 
            "present") {
            el.classList.add("status-green");
        } else if (s === "missed" || s === "absent") {
            el.classList.add("status-red");
        } else {
            el.classList.add("status-gray");
        }

        el.textContent = status;
    }

    /* Render Table */
    function renderPage() {
        rowsContainer.innerHTML = "";
        const total = filtered.length;

        const start = (page - 1) * pageSize;
        const end = Math.min(start + pageSize, total);
        const pageRows = filtered.slice(start, end);

        totalCount.textContent = total;
        showCount.textContent = total ? start + 1 : 0;
        showEnd.textContent = end;

        if (!pageRows.length) {
            rowsContainer.innerHTML =
                `<div class='p-6 text-center text-gray-500'>No chapters found.</div>`;
            return;
        }

        pageRows.forEach((r, idx) => {
            const row = rowTemplate.cloneNode(true);

            row.querySelector(".row-index").textContent = start + idx + 1;
            row.querySelector(".chapter-initial").textContent = r.chapter[0];
            row.querySelector(".chapter-initial-m").textContent = r.chapter[0];

            row.querySelector(".chapter-name").textContent = r.chapter;
            row.querySelector(".chapter-name-m").textContent = r.chapter;

            row.querySelector(".Details").textContent = r.Details;
            row.querySelector(".Details-city").textContent = `${r.Details} • ${r.city}`;

            row.querySelector(".date-time").textContent = `${r.date} • ${r.time}`;
            row.querySelector(".date-attended").textContent = `${r.date} — ${r.status}`;
            row.querySelector(".city").textContent = r.city;

            // Status badges
            applyBadge(row.querySelector(".status-badge"), r.status);
            applyBadge(row.querySelector(".status-badge-mobile"), r.status);

            // View buttons
            row.querySelectorAll(".viewBtn").forEach(btn => btn.dataset.id = r.id);

            rowsContainer.appendChild(row);
        });

        prevBtn.disabled = page <= 1;
        firstBtn.disabled = page <= 1;
        nextBtn.disabled = end >= total;
    }

    /* Filters */
    function applyFilters() {
        const q = searchInput.value.toLowerCase().trim();
        const chapter = chapterFilter.value;
        const date = dateFilter.value;

        filtered = sampleRows.filter(r => {
            let hay = (r.chapter + " " + r.Details + " " + r.city).toLowerCase();
            return (!q || hay.includes(q)) &&
                   (!chapter || r.chapter === chapter) &&
                   (!date || r.date === date);
        });

        page = 1;
        renderPage();
    }

    document.getElementById("applyFilters").addEventListener("click", applyFilters);

    document.getElementById("clearFilters").addEventListener("click", () => {
        searchInput.value = "";
        chapterFilter.value = "";
        dateFilter.value = "";
        filtered = sampleRows.slice();
        page = 1;
        renderPage();
    });

    /* Pagination */
    prevBtn.onclick = () => { if (page > 1) page--; renderPage(); };
    firstBtn.onclick = () => { page = 1; renderPage(); };
    nextBtn.onclick = () => { if (page * pageSize < filtered.length) page++; renderPage(); };

    /* Modal */
    const detailModal = document.getElementById("detailModal");
    const modalContent = document.getElementById("modalContent");

    function openDetail(id) {
        const item = sampleRows.find(x => x.id == id);

        modalContent.innerHTML = `
            <p><strong>Chapter:</strong> ${item.chapter}</p>
            <p><strong>Details:</strong> ${item.Details}</p>
            <p><strong>Description:</strong> ${item.desc}</p>
            <p><strong>Date:</strong> ${item.date}</p>
            <p><strong>Time:</strong> ${item.time}</p>
            <p><strong>City:</strong> ${item.city}</p>
            <p><strong>Status:</strong> ${item.status}</p>
        `;

        detailModal.classList.remove("hidden");
        detailModal.classList.add("flex");
    }

    document.addEventListener("click", (ev) => {
        const btn = ev.target.closest(".viewBtn");
        if (!btn) return;
        openDetail(btn.dataset.id);
    });

    function closeDetail() {
        detailModal.classList.add("hidden");
        detailModal.classList.remove("flex");
    }

    document.getElementById("closeModal").onclick = closeDetail;
    document.getElementById("modalCloseBtn").onclick = closeDetail;

    renderPage();
});
</script>

@endsection
