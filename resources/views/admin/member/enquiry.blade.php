@include('components.adminheader')

<style>
 /* Enquiry page specific styles (updated) */
.enq-container .card { background: #fff; border-radius: .5rem; box-shadow: 0 1px 4px rgba(2,6,23,0.06); }
.enq-filter .input, .enq-filter select { border: 1px solid #e6e6e6; }

.statusBtn {
  padding: .35rem .5rem;
  border-radius: .375rem;
  font-weight: 600;
  font-size: .775rem;
  display: inline-flex;
  gap: .4rem;
  align-items: center;
  border: 1px solid transparent;
  cursor: pointer;
}
.statusBtn.new { background: #eff6ff; color: #0369a1; border-color: rgba(3,105,161,0.08); }
.statusBtn.closed { background: #ecfdf5; color: #166534; border-color: rgba(22,101,52,0.06); cursor: default; opacity: 0.95; }

/* dropdown */
.statusMenu {
  min-width: 10rem;
  border-radius: .5rem;
  overflow: hidden;
  box-shadow: 0 8px 24px rgba(15,23,42,0.08);
}
.statusMenu button {
  padding: .5rem .75rem;
  width: 100%;
  text-align: left;
  font-size: .95rem;
  background: transparent;
  border: none;
}
.statusMenu button:hover { background: rgba(0,0,0,0.03); }

.statusMenu.fade-in { animation: enqFade .14s ease-out; }
@keyframes enqFade { from { opacity: 0; transform: translateY(-6px); } to { opacity: 1; transform: translateY(0); } }

.row-action .statusBtn:hover { transform: translateY(-2px); transition: .18s; }

/* mobile card tweak */
.enq-mobile-card { padding-bottom: .9rem; }

/* small disabled look for non-interactive closed rows */
.statusBtn.closed { pointer-events: none; }

  </style>
<div class="enq-container p-6 sm:p-10">

  <div class="flex items-start justify-between mb-6">
    <div>
      <h2 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
        <i data-feather="message-square" class="w-5 h-5 text-red-600"></i>
        Enquiries
      </h2>
      <p class="text-gray-600 mt-1">Manage all enquiries submitted by users.</p>
    </div>
  </div>

  <!-- Filters -->
  <div class="card enq-filter p-4 rounded-lg shadow-sm mb-6 bg-white">
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
      <div>
        <label class="text-xs text-gray-600">Search</label>
        <input id="searchInput" class="input mt-1 w-full px-3 py-2 rounded text-sm" placeholder="Name, email, profession…" type="search">
      </div>

      <div>
        <label class="text-xs text-gray-600">Status</label>
        <select id="statusFilter" class="mt-1 w-full px-3 py-2 rounded text-sm">
          <option value="">All</option>
          <option value="new">New</option>
          <option value="closed">Closed</option>
        </select>
      </div>

      <div class="flex items-end justify-end gap-2 sm:col-span-2">
        <button id="clearFilters" class="px-3 py-2 bg-white border rounded text-sm">Clear</button>
        <button id="applyFilters" class="px-3 py-2 bg-red-600 text-white rounded text-sm">Apply</button>
      </div>
    </div>
  </div>

  <!-- Table -->
  <div class="card bg-white rounded-lg shadow-sm overflow-hidden">
    <div class="hidden md:grid grid-cols-12 gap-4 px-4 py-3 text-xs text-gray-500 border-b">
      <div class="col-span-1">#</div>
      <div class="col-span-2">Name</div>
      <div class="col-span-2">Email</div>
      <div class="col-span-2">Phone</div>
      <div class="col-span-2">Profession</div>
      <div class="col-span-1">Status</div>
      <div class="col-span-2 text-right">Action</div>
    </div>

    <div id="rowsContainer" class="divide-y"></div>

    <div class="px-4 py-3 border-t bg-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-sm">
      <div class="text-gray-600">Showing <span id="showStart">0</span>-<span id="showEnd">0</span> of <span id="totalCount">0</span></div>
      <div class="flex items-center gap-2">
        <button id="firstPage" class="px-3 py-1 bg-white border rounded disabled:opacity-50">First</button>
        <button id="prevPage" class="px-3 py-1 bg-white border rounded disabled:opacity-50">Prev</button>
        <button id="nextPage" class="px-3 py-1 bg-white border rounded disabled:opacity-50">Next</button>
      </div>
    </div>
  </div>
</div>

<!-- View Modal (keeps details display if you want to open other ways) -->
<div id="viewModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
  <div class="relative bg-white rounded-xl shadow-xl max-w-lg w-full mx-4">
    <div class="px-6 py-4 border-b flex justify-between items-center">
      <h3 class="text-lg font-semibold">Enquiry Details</h3>
      <button id="closeViewX" class="text-gray-500 hover:text-gray-700">✕</button>
    </div>
    <div id="modalBody" class="p-6 text-sm"></div>
    <div class="p-4 border-t flex justify-end">
      <button id="closeViewBtn" class="px-4 py-2 bg-red-600 text-white rounded">Close</button>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  if (typeof feather !== 'undefined') feather.replace();

  // Demo data (no in_progress)
  let enquiries = [
    {id:1, name:"Ravi Sharma", email:"ravi@gmail.com", contact_number:"9876543210", profession:"Doctor", status:"new", created_at:"2025-01-01"},
    {id:2, name:"Aditi Verma", email:"aditi@gmail.com", contact_number:"9988776655", profession:"Engineer", status:"closed", created_at:"2025-01-15"},
    {id:3, name:"Mohit Jain", email:"mohit@gmail.com", contact_number:"9090909090", profession:"Teacher", status:"new", created_at:"2025-02-01"},
  ];

  let filtered = enquiries.slice();
  let page = 1;
  const pageSize = 6;

  const rowsContainer = document.getElementById('rowsContainer');
  const showStart = document.getElementById('showStart');
  const showEnd = document.getElementById('showEnd');
  const totalCount = document.getElementById('totalCount');
  const prevBtn = document.getElementById('prevPage');
  const nextBtn = document.getElementById('nextPage');
  const firstBtn = document.getElementById('firstPage');

  const searchInput = document.getElementById('searchInput');
  const statusFilter = document.getElementById('statusFilter');
  const applyFiltersBtn = document.getElementById('applyFilters');
  const clearBtn = document.getElementById('clearFilters');

  function badgeInline(status) {
    if (status === "new") return `<span class="px-2 py-1 bg-blue-50 text-blue-700 rounded text-xs">New</span>`;
    return `<span class="px-2 py-1 bg-green-50 text-green-700 rounded text-xs">Closed</span>`;
  }

  function escapeHtml(s) {
    if (s == null) return '';
    return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
  }

  function render() {
    rowsContainer.innerHTML = '';
    const total = filtered.length;
    const start = (page - 1) * pageSize;
    const end = Math.min(start + pageSize, total);
    const pageList = filtered.slice(start, start + pageSize);

    if (!pageList.length) {
      rowsContainer.innerHTML = '<div class="p-6 text-center text-gray-500">No enquiries found.</div>';
    } else {
      pageList.forEach((e, i) => {
        // desktop row
        const desktop = document.createElement('div');
        desktop.className = 'hidden md:grid grid-cols-12 gap-4 px-4 py-4 items-center text-sm';
        desktop.innerHTML = `
          <div class="col-span-1 text-gray-600">${start + i + 1}</div>
          <div class="col-span-2 font-medium">${escapeHtml(e.name)}</div>
          <div class="col-span-2 text-gray-600 truncate">${escapeHtml(e.email || '-')}</div>
          <div class="col-span-2 text-gray-600">${escapeHtml(e.contact_number || '-')}</div>
          <div class="col-span-2 text-gray-600">${escapeHtml(e.profession || '-')}</div>
          <div class="col-span-1">${badgeInline(e.status)}</div>

          <div class="col-span-2 text-right row-action">
            <div class="inline-block relative">
              ${ e.status === 'closed' 
                ? `<button class="statusBtn closed text-sm" data-id="${e.id}"><i data-feather="check" class="w-4 h-4"></i><span class="ml-1">Closed</span></button>`
                : `<button class="statusBtn new text-sm" data-id="${e.id}" aria-expanded="false"><i data-feather="x-circle" class="w-4 h-4"></i><span class="ml-1">New</span></button>
                   <div class="statusMenu hidden absolute right-0 mt-2 bg-white border border-gray-100 z-50 rounded-lg">
                     <button data-new="closed" class="block text-sm">Mark as Closed</button>
                   </div>`
              }
            </div>
          </div>
        `;
        rowsContainer.appendChild(desktop);

        // mobile card
        const mobile = document.createElement('div');
        mobile.className = 'md:hidden px-4 py-4 border-b enq-mobile-card';
        mobile.innerHTML = `
          <div class="flex items-start justify-between gap-3">
            <div>
              <div class="font-medium">${escapeHtml(e.name)}</div>
              <div class="text-xs text-gray-500 mt-1">${escapeHtml(e.profession || '-')}</div>
            </div>

            <div class="text-right">
              <div>${badgeInline(e.status)}</div>
              <div class="mt-2">
                ${ e.status === 'closed' 
                  ? `<button class="statusBtn closed text-sm" data-id="${e.id}"><i data-feather="check" class="w-4 h-4"></i><span class="ml-1">Closed</span></button>`
                  : `<div class="relative inline-block">
                       <button class="statusBtn new text-sm" data-id="${e.id}" aria-expanded="false"><i data-feather="x-circle" class="w-4 h-4"></i><span class="ml-1">New</span></button>
                       <div class="statusMenu hidden absolute right-0 mt-2 bg-white border border-gray-100 z-50 rounded-lg">
                         <button data-new="closed" class="block text-sm">Mark as Closed</button>
                       </div>
                     </div>`
                }
              </div>
            </div>
          </div>
        `;
        rowsContainer.appendChild(mobile);
      });
    }

    // counters & pagination
    showStart.textContent = total ? start + 1 : 0;
    showEnd.textContent = end;
    totalCount.textContent = total;

    prevBtn.disabled = page <= 1;
    firstBtn.disabled = page <= 1;
    nextBtn.disabled = page * pageSize >= total;

    // refresh icons
    if (typeof feather !== 'undefined') feather.replace();
  }

  // filters
  function applyFilters() {
    const q = (searchInput && searchInput.value || '').toLowerCase().trim();
    const st = (statusFilter && statusFilter.value) || '';
    filtered = enquiries.filter(e => {
      const hay = (e.name + ' ' + (e.email||'') + ' ' + (e.profession||'')).toLowerCase();
      if (q && !hay.includes(q)) return false;
      if (st && e.status !== st) return false;
      return true;
    });
    page = 1; render();
  }
  if (applyFiltersBtn) applyFiltersBtn.addEventListener('click', applyFilters);
  if (clearBtn) clearBtn.addEventListener('click', () => {
    if (searchInput) searchInput.value = '';
    if (statusFilter) statusFilter.value = '';
    filtered = enquiries.slice();
    page = 1;
    render();
  });

  // pagination
  if (firstBtn) firstBtn.addEventListener('click', () => { page = 1; render(); });
  if (prevBtn) prevBtn.addEventListener('click', () => { if (page>1) page--; render(); });
  if (nextBtn) nextBtn.addEventListener('click', () => { if ((page * pageSize) < filtered.length) page++; render(); });

  // delegation: status controls
  document.addEventListener('click', (ev) => {
    // toggle menu for new rows
    const statusBtn = ev.target.closest('.statusBtn.new');
    if (statusBtn) {
      const container = statusBtn.parentElement;
      const menu = container.querySelector('.statusMenu');
      document.querySelectorAll('.statusMenu').forEach(m => { if (m !== menu) m.classList.add('hidden'); });
      if (menu) {
        menu.classList.toggle('hidden');
        menu.classList.toggle('fade-in', !menu.classList.contains('hidden'));
      }
      return;
    }

    // clicking the "Mark as Closed" option
    const statusOpt = ev.target.closest('.statusMenu button');
    if (statusOpt) {
      const menu = statusOpt.closest('.statusMenu');
      const container = menu.parentElement;
      const btn = container.querySelector('.statusBtn.new');
      const id = btn && btn.dataset.id;
      const newStatus = statusOpt.dataset.new;
      // update model (persist here with AJAX in production)
      const rec = enquiries.find(x => x.id == id);
      if (rec && rec.status !== 'closed') rec.status = newStatus;

      // hide menus and re-render
      document.querySelectorAll('.statusMenu').forEach(m => m.classList.add('hidden'));
      render();
      return;
    }

    // click outside: close menus
    if (!ev.target.closest('.statusMenu') && !ev.target.closest('.statusBtn.new')) {
      document.querySelectorAll('.statusMenu').forEach(m => m.classList.add('hidden'));
    }
  });

  // modal close handlers (if you later open modal another way)
  const closeViewBtn = document.getElementById('closeViewBtn');
  const closeViewX = document.getElementById('closeViewX');
  if (closeViewBtn) closeViewBtn.addEventListener('click', () => {
    const modal = document.getElementById('viewModal'); if (modal) modal.classList.add('hidden');
  });
  if (closeViewX) closeViewX.addEventListener('click', () => {
    const modal = document.getElementById('viewModal'); if (modal) modal.classList.add('hidden');
  });

  // initial render
  render();
});
</script>
@include('components.script')       