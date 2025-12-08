@extends('layouts.app')

@section('content')

    <!-- controls + table -->
    <section class="space-y-4">
      <!-- controls row -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="flex items-center gap-3">
          <!-- optional: place for future filters -->
        </div>

        <div class="flex items-center gap-2 w-full sm:w-auto">
          <input
            id="globalSearch"
            type="search"
            placeholder="Search title, member, event..."
            class="flex-1 sm:w-80 px-3 py-2 border rounded-md text-sm
                   focus:outline-none focus:ring-2 focus:ring-red-500/60 focus:border-red-500"
          />
          <button
            id="searchBtn"
            type="button"
            class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md text-sm"
          >
            Search
          </button>
        </div>
      </div>

      <!-- table card (unchanged) -->
      <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <!-- desktop header -->
        <div class="hidden md:grid grid-cols-12 gap-4 px-4 py-3 text-xs font-medium text-gray-500 border-b bg-gray-50">
          <div class="col-span-1">#</div>
          <div class="col-span-3">Title</div>
          <div class="col-span-3">Awarded To</div>
          <div class="col-span-2">Date</div>
          <div class="col-span-2">Status</div>
          <div class="col-span-1 text-right">View</div>
        </div>

        <div id="rowsContainer" class="divide-y divide-gray-100"></div>

        <!-- pagination (unchanged) -->
        <div class="px-4 py-3 border-t bg-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-sm">
          <div class="text-gray-600">
            Showing
            <span id="showCount">0</span>–<span id="showEnd">0</span>
            of <span id="totalCount">0</span>
            <span class="mx-2 text-gray-400">•</span>
            Page <span id="currentPage">1</span>
          </div>

          <div class="flex items-center gap-2">
            <button id="firstPage" type="button" class="px-3 py-1 bg-white border rounded-md text-sm disabled:opacity-40 disabled:cursor-not-allowed hover:bg-gray-50">First</button>
            <button id="prevPage"  type="button" class="px-3 py-1 bg-white border rounded-md text-sm disabled:opacity-40 disabled:cursor-not-allowed hover:bg-gray-50">Prev</button>
            <button id="nextPage"  type="button" class="px-3 py-1 bg-white border rounded-md text-sm disabled:opacity-40 disabled:cursor-not-allowed hover:bg-gray-50">Next</button>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
<!-- VIEW MODAL: add this once in your page -->
<div id="viewModal" class="fixed inset-0 z-50 hidden items-center justify-center">
  <div id="viewOverlay" class="absolute inset-0 bg-black/40"></div>

  <div class="relative max-w-2xl w-full mx-4">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
      <div class="flex items-center justify-between px-6 py-4 border-b">
        <h3 class="text-lg font-semibold">Award Details</h3>
        <button id="viewModalCloseX" class="text-gray-500 hover:text-gray-700">✕</button>
      </div>

      <div id="viewModalContent" class="p-6 text-sm">
        <!-- populated by JS -->
      </div>

      <div class="p-4 border-t flex justify-end">
        <button id="viewModalCloseBtn" class="px-4 py-2 bg-red-500 text-white rounded-md">Close</button>
      </div>
    </div>
  </div>
</div>

    </main>
  </div>
