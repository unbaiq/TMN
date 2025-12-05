@include('components.memberheader')
<div class="p-6 sm:p-10 space-y-6">

  <!-- Title only -->
    <div class="space-y-1">
    <h2 class="text-2xl font-semibold text-gray-800">Give Services</h2>
    <p class="text-gray-600 mt-1">
      These are the services you have given to other members.
    </p>
  </div>

  <!-- Filters -->
  <div class="bg-white p-4 rounded-lg shadow-sm grid grid-cols-1 md:grid-cols-4 gap-3 items-end">
    <div>
      <label class="text-xs text-gray-600">Search</label>
      <input id="searchInput" type="search" placeholder="Service, receiver..."
             class="mt-1 block w-full px-3 py-2 rounded-md border border-slate-200">
    </div>

    <div>
      <label class="text-xs text-gray-600">Receiver</label>
      <input id="receiverFilter" type="text" placeholder="Name or Member ID"
             class="mt-1 block w-full px-3 py-2 rounded-md border border-slate-200">
    </div>

    <div>
      <label class="text-xs text-gray-600">Status</label>
      <select id="statusFilter" class="mt-1 block w-full px-3 py-2 rounded-md border border-slate-200">
        <option value="">Any</option>
        <option value="pending">Pending</option>
        <option value="accepted">Accepted</option>
        <option value="rejected">Rejected</option>
        <option value="cancelled">Cancelled</option>
      </select>
    </div>

    <div class="flex flex-col items-end gap-2">
      <div class="flex items-center gap-3">
        <label class="flex items-center gap-2 text-xs">
          <input id="showTakerRequests" type="checkbox" class="h-4 w-4" />
          <span>Show taker requests</span>
        </label>
      </div>
      <div class="flex gap-2 mt-1">
        <button id="clearFilters" class="px-3 py-2 bg-white border rounded-md text-sm">Clear</button>
        <button id="applyFilters" class="px-3 py-2 bg-red-500 text-white rounded-md text-sm">Apply</button>
      </div>
    </div>
  </div>

  <!-- SERVICES TABLE -->
  <div class="bg-white rounded-lg shadow-sm overflow-hidden mt-4">

    <!-- Header (desktop) -->
    <div class="hidden md:grid grid-cols-12 gap-4 px-4 py-3 text-xs text-gray-500 border-b">
      <div class="col-span-3">Service</div>
      <div class="col-span-4">Description</div>
      <div class="col-span-3">Receiver</div>
      <div class="col-span-1 text-center">Status</div>
      <div class="col-span-1 text-right">Actions</div>
    </div>

    <!-- Rows container (JS fills this) -->
    <div id="rowsContainer" class="divide-y"></div>

    <!-- Pagination -->
    <div class="px-4 py-3 border-t bg-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
      <div class="text-sm text-gray-600">
        Showing <span id="showCount">0</span>-<span id="showEnd">0</span> of
        <span id="totalCount">0</span> • Page <span id="currentPage">1</span>
      </div>

      <div class="flex items-center gap-2">
        <button id="firstPage" class="px-3 py-1 bg-white border rounded-md disabled:opacity-50">First</button>
        <button id="prevPage" class="px-3 py-1 bg-white border rounded-md disabled:opacity-50">Prev</button>
        <button id="nextPage" class="px-3 py-1 bg-white border rounded-md disabled:opacity-50">Next</button>
      </div>
    </div>
  </div>

  <!-- VIEW MODAL -->
  <div id="serviceModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div id="modalOverlay" class="absolute inset-0 bg-black/40"></div>

    <div class="relative max-w-xl w-full mx-4">
      <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b">
          <h3 class="text-lg font-semibold">Service Details</h3>
          <button id="closeModal" class="text-gray-500 hover:text-gray-700" aria-label="Close modal">✕</button>
        </div>

        <div id="modalContent" class="p-6"></div>

      </div>
    </div>
  </div>
</div>

