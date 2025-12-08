@extends('layouts.app')

@section('content')

<div class="p-6 sm:p-10">
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl font-semibold text-gray-800">Member Businesses</h1>
        <p class="text-sm text-gray-600">Business transactions between you and other chapter members.</p>
      </div>

      <div class="flex items-center gap-3">
        <button id="exportCsv" class="px-3 py-2 bg-white border rounded-md text-sm flex items-center gap-2 hover:shadow-sm">
          <i data-feather="share" class="w-4"></i> Export
        </button>

        <button id="openAddBtn" class="px-4 py-2 bg-red-500 text-white rounded-md text-sm flex items-center gap-2 shadow-md">
          <i data-feather="plus" class="w-4"></i> Add Business
        </button>
      </div>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-lg shadow-sm mb-6 grid grid-cols-1 md:grid-cols-4 gap-3">
      <div>
        <label class="text-xs text-gray-600">Search</label>
        <input id="q" type="search" placeholder="Title, description, member..." class="mt-1 block w-full px-3 py-2 rounded-md border border-slate-200" />
      </div>

      <div>
        <label class="text-xs text-gray-600">Role</label>
        <select id="roleFilter" class="mt-1 block w-full px-3 py-2 rounded-md border border-slate-200">
          <option value="">Any</option>
          <option value="giver">Giver</option>
          <option value="taker">Taker</option>
        </select>
      </div>

      <div>
        <label class="text-xs text-gray-600">Status</label>
        <select id="statusFilter" class="mt-1 block w-full px-3 py-2 rounded-md border border-slate-200">
          <option value="">All</option>
          <option value="initiated">Initiated</option>
          <option value="in_progress">In Progress</option>
          <option value="completed">Completed</option>
          <option value="cancelled">Cancelled</option>
        </select>
      </div>

      <div class="flex items-end gap-2 justify-end">
        <button id="clearFilters" class="px-3 py-2 bg-white border rounded-md text-sm">Clear</button>
        <button id="applyFilters" class="px-3 py-2 bg-red-500 text-white rounded-md text-sm">Apply</button>
      </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
      <div class="hidden md:grid grid-cols-12 gap-4 px-4 py-3 text-xs text-gray-500 border-b">
        <div class="col-span-1">#</div>
        <div class="col-span-3">Business</div>
        <div class="col-span-2">Role</div>
        <div class="col-span-2">Counterparty</div>
        <div class="col-span-2">Value</div>
        <div class="col-span-1">Status</div>
        <div class="col-span-1 text-right">Actions</div>
      </div>

      <div id="rows" class="divide-y"></div>

      <!-- Pagination -->
      <div class="px-4 py-3 border-t bg-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="text-sm text-gray-600">
          Showing <span id="showStart">0</span>-<span id="showEnd">0</span> of <span id="total">0</span>
          <span class="mx-2 text-gray-400">•</span>
          Page <span id="pageNum">1</span>
        </div>

        <div class="flex items-center gap-2">
          <button id="firstPage" class="px-3 py-1 bg-white border rounded-md disabled:opacity-50">First</button>
          <button id="prevPage" class="px-3 py-1 bg-white border rounded-md disabled:opacity-50">Prev</button>
          <button id="nextPage" class="px-3 py-1 bg-white border rounded-md disabled:opacity-50">Next</button>
        </div>
      </div>
    </div>
  </main>

  <!-- VIEW MODAL -->
  <div id="viewModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div id="viewOverlay" class="absolute inset-0 bg-black/40"></div>
    <div class="relative max-w-2xl w-full mx-4">
      <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b">
          <h3 class="text-lg font-semibold">Business Details</h3>
          <button id="closeView" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>
        <div id="viewContent" class="p-6 text-sm text-gray-700"></div>
        <div class="p-4 border-t flex justify-end">
          <button id="viewCloseBtn" class="px-4 py-2 bg-red-500 text-white rounded-md">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- ADD MODAL -->
  <div id="addModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div id="addOverlay" class="absolute inset-0 bg-black/40"></div>
    <div class="relative max-w-xl w-full mx-4">
      <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b">
          <h3 class="text-lg font-semibold">Add Business</h3>
          <button id="closeAdd" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>

        <form id="addForm" class="p-6 space-y-3">
          <div>
            <label class="text-xs text-gray-600">Business Title</label>
            <input id="b_title" required class="mt-1 w-full px-3 py-2 border rounded-md" />
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
              <label class="text-xs text-gray-600">You are</label>
              <select id="b_role" class="mt-1 w-full px-3 py-2 border rounded-md">
                <option value="giver">Giver</option>
                <option value="taker">Taker</option>
              </select>
            </div>

            <div>
              <label class="text-xs text-gray-600">Counterparty (Member ID)</label>
              <input id="b_counterparty" class="mt-1 w-full px-3 py-2 border rounded-md" placeholder="e.g., 205" />
            </div>
          </div>

          <div>
            <label class="text-xs text-gray-600">Business Value (INR)</label>
            <input id="b_value" type="number" min="0" step="0.01" class="mt-1 w-full px-3 py-2 border rounded-md" />
          </div>

          <div>
            <label class="text-xs text-gray-600">Description</label>
            <textarea id="b_desc" rows="3" class="mt-1 w-full px-3 py-2 border rounded-md"></textarea>
          </div>

          <div class="flex items-center gap-2 justify-end pt-2">
            <button type="button" id="cancelAddBtn" class="px-3 py-2 bg-white border rounded-md">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md">Create</button>
          </div>
        </form>

      </div>
    </div>
  </div>
  </div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  /* ---------- sample data ----------
     mimic server rows from migration: member_one_id, member_two_id, member_one_role, business_title,
     description, business_value, attachment (url string or null), status, member_one_notes, member_two_notes, completed_at
  */
  const currentMemberId = 100; // pretend logged-in member id
  let businesses = [
    {
      id: 1,
      member_one_id: 100,
      member_two_id: 205,
      member_one_role: 'giver',
      business_title: 'IT Services Contract',
      description: 'Quarterly retainer for IT infrastructure management.',
      business_value: 50000,
      attachment: null,
      status: 'in_progress',
      member_one_notes: 'Started work',
      member_two_notes: 'Paid first installment',
      completed_at: null
    },
    {
      id: 2,
      member_one_id: 301,
      member_two_id: 100,
      member_one_role: 'giver',
      business_title: 'Consulting - Marketing',
      description: 'Marketing strategy and execution for launch.',
      business_value: 75000,
      attachment: 'https://via.placeholder.com/400x200.png?text=invoice.pdf',
      status: 'completed',
      member_one_notes: 'Delivered report',
      member_two_notes: 'Happy with results',
      completed_at: '2025-03-10'
    },
    {
      id: 3,
      member_one_id: 100,
      member_two_id: 205,
      member_one_role: 'taker',
      business_title: 'Product Design',
      description: 'Product redesign and UI/UX improvements.',
      business_value: 20000,
      attachment: null,
      status: 'initiated',
      member_one_notes: '',
      member_two_notes: '',
      completed_at: null
    }
  ];

  // state
  let filtered = [...businesses];
  let page = 1;
  const pageSize = 6;

  // refs
  const rowsEl = document.getElementById('rows');
  const showStart = document.getElementById('showStart');
  const showEnd = document.getElementById('showEnd');
  const totalEl = document.getElementById('total');
  const pageNum = document.getElementById('pageNum');
  const firstPage = document.getElementById('firstPage');
  const prevPage = document.getElementById('prevPage');
  const nextPage = document.getElementById('nextPage');

  const qEl = document.getElementById('q');
  const roleFilter = document.getElementById('roleFilter');
  const statusFilter = document.getElementById('statusFilter');
  const applyFilters = document.getElementById('applyFilters');
  const clearFilters = document.getElementById('clearFilters');

  const exportCsvBtn = document.getElementById('exportCsv');

  // modals
  const viewModal = document.getElementById('viewModal');
  const viewOverlay = document.getElementById('viewOverlay');
  const viewContent = document.getElementById('viewContent');
  const closeView = document.getElementById('closeView');
  const viewCloseBtn = document.getElementById('viewCloseBtn');

  const addModal = document.getElementById('addModal');
  const addOverlay = document.getElementById('addOverlay');
  const openAddBtn = document.getElementById('openAddBtn');
  const closeAdd = document.getElementById('closeAdd');
  const cancelAddBtn = document.getElementById('cancelAddBtn');
  const addForm = document.getElementById('addForm');

  // add form fields
  const b_title = document.getElementById('b_title');
  const b_role = document.getElementById('b_role');
  const b_counterparty = document.getElementById('b_counterparty');
  const b_value = document.getElementById('b_value');
  const b_desc = document.getElementById('b_desc');

  function formatCurrency(v){
    if (v == null || v === '') return '-';
    return '₹' + Number(v).toLocaleString('en-IN', {maximumFractionDigits:2});
  }

  function roleLabel(role){
    if(role==='giver') return '<span class="px-2 py-1 rounded-full bg-red-50 text-red-700 text-xs">Giver</span>';
    if(role==='taker') return '<span class="px-2 py-1 rounded-full bg-blue-50 text-blue-700 text-xs">Taker</span>';
    return '<span class="px-2 py-1 rounded-full bg-gray-50 text-gray-700 text-xs">N/A</span>';
  }

  function statusLabel(s){
    const map = {
      initiated: 'bg-yellow-50 text-yellow-700',
      in_progress: 'bg-indigo-50 text-indigo-700',
      completed: 'bg-green-50 text-green-700',
      cancelled: 'bg-gray-50 text-gray-700'
    };
    return `<span class="px-2 py-1 rounded-full text-xs ${map[s]||'bg-gray-50 text-gray-700'}">${s.replace(/_/g,' ')}</span>`;
  }

  function buildRow(item, idx){
    // determine which side is current member and counterparty details
    const amMemberOne = Number(item.member_one_id) === Number(currentMemberId);
    const counterpartyId = amMemberOne ? item.member_two_id : item.member_one_id;
    // For demo we don't have member names; we'll show "Member {id}"
    const counterpartyName = counterpartyId ? `Member ${counterpartyId}` : '—';

    // show role from current member perspective (member_one_role belongs to member_one)
    const myRole = amMemberOne ? item.member_one_role : (item.member_one_role === 'giver' ? 'taker' : 'giver');

    const attachmentHtml = item.attachment ? `<a href="${item.attachment}" target="_blank" class="text-sm text-blue-600 underline">Download</a>` : '-';

    // desktop row
    const desktop = `
      <div class="hidden md:grid grid-cols-12 gap-4 px-4 py-4 items-center text-sm">
        <div class="col-span-1 text-gray-600">${idx}</div>
        <div class="col-span-3 font-medium">${escapeHtml(item.business_title)}</div>
        <div class="col-span-2">${roleLabel(myRole)}</div>
        <div class="col-span-2">${escapeHtml(counterpartyName)} <div class="text-xs text-gray-400">ID: ${counterpartyId||'—'}</div></div>
        <div class="col-span-2">${formatCurrency(item.business_value)}</div>
        <div class="col-span-1">${statusLabel(item.status)}</div>
        <div class="col-span-1 text-right">
          <button class="viewBtn text-blue-600 text-sm font-medium" data-id="${item.id}">View</button>
          ${item.status !== 'completed' ? `<button class="ml-2 completeBtn px-2 py-1 border rounded text-xs" data-id="${item.id}">Mark Complete</button>` : ''}
        </div>
      </div>
    `;

    // mobile card
    const mobile = `
      <div class="md:hidden px-4 py-4">
        <div class="flex items-start justify-between gap-3">
          <div>
            <div class="font-medium">${escapeHtml(item.business_title)}</div>
            <div class="text-xs text-gray-500 mt-1 truncate-2">${escapeHtml(item.description)}</div>
            <div class="text-xs text-gray-400 mt-2">Counterparty: ${escapeHtml(counterpartyName)} • ${formatCurrency(item.business_value)}</div>
          </div>
          <div class="text-right">
            <div>${statusLabel(item.status)}</div>
            <div class="mt-2">
              <button class="viewBtn text-blue-600 text-sm font-medium" data-id="${item.id}">View</button>
              ${item.status !== 'completed' ? `<button class="ml-1 completeBtn px-2 py-1 border rounded text-xs" data-id="${item.id}">Complete</button>` : ''}
            </div>
          </div>
        </div>
      </div>
    `;

    return desktop + mobile;
  }

  function escapeHtml(v){
    if (v == null) return '';
    return String(v)
      .replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
      .replace(/"/g,'&quot;').replace(/'/g,'&#039;');
  }

  function render(){
    rowsEl.innerHTML = '';
    const start = (page-1)*pageSize;
    const end = start + pageSize;
    const slice = filtered.slice(start, end);

    if (slice.length === 0){
      rowsEl.innerHTML = '<div class="p-6 text-center text-gray-500">No business records found.</div>';
    } else {
      slice.forEach((it, i) => rowsEl.insertAdjacentHTML('beforeend', buildRow(it, start + i + 1)));
    }

    showStart.textContent = slice.length ? start + 1 : 0;
    showEnd.textContent = Math.min(end, filtered.length);
    totalEl.textContent = filtered.length;
    pageNum.textContent = page;

    firstPage.disabled = page <= 1;
    prevPage.disabled = page <= 1;
    nextPage.disabled = end >= filtered.length;
  }

  // initial
  filtered = [...businesses];
  render();

  // filters
  applyFilters.addEventListener('click', () => {
    const q = (qEl.value || '').toLowerCase().trim();
    const role = roleFilter.value;
    const status = statusFilter.value;

    filtered = businesses.filter(b => {
      const hay = `${b.business_title} ${b.description} ${b.member_one_id} ${b.member_two_id}`.toLowerCase();
      if (q && !hay.includes(q)) return false;
      // role filter: interpret role from current member perspective
      if (role){
        const amMemberOne = Number(b.member_one_id) === Number(currentMemberId);
        const myRole = amMemberOne ? b.member_one_role : (b.member_one_role === 'giver' ? 'taker' : 'giver');
        if (myRole !== role) return false;
      }
      if (status && b.status !== status) return false;
      return true;
    });

    page = 1;
    render();
  });

  clearFilters.addEventListener('click', () => {
    qEl.value = '';
    roleFilter.value = '';
    statusFilter.value = '';
    filtered = [...businesses];
    page = 1;
    render();
  });

  // pagination
  firstPage.addEventListener('click', () => { page = 1; render(); });
  prevPage.addEventListener('click', () => { if(page>1) page--; render(); });
  nextPage.addEventListener('click', () => { if((page*pageSize) < filtered.length) page++; render(); });

  // export CSV
  exportCsvBtn.addEventListener('click', () => {
    const rows = filtered.map(r => [
      r.id,
      r.business_title,
      (Number(r.member_one_id) === Number(currentMemberId) ? r.member_one_role : (r.member_one_role==='giver'?'taker':'giver')),
      (Number(r.member_one_id) === Number(currentMemberId) ? r.member_two_id : r.member_one_id),
      r.business_value,
      r.status,
      r.completed_at || ''
    ]);
    const header = ['ID','Title','Your role','Counterparty ID','Value','Status','Completed At'];
    const csv = [header, ...rows].map(row => row.map(c => `"${String(c||'').replace(/"/g,'""')}"`).join(',')).join('\n');
    const blob = new Blob([csv], {type:'text/csv'});
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a'); a.href = url; a.download = 'member_businesses.csv'; a.click();
    URL.revokeObjectURL(url);
  });

  // delegation: view, complete
  document.addEventListener('click', (ev) => {
    const viewBtn = ev.target.closest && ev.target.closest('.viewBtn');
    if (viewBtn){
      const id = Number(viewBtn.dataset.id);
      const item = businesses.find(b => Number(b.id) === id);
      if (!item) return;
      showViewModal(item);
      return;
    }

    const completeBtn = ev.target.closest && ev.target.closest('.completeBtn');
    if (completeBtn){
      const id = Number(completeBtn.dataset.id);
      const idx = businesses.findIndex(b => Number(b.id) === id);
      if (idx === -1) return;
      // mark completed (simple demo)
      businesses[idx].status = 'completed';
      businesses[idx].completed_at = new Date().toISOString().slice(0,10);
      // refresh filtered & UI
      filtered = filtered.map(f => f.id === id ? businesses[idx] : f);
      render();
      // show a quick confirmation (toast-like)
      showTemporaryMessage('Marked as completed');
      return;
    }
  });

  // view modal functions
  function showViewModal(item){
    const amMemberOne = Number(item.member_one_id) === Number(currentMemberId);
    const myRole = amMemberOne ? item.member_one_role : (item.member_one_role === 'giver' ? 'taker' : 'giver');
    const counterparty = amMemberOne ? item.member_two_id : item.member_one_id;
    const html = `
      <div class="grid grid-cols-1 gap-3 text-sm text-gray-700">
        <div><strong>Title:</strong> ${escapeHtml(item.business_title)}</div>
        <div><strong>Role:</strong> ${escapeHtml(myRole)}</div>
        <div><strong>Counterparty:</strong> Member ${escapeHtml(counterparty || '')}</div>
        <div><strong>Value:</strong> ${formatCurrency(item.business_value)}</div>
        <div><strong>Status:</strong> ${escapeHtml(item.status)}</div>
        <div><strong>Completed at:</strong> ${escapeHtml(item.completed_at || '—')}</div>
        <div><strong>Description:</strong><div class="mt-1 text-gray-600">${escapeHtml(item.description || '—')}</div></div>
        <div><strong>Attachment:</strong> ${item.attachment ? `<a href="${item.attachment}" target="_blank" class="text-blue-600 underline">Download</a>` : '—'}</div>
        <div class="pt-2">
          <strong>Member notes</strong>
          <div class="mt-1 text-xs text-gray-600">
            <div><strong>You:</strong> ${escapeHtml(amMemberOne? item.member_one_notes : item.member_two_notes)}</div>
            <div class="mt-1"><strong>Other:</strong> ${escapeHtml(amMemberOne? item.member_two_notes : item.member_one_notes)}</div>
          </div>
        </div>
      </div>
    `;
    viewContent.innerHTML = html;
    viewModal.classList.remove('hidden');
    viewModal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
  }

  function hideViewModal(){
    viewModal.classList.add('hidden');
    viewModal.style.display = 'none';
    document.body.style.overflow = '';
  }

  if (viewOverlay) viewOverlay.addEventListener('click', hideViewModal);
  if (closeView) closeView.addEventListener('click', hideViewModal);
  if (viewCloseBtn) viewCloseBtn.addEventListener('click', hideViewModal);

  // add modal handlers
  function openAdd(){
    addModal.classList.remove('hidden');
    addModal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
  }
  function closeAddModal(){
    addModal.classList.add('hidden');
    addModal.style.display = 'none';
    document.body.style.overflow = '';
    addForm.reset();
  }

  if (openAddBtn) openAddBtn.addEventListener('click', openAdd);
  if (addOverlay) addOverlay.addEventListener('click', closeAddModal);
  if (closeAdd) closeAdd.addEventListener('click', closeAddModal);
  if (cancelAddBtn) cancelAddBtn.addEventListener('click', closeAddModal);

  addForm.addEventListener('submit', (ev) => {
    ev.preventDefault();
    const newObj = {
      id: businesses.length ? Math.max(...businesses.map(b=>b.id)) + 1 : 1,
      member_one_id: Number(currentMemberId),
      member_two_id: Number(b_counterparty.value) || null,
      member_one_role: b_role.value || 'giver',
      business_title: (b_title.value||'').trim(),
      description: (b_desc.value||'').trim(),
      business_value: Number(b_value.value) || 0,
      attachment: null,
      status: 'initiated',
      member_one_notes: '',
      member_two_notes: '',
      completed_at: null
    };
    businesses.unshift(newObj);
    filtered = [...businesses];
    page = 1;
    render();
    closeAddModal();
    showTemporaryMessage('Business created');
  });

  // keyboard Escape close modals
  document.addEventListener('keydown', (ev) => {
    if (ev.key === 'Escape'){
      if (!viewModal.classList.contains('hidden')) hideViewModal();
      if (!addModal.classList.contains('hidden')) closeAddModal();
    }
  });

  // small helper message
  function showTemporaryMessage(msg){
    const el = document.createElement('div');
    el.className = 'fixed bottom-6 right-6 bg-black text-white px-4 py-2 rounded shadow';
    el.textContent = msg;
    document.body.appendChild(el);
    setTimeout(() => { el.remove(); }, 2000);
  }

  // re-run feather icons
  if (typeof feather !== 'undefined' && feather.replace) feather.replace();
});
</script>
@endsection