<script>
document.addEventListener('DOMContentLoaded', () => {
  /* ---------- sample data ---------- (keep your awards array / replace with real data) */
  const awards = [
    { id: 1, member_id: 301, member_name: 'Priya Singh', title: 'Best Mentor', category: 'Leadership', description: 'Outstanding mentoring to new entrepreneurs', award_event: 'Annual Gala', award_date: '2025-03-10', status: 'active', admin_notes: 'Well deserved.' },
    { id: 2, member_id: 205, member_name: 'Aditi Verma', title: 'Design Excellence', category: 'Innovation', description: 'Outstanding contribution to branding.', award_event: 'Design Summit', award_date: '2025-02-15', status: 'active', admin_notes: '' },
    { id: 3, member_id: 112, member_name: 'Rahul Mehta', title: 'Community Champion', category: 'Contribution', description: 'For community upliftment activities', award_event: 'Chapter Meet', award_date: '2024-12-01', status: 'archived', admin_notes: 'Archived after 1 year.' }
  ];

  /* ---------- helpers ---------- */
  const esc = s => s == null ? '' : String(s).replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;');
  const formatDate = d => {
    if (!d) return '—';
    if (typeof d === 'string' && /^\d{4}-\d{2}-\d{2}$/.test(d)) return d;
    const dt = new Date(d);
    if (Number.isNaN(dt.getTime())) return '—';
    return dt.toLocaleDateString(undefined, { year:'numeric', month:'short', day:'numeric' });
  };

  /* ---------- ensure needed modal exists (create if missing) ---------- */
  let viewModal = document.getElementById('viewModal');
  let viewOverlay = document.getElementById('viewOverlay');
  let viewModalContent = document.getElementById('viewModalContent');
  let viewModalCloseX = document.getElementById('viewModalCloseX');
  let viewModalCloseBtn = document.getElementById('viewModalCloseBtn');

  if (!viewModal) {
    // create minimal modal structure and append to body
    const modalHtml = `
      <div id="viewModal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <div id="viewOverlay" class="absolute inset-0 bg-black/40"></div>
        <div class="relative max-w-2xl w-full mx-4">
          <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b">
              <h3 class="text-lg font-semibold">Details</h3>
              <button id="viewModalCloseX" class="text-gray-500 hover:text-gray-700">✕</button>
            </div>
            <div id="viewModalContent" class="p-6 text-sm"></div>
            <div class="p-4 border-t flex justify-end">
              <button id="viewModalCloseBtn" class="px-4 py-2 bg-red-500 text-white rounded-md">Close</button>
            </div>
          </div>
        </div>
      </div>
    `;
    const wrapper = document.createElement('div');
    wrapper.innerHTML = modalHtml;
    document.body.appendChild(wrapper.firstElementChild);

    // re-query
    viewModal = document.getElementById('viewModal');
    viewOverlay = document.getElementById('viewOverlay');
    viewModalContent = document.getElementById('viewModalContent');
    viewModalCloseX = document.getElementById('viewModalCloseX');
    viewModalCloseBtn = document.getElementById('viewModalCloseBtn');
  }

  /* ---------- safe open/close helpers ---------- */
  function openViewModal() {
    if (!viewModal) return;
    viewModal.classList.remove('hidden');
    viewModal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
  }
  function closeViewModal() {
    if (!viewModal) return;
    viewModal.classList.add('hidden');
    viewModal.style.display = 'none';
    document.body.style.overflow = '';
  }

  if (viewOverlay) viewOverlay.addEventListener('click', (e) => { if (e.target === viewOverlay) closeViewModal(); });
  if (viewModalCloseX) viewModalCloseX.addEventListener('click', closeViewModal);
  if (viewModalCloseBtn) viewModalCloseBtn.addEventListener('click', closeViewModal);
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeViewModal(); });

  /* ---------- delegated click for view buttons ----------
     - uses data-id attribute to find item
     - tolerant to missing DOM pieces
  */
  document.addEventListener('click', (ev) => {
    // find closest element with class viewBtn (works for buttons and links)
    const btn = ev.target && ev.target.closest ? ev.target.closest('.viewBtn') : null;
    if (!btn) return;

    // stop if button is disabled
    if (btn.disabled) return;

    // read id (support data-id and data-award-id)
    const rawId = btn.getAttribute('data-id') || btn.getAttribute('data-award-id') || btn.dataset.id;
    if (!rawId) return;

    const id = Number(rawId);
    if (Number.isNaN(id)) return;

    // find item in awards list
    const item = awards.find(a => Number(a.id) === id);
    if (!item) {
      console.warn('Award not found for id', id);
      return;
    }

    // build modal HTML (escaped)
    if (!viewModalContent) {
      console.warn('viewModalContent not found');
      return;
    }

    viewModalContent.innerHTML = `
      <div class="space-y-4">
        <h2 class="text-xl font-semibold">${esc(item.title)}</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
          <div><strong>Awarded To</strong><div class="mt-0.5">${esc(item.member_name || ('Member #' + item.member_id))}<div class="text-xs text-gray-500">ID: ${esc(item.member_id)}</div></div></div>
          <div><strong>Category</strong><div class="mt-0.5">${esc(item.category || '—')}</div></div>
          <div><strong>Event</strong><div class="mt-0.5">${esc(item.award_event || '—')}</div></div>
          <div><strong>Date</strong><div class="mt-0.5">${formatDate(item.award_date)}</div></div>
          <div class="sm:col-span-2"><strong>Description</strong><div class="mt-1 text-gray-700">${esc(item.description || '—')}</div></div>
          <div class="sm:col-span-2"><strong>Admin notes</strong><div class="mt-1 text-gray-700">${esc(item.admin_notes || '—')}</div></div>
        </div>
      </div>
    `;

    // show modal
    openViewModal();
  });

  /* ---------- NOTE ----------
     If your view buttons still do not open the modal:
     1) Inspect one of the view buttons in browser devtools and verify it has class "viewBtn" and a data-id attribute.
        e.g. <button class="viewBtn" data-id="1">View</button>
     2) Make sure the script runs after the table rows are rendered (script placed at end of <body> or after rows output).
     3) If you build rows dynamically later, delegated handler will still catch clicks — no rebind needed.
  */

  /* ---------- optional: initial rendering if you render rows here ----------
     (If your page already renders rows via other code, skip this block)
     Example renderer (uncomment to use):
  */
  /*
  (function renderSampleRows(){
    const rowsContainer = document.getElementById('rowsContainer');
    if (!rowsContainer) return;
    rowsContainer.innerHTML = '';
    awards.forEach((a, i) => {
      const html = buildDesktopRow(a, i+1) + buildMobileCard(a, i+1); // if you have these functions in scope
      rowsContainer.insertAdjacentHTML('beforeend', html);
    });
  })();
  */
});
</script>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // sample data (replace with server data)
      const awards = [
        {
          id: 1,
          member_id: 301,
          member_name: 'Priya Singh',
          title: 'Best Mentor',
          category: 'Leadership',
          description: 'Outstanding mentoring to new entrepreneurs',
          award_event: 'Annual Gala',
          award_date: '2025-03-10',
          status: 'active',
          admin_notes: 'Well deserved.'
        },
        {
          id: 2,
          member_id: 205,
          member_name: 'Aditi Verma',
          title: 'Design Excellence',
          category: 'Innovation',
          description: 'Outstanding contribution to branding.',
          award_event: 'Design Summit',
          award_date: '2025-02-15',
          status: 'active',
          admin_notes: ''
        },
        {
          id: 3,
          member_id: 112,
          member_name: 'Rahul Mehta',
          title: 'Community Champion',
          category: 'Contribution',
          description: 'For community upliftment activities',
          award_event: 'Chapter Meet',
          award_date: '2024-12-01',
          status: 'archived',
          admin_notes: 'Archived after 1 year.'
        }
      ];

      // state
      let filtered = [...awards];
      let page = 1;
      const pageSize = 6;

      // dom refs
      const rowsContainer = document.getElementById('rowsContainer');
      const showCount = document.getElementById('showCount');
      const showEnd = document.getElementById('showEnd');
      const totalCountEl = document.getElementById('totalCount');
      const currentPageEl = document.getElementById('currentPage');
      const prevBtn = document.getElementById('prevPage');
      const nextBtn = document.getElementById('nextPage');
      const firstBtn = document.getElementById('firstPage');

      const globalSearch = document.getElementById('globalSearch');
      const searchBtn = document.getElementById('searchBtn');
      const exportCsvBtn = document.getElementById('exportCsvBtn');

      const viewModal = document.getElementById('viewModal');
      const viewOverlay = document.getElementById('viewOverlay');
      const viewModalCloseX = document.getElementById('viewModalCloseX');
      const viewModalCloseBtn = document.getElementById('viewModalCloseBtn');
      const viewModalContent = document.getElementById('viewModalContent');

      // mobile sidebar
      const mobileOpenBtn = document.getElementById('mobileOpenBtn');
      const mobileCloseBtn = document.getElementById('mobileCloseBtn');
      const mobileSidebar = document.getElementById('mobileSidebar');
      const mobilePanel = document.getElementById('mobilePanel');
      const mobileOverlay = document.getElementById('mobileOverlay');

      // helpers
      const esc = s =>
        s == null
          ? ''
          : String(s)
              .replaceAll('&', '&amp;')
              .replaceAll('<', '&lt;')
              .replaceAll('>', '&gt;');

      // robust date formatting without timezone shift
      const formatDate = d => {
        if (!d) return '—';
        if (typeof d === 'string' && /^\d{4}-\d{2}-\d{2}$/.test(d)) {
          // already in YYYY-MM-DD format
          return d;
        }
        const date = new Date(d);
        if (Number.isNaN(date.getTime())) return '—';
        return date.toLocaleDateString(undefined, {
          year: 'numeric',
          month: 'short',
          day: 'numeric'
        });
      };

      function buildDesktopRow(a, idx) {
        return `
          <div class="hidden md:grid grid-cols-12 gap-4 px-4 py-4 items-center text-sm">
            <div class="col-span-1 text-gray-600">${idx}</div>
            <div class="col-span-3 font-medium">
              ${esc(a.title)}
              <div class="text-xs text-gray-400 mt-1">${esc(a.category || '')}</div>
            </div>
            <div class="col-span-3">
              <div class="font-medium">
                ${esc(a.member_name || ('Member #' + a.member_id))}
              </div>
              <div class="text-xs text-gray-500">ID: ${esc(a.member_id)}</div>
            </div>
            <div class="col-span-2 text-gray-600">${formatDate(a.award_date)}</div>
            <div class="col-span-2">
              <span class="${
                a.status === 'active'
                  ? 'inline-block px-2 py-1 rounded-full bg-green-50 text-green-700 text-xs'
                  : 'inline-block px-2 py-1 rounded-full bg-gray-100 text-gray-700 text-xs'
              }">
                ${esc(a.status)}
              </span>
            </div>
            <div class="col-span-1 text-right">
              <button
                type="button"
                class="viewBtn text-blue-600 hover:text-blue-700 text-sm font-medium"
                data-id="${a.id}"
              >
                View
              </button>
            </div>
          </div>
        `;
      }

      function buildMobileCard(a, idx) {
        return `
          <div class="md:hidden px-4 py-4 bg-white">
            <div class="flex items-start justify-between gap-3">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-md bg-slate-100 flex items-center justify-center text-slate-600 text-sm font-semibold">
                  ${esc((a.member_name || 'M').charAt(0))}
                </div>
                <div>
                  <div class="font-medium text-sm">${esc(a.title)}</div>
                  <div class="text-xs text-gray-400 mt-1">
                    ${esc(a.category || '')}${a.award_event ? ' • ' + esc(a.award_event) : ''}
                  </div>
                  <div class="text-xs text-gray-500 mt-1">
                    Awarded to:
                    ${esc(a.member_name || ('Member #' + a.member_id))}
                    (ID: ${esc(a.member_id)})
                  </div>
                  <div class="text-xs text-gray-500 mt-1">
                    Date: ${formatDate(a.award_date)}
                  </div>
                  <div class="text-xs mt-1">
                    <span class="${
                      a.status === 'active'
                        ? 'inline-block px-2 py-0.5 rounded-full bg-green-50 text-green-700'
                        : 'inline-block px-2 py-0.5 rounded-full bg-gray-100 text-gray-700'
                    }">
                      ${esc(a.status)}
                    </span>
                  </div>
                </div>
              </div>

              <div class="flex items-start gap-2">
                <button
                  type="button"
                  class="viewBtn text-blue-600 hover:text-blue-700 text-sm font-medium"
                  data-id="${a.id}"
                >
                  View
                </button>
              </div>
            </div>
          </div>
        `;
      }

      // render
      function render() {
        rowsContainer.innerHTML = '';
        const start = (page - 1) * pageSize;
        const end = start + pageSize;
        const list = filtered.slice(start, end);

        if (!list.length) {
          rowsContainer.innerHTML = '<div class="p-6 text-center text-gray-500 text-sm">No awards available.</div>';
        } else {
          list.forEach((a, i) => {
            rowsContainer.insertAdjacentHTML('beforeend', buildDesktopRow(a, start + i + 1));
            rowsContainer.insertAdjacentHTML('beforeend', buildMobileCard(a, start + i + 1));
          });
        }

        showCount.textContent = list.length ? start + 1 : 0;
        showEnd.textContent = Math.min(end, filtered.length);
        totalCountEl.textContent = filtered.length;
        currentPageEl.textContent = page;

        const atFirstPage = page <= 1;
        const atLastPage = end >= filtered.length;

        prevBtn.disabled = atFirstPage;
        firstBtn.disabled = atFirstPage;
        nextBtn.disabled = atLastPage;
      }

      // initial
      filtered = [...awards];
      render();

      // search
      function doSearch() {
        const q = (globalSearch.value || '').toLowerCase().trim();
        filtered = awards.filter(a => {
          const hay = `${a.title} ${a.member_name} ${a.member_id} ${a.category} ${a.award_event} ${a.description}`.toLowerCase();
          return !q || hay.includes(q);
        });
        page = 1;
        render();
      }

      searchBtn.addEventListener('click', doSearch);
      globalSearch.addEventListener('keydown', e => {
        if (e.key === 'Enter') doSearch();
      });

      // pagination
      firstBtn.addEventListener('click', () => {
        page = 1;
        render();
      });

      prevBtn.addEventListener('click', () => {
        if (page > 1) {
          page--;
          render();
        }
      });

      nextBtn.addEventListener('click', () => {
        if (page * pageSize < filtered.length) {
          page++;
          render();
        }
      });

      // export csv
      exportCsvBtn.addEventListener('click', () => {
        const rows = filtered.map(r => [
          r.title,
          r.member_name || 'Member #' + r.member_id,
          r.member_id,
          r.category,
          formatDate(r.award_date),
          r.status,
          r.award_event,
          r.description || ''
        ]);
        const header = ['Title', 'Member', 'Member ID', 'Category', 'Date', 'Status', 'Event', 'Description'];
        const csv = [header, ...rows]
          .map(r => r.map(c => `"${String(c || '').replace(/"/g, '""')}"`).join(','))
          .join('\n');
        const blob = new Blob([csv], { type: 'text/csv' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'awards.csv';
        a.click();
        URL.revokeObjectURL(url);
      });

      // delegated view modal (safe, defensive)
document.addEventListener('click', (ev) => {
  const btn = ev.target.closest && ev.target.closest('.viewBtn');
  if (!btn) return;

  // find the item by id
  const id = Number(btn.dataset.id);
  const item = awards.find(x => x.id === id);
  if (!item) return;

  // ensure modal DOM exists
  if (!viewModal || !viewModalContent) {
    console.warn('Modal elements missing: viewModal or viewModalContent not found');
    return;
  }

  // populate content
  viewModalContent.innerHTML = `
    <div class="space-y-4">
      <h2 class="text-xl font-semibold">${esc(item.title)}</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
        <div>
          <strong class="block text-gray-700">Awarded To:</strong>
          <div class="mt-0.5">
            ${esc(item.member_name || ('Member #' + item.member_id))}
            <span class="text-xs text-gray-500">(${esc(item.member_id)})</span>
          </div>
        </div>
        <div>
          <strong class="block text-gray-700">Category:</strong>
          <div class="mt-0.5">${esc(item.category || '—')}</div>
        </div>
        <div>
          <strong class="block text-gray-700">Event:</strong>
          <div class="mt-0.5">${esc(item.award_event || '—')}</div>
        </div>
        <div>
          <strong class="block text-gray-700">Date:</strong>
          <div class="mt-0.5">${formatDate(item.award_date)}</div>
        </div>
        <div class="sm:col-span-2">
          <strong class="block text-gray-700">Description:</strong>
          <div class="mt-1 text-gray-700">${esc(item.description || '—')}</div>
        </div>
        <div class="sm:col-span-2">
          <strong class="block text-gray-700">Admin notes:</strong>
          <div class="mt-1 text-gray-700">${esc(item.admin_notes || '—')}</div>
        </div>
      </div>
    </div>
  `;

  // open modal (only if element exists)
  viewModal.classList.remove('hidden');
  viewModal.classList.add('modal-open');
  document.body.style.overflow = 'hidden';
});

// close modal helper (defensive)
function closeViewModal() {
  if (!viewModal) return;
  viewModal.classList.add('hidden');
  viewModal.classList.remove('modal-open');
  document.body.style.overflow = '';
}

// only attach listeners when elements exist
if (viewOverlay) viewOverlay.addEventListener('click', closeViewModal);
if (viewModalCloseX) viewModalCloseX.addEventListener('click', closeViewModal);
if (viewModalCloseBtn) viewModalCloseBtn.addEventListener('click', closeViewModal);

// close on Esc (defensive)
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') closeViewModal();
});


      // mobile sidebar
      if (mobileOpenBtn) {
        mobileOpenBtn.addEventListener('click', () => {
          mobileSidebar.classList.remove('hidden');
          // allow DOM to paint before animating
          setTimeout(() => mobilePanel.classList.add('translate-x-0'), 10);
          document.documentElement.style.overflow = 'hidden';
        });
      }

      if (mobileCloseBtn) {
        mobileCloseBtn.addEventListener('click', () => {
          mobilePanel.classList.remove('translate-x-0');
          document.documentElement.style.overflow = '';
          setTimeout(() => mobileSidebar.classList.add('hidden'), 220);
        });
      }

      if (mobileOverlay) {
        mobileOverlay.addEventListener('click', () => {
          mobilePanel.classList.remove('translate-x-0');
          document.documentElement.style.overflow = '';
          setTimeout(() => mobileSidebar.classList.add('hidden'), 220);
        });
      }

      // feather icons
      if (typeof feather !== 'undefined') feather.replace();
    });
  </script>
@endsection