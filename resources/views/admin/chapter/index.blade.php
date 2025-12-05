@include('components.adminheader')
 <script src="https://unpkg.com/feather-icons"></script>

  <style>
    body { font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; }
    .chapter-card { position: relative; overflow: visible; }
    .chapter-card::after { content:""; position:absolute; inset:0; z-index:-1; border-radius:1rem; background: linear-gradient(180deg, rgba(229,57,53,0.02), rgba(229,57,53,0)); opacity:0; transition:opacity .25s; }
    .chapter-card:hover::after { opacity:1; }
    .badge-active { background: linear-gradient(90deg, #ecfdf5, #bbf7d0); color:#065f46; }
    .badge-inactive { background:#f3f4f6; color:#6b7280; }
    .card-accent { position:absolute; left:1rem; right:1rem; top:-6px; height:6px; border-radius:8px; background:linear-gradient(90deg,#f97316,#ef4444); opacity:0.12; }
    .fade-in { animation: fadeIn .18s ease both; } @keyframes fadeIn { from {opacity:0; transform: translateY(6px)} to {opacity:1; transform:none} }
    #toast > div { margin-top: 6px; }
  </style>
   <div class="max-w-7xl mx-auto p-6">
        <div class="flex items-center justify-between mb-6">
          <div>
            <h2 class="text-2xl font-semibold text-gray-800">Manage Chapters</h2>
            <p class="text-gray-600 mt-1">Create chapters and assign members. Data stored locally in your browser.</p>
          </div>

          <div class="flex items-center gap-3">
            <input id="chapterSearch" type="search" placeholder="Search chapters..." class="px-3 py-2 border rounded-md w-64" />
            <button id="openCreateChapter" class="px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg flex items-center gap-2">
              <i data-feather="plus-circle" class="w-4 h-4"></i> Create Chapter
            </button>
          </div>
        </div>

        <div id="chaptersGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"></div>
        <div class="mt-6 text-sm text-gray-600" id="chaptersCount"></div>
      </div>
    </main>
  </div>

  <!-- Create / Edit Chapter Modal -->
  <div id="chapterModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/40"></div>
    <div class="relative z-10 bg-white rounded-2xl max-w-2xl w-full p-6 shadow-xl">
      <div class="flex items-center justify-between mb-4">
        <h3 id="chapterModalTitle" class="text-lg font-semibold text-gray-800">Create Chapter</h3>
        <button id="closeChapterModal" class="text-gray-400 hover:text-gray-600">✕</button>
      </div>

      <form id="chapterForm" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <input type="hidden" id="chapterEditingId">

        <div>
          <label class="block text-sm text-gray-700">Name</label>
          <input id="chapterName" class="mt-1 w-full border rounded px-3 py-2" required>

          <label class="block text-sm text-gray-700 mt-3">Slug</label>
          <input id="chapterSlug" class="mt-1 w-full border rounded px-3 py-2">

          <label class="block text-sm text-gray-700 mt-3">Order No</label>
          <input id="chapterOrder" type="number" min="1" value="1" class="mt-1 w-full border rounded px-3 py-2">
        </div>

        <div>
          <label class="block text-sm text-gray-700">City</label>
          <input id="chapterCity" class="mt-1 w-full border rounded px-3 py-2">

          <label class="block text-sm text-gray-700 mt-3">Pincode</label>
          <input id="chapterPincode" class="mt-1 w-full border rounded px-3 py-2">

          <label class="block text-sm text-gray-700 mt-3">Active</label>
          <div class="mt-1">
            <label class="inline-flex items-center gap-2">
              <input id="chapterActive" type="checkbox" class="h-4 w-4" checked>
              <span class="text-sm text-gray-700">Is Active</span>
            </label>
          </div>
        </div>

        <div class="md:col-span-2">
          <label class="block text-sm text-gray-700">Description</label>
          <textarea id="chapterDesc" rows="3" class="mt-1 w-full border rounded px-3 py-2"></textarea>

          <div class="mt-4 flex items-center justify-end gap-3">
            <button type="button" id="cancelChapter" class="px-4 py-2 rounded bg-gray-100">Cancel</button>
            <button type="submit" id="saveChapter" class="px-4 py-2 rounded bg-gradient-to-r from-red-500 to-red-600 text-white">Save Chapter</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Assign Members Modal (clean - no create section) -->
  <div id="assignModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/40"></div>
    <div class="relative z-10 bg-white rounded-2xl max-w-xl w-full p-6 shadow-xl">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">
          Assign Members to <span id="assignModalChapterName" class="font-semibold"></span>
        </h3>
        <button id="closeAssignModal" class="text-gray-400 hover:text-gray-600">✕</button>
      </div>

      <!-- Search -->
      <div class="mb-3">
        <input id="assignMemberSearch" type="search"
               class="w-full border rounded px-3 py-2"
               placeholder="Search members..." />
      </div>

      <!-- Member list -->
      <div id="assignMembersList"
           class="max-h-72 overflow-y-auto border rounded p-2 space-y-2 bg-gray-50">
      </div>

      <!-- Footer buttons -->
      <div class="mt-4 flex items-center justify-end gap-3">
        <button id="cancelAssign" class="px-4 py-2 rounded bg-gray-100">Cancel</button>
        <button id="confirmAssign"
                class="px-4 py-2 rounded bg-gradient-to-r from-red-500 to-red-600 text-white">
          Save Assigned Members
        </button>
      </div>
    </div>
  </div>

  <!-- View / Edit Members Modal -->
  <div id="viewMembersModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/40"></div>
    <div class="relative z-10 bg-white rounded-2xl max-w-2xl w-full p-6 shadow-xl">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Members in <span id="viewModalChapterName" class="font-semibold"></span></h3>
        <button id="closeViewMembers" class="text-gray-400 hover:text-gray-600">✕</button>
      </div>

      <div id="chapterMembersContainer" class="max-h-72 overflow-y-auto border rounded p-2 space-y-2"></div>

      <div class="mt-4 flex items-center justify-end gap-3">
        <button id="closeViewMembers2" class="px-4 py-2 rounded bg-gray-100">Close</button>
      </div>
    </div>
  </div>

  <!-- Toast container -->
  <div id="toast" class="fixed right-6 bottom-6 z-50"></div>

  <!-- Script -->
  <script>
  (function(){
    // persistence key
    const STORAGE_KEY = 'tmn_chapters_v2';

    // sample seed data
    let chapters = [
      { id: 1, name: 'Delhi Chapter', slug:'delhi-chapter', description:'Delhi events & networking', city:'Delhi', pincode:'110001', is_active:true, order_no:1, members:[101,102] },
      { id: 2, name: 'Mumbai Chapter', slug:'mumbai-chapter', description:'Mumbai networking', city:'Mumbai', pincode:'400001', is_active:true, order_no:2, members:[] },
    ];

    let allMembers = [
      { id: 101, name:'Ramesh Kumar', email:'ramesh@example.com', phone:'+91 9876543210' },
      { id: 102, name:'Priya Sharma', email:'priya@example.com', phone:'+91 9123456780' },
      { id: 103, name:'Amit Singh', email:'amit@example.com', phone:'' },
    ];

    function saveStorage(){ try { localStorage.setItem(STORAGE_KEY, JSON.stringify({ chapters, members: allMembers })); } catch(e){ console.warn(e); } }
    function loadStorage(){
      try {
        const raw = localStorage.getItem(STORAGE_KEY);
        if (!raw) { saveStorage(); return; }
        const parsed = JSON.parse(raw);
        if (Array.isArray(parsed.chapters)) chapters = parsed.chapters;
        if (Array.isArray(parsed.members)) allMembers = parsed.members;
      } catch(e){ console.warn(e); }
    }
    loadStorage();

    // helpers
    const uid = () => Date.now() + Math.floor(Math.random()*999);
    const escapeHtml = s => String(s||'').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
    function showToast(msg, type='success'){
      const el = document.createElement('div');
      el.className = 'px-4 py-2 rounded shadow text-white ' + (type==='success' ? 'bg-green-600' : 'bg-gray-800');
      el.textContent = msg;
      document.getElementById('toast').appendChild(el);
      setTimeout(()=> el.remove(), 2400);
    }

    // DOM refs
    const grid = document.getElementById('chaptersGrid');
    const countEl = document.getElementById('chaptersCount');
    const searchInput = document.getElementById('chapterSearch');

    const chapterModal = document.getElementById('chapterModal');
    const chapterForm = document.getElementById('chapterForm');
    const chapterEditingId = document.getElementById('chapterEditingId');
    const fields = {
      name: document.getElementById('chapterName'),
      slug: document.getElementById('chapterSlug'),
      city: document.getElementById('chapterCity'),
      pincode: document.getElementById('chapterPincode'),
      desc: document.getElementById('chapterDesc'),
      active: document.getElementById('chapterActive'),
      order: document.getElementById('chapterOrder')
    };

    const assignModal = document.getElementById('assignModal');
    const assignMembersList = document.getElementById('assignMembersList');
    const assignMemberSearch = document.getElementById('assignMemberSearch');
    const assignModalChapterName = document.getElementById('assignModalChapterName');

    const viewMembersModal = document.getElementById('viewMembersModal');
    const chapterMembersContainer = document.getElementById('chapterMembersContainer');
    const viewModalChapterName = document.getElementById('viewModalChapterName');

    /* Render */
    function renderChapters(list){
      grid.innerHTML = '';
      list.forEach(ch => grid.appendChild(createChapterCard(ch)));
      countEl.textContent = `Showing ${list.length} chapter(s)`;
      feather.replace();
      updateMemberCountBadges();
      saveStorage();
    }

    function createChapterCard(ch){
      const card = document.createElement('article');
      card.className = 'chapter-card bg-white rounded-2xl p-6 shadow-sm transform transition-all duration-300 hover:shadow-lg hover:-translate-y-1 fade-in';
      card.setAttribute('data-id', ch.id);

      const memberCount = (ch.members || []).length;

      card.innerHTML = `
        <div class="card-accent"></div>
        <div class="flex items-start justify-between gap-4">
          <div>
            <h3 class="chapter-name text-2xl font-semibold text-gray-900">${escapeHtml(ch.name)}</h3>
            <p class="text-sm text-gray-500 mt-1">${escapeHtml(ch.city||'')}</p>
            <div class="mt-2 text-xs text-gray-500">${escapeHtml(ch.description || '')}</div>
          </div>
          <div class="text-right">
            <div class="${ch.is_active ? 'badge-active' : 'badge-inactive'} inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium">
              ${ch.is_active ? '<svg class="w-3 h-3" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="4" cy="4" r="3" fill="#16A34A"/></svg> Active' : 'Inactive'}
            </div>
            <div class="text-xs text-gray-400 mt-2">Order: <span class="chapter-order font-medium">${escapeHtml(ch.order_no)}</span></div>
            <div class="text-xs text-gray-500 mt-2 member-count-pill">${memberCount ? memberCount + ' member' + (memberCount>1?'s':'') : 'No members'}</div>
          </div>
        </div>

        <div class="mt-6 flex items-center justify-between">
          <div class="flex items-center gap-2">
            <button class="btn-view inline-flex items-center gap-2 px-3 py-2 bg-white border border-gray-100 rounded-lg hover:bg-red-50 transition" title="View members">
              <i data-feather="eye" class="w-4 h-4 text-gray-600"></i>
            </button>

            <button class="btn-edit inline-flex items-center gap-2 px-3 py-2 bg-white border border-gray-100 rounded-lg hover:bg-red-50 transition" title="Edit">
              <i data-feather="edit-2" class="w-4 h-4 text-gray-600"></i>
            </button>

            <button class="btn-assign inline-flex items-center gap-2 px-3 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg shadow-sm hover:shadow-md transition" title="Assign members">
              <i data-feather="user-plus" class="w-4 h-4"></i> Assign
            </button>
          </div>

          <div class="flex items-center gap-2">
            <button class="btn-toggle inline-flex items-center justify-center w-9 h-9 bg-white border rounded text-sm" title="Toggle active">
              <i data-feather="${ch.is_active ? 'toggle-right' : 'toggle-left'}" class="w-5"></i>
            </button>

            <button class="btn-delete text-red-600 px-3 py-2 rounded-lg hover:bg-red-50 transition flex items-center gap-2" title="Delete">
              <i data-feather="trash-2" class="w-4 h-4"></i> Delete
            </button>
          </div>
        </div>
      `;

      // Bind actions
      card.querySelector('.btn-edit').addEventListener('click', () => openEditChapter(ch.id));
      card.querySelector('.btn-delete').addEventListener('click', () => {
        if (!confirm('Delete chapter?')) return;
        chapters = chapters.filter(x => x.id !== ch.id);
        renderChaptersFiltered();
        showToast('Chapter deleted');
      });
      card.querySelector('.btn-toggle').addEventListener('click', () => {
        ch.is_active = !ch.is_active;
        renderChaptersFiltered();
        showToast(ch.is_active ? 'Chapter activated' : 'Chapter deactivated');
      });
      card.querySelector('.btn-assign').addEventListener('click', () => openAssignModal(ch.id));
      card.querySelector('.btn-view').addEventListener('click', () => openViewMembers(ch.id));

      return card;
    }

    function updateMemberCountBadges(){
      document.querySelectorAll('.chapter-card').forEach(card => {
        const id = Number(card.getAttribute('data-id'));
        const ch = chapters.find(c => c.id === id);
        if (!ch) return;
        const pill = card.querySelector('.member-count-pill');
        const count = (ch.members||[]).length;
        if (pill) pill.textContent = count ? `${count} member${count>1?'s':''}` : 'No members';
      });
    }

    /* Search & render wrapper */
    function renderChaptersFiltered(){
      const q = searchInput.value.trim().toLowerCase();
      const filtered = chapters.filter(c => !q || c.name.toLowerCase().includes(q) || (c.city||'').toLowerCase().includes(q) || (c.slug||'').toLowerCase().includes(q));
      renderChapters(filtered);
    }

    /* Chapter modal (create/edit) */
    document.getElementById('openCreateChapter').addEventListener('click', openCreateChapter);

    function openCreateChapter(){
      chapterEditingId.value = '';
      chapterForm.reset();
      fields.active.checked = true;
      document.getElementById('chapterModalTitle').textContent = 'Create Chapter';
      chapterModal.classList.remove('hidden'); chapterModal.classList.add('flex');
    }

    function openEditChapter(id){
      const ch = chapters.find(c=>c.id===id); if(!ch) return;
      chapterEditingId.value = ch.id;
      fields.name.value = ch.name || '';
      fields.slug.value = ch.slug || '';
      fields.city.value = ch.city || '';
      fields.pincode.value = ch.pincode || '';
      fields.desc.value = ch.description || '';
      fields.active.checked = !!ch.is_active;
      fields.order.value = ch.order_no || 1;
      document.getElementById('chapterModalTitle').textContent = 'Edit Chapter';
      chapterModal.classList.remove('hidden'); chapterModal.classList.add('flex');
    }

    document.getElementById('closeChapterModal').addEventListener('click', () => { chapterModal.classList.add('hidden'); chapterModal.classList.remove('flex'); });
    document.getElementById('cancelChapter').addEventListener('click', () => { chapterModal.classList.add('hidden'); chapterModal.classList.remove('flex'); });

    chapterForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const id = chapterEditingId.value ? Number(chapterEditingId.value) : null;
      const payload = {
        id: id || uid(),
        name: fields.name.value.trim(),
        slug: fields.slug.value.trim() || fields.name.value.trim().toLowerCase().replace(/\s+/g,'-'),
        city: fields.city.value.trim(),
        pincode: fields.pincode.value.trim(),
        description: fields.desc.value.trim(),
        is_active: !!fields.active.checked,
        order_no: Number(fields.order.value) || 1,
        members: id ? (chapters.find(c=>c.id===id).members || []) : []
      };
      if (!payload.name) return alert('Name is required');
      if (id) {
        chapters = chapters.map(c => c.id === id ? Object.assign({}, c, payload) : c);
        showToast('Chapter updated');
      } else {
        chapters.unshift(payload);
        showToast('Chapter created');
      }
      chapterModal.classList.add('hidden'); chapterModal.classList.remove('flex');
      renderChaptersFiltered();
    });

    /* Assign members modal (clean) */
    let currentAssignChapterId = null;

    function openAssignModal(chapterId){
      currentAssignChapterId = chapterId;
      const ch = chapters.find(c => c.id === chapterId);
      assignModalChapterName.textContent = ch ? ch.name : "";
      renderAssignList(allMembers, ch?.members || []);
      assignMemberSearch.value = '';
      assignModal.classList.remove('hidden'); assignModal.classList.add('flex');
    }

    function closeAssignModal(){
      assignModal.classList.add('hidden'); assignModal.classList.remove('flex');
      assignMembersList.innerHTML = '';
      currentAssignChapterId = null;
    }

    function renderAssignList(list, preChecked){
      assignMembersList.innerHTML = list.map(m => `
        <label class="flex items-center gap-3 p-2 rounded hover:bg-gray-100 cursor-pointer">
          <input type="checkbox" class="assign-checkbox" value="${m.id}" ${ (preChecked||[]).includes(m.id) ? 'checked' : '' } />
          <div>
            <div class="font-medium">${escapeHtml(m.name)}</div>
            <div class="text-xs text-gray-500">${escapeHtml(m.email||'')}</div>
          </div>
        </label>
      `).join('');
    }

    document.getElementById('closeAssignModal').addEventListener('click', closeAssignModal);
    document.getElementById('cancelAssign').addEventListener('click', closeAssignModal);

    assignMemberSearch.addEventListener('input', (e) => {
      const q = e.target.value.trim().toLowerCase();
      const filtered = allMembers.filter(m => m.name.toLowerCase().includes(q) || (m.email||'').toLowerCase().includes(q));
      const pre = (chapters.find(c=>c.id===currentAssignChapterId)?.members) || [];
      renderAssignList(filtered, pre);
    });

    document.getElementById('confirmAssign').addEventListener('click', (ev) => {
      ev.preventDefault();
      if (!currentAssignChapterId) return alert('No chapter selected');
      const checked = Array.from(assignMembersList.querySelectorAll('input.assign-checkbox:checked')).map(i=>Number(i.value));
      const chIdx = chapters.findIndex(c => c.id === currentAssignChapterId);
      if (chIdx === -1) return alert('Chapter not found');
      chapters[chIdx].members = checked;
      showToast('Members assigned', 'success');
      renderChaptersFiltered();
      closeAssignModal();
      saveStorage();
    });

    /* View members (remove capability) */
    function openViewMembers(chapterId){
      const ch = chapters.find(c => c.id === chapterId); if(!ch) return;
      viewModalChapterName.textContent = ch.name;
      renderChapterMembers(ch);
      viewMembersModal.classList.remove('hidden'); viewMembersModal.classList.add('flex');
    }

    function renderChapterMembers(ch){
      const items = (ch.members || []).map(id => allMembers.find(m => m.id === id)).filter(Boolean);
      if (!items.length) {
        chapterMembersContainer.innerHTML = '<div class="text-sm text-gray-500 p-3">No members in this chapter.</div>';
        return;
      }
      chapterMembersContainer.innerHTML = items.map(m => `
        <div class="flex items-center justify-between p-2 rounded hover:bg-gray-50">
          <div>
            <div class="font-medium">${escapeHtml(m.name)}</div>
            <div class="text-xs text-gray-500">${escapeHtml(m.email||'')}</div>
          </div>
          <div>
            <button class="remove-member inline-flex items-center gap-2 text-sm text-red-600 px-3 py-1 rounded hover:bg-red-50" data-id="${m.id}">
              <i data-feather="trash-2" class="w-4 h-4"></i> Remove
            </button>
          </div>
        </div>
      `).join('');

      // bind remove actions
      chapterMembersContainer.querySelectorAll('.remove-member').forEach(btn => {
        btn.addEventListener('click', () => {
          const mid = Number(btn.getAttribute('data-id'));
          if (!confirm('Remove this member from chapter?')) return;
          ch.members = ch.members.filter(x => x !== mid);
          renderChapterMembers(ch);
          renderChaptersFiltered();
          saveStorage();
          showToast('Member removed');
        });
      });

      feather.replace();
    }

    document.getElementById('closeViewMembers').addEventListener('click', ()=> { viewMembersModal.classList.add('hidden'); viewMembersModal.classList.remove('flex'); });
    document.getElementById('closeViewMembers2').addEventListener('click', ()=> { viewMembersModal.classList.add('hidden'); viewMembersModal.classList.remove('flex'); });

    /* Delegation for dynamic card buttons */
    grid.addEventListener('click', (e) => {
      if (e.target.closest('.btn-assign')) {
        const card = e.target.closest('.chapter-card');
        const id = Number(card.getAttribute('data-id'));
        openAssignModal(id);
      } else if (e.target.closest('.btn-view')) {
        const card = e.target.closest('.chapter-card');
        const id = Number(card.getAttribute('data-id'));
        openViewMembers(id);
      } else if (e.target.closest('.btn-edit')) {
        const card = e.target.closest('.chapter-card');
        const id = Number(card.getAttribute('data-id'));
        openEditChapter(id);
      } else if (e.target.closest('.btn-delete')) {
        const card = e.target.closest('.chapter-card');
        const id = Number(card.getAttribute('data-id'));
        if (!confirm('Delete chapter?')) return;
        chapters = chapters.filter(c => c.id !== id);
        renderChaptersFiltered();
        showToast('Chapter deleted');
      } else if (e.target.closest('.btn-toggle')) {
        const card = e.target.closest('.chapter-card');
        const id = Number(card.getAttribute('data-id'));
        const ch = chapters.find(c => c.id === id);
        if (!ch) return;
        ch.is_active = !ch.is_active;
        renderChaptersFiltered();
        showToast(ch.is_active ? 'Activated' : 'Deactivated');
      }
    });

    /* Init */
    searchInput.addEventListener('input', renderChaptersFiltered);
    renderChaptersFiltered();
    feather.replace();
    window.addEventListener('beforeunload', saveStorage);

  })();
  </script>

  <script>feather.replace()</script>
@include('components.script')