<script>
/*
  Adjusted Give Services UI:
  - Desktop: status centered, actions right-aligned.
  - Mobile: actions stacked below details, buttons full-width for easier taps.
  - Full runnable code with sample data.
*/
(function(){
  const $ = id => document.getElementById(id);
  const escHtml = v => v == null ? '' : String(v).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;');
  function lockScroll(){ document.body.style.overflow = 'hidden'; }
  function unlockScroll(){ document.body.style.overflow = ''; }

  // sample data (replace with server data)
  window.services = window.services || [
    { id:1, service_name:"Technical Audit", description:"Audit of website performance and SEO improvements. Long description truncated.", receiver_name:"Rahul Mehta", receiver_member_id:112, status:"pending", taker_request:true, taker_contact:{ name:'Rahul Mehta', member_id:112, phone:'+91-9876543210', email:'rahul@example.com' }, taker_documents:[{name:'audit-log.txt',url:'#',size:'45 KB'}] },
    { id:2, service_name:"Website Audit (requested)", description:"Taker uploaded logs and screenshots indicating issues.", receiver_name:"Anita Singh", receiver_member_id:401, status:"pending", taker_request:true, taker_contact:{ name:'Amit Kumar', member_id:401, phone:'+91-98xxxxxx', email:'amit@example.com' }, taker_documents:[{name:'audit-log.txt',url:'#',size:'45 KB'},{name:'screenshot.png',url:'#',size:'180 KB'}] },
    
  ];

  // state
  let services = window.services.slice();
  let filtered = services.slice();
  let page = 1;
  const pageSize = 5;

  // refs
  const rowsContainer = $('rowsContainer');
  const showCount = $('showCount'); const showEnd = $('showEnd'); const totalCountEl = $('totalCount'); const currentPageEl = $('currentPage');
  const prevBtn = $('prevPage'); const nextBtn = $('nextPage'); const firstBtn = $('firstPage');
  const applyFiltersBtn = $('applyFilters'); const clearFiltersBtn = $('clearFilters');
  const searchInput = $('searchInput'); const receiverFilter = $('receiverFilter'); const statusFilter = $('statusFilter'); const showTakerRequests = $('showTakerRequests');

  const serviceModal = $('serviceModal');
  const modalOverlay = $('modalOverlay');
  const modalContent = $('modalContent');
  const modalCloseX = $('closeModal');
  const modalCloseBtn = $('modalCloseBtn');

  if (!rowsContainer) return;

  function statusBadgeHtml(status){
    const s = String(status || '').toLowerCase();
    if (s === 'accepted') return `<span class="inline-block px-2 py-1 rounded-full bg-green-50 text-green-700 text-xs font-medium">${escHtml(s)}</span>`;
    if (s === 'rejected') return `<span class="inline-block px-2 py-1 rounded-full bg-red-50 text-red-700 text-xs font-medium">${escHtml(s)}</span>`;
    if (s === 'cancelled') return `<span class="inline-block px-2 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-medium">${escHtml(s)}</span>`;
    return `<span class="inline-block px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-medium">${escHtml(s || 'pending')}</span>`;
  }

  function actionButtonsHtml(s){
    // Keep consistent order: Accept, Reject, View (desktop)
    if (s.taker_request) {
      // for desktop we use inline small buttons; mobile will render stacked buttons separately
      return `
        <div class="hidden md:flex items-center justify-end gap-2">
          <button aria-label="Accept request" class="acceptBtn inline-block px-3 py-1 rounded bg-green-600 text-white text-xs" data-id="${s.id}">Accept</button>
          <button aria-label="Reject request" class="rejectBtn inline-block px-3 py-1 rounded bg-red-600 text-white text-xs" data-id="${s.id}">Reject</button>
          <button aria-label="View details" class="viewBtn inline-block text-sm text-blue-600" data-id="${s.id}">View</button>
        </div>
      `;
    }
    return `<div class="hidden md:flex items-center justify-end gap-2"><button aria-label="View details" class="viewBtn text-sm text-blue-600" data-id="${s.id}">View</button></div>`;
  }

  function buildRowHtml(s, index){
    // desktop layout
    const receiverText = `${escHtml(s.receiver_name || '—')} <span class="text-xs text-gray-500">(${escHtml(s.receiver_member_id || '—')})</span>`;

    return `
      <div class="hidden md:grid grid-cols-12 gap-4 px-4 py-4 items-center text-sm">
        <div class="col-span-3 font-medium">${escHtml(s.service_name)}</div>
        <div class="col-span-4 text-gray-600 truncate">${escHtml(s.description || '')}</div>
        <div class="col-span-3">${receiverText}</div>
        <div class="col-span-1 text-center">
          ${statusBadgeHtml(s.status)}
        </div>
        <div class="col-span-1">
          ${actionButtonsHtml(s)}
        </div>
      </div>

      <!-- mobile card -->
      <div class="md:hidden px-4 py-4">
        <div class="flex items-start justify-between gap-3">
          <div class="flex-1 min-w-0">
            <div class="font-medium">${escHtml(s.service_name)}</div>
            <div class="text-xs text-gray-500 mt-1 truncate">${escHtml(s.description || '')}</div>
            <div class="text-xs text-gray-400 mt-2">Receiver: ${escHtml(s.receiver_name || '—')} • ${escHtml(s.receiver_member_id || '—')}</div>
            <div class="mt-2">
              ${statusBadgeHtml(s.status)}
            </div>

            <!-- mobile action strip (stacked full-width buttons) -->
            <div class="mt-3 space-y-2">
              ${s.taker_request ? `
                <div class="flex flex-col sm:flex-row sm:gap-2">
                  <button aria-label="Accept request" class="acceptBtnMobile w-full sm:w-auto px-4 py-2 rounded bg-green-600 text-white text-sm" data-id="${s.id}">Accept</button>
                  <button aria-label="Reject request" class="rejectBtnMobile w-full sm:w-auto px-4 py-2 rounded bg-red-600 text-white text-sm" data-id="${s.id}">Reject</button>
                </div>
              ` : ''}
              <div>
                <button class="viewBtn text-sm text-blue-600 font-medium" data-id="${s.id}">View</button>
              </div>
            </div>

          </div>
        </div>
      </div>
    `;
  }

  function updateStatusForId(id, newStatus){
    const s = services.find(x => String(x.id) === String(id));
    if (!s) return false;
    s.status = newStatus;
    if (newStatus === 'accepted' || newStatus === 'rejected') s.taker_request = false;
    return true;
  }

  function handleAccept(id){
    if (!confirm('Accept this taker request?')) return;
    const ok = updateStatusForId(id, 'accepted');
    if (ok) {
      render();
      const open = serviceModal && !serviceModal.classList.contains('hidden');
      if (open) {
        const currId = modalContent.dataset.currentId;
        if (String(currId) === String(id)) showServiceModalFor(services.find(x => String(x.id) === String(id)));
      }
      alert('Request accepted.');
    } else alert('Could not update status.');
  }

  function handleReject(id){
    const reason = prompt('Rejection reason (optional):', '');
    if (reason === null) return;
    const ok = updateStatusForId(id, 'rejected');
    if (ok) {
      const s = services.find(x => String(x.id) === String(id));
      s.reject_reason = reason || null;
      render();
      const open = serviceModal && !serviceModal.classList.contains('hidden');
      if (open) {
        const currId = modalContent.dataset.currentId;
        if (String(currId) === String(id)) showServiceModalFor(services.find(x => String(x.id) === String(id)));
      }
      alert('Request rejected.');
    } else alert('Could not update status.');
  }

  function render(){
    rowsContainer.innerHTML = '';
    const total = filtered.length;
    const start = (page - 1) * pageSize;
    const rawEnd = start + pageSize;
    const list = filtered.slice(start, rawEnd);

    if (list.length === 0){
      rowsContainer.innerHTML = '<div class="p-6 text-center text-gray-500">No services found.</div>';
    } else {
      list.forEach((s, i) => rowsContainer.insertAdjacentHTML('beforeend', buildRowHtml(s, start + i + 1)));
    }

    if (showCount) showCount.textContent = list.length ? start + 1 : 0;
    if (showEnd) showEnd.textContent = Math.min(rawEnd, total);
    if (totalCountEl) totalCountEl.textContent = total;
    if (currentPageEl) currentPageEl.textContent = page;

    if (prevBtn) prevBtn.disabled = page <= 1;
    if (firstBtn) firstBtn.disabled = page <= 1;
    if (nextBtn) nextBtn.disabled = rawEnd >= total || total === 0;
  }

  // filters
  if (applyFiltersBtn) applyFiltersBtn.addEventListener('click', () => {
    const qv = (searchInput?.value || '').toLowerCase().trim();
    const recv = (receiverFilter?.value || '').toLowerCase().trim();
    const st = (statusFilter?.value || '').toLowerCase().trim();
    const showRequests = !!(showTakerRequests && showTakerRequests.checked);

    filtered = services.filter(s => {
      const hay = `${s.service_name} ${s.description} ${s.receiver_name} ${s.receiver_member_id}`.toLowerCase();
      if (qv && !hay.includes(qv)) return false;
      if (recv && !hay.includes(recv)) return false;
      if (st && String((s.status||'')).toLowerCase() !== st) return false;
      if (!showRequests && s.taker_request) return false;
      return true;
    });
    page = 1;
    render();
  });

  if (clearFiltersBtn) clearFiltersBtn.addEventListener('click', () => {
    if (searchInput) searchInput.value = '';
    if (receiverFilter) receiverFilter.value = '';
    if (statusFilter) statusFilter.value = '';
    if (showTakerRequests) showTakerRequests.checked = false;
    filtered = services.slice();
    page = 1;
    render();
  });

  // pagination
  if (firstBtn) firstBtn.addEventListener('click', () => { page = 1; render(); rowsContainer.scrollIntoView({behavior:'smooth', block:'start'}); });
  if (prevBtn) prevBtn.addEventListener('click', () => { if (page > 1) { page--; render(); rowsContainer.scrollIntoView({behavior:'smooth', block:'start'}); } });
  if (nextBtn) nextBtn.addEventListener('click', () => { if (((page) * pageSize) < filtered.length) { page++; render(); rowsContainer.scrollIntoView({behavior:'smooth', block:'start'}); } });

  // modal
  function showServiceModalFor(s){
    if (!modalContent) return;
    modalContent.dataset.currentId = s.id;
    modalContent.innerHTML = `
      <h2 class="text-xl font-semibold">${escHtml(s.service_name)}</h2>
      <p class="mt-2 text-gray-700">${escHtml(s.description || '')}</p>
      <div class="mt-4 text-sm space-y-2">
        <div><strong>Receiver:</strong> ${escHtml(s.receiver_name || '—')} ${s.receiver_member_id ? '('+escHtml(s.receiver_member_id)+')' : ''}</div>
        <div><strong>Status:</strong> <span class="${s.status==='accepted'?'text-green-700':'text-yellow-700'} font-medium">${escHtml(s.status)}</span></div>
        ${s.taker_request ? '<div class="mt-2 text-xs text-indigo-700">This was requested by the taker.</div>' : ''}
      </div>
    `;

    if (s.taker_request && s.taker_contact) {
      modalContent.insertAdjacentHTML('beforeend', `
        <hr class="my-4" />
        <div class="text-sm">
          <div class="font-medium">Taker contact details</div>
          <div class="text-xs text-gray-600 mt-1">Name: ${escHtml(s.taker_contact.name || '—')}</div>
          <div class="text-xs text-gray-600">Member ID: ${escHtml(s.taker_contact.member_id || '—')}</div>
          <div class="text-xs text-gray-600">Phone: ${escHtml(s.taker_contact.phone || '—')}</div>
          <div class="text-xs text-gray-600">Email: ${escHtml(s.taker_contact.email || '—')}</div>
        </div>
      `);
    }

    if (s.taker_documents && s.taker_documents.length) {
      let docsHtml = `<hr class="my-4" />
        <div class="text-sm">
          <div class="font-medium mb-2">Taker documents</div>
          <div class="space-y-2">`;
      s.taker_documents.forEach((d, idx) => {
        docsHtml += `
          <div class="flex items-center justify-between bg-gray-50 p-2 rounded">
            <div class="truncate text-sm"><strong class="text-gray-800">${escHtml(d.name)}</strong> <div class="text-xs text-gray-500">${escHtml(d.size||'')}</div></div>
            <a href="${escHtml(d.url)}" download target="_blank" class="px-3 py-1 border rounded text-xs bg-white">Download</a>
          </div>
        `;
      });
      docsHtml += `</div></div>`;
      modalContent.insertAdjacentHTML('beforeend', docsHtml);
    }

    // action area
    const actionArea = document.createElement('div');
    actionArea.className = 'mt-4 flex gap-2 justify-end flex-wrap';
    if (s.taker_request) {
      const acceptBtn = document.createElement('button');
      acceptBtn.className = 'px-4 py-2 bg-green-600 text-white rounded-md acceptBtnModal';
      acceptBtn.textContent = 'Accept';
      acceptBtn.dataset.id = s.id;
      const rejectBtn = document.createElement('button');
      rejectBtn.className = 'px-4 py-2 bg-red-600 text-white rounded-md rejectBtnModal';
      rejectBtn.textContent = 'Reject';
      rejectBtn.dataset.id = s.id;
      actionArea.appendChild(acceptBtn);
      actionArea.appendChild(rejectBtn);
    }
    const closeAreaBtn = document.createElement('button');
    closeAreaBtn.className = 'px-4 py-2 bg-red-500 text-white rounded-md ml-2';
    closeAreaBtn.textContent = 'Close';
    closeAreaBtn.addEventListener('click', () => hideServiceModal());
    actionArea.appendChild(closeAreaBtn);
    modalContent.appendChild(actionArea);

    modalContent.querySelectorAll('.acceptBtnModal').forEach(b => {
      b.addEventListener('click', (e) => { e.preventDefault(); handleAccept(b.dataset.id); hideServiceModal(); });
    });
    modalContent.querySelectorAll('.rejectBtnModal').forEach(b => {
      b.addEventListener('click', (e) => { e.preventDefault(); handleReject(b.dataset.id); hideServiceModal(); });
    });

    if (serviceModal) { serviceModal.classList.remove('hidden'); serviceModal.style.display = 'flex'; lockScroll(); }
  }

  // delegated click handlers
  document.addEventListener('click', (ev) => {
    const viewBtn = ev.target.closest && ev.target.closest('.viewBtn');
    if (viewBtn) {
      const id = viewBtn.dataset.id;
      if (!id) return;
      const s = services.find(x => String(x.id) === String(id));
      if (!s) return;
      showServiceModalFor(s);
      return;
    }

    const acceptBtn = ev.target.closest && ev.target.closest('.acceptBtn');
    if (acceptBtn) {
      const id = acceptBtn.dataset.id;
      if (!id) return;
      handleAccept(id);
      return;
    }

    const rejectBtn = ev.target.closest && ev.target.closest('.rejectBtn');
    if (rejectBtn) {
      const id = rejectBtn.dataset.id;
      if (!id) return;
      handleReject(id);
      return;
    }

    // mobile accept/reject (stacked)
    const acceptBtnMobile = ev.target.closest && ev.target.closest('.acceptBtnMobile');
    if (acceptBtnMobile) {
      const id = acceptBtnMobile.dataset.id;
      if (!id) return;
      handleAccept(id);
      return;
    }
    const rejectBtnMobile = ev.target.closest && ev.target.closest('.rejectBtnMobile');
    if (rejectBtnMobile) {
      const id = rejectBtnMobile.dataset.id;
      if (!id) return;
      handleReject(id);
      return;
    }
  });

  function hideServiceModal(){ if (!serviceModal) return; serviceModal.classList.add('hidden'); serviceModal.style.display = 'none'; unlockScroll(); if (modalContent) delete modalContent.dataset.currentId; }
  if (modalOverlay) modalOverlay.addEventListener('click', (ev) => { if (ev.target === modalOverlay) hideServiceModal(); });
  if (modalCloseX) modalCloseX.addEventListener('click', (e) => { e.preventDefault(); hideServiceModal(); });
  if (modalCloseBtn) modalCloseBtn.addEventListener('click', (e) => { e.preventDefault(); hideServiceModal(); });

  document.addEventListener('keydown', (ev) => { if (ev.key === 'Escape') { hideServiceModal(); } });

  filtered = services.slice();
  render();
})();
</script>

@include('components.script')