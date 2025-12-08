@extends('layouts.app')

@section('content')
 <div class="p-6 sm:p-10 space-y-6">

  <!-- PAGE HEADER (moved out of filters) -->
  <div class="bg-white shadow-md px-4 sm:px-6 py-3 rounded-lg">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
      <div>
        <h1 class="text-lg sm:text-xl font-semibold text-red-600 flex items-center gap-2">
          <i data-feather="check-circle" class="w-4"></i>
          Chapter Attended
        </h1>
        <p class="text-sm text-gray-600 mt-1">Overview of chapters you've attended and attendance history.</p>
      </div>

      <div class="flex items-center gap-3">
        <div class="hidden sm:flex items-center gap-2">
          <div class="text-xs text-gray-500">Total Attended</div>
          <div class="px-2 py-1 rounded bg-green-50 text-green-700 font-semibold text-sm">18</div>
        </div>

        <button id="exportCsv" class="px-3 py-2 bg-white border rounded-md text-sm hover:shadow-sm flex items-center gap-2">
          <i data-feather="share" class="w-4"></i> Export
        </button>
      </div>
    </div>
  </div>

  <!-- FILTERS -->
  <div class="bg-white p-4 rounded-lg shadow-sm">
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-3 items-end">
      <div>
        <label class="text-xs text-gray-600">Search</label>
        <input id="searchInput" type="search" placeholder="Search by chapter, city, description..."
               class="mt-1 block w-full px-3 py-2 rounded-md border border-slate-200">
      </div>

      <div>
        <label class="text-xs text-gray-600">Chapter</label>
        <select id="chapterFilter" class="mt-1 block w-full px-3 py-2 rounded-md border border-slate-200">
          <option value="">All Chapters</option>
          <option value="Chapter A">Chapter A</option>
          <option value="Chapter B">Chapter B</option>
          <option value="Chapter C">Chapter C</option>
        </select>
      </div>

      <div>
        <label class="text-xs text-gray-600">Date</label>
        <input id="dateFilter" type="date" class="mt-1 block w-full px-3 py-2 rounded-md border border-slate-200">
      </div>

      <div class="flex gap-2 justify-end">
        <button id="clearFilters" class="px-3 py-2 bg-white border rounded-md text-sm hover:shadow-sm">Clear</button>
        <button id="applyFilters" class="px-3 py-2 bg-red-500 text-white rounded-md text-sm">Apply</button>
      </div>
    </div>
  </div>

 <!-- Table / Rows container + template (paste directly after filters) -->
<div class="mt-6 bg-white rounded-lg shadow-sm overflow-hidden p-0">
  <!-- Desktop header -->
  <div class="hidden md:grid grid-cols-12 gap-4 px-4 py-3 text-xs text-gray-500 border-b">
    <div class="col-span-1">#</div>
    <div class="col-span-2">Chapter</div>
    <div class="col-span-3">Details</div>
   <div class="col-span-2">Status</div>
    <div class="col-span-2">Date & Time</div>
    <div class="col-span-1">City</div>
    <div class="col-span-1 text-right">Actions</div>
  </div>

  <!-- rows container where script injects clones -->
  <div id="rowsContainer" class="divide-y"></div>

  <!-- pagination/footer -->
  <div class="px-4 py-3 border-t bg-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div class="text-sm text-gray-600">
      Showing <span id="showCount">0</span>-<span id="showEnd">0</span> of <span id="totalCount">0</span>
      <span class="mx-2 text-gray-400">•</span>
      Page <span id="currentPage">1</span>
    </div>

    <div class="flex items-center gap-2">
      <button id="firstPage" class="px-3 py-1 bg-white border rounded-md disabled:opacity-50">First</button>
      <button id="prevPage" class="px-3 py-1 bg-white border rounded-md disabled:opacity-50">Prev</button>
      <button id="nextPage" class="px-3 py-1 bg-white border rounded-md disabled:opacity-50">Next</button>
    </div>
  </div>
</div>

