@include('components.memberheader')

<div id="inv-page" class="max-w-7xl mx-auto px-4 py-8">
  <div class="flex items-center justify-between mb-4">
    <div>
      <h2 class="text-lg font-semibold text-gray-800">Investors</h2>
      <p class="text-sm text-gray-600">Members who have indicated investment interest (admin adds/approves).</p>
    </div>

    <div class="flex items-center gap-2">
      <input id="inv-globalSearch" type="search" placeholder="Search by member, category, interest..." class="px-3 py-2 border rounded-md text-sm w-72" />
      <button id="inv-searchBtn" class="px-3 py-2 bg-red-500 text-white rounded-md text-sm">Search</button>
      <button id="inv-exportCsvBtn" class="px-3 py-2 bg-white border rounded text-sm">Export</button>
      <button id="inv-openAddBtn" class="px-3 py-2 bg-red-500 text-white rounded-md text-sm">Add Investor</button>

    </div>
  </div>

  <div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <div class="hidden md:grid grid-cols-12 gap-4 px-4 py-3 text-xs text-gray-500 border-b bg-gray-50">
      <div class="col-span-1">#</div>
      <div class="col-span-2">Member</div>
      <div class="col-span-2">Amount</div>
      <div class="col-span-3">Interested Categories</div>
      <div class="col-span-2">Startup Interest</div>
      <div class="col-span-1">Status</div>
      <div class="col-span-1 text-right">View</div>
    </div>

    <div id="inv-rowsContainer" class="divide-y divide-gray-100"></div>

    <div class="px-4 py-3 border-t bg-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-sm">
      <div class="text-gray-600">Showing <span id="inv-showCount">0</span>–<span id="inv-showEnd">0</span> of <span id="inv-totalCount">0</span> • Page <span id="inv-currentPage">1</span></div>
      <div class="flex items-center gap-2">
        <button id="inv-firstPage" class="px-3 py-1 bg-white border rounded text-sm">First</button>
        <button id="inv-prevPage"  class="px-3 py-1 bg-white border rounded text-sm">Prev</button>
        <button id="inv-nextPage"  class="px-3 py-1 bg-white border rounded text-sm">Next</button>
      </div>
    </div>
  </div>
</div>

<!-- VIEW MODAL (investors) -->
<div id="inv-viewModal" class="fixed inset-0 z-50 hidden flex items-center justify-center">

  <div id="inv-viewOverlay" class="absolute inset-0 bg-black/40"></div>

  <div class="relative max-w-2xl w-full mx-4">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
      <div class="flex items-center justify-between px-6 py-4 border-b">
        <h3 class="text-lg font-semibold">Investor Details</h3>
        <button id="inv-viewModalCloseX" class="text-gray-500 hover:text-gray-700">✕</button>
      </div>

      <div id="inv-viewModalContent" class="p-6 text-sm">
        <!-- populated by JS -->
      </div>

      <div class="p-4 border-t flex justify-between items-center gap-3">
        <div id="inv-adminActions" class="flex items-center gap-2"></div>
        <div class="flex gap-2">
          <button id="inv-viewModalCloseBtn" class="px-4 py-2 bg-red-500 text-white rounded-md">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

    </main>
  </div>
