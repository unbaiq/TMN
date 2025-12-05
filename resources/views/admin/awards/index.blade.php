@include('components.adminheader')

  <style>
    :root { --brand: #e53935; --brand-600: #e53935; }
    body { font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; background:#f3f4f6; }
    .card-accent { height:6px; border-radius:8px; background:linear-gradient(90deg,#fb923c,#ef4444); opacity:.12; margin:-1rem 1rem 0 1rem; }
    .badge-active { background: linear-gradient(90deg,#ecfdf5,#bbf7d0); color:#065f46; }
    .badge-inactive { background:#f3f4f6; color:#6b7280; }
    .confirm { position:fixed; right:20px; top:20px; z-index:60; min-width:240px; display:none; }
    .file-preview { max-height:120px; object-fit:contain; border-radius:8px; }
    @media (max-width:640px){ .grid-cols-responsive { grid-template-columns: repeat(1, minmax(0,1fr)); } }
  </style>

<div class="antialiased text-gray-800">

  <div class="max-w-7xl mx-auto p-6">
    <!-- page header -->
    <div class="bg-white rounded-2xl shadow-sm p-4 mb-6">
      <div class="card-accent"></div>
      <div class="flex items-center justify-between gap-4">
        <div>
          <h1 class="text-2xl font-semibold text-gray-900">Awards — Admin</h1>
          <p class="text-sm text-gray-500 mt-1">Declare awards to members (chapter, member, date, certificate).</p>
        </div>

        <div class="flex items-center gap-3">
          <input id="searchBox" placeholder="Search title / member" class="border rounded px-3 py-2 text-sm w-56" />
          <select id="filterChapter" class="border rounded px-3 py-2 text-sm">
            <option value="">All Chapters</option>
          </select>
          <button id="openCreate" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded flex items-center gap-2 text-sm">
            <i data-feather="award" class="w-4 h-4"></i> New Award
          </button>
        </div>
      </div>
    </div>

    <!-- awards grid -->
    <div id="awardsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 grid-cols-responsive"></div>

    <div id="noAwards" class="text-center text-gray-500 mt-8 hidden">No awards found. Create one using “New Award”.</div>
  </div>

  <!-- Create / Edit Modal -->
  <div id="awardModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/40"></div>
    <div class="relative z-10 bg-white rounded-2xl max-w-2xl w-full p-6 shadow-xl">
      <div class="flex items-center justify-between mb-4">
        <h3 id="modalTitle" class="text-lg font-semibold">Create Award</h3>
        <button id="closeModal" class="text-gray-400 hover:text-gray-600">✕</button>
      </div>

      <form id="awardForm" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <input type="hidden" id="awardId">

        <div class="md:col-span-2">
          <label class="text-sm text-gray-600">Title</label>
          <input id="awardTitle" class="w-full border rounded px-3 py-2" required />
        </div>

        <div>
          <label class="text-sm text-gray-600">Chapter</label>
          <select id="awardChapter" class="w-full border rounded px-3 py-2"></select>
        </div>

        <div>
          <label class="text-sm text-gray-600">Recipient (Member)</label>
          <select id="awardMember" class="w-full border rounded px-3 py-2"></select>
        </div>

        <div>
          <label class="text-sm text-gray-600">Awarded on</label>
          <input id="awardDate" type="date" class="w-full border rounded px-3 py-2" />
        </div>

        <div>
          <label class="text-sm text-gray-600">Active</label>
          <div class="mt-2">
            <label class="inline-flex items-center gap-2">
              <input id="awardActive" type="checkbox" checked class="h-4 w-4" />
              <span class="text-sm text-gray-700">Is Active</span>
            </label>
          </div>
        </div>

        <div class="md:col-span-2">
          <label class="text-sm text-gray-600">Description</label>
          <textarea id="awardDescription" rows="3" class="w-full border rounded px-3 py-2"></textarea>
        </div>

        <div class="md:col-span-2">
          <label class="text-sm text-gray-600">Certificate / File (optional)</label>
          <input id="awardFile" type="file" accept="image/*,application/pdf" class="mt-2" />
          <div id="filePreview" class="mt-3"></div>
        </div>

        <div class="md:col-span-2 flex items-center justify-end gap-3 mt-2">
          <button type="button" id="modalCancel" class="px-4 py-2 border rounded text-sm">Cancel</button>
          <button type="submit" id="modalSave" class="px-4 py-2 bg-red-600 text-white rounded text-sm flex items-center gap-2">
            <i data-feather="save" class="w-4"></i> Save Award
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- confirmation dropdown -->
  <div id="confirm" class="confirm right-6 top-6">
    <div class="bg-white border-l-4 border-red-600 rounded shadow px-4 py-3 flex items-center gap-3">
      <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
          <path d="M20 6L9 17l-5-5" stroke="#065f46" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <div>
        <div class="font-medium text-gray-900">Saved</div>
        <div class="text-sm text-gray-600">Award saved successfully.</div>
      </div>
    </div>
  </div>

<script>
  feather.replace();

  (function(){
    const KEY = 'tmn_awards_demo_v1';

    // Demo data: chapters and members (replace with real from backend)
    let chapters = [
      { id: 1, name: 'Delhi Chapter', slug: 'delhi' },
      { id: 2, name: 'Mumbai Chapter', slug: 'mumbai' },
      { id: 3, name: 'Bengaluru Chapter', slug: 'bengaluru' }
    ];

    let members = [
      { id: 101, name: 'Ramesh Kumar', email: 'ramesh@example.com' },
      { id: 102, name: 'Priya Sharma', email: 'priya@example.com' },
      { id: 103, name: 'Amit Singh', email: 'amit@example.com' }
    ];

    // awards: id, chapter_id, member_id, title, description, awarded_on, award_file (dataURL or filename), is_active, created_at
    let awards = [];

    // DOM refs
    const awardsGrid = document.getElementById('awardsGrid');
    const noAwards = document.getElementById('noAwards');
    const openCreate = document.getElementById('openCreate');
    const awardModal = document.getElementById('awardModal');
    const closeModal = document.getElementById('closeModal');
    const modalCancel = document.getElementById('modalCancel');
    const modalTitle = document.getElementById('modalTitle');
    const awardForm = document.getElementById('awardForm');
    const awardId = document.getElementById('awardId');
    const awardTitle = document.getElementById('awardTitle');
    const awardChapter = document.getElementById('awardChapter');
    const awardMember = document.getElementById('awardMember');
    const awardDate = document.getElementById('awardDate');
    const awardActive = document.getElementById('awardActive');
    const awardDescription = document.getElementById('awardDescription');
    const awardFile = document.getElementById('awardFile');
    const filePreview = document.getElementById('filePreview');
    const filterChapter = document.getElementById('filterChapter');
    const searchBox = document.getElementById('searchBox');
    const confirmBox = document.getElementById('confirm');

    // load/save
    function load(){
      try {
        const raw = localStorage.getItem(KEY);
        if (!raw) return;
        const parsed = JSON.parse(raw);
        awards = parsed.awards || [];
      } catch(e){ console.warn(e); }
    }
    function save(){
      localStorage.setItem(KEY, JSON.stringify({ awards }));
    }

    // init selects
    function populateChapterSelects(){
      awardChapter.innerHTML = '<option value="">-- Select Chapter --</option>';
      filterChapter.innerHTML = '<option value="">All Chapters</option>';
      chapters.forEach(c => {
        const opt = `<option value="${c.id}">${escapeHtml(c.name)}</option>`;
        awardChapter.insertAdjacentHTML('beforeend', opt);
        filterChapter.insertAdjacentHTML('beforeend', opt);
      });
    }
    function populateMemberSelect(){
      awardMember.innerHTML = '<option value="">-- Select Member --</option>';
      members.forEach(m => {
        awardMember.insertAdjacentHTML('beforeend', `<option value="${m.id}">${escapeHtml(m.name)} — ${escapeHtml(m.email)}</option>`);
      });
    }

    // render awards
    function render(){
      awardsGrid.innerHTML = '';
      const q = (searchBox.value || '').trim().toLowerCase();
      const fChapter = filterChapter.value || '';
      const list = awards.filter(a => {
        if (fChapter && String(a.chapter_id) !== String(fChapter)) return false;
        if (!q) return true;
        return (a.title||'').toLowerCase().includes(q) || (findMember(a.member_id)?.name||'').toLowerCase().includes(q);
      });

      if (!list.length) {
        noAwards.classList.remove('hidden');
      } else {
        noAwards.classList.add('hidden');
      }

      list.sort((a,b) => new Date(b.awarded_on || b.created_at) - new Date(a.awarded_on || a.created_at));

      for (const a of list){
        awardsGrid.appendChild(createCard(a));
      }
      feather.replace();
    }

    function createCard(a){
      const el = document.createElement('article');
      el.className = 'bg-white rounded-2xl p-5 shadow-sm relative hover:shadow-md transition';
      el.innerHTML = `
        <div class="absolute left-4 right-4 top-[-6px] h-1 rounded card-accent"></div>
        <div class="flex items-start justify-between gap-3">
          <div>
            <h3 class="text-lg font-semibold text-gray-900">${escapeHtml(a.title)}</h3>
            <div class="text-sm text-gray-500 mt-1">${escapeHtml(a.description || '')}</div>

            <div class="mt-3 text-sm text-gray-600 space-y-1">
              <div><strong>Recipient:</strong> ${escapeHtml(findMember(a.member_id)?.name || '—')}</div>
              <div><strong>Chapter:</strong> ${escapeHtml(findChapter(a.chapter_id)?.name || '—')}</div>
              <div><strong>Date:</strong> ${escapeHtml(a.awarded_on || '')}</div>
            </div>
          </div>

          <div class="flex flex-col items-end gap-3">
            <div class="${a.is_active ? 'badge-active' : 'badge-inactive'} inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium">
              ${a.is_active ? 'Active' : 'Inactive'}
            </div>

            <div class="flex items-center gap-2">
              <button class="edit-btn px-2 py-2 bg-white border rounded hover:bg-red-50" title="Edit" data-id="${a.id}">
                <i data-feather="edit-2" class="w-4 h-4"></i>
              </button>
              <button class="download-btn px-2 py-2 bg-white border rounded hover:bg-red-50" title="Download" data-id="${a.id}">
                <i data-feather="download" class="w-4 h-4"></i>
              </button>
              <button class="delete-btn px-2 py-2 text-red-600 hover:bg-red-50 rounded" title="Delete" data-id="${a.id}">
                <i data-feather="trash-2" class="w-4 h-4"></i>
              </button>
            </div>
          </div>
        </div>

        ${a.award_file ? `<div class="mt-4">${renderFilePreviewHTML(a.award_file)}</div>` : ''}
      `;
      // bind actions
      el.querySelector('.edit-btn').addEventListener('click', () => openEdit(a.id));
      el.querySelector('.delete-btn').addEventListener('click', () => {
        if (!confirm('Delete award?')) return;
        awards = awards.filter(x => x.id !== a.id);
        save(); render(); showConfirm();
      });
      el.querySelector('.download-btn').addEventListener('click', () => {
        if (!a.award_file) return alert('No file attached');
        downloadDataUrl(a.award_file, (a.title || 'award').replace(/\s+/g,'_'));
      });

      return el;
    }

    function renderFilePreviewHTML(fileData){
      // if data URL of image -> show image; if pdf -> show link icon
      if (typeof fileData !== 'string') return '';
      if (fileData.startsWith('data:image/')) {
        return `<img src="${fileData}" class="file-preview border rounded" alt="certificate">`;
      }
      // for pdf or unknown, show link
      return `<div class="flex items-center gap-2 text-sm text-gray-600"><svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none"><path d="M12 2v6l4 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg> Attached file</div>`;
    }

    // helpers
    function findChapter(id){ return chapters.find(c => String(c.id) === String(id)) || null; }
    function findMember(id){ return members.find(m => String(m.id) === String(id)) || null; }
    function escapeHtml(s){ return String(s||''); }

    // modal open / close / populate
    function openCreateModal(){
      awardForm.reset();
      awardId.value = '';
      filePreview.innerHTML = '';
      modalTitle.textContent = 'Create Award';
      awardActive.checked = true;
      showModal();
    }
    function openEdit(id){
      const a = awards.find(x => x.id === id);
      if (!a) return;
      awardId.value = a.id;
      awardTitle.value = a.title || '';
      awardChapter.value = a.chapter_id || '';
      awardMember.value = a.member_id || '';
      awardDate.value = a.awarded_on || '';
      awardActive.checked = !!a.is_active;
      awardDescription.value = a.description || '';
      filePreview.innerHTML = a.award_file ? renderFilePreview(a.award_file) : '';
      modalTitle.textContent = 'Edit Award';
      showModal();
    }

    function renderFilePreview(dataUrl){
      if (!dataUrl) return '';
      if (typeof dataUrl === 'string' && dataUrl.startsWith('data:image/')) {
        return `<img src="${dataUrl}" class="file-preview border rounded" alt="preview">`;
      }
      return `<div class="text-sm text-gray-600">Attached file available</div>`;
    }

    function showModal(){ awardModal.classList.remove('hidden'); awardModal.classList.add('flex'); }
    function hideModal(){ awardModal.classList.add('hidden'); awardModal.classList.remove('flex'); }

    // file handling
    awardFile.addEventListener('change', (e) => {
      const f = e.target.files && e.target.files[0];
      if (!f) { filePreview.innerHTML = ''; return; }
      const reader = new FileReader();
      reader.onload = (ev) => {
        const data = ev.target.result;
        filePreview.innerHTML = renderFilePreview(data);
        // store temp in data attribute on input (will be read on save)
        awardFile.dataset.data = data;
      };
      // for images and pdf both, read as data URL
      reader.readAsDataURL(f);
    });

    // save award (create or update)
    awardForm.addEventListener('submit', (ev) => {
      ev.preventDefault();
      const id = awardId.value ? Number(awardId.value) : Date.now();
      const payload = {
        id,
        chapter_id: awardChapter.value ? Number(awardChapter.value) : null,
        member_id: awardMember.value ? Number(awardMember.value) : null,
        title: awardTitle.value.trim(),
        description: awardDescription.value.trim(),
        awarded_on: awardDate.value || new Date().toISOString().slice(0,10),
        award_file: awardFile.dataset.data || null,
        is_active: !!awardActive.checked,
        created_at: new Date().toISOString()
      };

      if (!payload.title) return alert('Title is required');

      const existing = awards.find(x => x.id === id);
      if (existing) {
        // update
        awards = awards.map(x => x.id === id ? Object.assign({}, x, payload) : x);
      } else {
        awards.unshift(payload);
      }

      save();
      hideModal();
      render();
      awardForm.reset();
      awardFile.dataset.data = '';
      filePreview.innerHTML = '';
      showConfirm();
    });

    // UI actions
    openCreate.addEventListener('click', openCreateModal);
    closeModal.addEventListener('click', hideModal);
    modalCancel.addEventListener('click', hideModal);

    filterChapter.addEventListener('change', render);
    searchBox.addEventListener('input', render);

    // download helper for data URL
    function downloadDataUrl(dataUrl, baseName='file') {
      try {
        const a = document.createElement('a');
        a.href = dataUrl;
        // attempt to determine extension
        let ext = 'jpg';
        if (dataUrl.startsWith('data:image/')) {
          ext = dataUrl.substring(11, dataUrl.indexOf(';')) || 'png';
        } else if (dataUrl.startsWith('data:application/pdf')) ext = 'pdf';
        a.download = `${baseName}.${ext}`;
        document.body.appendChild(a);
        a.click();
        a.remove();
      } catch(e) {
        alert('Cannot download file');
      }
    }

    // Render preview HTML string for image/pdf
    function renderFilePreview(data){
      if (!data) return '';
      if (data.startsWith('data:image/')) {
        return `<img src="${data}" class="file-preview border rounded" alt="certificate">`;
      }
      return `<div class="text-sm text-gray-600">Attached file available</div>`;
    }

    // confirmation animation
    let confirmTimer = null;
    function showConfirm(){
      clearTimeout(confirmTimer);
      confirmBox.style.display = 'block';
      confirmBox.classList.add('opacity-0');
      // run tiny animation (scale/fade)
      confirmBox.animate([{ transform: 'translateY(-6px)', opacity: 0 }, { transform: 'translateY(0)', opacity: 1 }], { duration: 260, easing: 'cubic-bezier(.2,.9,.2,1)' });
      confirmTimer = setTimeout(() => {
        confirmBox.animate([{ transform: 'translateY(0)', opacity: 1 }, { transform: 'translateY(-6px)', opacity: 0 }], { duration: 200, easing: 'ease-in' });
        setTimeout(() => { confirmBox.style.display = 'none'; }, 210);
      }, 1800);
    }

    // small escape helper
    function escapeHtml(s){ return String(s||''); }

    // initial boot
    function boot(){
      populateChapterSelects();
      populateMemberSelect();
      load();
      render();
    }

    boot();

    // expose for debugging (optional)
    window.__tmn_awards = { awards, chapters, members, save, render };
  })();
</script>
@include('components.script')