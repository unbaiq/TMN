@include('components.memberheader')
<main class="flex-1 p-6 sm:p-10">
      <!-- Header -->
      <div class="flex items-start justify-between gap-4 mb-6">
        <div>
          <h1 class="text-2xl font-semibold text-gray-800 flex items-center gap-3">
            <i data-feather="heart" class="w-5 h-5 text-red-600"></i>
            Member CSR
          </h1>
          <p class="text-sm text-gray-600 mt-1">Manage CSR initiatives — add, attach documents, view and export (demo).</p>
        </div>

        <div class="flex items-center gap-3">
          <button id="exportCsv" class="px-3 py-2 bg-white border rounded text-sm flex items-center gap-2 hover:shadow-sm">
            <i data-feather="download" class="w-4 h-4"></i> Export CSV
          </button>

          <!-- Add CSR Button -->
          <div>
            <button id="openAddCSR_main" class="px-4 py-2 bg-red-600 text-white rounded-md text-sm flex items-center gap-2 shadow">
              <i data-feather="plus" class="w-4 h-4"></i> Add CSR
            </button>
          </div>
        </div>
      </div>

      <!-- Filters -->
      <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">
          <div>
            <label class="text-xs text-gray-600">Search</label>
            <input id="searchInput" type="search" placeholder="Title, description, chapter..." class="mt-1 w-full px-3 py-2 rounded border border-slate-200 text-sm" />
          </div>

          <div>
            <label class="text-xs text-gray-600">Category</label>
            <select id="categoryFilter" class="mt-1 w-full px-3 py-2 rounded border border-slate-200 text-sm">
              <option value="">All Categories</option>
              <option>Education</option>
              <option>Health</option>
              <option>Environment</option>
            </select>
          </div>

          <div>
            <label class="text-xs text-gray-600">Chapter</label>
            <select id="chapterFilter" class="mt-1 w-full px-3 py-2 rounded border border-slate-200 text-sm">
              <option value="">All Chapters</option>
              <option>Delhi</option>
              <option>Mumbai</option>
              <option>Bengaluru</option>
            </select>
          </div>

          <div class="flex gap-2 justify-end">
            <button id="clearFilters" class="px-3 py-2 bg-white border rounded text-sm">Clear</button>
            <button id="applyFilters" class="px-3 py-2 bg-red-600 text-white rounded text-sm">Apply</button>
          </div>
        </div>
      </div>

      <!-- Table -->
      <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="hidden md:grid grid-cols-12 gap-4 px-4 py-3 text-xs text-gray-500 border-b">
          <div class="col-span-1">#</div>
          <div class="col-span-3">Title</div>
          <div class="col-span-3">Description</div>
          <div class="col-span-1">Amount</div>
          <div class="col-span-2">Date</div>
          <div class="col-span-2 text-right">Actions</div>
        </div>

        <div id="rowsContainer" class="divide-y"></div>

        <div class="px-4 py-3 border-t bg-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-sm">
          <div class="text-gray-600">Showing <span id="showStart">0</span>-<span id="showEnd">0</span> of <span id="totalCount">0</span> • Page <span id="currentPage">1</span></div>
          <div class="flex items-center gap-2">
            <button id="firstPage" class="px-3 py-1 bg-white border rounded disabled:opacity-50">First</button>
            <button id="prevPage" class="px-3 py-1 bg-white border rounded disabled:opacity-50">Prev</button>
            <button id="nextPage" class="px-3 py-1 bg-white border rounded disabled:opacity-50">Next</button>
          </div>
        </div>
      </div>
    </main>
  </div>

  <!-- View Modal -->
  <div id="viewModal" class="fixed inset-0 z-50 hidden flex items-center justify-center modal-backdrop">
    <div id="viewOverlay" class="absolute inset-0 bg-black/40"></div>

    <div class="relative max-w-2xl w-full mx-4">
      <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b">
          <h3 class="text-lg font-semibold">CSR Details</h3>
          <button id="closeViewX" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>

        <div id="modalBody" class="p-6 text-sm text-gray-800 max-h-[80vh] overflow-y-auto"></div>

        <div class="p-4 border-t flex items-center justify-between">
          <div id="modalDownloadAll"></div>
          <div>
            <button id="closeViewBtn" class="px-4 py-2 bg-red-600 text-white rounded-md">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Add CSR Modal (scrollable internal content) -->
  <div id="addCSRModal" class="fixed inset-0 z-50 hidden flex items-center justify-center modal-backdrop">
    <div id="addCSROverlay" class="absolute inset-0 bg-black/40"></div>

    <div class="relative max-w-xl w-full mx-4">
      <div class="bg-white rounded-2xl shadow-xl max-h-[90vh] w-full flex flex-col overflow-hidden">
        <!-- header -->
        <div class="flex items-center justify-between px-6 py-4 border-b flex-shrink-0">
          <h3 class="text-lg font-semibold">Add CSR Initiative</h3>
          <button id="closeAddX" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>

        <!-- scrollable content -->
        <div class="p-6 space-y-3 overflow-y-auto" style="max-height: calc(90vh - 88px);">
          <form id="addCSRForm" class="space-y-3">
            <div>
              <label class="text-xs text-gray-600">Title</label>
              <input id="csrTitle" required class="mt-1 w-full px-3 py-2 border rounded" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
              <div>
                <label class="text-xs text-gray-600">Category</label>
                <input id="csrCategory" class="mt-1 w-full px-3 py-2 border rounded" />
              </div>
              <div>
                <label class="text-xs text-gray-600">Amount (INR)</label>
                <input id="csrAmount" type="number" min="0" class="mt-1 w-full px-3 py-2 border rounded" />
              </div>
            </div>

            <div>
              <label class="text-xs text-gray-600">Chapter</label>
              <input id="csrChapter" class="mt-1 w-full px-3 py-2 border rounded" />
            </div>

            <div>
              <label class="text-xs text-gray-600">Date</label>
              <input id="csrDate" type="date" class="mt-1 w-full px-3 py-2 border rounded" />
            </div>

            <div>
              <label class="text-xs text-gray-600">Description</label>
              <textarea id="csrDesc" rows="4" class="mt-1 w-full px-3 py-2 border rounded"></textarea>
            </div>

            <div>
              <label class="text-xs text-gray-600">Attach documents (optional)</label>
              <input id="csrFiles" type="file" multiple class="mt-1 w-full" />
              <p class="text-xs text-gray-400 mt-1">You can attach proposal, photos, report, etc.</p>
            </div>

            <div class="flex items-center gap-2 justify-end">
              <button id="cancelAddCSR" type="button" class="px-3 py-2 bg-white border rounded">Cancel</button>
              <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Create CSR</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  if (typeof feather !== 'undefined') feather.replace();

  // Demo data (uses 'date' field)
  let csrs = [
    { id: 1, title: 'School Library Renovation', category: 'Education', description: 'Renovate government school library and provide new books.', amount: 50000, currency: 'INR', chapter: 'Delhi', date: '2025-10-12', documents: [{ name: 'proposal.pdf', url: 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf', size: '220 KB' }], created_at: '2025-10-12' },
    { id: 2, title: 'Medical Camp - Riverside', category: 'Health', description: 'Free medical checkup and general awareness event.', amount: 30000, currency: 'INR', chapter: 'Mumbai', date: '2025-09-20', documents: [], created_at: '2025-09-20' },
    { id: 3, title: 'Tree Plantation Drive', category: 'Environment', description: 'Planting 500 trees across public parks.', amount: 45000, currency: 'INR', chapter: 'Bengaluru', date: '2025-08-05', documents: [{ name: 'plan.pdf', url: 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf', size: '310 KB' }], created_at: '2025-08-05' }
  ];

  // state
  let filtered = csrs.slice();
  let page = 1;
  const pageSize = 6;

  // dom refs
  const rowsContainer = document.getElementById('rowsContainer');
  const showStart = document.getElementById('showStart');
  const showEnd = document.getElementById('showEnd');
  const totalCountEl = document.getElementById('totalCount');
  const currentPageEl = document.getElementById('currentPage');

  const prevBtn = document.getElementById('prevPage');
  const nextBtn = document.getElementById('nextPage');
  const firstBtn = document.getElementById('firstPage');

  const searchInput = document.getElementById('searchInput');
  const categoryFilter = document.getElementById('categoryFilter');
  const chapterFilter = document.getElementById('chapterFilter');
  const applyFiltersBtn = document.getElementById('applyFilters');
  const clearFiltersBtn = document.getElementById('clearFilters');

  const exportCsvBtn = document.getElementById('exportCsv');

  // add modal refs
  const openAddCSR_main = document.getElementById('openAddCSR_main');
  const addCSRModal = document.getElementById('addCSRModal');
  const addCSROverlay = document.getElementById('addCSROverlay');
  const closeAddX = document.getElementById('closeAddX');
  const cancelAddCSR = document.getElementById('cancelAddCSR');
  const addCSRForm = document.getElementById('addCSRForm');
  const csrFiles = document.getElementById('csrFiles');

  // view modal refs
  const viewModal = document.getElementById('viewModal');
  const viewOverlay = document.getElementById('viewOverlay');
  const modalBody = document.getElementById('modalBody');
  const closeViewX = document.getElementById('closeViewX');
  const closeViewBtn = document.getElementById('closeViewBtn');
  const modalDownloadAll = document.getElementById('modalDownloadAll');

  // helpers
  const esc = s => s == null ? '' : String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
  const formatMoney = v => typeof v === 'number' ? '₹' + v.toLocaleString() : v;
  function formatDate(d) { if (!d) return '—'; return String(d).slice(0,10); }

  // defensive guard
  if (!rowsContainer) { console.warn('rowsContainer not found — CSR script aborted'); return; }

  // render
  function render(){
    rowsContainer.innerHTML = '';
    const total = filtered.length;
    const start = (page - 1) * pageSize;
    const end = Math.min(start + pageSize, total);
    const pageList = filtered.slice(start, start + pageSize);

    if (!pageList.length) {
      rowsContainer.innerHTML = '<div class="p-6 text-center text-gray-500">No CSR records found.</div>';
    } else {
      pageList.forEach((c, i) => {
        // desktop row
        const desktop = document.createElement('div');
        desktop.className = 'hidden md:grid grid-cols-12 gap-4 px-4 py-4 items-center text-sm';
        desktop.innerHTML = `
          <div class="col-span-1 text-gray-600">${start + i + 1}</div>
          <div class="col-span-3 font-medium">${esc(c.title)}</div>
          <div class="col-span-3 text-gray-600 truncate">${esc(c.description)}</div>
          <div class="col-span-1">${formatMoney(c.amount)}</div>
          <div class="col-span-2">${formatDate(c.date)}</div>
          <div class="col-span-2 text-right">
            <button class="viewBtn text-blue-600 mr-3" data-id="${c.id}">View</button>
          </div>
        `;
        rowsContainer.appendChild(desktop);

        // mobile card
        const mobile = document.createElement('div');
        mobile.className = 'md:hidden px-4 py-4';
        mobile.innerHTML = `
          <div class="flex items-start justify-between gap-3">
            <div>
              <div class="font-medium">${esc(c.title)}</div>
              <div class="text-xs text-gray-500 mt-1">${esc(c.chapter)} • ${formatMoney(c.amount)} • ${formatDate(c.date)}</div>
            </div>
            <div class="text-right">
              <div class="mt-2"><button class="viewBtn text-blue-600 text-sm" data-id="${c.id}">View</button></div>
            </div>
          </div>
        `;
        rowsContainer.appendChild(mobile);
      });
    }

    if (showStart) showStart.textContent = total ? ((page - 1) * pageSize + 1) : 0;
    if (showEnd) showEnd.textContent = total ? Math.min(page * pageSize, total) : 0;
    if (totalCountEl) totalCountEl.textContent = total;
    if (currentPageEl) currentPageEl.textContent = page;

    if (prevBtn) prevBtn.disabled = page <= 1;
    if (firstBtn) firstBtn.disabled = page <= 1;
    if (nextBtn) nextBtn.disabled = page * pageSize >= total;
  }

  // filtering
  function applyFilters(){
    const q = (searchInput && searchInput.value || '').toLowerCase().trim();
    const cat = (categoryFilter && categoryFilter.value || '').toLowerCase();
    const chap = (chapterFilter && chapterFilter.value || '').toLowerCase();
    filtered = csrs.filter(c => {
      const hay = (c.title + ' ' + c.description + ' ' + (c.category||'') + ' ' + (c.chapter||'')).toLowerCase();
      if (q && !hay.includes(q)) return false;
      if (cat && (c.category || '').toLowerCase() !== cat) return false;
      if (chap && (c.chapter || '').toLowerCase() !== chap) return false;
      return true;
    });
    page = 1; render();
  }

  // init
  filtered = csrs.slice();
  render();

  // pagination
  if (firstBtn) firstBtn.addEventListener('click', () => { page = 1; render(); });
  if (prevBtn) prevBtn.addEventListener('click', () => { if (page>1) page--; render(); });
  if (nextBtn) nextBtn.addEventListener('click', () => { if ((page * pageSize) < filtered.length) page++; render(); });

  if (applyFiltersBtn) applyFiltersBtn.addEventListener('click', applyFilters);
  if (clearFiltersBtn) clearFiltersBtn.addEventListener('click', () => {
    if (searchInput) searchInput.value='';
    if (categoryFilter) categoryFilter.value='';
    if (chapterFilter) chapterFilter.value='';
    filtered = csrs.slice(); page=1; render();
  });

  // CSV export (uses date)
  if (exportCsvBtn) {
    exportCsvBtn.addEventListener('click', () => {
      const list = filtered.length ? filtered : csrs;
      const rows = list.map(r => [r.title, r.category, r.description, r.chapter, r.amount, r.date]);
      const header = ['Title','Category','Description','Chapter','Amount','Date'];
      const csv = [header, ...rows].map(r => r.map(c => `"${String(c||'').replace(/"/g,'""')}"`).join(',')).join('\n');
      const blob = new Blob([csv], { type: 'text/csv' });
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a'); a.href = url; a.download = 'csrs.csv'; a.click(); URL.revokeObjectURL(url);
    });
  }

  // ---------------- Add modal behavior ----------------
  function openAddModal(opts = { focusFiles:false }) {
    if (!addCSRModal) return;
    addCSRModal.classList.remove('hidden');
    addCSRModal.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    // reset and focus
    if (addCSRForm) addCSRForm.reset();

    // scroll content to top and focus first input
    const scrollArea = addCSRModal.querySelector('.overflow-y-auto');
    if (scrollArea) {
      scrollArea.scrollTop = 0;
      const firstInput = scrollArea.querySelector('input, textarea, select, button');
      if (firstInput) firstInput.focus();
    }

    // optionally open file picker
    if (opts.focusFiles && csrFiles) {
      setTimeout(() => {
        try { csrFiles.click(); } catch(e){}
      }, 150);
    }
  }

  function closeAddModal() {
    if (!addCSRModal) return;
    addCSRModal.classList.add('hidden');
    addCSRModal.style.display = '';
    document.body.style.overflow = '';
    if (addCSRForm) addCSRForm.reset();
  }

  if (openAddCSR_main) openAddCSR_main.addEventListener('click', (e) => { e.preventDefault(); openAddModal({ focusFiles:false }); });
  if (closeAddX) closeAddX.addEventListener('click', closeAddModal);
  if (cancelAddCSR) cancelAddCSR.addEventListener('click', closeAddModal);
  if (addCSROverlay) addCSROverlay.addEventListener('click', (ev) => { if (ev.target === addCSROverlay) closeAddModal(); });

  // Add CSR form submit (demo: store in local array)
  if (addCSRForm) {
    addCSRForm.addEventListener('submit', (ev) => {
      ev.preventDefault();
      const title = (document.getElementById('csrTitle') && document.getElementById('csrTitle').value.trim()) || '';
      const category = (document.getElementById('csrCategory') && document.getElementById('csrCategory').value.trim()) || '';
      const amount = Number((document.getElementById('csrAmount') && document.getElementById('csrAmount').value) || 0);
      const chapter = (document.getElementById('csrChapter') && document.getElementById('csrChapter').value.trim()) || '';
      const desc = (document.getElementById('csrDesc') && document.getElementById('csrDesc').value.trim()) || '';
      const dateVal = (document.getElementById('csrDate') && document.getElementById('csrDate').value) || new Date().toISOString().slice(0,10);
      if (!title) { alert('Please provide a title'); return; }

      // process files: create object URLs for demo
      const files = Array.from((csrFiles && csrFiles.files) || []);
      const docs = files.map(f => {
        const url = URL.createObjectURL(f);
        return { name: f.name, size: formatFileSize(f.size), url };
      });

      const newObj = {
        id: Math.max(0, ...csrs.map(c=>c.id)) + 1,
        title, category, description: desc, amount, chapter, date: dateVal, documents: docs, created_at: new Date().toISOString().slice(0,10)
      };

      csrs.unshift(newObj);
      filtered = csrs.slice();
      page = 1;
      render();
      closeAddModal();
      alert('CSR created (demo). Replace with real upload endpoint in production.');
    });
  }

  function formatFileSize(bytes) {
    if (!bytes) return '';
    if (bytes < 1024) return bytes + ' B';
    if (bytes < 1024*1024) return Math.round(bytes/1024) + ' KB';
    return Math.round(bytes/(1024*1024)) + ' MB';
  }

  // ---------------- View modal (delegated) ----------------
  document.addEventListener('click', (ev) => {
    const btn = ev.target.closest && ev.target.closest('.viewBtn');
    if (!btn) return;
    const id = Number(btn.dataset.id);
    if (!id) return;
    const item = csrs.find(x => x.id === id);
    if (!item) return;

    if (!modalBody) return;
    modalBody.innerHTML = `
      <div class="space-y-3">
        <div><strong>Title:</strong> ${esc(item.title)}</div>
        <div><strong>Category:</strong> ${esc(item.category || '—')}</div>
        <div><strong>Date:</strong> ${formatDate(item.date)}</div>
        <div><strong>Amount:</strong> ${formatMoney(item.amount)}</div>
        <div><strong>Chapter:</strong> ${esc(item.chapter || '—')}</div>
        <div class="pt-2 text-gray-600">${esc(item.description || '')}</div>
      </div>
    `;

    if (modalDownloadAll) modalDownloadAll.innerHTML = '';
    if (item.documents && item.documents.length) {
      let docsHtml = '<hr class="my-4" /><div><strong>Documents</strong><div class="mt-2 space-y-2">';
      item.documents.forEach((d, idx) => {
        docsHtml += `<div class="flex items-center justify-between bg-gray-50 p-3 rounded">
                      <div>
                        <div class="font-medium text-sm">${esc(d.name)}</div>
                        <div class="text-xs text-gray-500">${esc(d.size||'')}</div>
                      </div>
                      <div><a class="text-sm text-blue-600" href="${esc(d.url)}" target="_blank" download>Download</a></div>
                    </div>`;
      });
      docsHtml += '</div></div>';
      modalBody.insertAdjacentHTML('beforeend', docsHtml);

      if (modalDownloadAll) {
        modalDownloadAll.innerHTML = `<button id="downloadAll" class="px-3 py-1 bg-red-600 text-white rounded text-sm">Download All</button>`;
        setTimeout(() => {
          const dl = document.getElementById('downloadAll');
          if (dl) {
            dl.addEventListener('click', () => {
              item.documents.forEach((d, i) => {
                setTimeout(() => {
                  const a = document.createElement('a');
                  a.href = d.url;
                  a.target = '_blank';
                  a.download = d.name || '';
                  document.body.appendChild(a);
                  a.click();
                  a.remove();
                }, i * 300);
              });
            });
          }
        }, 10);
      }
    }

    // open view modal
    if (viewModal) {
      viewModal.classList.remove('hidden');
      viewModal.style.display = 'flex';
      document.body.style.overflow = 'hidden';
    }
  });

  function closeViewModal(){
    if (!viewModal) return;
    viewModal.classList.add('hidden');
    viewModal.style.display = '';
    document.body.style.overflow = '';
    if (modalBody) modalBody.innerHTML = '';
    if (modalDownloadAll) modalDownloadAll.innerHTML = '';
  }
  if (closeViewX) closeViewX.addEventListener('click', closeViewModal);
  if (closeViewBtn) closeViewBtn.addEventListener('click', closeViewModal);
  if (viewOverlay) viewOverlay.addEventListener('click', (ev) => { if (ev.target === viewOverlay) closeViewModal(); });

  // ESC handling
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      if (viewModal && !viewModal.classList.contains('hidden')) closeViewModal();
      if (addCSRModal && !addCSRModal.classList.contains('hidden')) closeAddModal();
    }
  });

});
</script>


@include('components.script')