<!-- ADD INVESTOR MODAL -->
<div id="inv-addModal" class="fixed inset-0 z-50 hidden items-center justify-center">
  <div id="inv-addOverlay" class="absolute inset-0 bg-black/40"></div>
  <div class="relative max-w-xl w-full mx-4">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
      <div class="flex items-center justify-between px-6 py-4 border-b">
        <h3 class="text-lg font-semibold">Add Investor</h3>
        <button id="inv-addModalCloseX" class="text-gray-500 hover:text-gray-700">✕</button>
      </div>

      <form id="inv-addForm" class="p-6 space-y-3">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <input id="inv-newMemberName" placeholder="Member name" class="px-3 py-2 border rounded-md w-full" required />
          <input id="inv-newMemberId" placeholder="Member ID" class="px-3 py-2 border rounded-md w-full" required />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <input id="inv-newAmount" type="number" step="0.01" placeholder="Investment amount (INR)" class="px-3 py-2 border rounded-md w-full" required />
          <input id="inv-newCategories" placeholder="Interested categories (comma separated)" class="px-3 py-2 border rounded-md w-full" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <select id="inv-investsInType" class="px-3 py-2 border rounded-md w-full">
            <option value="company">Company</option>
            <option value="startup">Member's Startup</option>
          </select>
          <input id="inv-investsInName" placeholder="Company / Startup name" class="px-3 py-2 border rounded-md w-full" />
        </div>

        <div>
          <label class="text-xs text-gray-600">Investor Contact (phone / email)</label>
          <input id="inv-newContact" placeholder="Phone or email" class="mt-1 px-3 py-2 border rounded-md w-full" />
        </div>

        <div>
          <label class="text-xs text-gray-600">Member notes</label>
          <textarea id="inv-newNotes" rows="3" class="mt-1 px-3 py-2 border rounded-md w-full"></textarea>
        </div>

        <div>
          <label class="text-xs text-gray-600">Document URL (optional)</label>
          <input id="inv-newDocUrl" placeholder="https://..." class="mt-1 px-3 py-2 border rounded-md w-full" />
        </div>

        <div class="flex items-center gap-2 justify-end pt-2">
          <button id="inv-cancelAdd" type="button" class="px-3 py-2 bg-white border rounded-md">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md">Add Investor</button>
        </div>
      </form>

    </div>
  </div>
</div>

  <!-- SCRIPTS -->

  <script>