<!-- Row template used by JS to clone one entry (must exist and have IDs/classes script expects) -->
<template id="rowTemplate">
  <div class="p-4">
    <!-- Desktop row -->
    <div class="hidden md:grid grid-cols-12 gap-4 items-center text-sm">
      <div class="col-span-1 text-gray-600 row-index">1</div>
      <div class="col-span-2 flex items-center gap-3">
        <div class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-gray-700 chapter-initial">C</div>
        <div class="font-medium chapter-name">Chapter A</div>
      </div>
      <div class="col-span-3 text-sm text-gray-600 Details">Entrepreneurship Bootcamp</div>

      <!-- STATUS column (was Leader) -->
      <div class="col-span-2 status-col">
        <span class="status-badge inline-block px-2 py-1 rounded-full bg-gray-100 text-gray-700 text-xs">Attended</span>
      </div>

      <div class="col-span-2 date-time text-sm text-gray-600">2025-11-05 • 10:00</div>
      <div class="col-span-1 city text-sm text-gray-600">Delhi</div>
      <div class="col-span-1 text-right">
        <button class="viewBtn text-blue-600 text-sm font-medium">View</button>
      </div>
    </div>

    <!-- Mobile / card -->
    <div class="md:hidden px-2 py-3">
      <div class="flex items-start justify-between gap-3">
        <div>
          <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-gray-700 chapter-initial-m">C</div>
            <div>
              <div class="font-medium chapter-name-m">Chapter A</div>
              <div class="text-xs text-gray-500 mt-1 Details-city">Entrepreneurship Bootcamp • Delhi</div>
              <!-- show status under details on mobile -->
              <div class="text-xs mt-1">
                <span class="status-badge-mobile inline-block px-2 py-1 rounded-full bg-gray-100 text-gray-700 text-xs">Attended</span>
              </div>
            </div>
          </div>
          <div class="text-xs text-gray-400 mt-2 date-attended">2025-11-05 — Attended</div>
        </div>
        <div class="text-right">
          <button class="viewBtn text-blue-600 text-sm font-medium">View</button>
        </div>
      </div>
    </div>
  </div>
</template>


</div>   
  </div>
  </main>
  <!-- Detail modal -->
<div id="detailModal" class="fixed inset-0 z-50 hidden items-center justify-center">
  <div id="modalOverlay" class="absolute inset-0 bg-black/40"></div>
  <div class="relative max-w-2xl w-full mx-4">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
      <div class="flex items-center justify-between px-6 py-4 border-b">
        <h3 class="text-lg font-semibold">Details</h3>
        <button id="closeModal" class="text-gray-500 hover:text-gray-700">✕</button>
      </div>
      <div id="modalContent" class="p-6 text-sm text-gray-700"></div>
      <div class="p-4 border-t flex justify-end">
        <button id="modalCloseBtn" class="px-4 py-2 bg-red-500 text-white rounded-md">Close</button>
      </div>
    </div>
  </div>
</div>

  <script>
