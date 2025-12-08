{{-- resources/views/admin/member/assigned.blade.php --}}
@include('components.adminheader')

<main class="flex-1 p-6 max-w-7xl mx-auto">
  <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h2 class="text-2xl font-semibold text-gray-800">Assigned Members</h2>
      <p class="text-sm text-gray-600 mt-1">Members assigned to chapters by admin. View role and chapter details below.</p>
    </div>

    <div class="flex items-center gap-2">
      <select id="filterChapter" class="px-3 py-2 border rounded-md text-sm">
        <option value="">All chapters</option>
        <!-- populated by JS -->
      </select>

      <input id="assignedSearch" type="search" placeholder="Search member name / id / role..." class="px-3 py-2 border rounded-md text-sm w-56" />
      <button id="clearAssignedFilters" class="px-3 py-2 bg-white border rounded-md text-sm">Clear</button>
    </div>
  </div>

  <!-- Table container -->
  <div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <!-- header row (desktop) -->
    <div class="hidden md:grid grid-cols-12 gap-4 px-4 py-3 text-xs text-gray-500 border-b">
      <div class="col-span-1">#</div>
      <div class="col-span-3">Member</div>
      <div class="col-span-3">Chapter</div>
      <div class="col-span-2">Role</div>
      <div class="col-span-3 text-right">Actions</div>
    </div>

    <!-- rows -->
    <div id="assignedRows" class="divide-y"></div>

    <!-- pagination -->
    <div class="px-4 py-3 border-t bg-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
      <div class="text-sm text-gray-600">
        Showing <span id="am-showStart">0</span>-<span id="am-showEnd">0</span> of <span id="am-total">0</span>
      </div>

      <div class="flex items-center gap-2">
        <button id="am-first" class="px-3 py-1 bg-white border rounded-md disabled:opacity-50">First</button>
        <button id="am-prev" class="px-3 py-1 bg-white border rounded-md disabled:opacity-50">Prev</button>
        <button id="am-next" class="px-3 py-1 bg-white border rounded-md disabled:opacity-50">Next</button>
      </div>
    </div>
  </div>
</main>

<!-- DETAILS / ACTION MODAL -->
<div id="am-modal" class="fixed inset-0 z-50 hidden items-center justify-center">
  <div id="am-modalOverlay" class="absolute inset-0 bg-black/40"></div>

  <div class="relative max-w-2xl w-full mx-4">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
      <div class="flex items-center justify-between px-6 py-4 border-b">
        <h3 id="am-modalTitle" class="text-lg font-semibold">Assigned Member</h3>
        <button id="am-closeModal" class="text-gray-500 hover:text-gray-700" aria-label="Close">✕</button>
      </div>

      <div id="am-modalContent" class="p-6 text-sm space-y-3"></div>

      <div class="p-4 border-t flex items-center justify-end gap-2">
        <button id="am-cancel" class="px-4 py-2 bg-white border rounded-md">Close</button>
        <button id="am-removeBtn" class="px-4 py-2 bg-red-600 text-white rounded-md">Remove assignment</button>
      </div>
    </div>
  </div>
</div>