/* INVESTORS PAGE — enhanced: Add investor + invested target + docs + Download All */
document.addEventListener('DOMContentLoaded', () => {
  // --- CONFIG ---
  const isAdmin = false; // change to true if admin testing

  // --- SAMPLE DATA (replace with server data in production) ---
  let investors = [
    { id: 1, member_id: 301, member_name: 'Priya Singh', investment_amount: 500000.00, interested_categories: 'Tech,Health', startup_interest: 'Seed', member_notes: 'Happy to support early-stage health-tech', status: 'pending', invests_in_type: 'company', invests_in_name: 'Priya Labs', contact: 'priya@example.com', documents: [], created_at:'2025-08-01' },
    { id: 2, member_id: 205, member_name: 'Aditi Verma', investment_amount: 2500000.00, interested_categories: 'EdTech', startup_interest: 'Series-A', member_notes: 'Prefer edtech founders with traction', status: 'verified', invests_in_type: 'startup', invests_in_name: 'Aditi Edventures', contact: 'aditi@company.com', documents: [], created_at:'2025-07-12' },
    { id: 3, member_id: 112, member_name: 'Rahul Mehta', investment_amount: 100000.00, interested_categories: 'FMCG', startup_interest: 'Early-stage', member_notes: '', status: 'rejected', invests_in_type: 'company', invests_in_name: 'Rahul Foods', contact: 'rahul@example.com', documents: [{name:'KYC.pdf', url:'https://example.com/files/kyc.pdf', size:'120 KB'}], created_at:'2025-06-20' }
  ];

  // --- STATE ---
  let filtered = [...investors];
  let page = 1;
  const pageSize = 6;

  // --- DOM REFS ---
  const rowsContainer = document.getElementById('inv-rowsContainer');
  const showCount = document.getElementById('inv-showCount');
  const showEnd = document.getElementById('inv-showEnd');
  const totalCountEl = document.getElementById('inv-totalCount');
  const currentPageEl = document.getElementById('inv-currentPage');
  const prevBtn = document.getElementById('inv-prevPage');
  const nextBtn = document.getElementById('inv-nextPage');
  const firstBtn = document.getElementById('inv-firstPage');

  const globalSearch = document.getElementById('inv-globalSearch');
  const searchBtn = document.getElementById('inv-searchBtn');
  const exportCsvBtn = document.getElementById('inv-exportCsvBtn');

  const viewModal = document.getElementById('inv-viewModal');
  const viewOverlay = document.getElementById('inv-viewOverlay');
  const viewModalCloseX = document.getElementById('inv-viewModalCloseX');
  const viewModalCloseBtn = document.getElementById('inv-viewModalCloseBtn');
  const viewModalContent = document.getElementById('inv-viewModalContent');
  const adminActions = document.getElementById('inv-adminActions');

  // add modal refs
  const openAddBtn = document.getElementById('inv-openAddBtn');
  const addModal = document.getElementById('inv-addModal');
  const addOverlay = document.getElementById('inv-addOverlay');
  const addCloseX = document.getElementById('inv-addModalCloseX');
  const addCancel = document.getElementById('inv-cancelAdd');
  const addForm = document.getElementById('inv-addForm');

  // helpers
  const esc = s => s == null ? '' : String(s).replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;');
  const formatMoney = v => typeof v === 'number' ? v.toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2}) : v;
  const formatDate = d => d ? d : '—';

  // build row (desktop)
  function buildDesktopRow(it, idx) {
    return `
      <div class="hidden md:grid grid-cols-12 gap-4 px-4 py-4 items-center text-sm">
        <div class="col-span-1 text-gray-600">${idx}</div>
        <div class="col-span-2 font-medium">${esc(it.member_name || ('Member #' + it.member_id))}</div>
        <div class="col-span-2">₹ ${formatMoney(it.investment_amount)}</div>
        <div class="col-span-3 text-gray-700">${esc(it.interested_categories || '—')}</div>
        <div class="col-span-2 text-gray-600">${esc(it.startup_interest || '—')}</div>
        <div class="col-span-1">
          <span class="${it.status==='verified' ? 'inline-block px-2 py-1 rounded-full bg-green-50 text-green-700 text-xs' : it.status==='pending' ? 'inline-block px-2 py-1 rounded-full bg-yellow-50 text-yellow-700 text-xs' : 'inline-block px-2 py-1 rounded-full bg-red-50 text-red-700 text-xs'}">${esc(it.status)}</span>
        </div>
        <div class="col-span-1 text-right">
          <button type="button" class="inv-viewBtn text-blue-600 hover:text-blue-700 text-sm font-medium" data-id="${it.id}">View</button>
        </div>
      </div>
    `;
  }

  // mobile card
  function buildMobileCard(it, idx) {
    return `
      <div class="md:hidden px-4 py-4 bg-white">
        <div class="flex items-start justify-between gap-3">
          <div>
            <div class="font-medium">${esc(it.member_name || ('Member #' + it.member_id))} — ₹ ${formatMoney(it.investment_amount)}</div>
            <div class="text-xs text-gray-500 mt-1">${esc(it.interested_categories || '—')} • ${esc(it.startup_interest || '—')}</div>
            <div class="text-xs text-gray-400 mt-2">${esc(it.member_notes || '')}</div>
          </div>
          <div class="flex items-start gap-2">
            <button type="button" class="inv-viewBtn text-blue-600 hover:text-blue-700 text-sm font-medium" data-id="${it.id}">View</button>
          </div>
        </div>
      </div>
    `;
  }

  // render page
  function render() {
    rowsContainer.innerHTML = '';
    const start = (page - 1) * pageSize;
    const end = start + pageSize;
    const list = filtered.slice(start, end);

    if (!list.length) {
      rowsContainer.innerHTML = '<div class="p-6 text-center text-gray-500 text-sm">No investors available.</div>';
    } else {
      list.forEach((it, i) => {
        rowsContainer.insertAdjacentHTML('beforeend', buildDesktopRow(it, start + i + 1));
        rowsContainer.insertAdjacentHTML('beforeend', buildMobileCard(it, start + i + 1));
      });
    }

    showCount.textContent = list.length ? start + 1 : 0;
    showEnd.textContent = Math.min(end, filtered.length);
    totalCountEl.textContent = filtered.length;
    currentPageEl.textContent = page;

    prevBtn.disabled = page <= 1;
    firstBtn.disabled = page <= 1;
    nextBtn.disabled = end >= filtered.length;
  }

  // search
  function doSearch() {
    const q = (globalSearch.value || '').toLowerCase().trim();
    filtered = investors.filter(i => {
      const hay = `${i.member_id} ${i.member_name} ${i.interested_categories} ${i.startup_interest} ${i.member_notes} ${i.status} ${i.invests_in_name}`.toLowerCase();
      return !q || hay.includes(q);
    });
    page = 1;
    render();
  }
  searchBtn.addEventListener('click', doSearch);
  globalSearch.addEventListener('keydown', e => { if (e.key === 'Enter') doSearch(); });

  // pagination
  firstBtn.addEventListener('click', () => { page = 1; render(); });
  prevBtn.addEventListener('click', () => { if (page > 1) { page--; render(); }});
  nextBtn.addEventListener('click', () => { if (page * pageSize < filtered.length) { page++; render(); }});

  // export CSV
  exportCsvBtn.addEventListener('click', () => {
    const rows = filtered.map(r => [ r.member_name || ('Member #' + r.member_id), r.member_id, r.investment_amount, r.invested_in_type || '', r.invests_in_name || '', r.interested_categories || '', r.startup_interest || '', r.member_notes || '', r.status ]);
    const header = ['Member','Member ID','Amount','Invests In Type','Invests In Name','Categories','Startup Interest','Member Notes','Status'];
    const csv = [header, ...rows].map(r => r.map(c => `"${String(c||'').replace(/"/g,'""')}"`).join(',')).join('\n');
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a'); a.href = url; a.download = 'investors.csv'; a.click(); URL.revokeObjectURL(url);
  });

  // view modal (delegated)
  document.addEventListener('click', (ev) => {
    const btn = ev.target.closest && ev.target.closest('.inv-viewBtn');
    if (!btn) return;
    const id = Number(btn.dataset.id);
    const item = investors.find(x => x.id === id);
    if (!item) return;

    // build modal content including invested company/startup and docs
    let html = `
      <div class="space-y-4">
        <h2 class="text-xl font-semibold">${esc(item.member_name || ('Member #' + item.member_id))} — ₹ ${formatMoney(item.investment_amount)}</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
          <div><strong>Member ID</strong><div class="mt-1">#${esc(item.member_id)}</div></div>
          <div><strong>Categories</strong><div class="mt-1">${esc(item.interested_categories || '—')}</div></div>
          <div><strong>Startup Interest</strong><div class="mt-1">${esc(item.startup_interest || '—')}</div></div>
          <div><strong>Status</strong><div class="mt-1">${esc(item.status)}</div></div>
          <div class="sm:col-span-2"><strong>Member Notes</strong><div class="mt-1">${esc(item.member_notes || '—')}</div></div>
          <div class="sm:col-span-2"><strong>Admin Notes</strong><div class="mt-1">${esc(item.admin_notes || '—')}</div></div>
          <div class="sm:col-span-2 text-xs text-gray-400">Created: ${formatDate(item.created_at)}</div>
        </div>
      </div>
    `;

    // invested in detail
    html += `
      <hr class="my-4" />
      <div class="text-sm">
        <div><strong>Invests In</strong></div>
        <div class="mt-1">${esc(item.invests_in_type || '—')} : <span class="font-medium">${esc(item.invests_in_name || '—')}</span></div>
        <div class="mt-2"><strong>Contact</strong> <div class="text-xs text-gray-600 mt-1">${esc(item.contact || '—')}</div></div>
      </div>
    `;

    // documents section
    if (item.documents && item.documents.length) {
      html += '<hr class="my-4" /><div class="text-sm"><div class="font-medium mb-2">Documents</div>';
      item.documents.forEach((d, idx) => {
        html += `
          <div class="flex items-center justify-between bg-gray-50 p-2 rounded mb-2">
            <div class="truncate text-sm"><strong>${esc(d.name || ('doc-'+(idx+1)))}</strong> <div class="text-xs text-gray-500">${esc(d.url)}</div></div>
            <div><a href="${esc(d.url)}" target="_blank" download class="px-3 py-1 border rounded text-xs bg-white">Download</a></div>
          </div>
        `;
      });
      html += `<div class="mt-2"><button id="inv-downloadAllDocsBtn" class="px-3 py-1 bg-red-500 text-white rounded text-sm">Download All</button></div></div>`;
    }

    viewModalContent.innerHTML = html;

    // admin actions
    adminActions.innerHTML = '';
    if (isAdmin) {
      const verifyBtn = document.createElement('button'); verifyBtn.className = 'px-3 py-1 bg-green-600 text-white rounded text-sm'; verifyBtn.textContent = 'Verify';
      verifyBtn.addEventListener('click', () => { item.status = 'verified'; item.verified_by = 1; item.admin_notes = 'Verified by admin'; render(); setTimeout(() => btn.click(), 50); });
      const rejectBtn = document.createElement('button'); rejectBtn.className = 'px-3 py-1 bg-red-600 text-white rounded text-sm'; rejectBtn.textContent = 'Reject';
      rejectBtn.addEventListener('click', () => { const r = prompt('Rejection reason (optional):','Insufficient docs'); item.status='rejected'; item.rejection_reason=r; item.admin_notes=r; render(); setTimeout(()=>btn.click(),50); });
      adminActions.appendChild(verifyBtn); adminActions.appendChild(rejectBtn);
    }

    // Download All handler
    setTimeout(() => {
      const dl = document.getElementById('inv-downloadAllDocsBtn');
      if (dl) {
        dl.addEventListener('click', (e) => {
          e.preventDefault();
          const anchors = Array.from(viewModalContent.querySelectorAll('a[target="_blank"]'));
          if (!anchors.length) return;
          anchors.forEach((a, i) => setTimeout(()=>{ try{ a.click(); } catch(err){ window.open(a.href,'_blank'); } }, i*300));
        });
      }
    }, 30);

    // show modal
    viewModal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
  });

  // close modal
  function closeViewModal(){ viewModal.classList.add('hidden'); document.body.style.overflow = ''; }
  if (viewOverlay) viewOverlay.addEventListener('click', closeViewModal);
  if (viewModalCloseX) viewModalCloseX.addEventListener('click', closeViewModal);
  if (viewModalCloseBtn) viewModalCloseBtn.addEventListener('click', closeViewModal);
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeViewModal(); });

  // --- Add investor modal handling ---
  function openAddModal(){
    if (!addModal) return;
    addModal.classList.remove('hidden');
    addModal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
  }
  function closeAddModal(){
    if (!addModal) return;
    addModal.classList.add('hidden');
    addModal.style.display = 'none';
    document.body.style.overflow = '';
  }

  if (openAddBtn) openAddBtn.addEventListener('click', openAddModal);
  if (addCloseX) addCloseX.addEventListener('click', closeAddModal);
  if (addOverlay) addOverlay.addEventListener('click', (ev) => { if (ev.target === addOverlay) closeAddModal(); });
  if (addCancel) addCancel.addEventListener('click', closeAddModal);

  if (addForm) {
    addForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const name = document.getElementById('inv-newMemberName')?.value?.trim();
      const memberId = document.getElementById('inv-newMemberId')?.value?.trim();
      const amount = parseFloat(document.getElementById('inv-newAmount')?.value) || 0;
      const categories = document.getElementById('inv-newCategories')?.value?.trim();
      const investsInType = document.getElementById('inv-investsInType')?.value;
      const investsInName = document.getElementById('inv-investsInName')?.value?.trim();
      const contact = document.getElementById('inv-newContact')?.value?.trim();
      const notes = document.getElementById('inv-newNotes')?.value?.trim();
      const docUrl = document.getElementById('inv-newDocUrl')?.value?.trim();

      if (!name || !memberId || !amount) {
        alert('Please provide Member name, Member ID and Investment amount.');
        return;
      }

      const newInv = {
        id: investors.length ? Math.max(...investors.map(i=>i.id)) + 1 : 1,
        member_id: memberId,
        member_name: name,
        investment_amount: amount,
        interested_categories: categories,
        startup_interest: '',
        member_notes: notes,
        status: 'pending',
        invests_in_type: investsInType,
        invests_in_name: investsInName,
        contact: contact,
        documents: docUrl ? [{name: docUrl.split('/').pop(), url: docUrl, size:''}] : [],
        created_at: new Date().toISOString().slice(0,10)
      };

      investors.unshift(newInv);
      filtered = [...investors];
      page = 1;
      render();
      addForm.reset();
      closeAddModal();
    });
  }

  // initial render
  filtered = [...investors];
  render();

  // feather icons safe refresh
  if (typeof feather !== 'undefined') feather.replace();
});
</script>
@include('components.script')