document.addEventListener('DOMContentLoaded', () => {
  // ---------- sample data ----------
  const sampleRows = [
    { id:1, chapter:'Chapter A', Details:'Entrepreneurship Bootcamp', Leader:'Anand', date:'2025-11-05', time:'10:00', city:'Delhi', status:'Attended', desc:'Intensive workshop on starting up.'},
    { id:2, chapter:'Chapter B', Details:'Marketing 101', Leader:'Priya', date:'2025-10-21', time:'18:00', city:'Mumbai', status:'Attended', desc:'Basics of digital marketing.'},
    { id:3, chapter:'Chapter C', Details:'Finance for Founders', Leader:'Ramesh', date:'2025-09-15', time:'15:00', city:'Bengaluru', status:'Attended', desc:'Understanding startup finance.'},
    { id:4, chapter:'Chapter D', Details:'Sales Sprint', Leader:'Anand', date:'2025-08-10', time:'11:00', city:'Delhi', status:'Attended', desc:'Practical sales strategies.'},
    { id:5, chapter:'Chapter E', Details:'Scaling', Leader:'Priya', date:'2025-07-05', time:'14:00', city:'Mumbai', status:'Attended', desc:'How to scale operations.'},
    { id:6, chapter:'Chapter F', Details:'Leadership Lab', Leader:'Karan', date:'2025-06-12', time:'16:00', city:'Pune', status:'Attended', desc:'Leadership skills.'},
    { id:7, chapter:'Chapter G', Details:'Design Sprint', Leader:'Meera', date:'2025-05-20', time:'09:30', city:'Hyderabad', status:'Attended', desc:'Product design.'},
    { id:8, chapter:'Chapter H', Details:'Entrepreneurship Bootcamp', Leader:'Anand', date:'2025-11-05', time:'10:00', city:'Delhi', status:'Attended', desc:'Intensive workshop on starting up.'},
    { id:9, chapter:'Chapter I', Details:'Marketing 101', Leader:'Priya', date:'2025-10-21', time:'18:00', city:'Mumbai', status:'Attended', desc:'Basics of digital marketing.'},
    { id:10, chapter:'Chapter J', Details:'Finance for Founders', Leader:'Ramesh', date:'2025-09-15', time:'15:00', city:'Bengaluru', status:'Attended', desc:'Understanding startup finance.'},
    { id:11, chapter:'Chapter K', Details:'Sales Sprint', Leader:'Anand', date:'2025-08-10', time:'11:00', city:'Delhi', status:'Attended', desc:'Practical sales strategies.'},
    { id:12, chapter:'Chapter L', Details:'Scaling', Leader:'Priya', date:'2025-07-05', time:'14:00', city:'Mumbai', status:'Attended', desc:'How to scale operations.'},
    { id:13, chapter:'Chapter M', Details:'Entrepreneurship Bootcamp', Leader:'Anand', date:'2025-11-05', time:'10:00', city:'Delhi', status:'Attended', desc:'Intensive workshop on starting up.'},
    { id:14, chapter:'Chapter N', Details:'Marketing 101', Leader:'Priya', date:'2025-10-21', time:'18:00', city:'Mumbai', status:'Attended', desc:'Basics of digital marketing.'},
    { id:15, chapter:'Chapter O', Details:'Finance for Founders', Leader:'Ramesh', date:'2025-09-15', time:'15:00', city:'Bengaluru', status:'Attended', desc:'Understanding startup finance.'},
    { id:16, chapter:'Chapter P', Details:'Sales Sprint', Leader:'Anand', date:'2025-08-10', time:'11:00', city:'Delhi', status:'Attended', desc:'Practical sales strategies.'},
    { id:17, chapter:'Chapter Q', Details:'Scaling', Leader:'Priya', date:'2025-07-05', time:'14:00', city:'Mumbai', status:'Attended', desc:'How to scale operations.'},
  ];

  // ---------- state ----------
  let page = 1;
  const pageSize = 5;
  let filtered = sampleRows.slice();

  // ---------- DOM refs ----------
  const rowsContainer = document.getElementById('rowsContainer');
  const rowTemplate = document.getElementById('rowTemplate') ? document.getElementById('rowTemplate').content : null;
  const totalCountEl = document.getElementById('totalCount');
  const showCount = document.getElementById('showCount');
  const showEnd = document.getElementById('showEnd');
  const currentPageEl = document.getElementById('currentPage');
  const prevBtn = document.getElementById('prevPage');
  const nextBtn = document.getElementById('nextPage');
  const firstBtn = document.getElementById('firstPage');

  const applyBtn = document.getElementById('applyFilters');
  const clearBtn = document.getElementById('clearFilters');
  const searchInput = document.getElementById('searchInput');
  const chapterFilter = document.getElementById('chapterFilter');
  const dateFilter = document.getElementById('dateFilter');
  const exportBtn = document.getElementById('exportCsv');

  if (!rowsContainer || !rowTemplate) {
    console.warn('Required DOM elements not present.');
    return;
  }

  // ---------- helpers ----------
  const esc = s => s == null ? '' : String(s).replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;');

  function makeStatusBadgeText(status) {
    // map statuses to colors or labels if you want different styles later
    const txt = esc(status || '—');
    return txt;
  }

  // ---------- render one page ----------
  function renderPage() {
    rowsContainer.innerHTML = '';

    const total = filtered.length;
    const start = (page - 1) * pageSize;
    const rawEnd = start + pageSize;
    const end = Math.min(rawEnd, total);
    const pageRows = filtered.slice(start, rawEnd);

    if (!pageRows.length) {
      const empty = document.createElement('div');
      empty.className = 'p-6 text-center text-gray-500';
      empty.textContent = 'No chapters found.';
      rowsContainer.appendChild(empty);
    } else {
      pageRows.forEach((r, idx) => {
        const row = rowTemplate.cloneNode(true);

        // Desktop
        const rowIndexEl = row.querySelector('.row-index');
        if (rowIndexEl) rowIndexEl.textContent = start + idx + 1;

        const chapterInitial = row.querySelector('.chapter-initial');
        if (chapterInitial) chapterInitial.textContent = r.chapter ? r.chapter.charAt(0) : '';

        const chapterName = row.querySelector('.chapter-name');
        if (chapterName) chapterName.textContent = r.chapter || '';

        const detailsEl = row.querySelector('.Details');
        if (detailsEl) detailsEl.textContent = r.Details || '';

        // Status cell (desktop)
        const statusCol = row.querySelector('.status-col');
        if (statusCol) {
          const badge = row.querySelector('.status-badge');
          if (badge) {
            // set color class depending on status (you can extend map)
            const s = (r.status || '').toLowerCase();
            badge.textContent = makeStatusBadgeText(r.status);
            badge.className = 'status-badge inline-block px-2 py-1 rounded-full text-xs';
            if (s === 'attended' || s === 'completed' || s === 'present') {
              badge.classList.add('bg-green-50','text-green-700');
            } else if (s === 'missed' || s === 'absent') {
              badge.classList.add('bg-red-50','text-red-700');
            } else {
              badge.classList.add('bg-gray-100','text-gray-700');
            }
          }
        }

        const dateTime = row.querySelector('.date-time');
        if (dateTime) dateTime.textContent = (r.date || '') + ' • ' + (r.time || '');

        const cityEl = row.querySelector('.city');
        if (cityEl) cityEl.textContent = r.city || '';

        // Mobile
        const chapterInitialM = row.querySelector('.chapter-initial-m');
        if (chapterInitialM) chapterInitialM.textContent = r.chapter ? r.chapter.charAt(0) : '';

        const chapterNameM = row.querySelector('.chapter-name-m');
        if (chapterNameM) chapterNameM.textContent = r.chapter || '';

        const detailsCity = row.querySelector('.Details-city');
        if (detailsCity) detailsCity.textContent = (r.Details || '') + ' • ' + (r.city || '');

        const dateAttended = row.querySelector('.date-attended');
        if (dateAttended) dateAttended.textContent = (r.date || '') + ' — ' + (r.status || '');

        // mobile status badge
        const badgeMobile = row.querySelector('.status-badge-mobile');
        if (badgeMobile) {
          badgeMobile.textContent = makeStatusBadgeText(r.status);
          const s = (r.status || '').toLowerCase();
          badgeMobile.className = 'status-badge-mobile inline-block px-2 py-1 rounded-full text-xs';
          if (s === 'attended' || s === 'completed' || s === 'present') {
            badgeMobile.classList.add('bg-green-50','text-green-700');
          } else if (s === 'missed' || s === 'absent') {
            badgeMobile.classList.add('bg-red-50','text-red-700');
          } else {
            badgeMobile.classList.add('bg-gray-100','text-gray-700');
          }
        }

        // attach id to view buttons
        row.querySelectorAll('.viewBtn').forEach(btn => btn.dataset.id = r.id);

        rowsContainer.appendChild(row);
      });
    }

    // counters
    totalCountEl.textContent = total;
    showCount.textContent = total ? (start + 1) : 0;
    showEnd.textContent = total ? end : 0;
    if (currentPageEl) currentPageEl.textContent = page;

    if (prevBtn) prevBtn.disabled = page <= 1;
    if (firstBtn) firstBtn.disabled = page <= 1;
    if (nextBtn) nextBtn.disabled = end >= total || total === 0;
  }

  // ---------- filtering ----------
  function applyFilters() {
    const q = (searchInput ? searchInput.value : '').toLowerCase().trim();
    const chapter = chapterFilter ? chapterFilter.value : '';
    const date = dateFilter ? dateFilter.value : '';

    filtered = sampleRows.filter(r => {
      const hay = (r.chapter + ' ' + r.Details + ' ' + r.city + ' ' + (r.desc || '')).toLowerCase();
      const matchesQ = !q || hay.includes(q);
      const matchesChapter = !chapter || r.chapter === chapter;
      const matchesDate = !date || r.date === date;
      return matchesQ && matchesChapter && matchesDate;
    });

    page = 1;
    renderPage();
  }

  if (applyBtn) applyBtn.addEventListener('click', applyFilters);
  if (clearBtn) clearBtn.addEventListener('click', () => {
    if (searchInput) searchInput.value = '';
    if (chapterFilter) chapterFilter.value = '';
    if (dateFilter) dateFilter.value = '';
    filtered = sampleRows.slice();
    page = 1;
    renderPage();
  });

  // ---------- pagination ----------
  if (prevBtn) prevBtn.addEventListener('click', () => {
    if (page <= 1) return;
    page--;
    renderPage();
    rowsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
  });

  if (firstBtn) firstBtn.addEventListener('click', () => {
    if (page === 1) return;
    page = 1;
    renderPage();
    rowsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
  });

  if (nextBtn) nextBtn.addEventListener('click', () => {
    if ((page * pageSize) >= filtered.length) return;
    page++;
    renderPage();
    rowsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
  });

  // ---------- view details ----------
  const detailModal = document.getElementById('detailModal');
  const modalOverlay = document.getElementById('modalOverlay');
  const modalContent = document.getElementById('modalContent');
  const closeModal = document.getElementById('closeModal');
  const modalCloseBtn = document.getElementById('modalCloseBtn');

  function openDetail(id) {
    const item = sampleRows.find(x => x.id == id);
    if (!item) return;
    if (modalContent) {
      modalContent.innerHTML = `
        <div>
          <h4 class="text-lg font-semibold">${esc(item.chapter)} — ${esc(item.Details)}</h4>
          <p class="text-sm text-gray-600 mt-2">${esc(item.desc)}</p>
          <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
            <div><strong>Date</strong><div class="text-gray-600">${esc(item.date)}</div></div>
            <div><strong>Time</strong><div class="text-gray-600">${esc(item.time)}</div></div>
            <div><strong>City</strong><div class="text-gray-600">${esc(item.city)}</div></div>
            <div><strong>Leader</strong><div class="text-gray-600">${esc(item.Leader)}</div></div>
            <div class="col-span-2"><strong>Status</strong>
              <div class="mt-1"><span class="inline-block px-2 py-1 rounded-full bg-green-50 text-green-700 text-xs">${esc(item.status)}</span></div>
            </div>
          </div>
        </div>
      `;
    }
    if (detailModal) { detailModal.classList.remove('hidden'); detailModal.style.display = 'flex'; }
  }

  function closeDetail() {
    if (detailModal) { detailModal.classList.add('hidden'); detailModal.style.display = 'none'; }
  }

  document.addEventListener('click', (ev) => {
    const btn = ev.target.closest && ev.target.closest('.viewBtn');
    if (!btn) return;
    const id = btn.dataset.id;
    if (!id) return;
    openDetail(parseInt(id, 10));
  });

  if (modalOverlay) modalOverlay.addEventListener('click', closeDetail);
  if (closeModal) closeModal.addEventListener('click', closeDetail);
  if (modalCloseBtn) modalCloseBtn.addEventListener('click', closeDetail);
  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDetail(); });

  // ---------- export CSV ----------
  if (exportBtn) exportBtn.addEventListener('click', () => {
    const rows = filtered.map(r => [r.chapter, r.Details, r.date, r.time, r.city, r.status]);
    const header = ['Chapter','Details','Date','Time','City','Status'];
    const csv = [header, ...rows].map(r => r.map(c => `"${String(c || '').replace(/"/g,'""')}"`).join(',')).join('\n');
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a'); a.href = url; a.download = 'chapter_attended.csv'; a.click();
    URL.revokeObjectURL(url);
  });

  // ---------- initial render ----------
  filtered = sampleRows.slice();
  renderPage();

  // refresh icons if needed
  if (typeof feather !== 'undefined' && feather.replace) feather.replace();
});
</script>
@endsection