<script>
(function(){
  // -------------------------
  // Demo data (UI-only)
  // -------------------------
  const chapters = [
    { id: 1, name: 'Delhi Chapter', slug: 'delhi-chapter' },
    { id: 2, name: 'Mumbai Chapter', slug: 'mumbai-chapter' },
    { id: 3, name: 'Bengaluru Chapter', slug: 'bengaluru-chapter' },
  ];

  const users = [
    { id: 101, name:'Ramesh Kumar', email:'ramesh@example.com', phone:'+91 9876543210', business_name:'RK Foods', category:'FMCG', location:'Delhi', joined_at:'2024-02-10' },
    { id: 102, name:'Priya Sharma', email:'priya@example.com', phone:'+91 9123456780', business_name:'PS Designs', category:'Fashion', location:'Mumbai', joined_at:'2023-12-01' },
    { id: 103, name:'Amit Verma', email:'amit@example.com', phone:'—', business_name:'AV Tech', category:'Software', location:'Pune', joined_at:'2024-01-15' },
  ];

  // chapter_members records (UI-only)
  let assigned = [
    { id: 1, chapter_id: 1, chapter_name: 'Delhi Chapter', member_id: 101, member_name: 'Ramesh Kumar', role: 'member', admin_notes: 'Active participant' },
    { id: 2, chapter_id: 1, chapter_name: 'Delhi Chapter', member_id: 102, member_name: 'Priya Sharma', role: 'coordinator', admin_notes: '' },
    { id: 3, chapter_id: 2, chapter_name: 'Mumbai Chapter', member_id: 103, member_name: 'Amit Verma', role: 'member', admin_notes: 'On probation' },
  ];

  // -------------------------
  // Pagination & UI state
  // -------------------------
  let page = 1;
  const pageSize = 6;
  let filtered = assigned.slice();

  // Elements
  const assignedRows = document.getElementById('assignedRows');
  const filterChapter = document.getElementById('filterChapter');
  const assignedSearch = document.getElementById('assignedSearch');
  const clearAssignedFilters = document.getElementById('clearAssignedFilters');
  const showStart = document.getElementById('am-showStart');
  const showEnd = document.getElementById('am-showEnd');
  const totalEl = document.getElementById('am-total');
  const btnFirst = document.getElementById('am-first');
  const btnPrev = document.getElementById('am-prev');
  const btnNext = document.getElementById('am-next');

  // modal refs
  const modal = document.getElementById('am-modal');
  const modalOverlay = document.getElementById('am-modalOverlay');
  const modalTitle = document.getElementById('am-modalTitle');
  const modalContent = document.getElementById('am-modalContent');
  const closeModal = document.getElementById('am-closeModal');
  const cancelBtn = document.getElementById('am-cancel');
  const removeBtn = document.getElementById('am-removeBtn');

  // Populate chapter filter dropdown
  function populateChapterFilter(){
    chapters.forEach(c => {
      const o = document.createElement('option');
      o.value = String(c.id);
      o.textContent = `${c.name} (ID:${c.id})`;
      filterChapter.appendChild(o);
    });
  }

  // Build a row for desktop + mobile card
  function buildRowHTML(item, idx){
    return `
      <div class="hidden md:grid grid-cols-12 gap-4 px-4 py-4 items-center text-sm">
        <div class="col-span-1">${idx}</div>

        <div class="col-span-3">
          <div class="font-medium cursor-pointer am-member-link" data-member-id="${item.member_id}">${escapeHtml(item.member_name)}</div>
          <div class="text-xs text-gray-500">ID: ${escapeHtml(item.member_id)}</div>
        </div>

        <div class="col-span-3">
          <div class="font-medium">${escapeHtml(item.chapter_name || '')}</div>
          <div class="text-xs text-gray-500">Chapter ID: ${escapeHtml(item.chapter_id)}</div>
        </div>

        <div class="col-span-2"><span class="text-sm text-gray-700 font-medium">${escapeHtml(item.role)}</span></div>

        <div class="col-span-3 text-right">
          <div class="inline-flex items-center gap-3">
            <button class="am-view text-blue-600 text-sm" data-id="${item.id}">View</button>
            <button class="am-remove text-red-600 text-sm" data-id="${item.id}">Remove</button>
          </div>
        </div>
      </div>

      <!-- mobile card -->
      <div class="md:hidden px-4 py-4">
        <div class="flex items-start justify-between gap-3">
          <div class="min-w-0 flex-1">
            <div class="flex items-center justify-between">
              <div>
                <div class="font-medium cursor-pointer am-member-link" data-member-id="${item.member_id}">${escapeHtml(item.member_name)}</div>
                <div class="text-xs text-gray-500">#${escapeHtml(item.member_id)} • ${escapeHtml(item.chapter_name||'')}</div>
              </div>
              <div class="text-sm text-gray-700 font-medium">${escapeHtml(item.role)}</div>
            </div>

            <div class="mt-2 text-xs text-gray-500">Chapter ID: ${escapeHtml(item.chapter_id)}</div>

            <div class="mt-3 flex gap-2">
              <button class="am-view text-blue-600 text-sm" data-id="${item.id}">View</button>
              <button class="am-remove text-red-600 text-sm" data-id="${item.id}">Remove</button>
            </div>
          </div>
        </div>
      </div>
    `;
  }

  // Render list based on filtered[] and page
  function render(){
    assignedRows.innerHTML = '';
    const total = filtered.length;
    const start = (page - 1) * pageSize;
    const end = Math.min(start + pageSize, total);
    const list = filtered.slice(start, end);

    if (!list.length){
      assignedRows.innerHTML = '<div class="p-6 text-center text-gray-500">No assigned members.</div>';
    } else {
      list.forEach((it, i) => assignedRows.insertAdjacentHTML('beforeend', buildRowHTML(it, start + i + 1)));
    }

    showStart.textContent = list.length ? start + 1 : 0;
    showEnd.textContent = end;
    totalEl.textContent = total;

    btnPrev.disabled = page <= 1;
    btnFirst.disabled = page <= 1;
    btnNext.disabled = end >= total;

    // wiring after DOM injection: view/remove/member-link actions
    wireRowActions();
  }

  // safe escape
  function escapeHtml(s){ return String(s==null?'':s).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c])); }

  // filtering
  function applyFilters(){
    const ch = filterChapter.value;
    const q = (assignedSearch.value || '').toLowerCase().trim();

    filtered = assigned.filter(a => {
      if (ch && String(a.chapter_id) !== String(ch)) return false;
      if (q){
        const hay = `${a.member_name} ${a.member_id} ${a.chapter_name} ${a.role} ${a.admin_notes}`.toLowerCase();
        if (!hay.includes(q)) return false;
      }
      return true;
    });

    page = 1;
    render();
  }

  // clear filters
  clearAssignedFilters.addEventListener('click', () => {
    filterChapter.value = '';
    assignedSearch.value = '';
    filtered = assigned.slice();
    page = 1;
    render();
  });

  filterChapter.addEventListener('change', applyFilters);
  assignedSearch.addEventListener('keydown', (e) => { if (e.key === 'Enter') applyFilters(); });

  // pagination controls
  btnFirst.addEventListener('click', () => { page = 1; render(); });
  btnPrev.addEventListener('click', () => { if (page>1) { page--; render(); }});
  btnNext.addEventListener('click', () => { if (page * pageSize < filtered.length){ page++; render(); }});

  // Delegated actions wiring for rows (call after render)
  function wireRowActions(){
    // View (open modal)
    document.querySelectorAll('.am-view').forEach(btn => {
      btn.removeEventListener('click', onViewClick);
      btn.addEventListener('click', onViewClick);
    });

    // Remove
    document.querySelectorAll('.am-remove').forEach(btn => {
      btn.removeEventListener('click', onRemoveClick);
      btn.addEventListener('click', onRemoveClick);
    });

    // Clicking member name should open the member profile page (hardcoded)
    document.querySelectorAll('.am-member-link').forEach(el => {
      el.removeEventListener('click', onMemberClick);
      el.addEventListener('click', onMemberClick);
    });
  }

  function onViewClick(ev){
    const id = Number(ev.currentTarget.dataset.id);
    const item = assigned.find(x => x.id === id);
    if (!item) return;
    openModalFor(item);
  }

  function onRemoveClick(ev){
    const id = Number(ev.currentTarget.dataset.id);
    if (!confirm('Remove this member assignment?')) return;
    assigned = assigned.filter(a => a.id !== id);
    filtered = filtered.filter(a => a.id !== id);
    showToast('Assignment removed');
    render();
  }

  // Clicking a member name redirects to the member profile page (UI-only, no backend integration)
  function onMemberClick(ev){
    const mid = ev.currentTarget.dataset.memberId;
    // Hardcoded path as requested — this will open admin/member/index
    // If you later define a named route, replace with route('index')
    window.location.href = '/admin/member/index';
  }

  // Modal open / close & actions
  let modalCurrentId = null;
  function openModalFor(item){
    modalCurrentId = item.id;

    // find full user profile
    const user = users.find(u => u.id === item.member_id) || {};

    modalTitle.textContent = `${item.member_name} — ${item.chapter_name}`;

    modalContent.innerHTML = `
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">

        <!-- MEMBER INFO -->
        <div class="space-y-2">
          <h4 class="font-semibold text-gray-800">Member Profile</h4>

          <div>
            <div class="text-xs text-gray-500">Name</div>
            <div class="font-medium">${escapeHtml(user.name || item.member_name)}</div>
          </div>

          <div>
            <div class="text-xs text-gray-500">Member ID</div>
            <div class="text-gray-700">#${escapeHtml(item.member_id)}</div>
          </div>

          <div>
            <div class="text-xs text-gray-500">Email</div>
            <div class="text-gray-700">${escapeHtml(user.email || '—')}</div>
          </div>

          <div>
            <div class="text-xs text-gray-500">Phone</div>
            <div class="text-gray-700">${escapeHtml(user.phone || '—')}</div>
          </div>

          <div>
            <div class="text-xs text-gray-500">Business Name</div>
            <div class="text-gray-700">${escapeHtml(user.business_name || '—')}</div>
          </div>

          <div>
            <div class="text-xs text-gray-500">Business Category</div>
            <div class="text-gray-700">${escapeHtml(user.category || '—')}</div>
          </div>

          <div>
            <div class="text-xs text-gray-500">Location</div>
            <div class="text-gray-700">${escapeHtml(user.location || '—')}</div>
          </div>

          <div>
            <div class="text-xs text-gray-500">Joining Date</div>
            <div class="text-gray-700">${escapeHtml(user.joined_at || '—')}</div>
          </div>
        </div>

        <!-- CHAPTER INFO -->
        <div class="space-y-2">
          <h4 class="font-semibold text-gray-800">Chapter Details</h4>

          <div>
            <div class="text-xs text-gray-500">Chapter</div>
            <div class="font-medium">${escapeHtml(item.chapter_name)}</div>
          </div>

          <div>
            <div class="text-xs text-gray-500">Chapter ID</div>
            <div class="text-gray-700">${escapeHtml(item.chapter_id)}</div>
          </div>

          <div>
            <div class="text-xs text-gray-500">Role</div>
            <div class="text-gray-700 font-medium">${escapeHtml(item.role)}</div>
          </div>

          <div>
            <div class="text-xs text-gray-500">Admin Notes</div>
            <div class="text-gray-700">${escapeHtml(item.admin_notes || '—')}</div>
          </div>
        </div>

      </div>
    `;

    modal.classList.remove('hidden');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
  }

  function closeModalFn(){
    modal.classList.add('hidden');
    modal.style.display = 'none';
    document.body.style.overflow = '';
    modalCurrentId = null;
  }

  if (modalOverlay) modalOverlay.addEventListener('click', closeModalFn);
  if (closeModal) closeModal.addEventListener('click', closeModalFn);
  if (cancelBtn) cancelBtn.addEventListener('click', closeModalFn);

  if (removeBtn) removeBtn.addEventListener('click', () => {
    if (!modalCurrentId) return closeModalFn();
    if (!confirm('Remove this member assignment?')) return;
    assigned = assigned.filter(a => a.id !== modalCurrentId);
    filtered = filtered.filter(a => a.id !== modalCurrentId);
    showToast('Assignment removed');
    render();
    closeModalFn();
  });

  // small toast
  function showToast(msg){
    const t = document.createElement('div');
    t.className = 'fixed right-6 bottom-6 bg-gray-900 text-white text-sm px-4 py-2 rounded shadow';
    t.textContent = msg;
    document.body.appendChild(t);
    setTimeout(()=> t.remove(), 2200);
  }

  // Init
  populateChapterFilter();
  filtered = assigned.slice();
  render();

  // feather icons replacement (if used elsewhere)
  if (typeof feather !== 'undefined') feather.replace();

})();
</script>

@include('components.script')
