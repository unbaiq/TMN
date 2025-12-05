@include('components.memberheader')
  <style>
    /* Re-using styles from your sidebar/header */
    .nav-active {
      background: linear-gradient(to right, #ffe6e6, #ffffff);
      border-right: 4px solid #e53935;
      box-shadow: inset 0 0 10px rgba(229, 57, 53, 0.15);
    }
    .nav-item:hover { background: rgba(255,100,100,0.08); transform: translateX(4px); transition: .25s; }
    .dropdown-hidden { display: none; }
    .dropdown-visible { display:block !important; opacity:1 !important; transform: scale(1) !important; }
    .sidebar-scrollbar::-webkit-scrollbar { width:8px; }
    .sidebar-scrollbar::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.12); border-radius:9999px; }

    /* Chips */
    .chip { padding:6px 10px; border-radius:9999px; font-size:12px; display:inline-flex; align-items:center; gap:6px; }
    .chip-article { background: #eef2ff; color:#3730a3; }
    .chip-story { background: #fff7ed; color:#7c2d12; }
    .chip-video { background: #ecfeff; color:#065f46; }
    .chip-draft { background:#f3f4f6; color:#374151; }
    .chip-submitted { background:#fff4cc; color:#92400e; }
    .chip-approved { background:#dcfce7; color:#065f46; }
    .chip-rejected { background:#fee2e2; color:#7f1d1d; }

    /* modal helpers */
    .modal-hidden { display:none; }
    .modal-show { display:flex !important; }

    /* small helper for preview image */
    .img-preview { max-width:100%; max-height:320px; object-fit:contain; border-radius:8px; }
  </style>
  <!-- MAIN -->
  <main class="flex-1 md:ml-64">
    <!-- PAGE CONTENT: Branding -->
    <div class="p-6 sm:p-8">
      <div class="flex flex-col lg:flex-row gap-4 items-start lg:items-center justify-between mb-6">
        <div class="flex gap-3 w-full lg:w-2/3">
          <div class="relative flex-1">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i data-feather="search" class="w-4 h-4"></i></span>
            <input id="searchInput" type="search" placeholder="Search title, content, SEO..." class="w-full pl-10 pr-4 py-2 border rounded-xl bg-white focus:ring-2 focus:ring-[#2C3E50]">
          </div>
          <select id="typeFilter" class="px-3 py-2 border rounded-xl bg-white">
            <option value="all">All Types</option>
            <option value="article">Article</option>
            <option value="story">Story</option>
            <option value="video">Video</option>
          </select>

          <select id="statusFilter" class="px-3 py-2 border rounded-xl bg-white">
            <option value="all">All Status</option>
            <option value="draft">Draft</option>
            <option value="submitted">Submitted</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
          </select>

          <select id="sortSelect" class="px-3 py-2 border rounded-xl bg-white">
            <option value="latest">Sort: Latest</option>
            <option value="oldest">Sort: Oldest</option>
          </select>
        </div>

        <div class="flex gap-3">
          <button id="newPostBtn" class="px-4 py-2 bg-[#2C3E50] text-white rounded-xl flex items-center gap-2 shadow">
            <i data-feather="plus"></i> New Post
          </button>
        </div>
      </div>

      <!-- Table / Cards wrapper -->
      <div class="bg-white rounded-xl shadow p-4 border">
        <!-- Desktop table -->
        <div class="hidden md:block overflow-x-auto">
          <table class="w-full table-auto">
            <thead>
              <tr class="text-left bg-gray-100 text-sm text-gray-700">
                <th class="py-3 px-4">Title</th>
                <th class="py-3 px-4">Type</th>
                <th class="py-3 px-4">Status</th>
                <th class="py-3 px-4">Created</th>
                <th class="py-3 px-4">Actions</th>
              </tr>
            </thead>
            <tbody id="postsTbody">
              <!-- JS will populate -->
            </tbody>
          </table>
        </div>

        <!-- Mobile cards -->
        <div id="mobileCards" class="md:hidden space-y-4 mt-4"></div>

        <!-- Pagination (simple) -->
        <div class="mt-4 flex items-center justify-between">
          <div id="summaryText" class="text-sm text-gray-600">Showing 0 posts</div>
          <div class="flex items-center gap-2">
            <button id="prevPage" class="px-3 py-1 border rounded">Prev</button>
            <button id="nextPage" class="px-3 py-1 border rounded">Next</button>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>

<!-- ====== CREATE / EDIT POST MODAL ====== -->
<div id="postModal" class="modal-hidden fixed inset-0 bg-black/50 z-50 items-center justify-center p-4">
  <div class="bg-white w-full max-w-3xl rounded-xl shadow-xl p-6 relative max-h-[90vh] overflow-y-auto">
    <button onclick="closePostModal()" class="absolute top-3 right-3 text-gray-600"><i data-feather="x"></i></button>
    <h2 id="postModalTitle" class="text-xl font-semibold mb-3">Create Branding Post</h2>

    <div class="space-y-4">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <div>
          <label class="block text-sm font-medium">Post Type</label>
          <select id="postType" class="w-full px-3 py-2 border rounded-lg">
            <option value="article">Article</option>
            <option value="story">Story</option>
            <option value="video">Video</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium">Title</label>
          <input id="postTitle" type="text" class="w-full px-3 py-2 border rounded-lg" placeholder="Enter title">
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium">Slug (auto)</label>
        <input id="postSlug" type="text" class="w-full px-3 py-2 border rounded-lg" placeholder="auto-generated from title">
      </div>

      <!-- content area toggles by type -->
      <div id="contentArticle" class="hidden">
        <label class="block text-sm font-medium">Article Content</label>
        <textarea id="postContent" rows="8" class="w-full px-3 py-2 border rounded-lg" placeholder="Write long article..."></textarea>
      </div>

      <div id="contentStory" class="hidden">
        <label class="block text-sm font-medium">Story Text</label>
        <textarea id="postStory" rows="4" class="w-full px-3 py-2 border rounded-lg" placeholder="Short story / caption..."></textarea>
      </div>

      <div id="contentVideo" class="hidden">
        <label class="block text-sm font-medium">Video URL (YouTube or hosted)</label>
        <input id="postVideoUrl" type="url" class="w-full px-3 py-2 border rounded-lg" placeholder="https://youtube.com/...">
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-3 items-start">
        <div>
          <label class="block text-sm font-medium">Featured Image</label>
          <input id="postImageInput" type="file" accept="image/*" class="mt-2">
          <div id="imagePreviewWrap" class="mt-3 hidden">
            <img id="imagePreview" class="img-preview" src="" alt="preview">
            <button id="removeImageBtn" class="mt-2 text-sm text-red-600">Remove image</button>
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium">Short Description</label>
          <textarea id="postShortDesc" rows="4" class="w-full px-3 py-2 border rounded-lg" placeholder="Short summary..."></textarea>
        </div>
      </div>

      <!-- SEO -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <div>
          <label class="text-sm font-medium">Meta Title</label>
          <input id="metaTitle" class="w-full px-3 py-2 border rounded-lg" />
        </div>
        <div>
          <label class="text-sm font-medium">Meta Description</label>
          <input id="metaDesc" class="w-full px-3 py-2 border rounded-lg" />
        </div>
        <div>
          <label class="text-sm font-medium">Meta Keywords</label>
          <input id="metaKeys" class="w-full px-3 py-2 border rounded-lg" />
        </div>
      </div>

      <div class="flex gap-2 justify-end">
        <button id="saveDraftBtn" class="px-4 py-2 bg-gray-100 rounded-lg">Save Draft</button>
        <button id="submitBtn" class="px-4 py-2 bg-yellow-400 rounded-lg">Submit for Approval</button>
        <button id="publishLocalBtn" class="px-4 py-2 bg-green-600 text-white rounded-lg">Publish (Approve) — Demo</button>
      </div>
    </div>
  </div>
</div>

<!-- VIEW POST MODAL -->
<div id="viewModal" class="modal-hidden fixed inset-0 bg-black/60 z-50 items-center justify-center p-4">
  <div class="bg-white w-full max-w-3xl rounded-xl shadow-xl p-6 relative max-h-[90vh] overflow-y-auto">
    <button onclick="closeViewModal()" class="absolute top-3 right-3 text-gray-600"><i data-feather="x"></i></button>
    <div id="viewContent"></div>
    <div class="mt-4 flex gap-2 justify-end">
      <button id="editFromViewBtn" class="px-4 py-2 bg-[#2C3E50] text-white rounded-lg">Edit</button>
      <button id="closeViewBtn" onclick="closeViewModal()" class="px-4 py-2 bg-gray-100 rounded-lg">Close</button>
    </div>
  </div>
</div>

<script>
/* Branding Module UI - client side demo
   - in-memory store saved to localStorage to persist between reloads
   - functions: create/edit/delete, search, filter, sort, pagination, preview
*/

feather.replace();

/* ---------- DATA STORE ---------- */
// Use localStorage key so demo persists
const STORAGE_KEY = 'tmn_branding_posts_v1';
let posts = [];
// pagination
let page = 1;
let perPage = 6;

/* Try to load saved posts */
function loadPosts() {
  try {
    const raw = localStorage.getItem(STORAGE_KEY);
    if (raw) posts = JSON.parse(raw);
    else {
      // seed with two sample posts
      posts = [
        {
          id: genId(),
          post_type: 'article',
          title: 'How to Optimize Your LinkedIn Profile',
          slug: 'how-to-optimize-your-linkedin-profile',
          content: 'Long article content here — write tips...',
          short_description: 'Quick tips to boost profile discoverability.',
          featured_image: '',
          video_url: '',
          meta_title: 'Optimize LinkedIn Profile',
          meta_description: 'Tips to improve profile',
          meta_keywords: 'linkedin,profile,seo',
          status: 'approved',
          approved_by: null,
          rejection_reason: null,
          created_at: new Date().toISOString()
        },
        {
          id: genId(),
          post_type: 'story',
          title: 'Big Win — Closed 3 Clients',
          slug: 'big-win-closed-3-clients',
          content: '',
          short_description: 'Shared a quick story about closing deals.',
          featured_image: '',
          video_url: '',
          meta_title: '',
          meta_description: '',
          meta_keywords: '',
          status: 'draft',
          approved_by: null,
          rejection_reason: null,
          created_at: new Date().toISOString()
        }
      ];
      savePosts();
    }
  } catch(e) {
    posts = [];
  }
}
function savePosts() {
  localStorage.setItem(STORAGE_KEY, JSON.stringify(posts));
}

/* ---------- UTIL ---------- */
function genId() { return 'p_' + Math.random().toString(36).slice(2,9); }
function nowISO() { return new Date().toISOString(); }
function toDateText(iso) {
  if(!iso) return '-';
  try { return new Date(iso).toLocaleDateString(undefined, { day:'2-digit', month:'short', year:'numeric' }); } catch(e){ return iso; }
}
function slugify(s){
  return (s||'').toString().toLowerCase().trim()
    .replace(/[\s\_]+/g, '-')
    .replace(/[^\w\-]+/g, '')
    .replace(/\-\-+/g,'-')
    .replace(/^-+|-+$/g,'');
}

/* ---------- DOM refs ---------- */
const postsTbody = document.getElementById('postsTbody');
const mobileCards = document.getElementById('mobileCards');
const searchInput = document.getElementById('searchInput');
const typeFilter = document.getElementById('typeFilter');
const statusFilter = document.getElementById('statusFilter');
const sortSelect = document.getElementById('sortSelect');
const summaryText = document.getElementById('summaryText');
const prevPageBtn = document.getElementById('prevPage');
const nextPageBtn = document.getElementById('nextPage');

const postModal = document.getElementById('postModal');
const postModalTitle = document.getElementById('postModalTitle');
const postType = document.getElementById('postType');
const postTitle = document.getElementById('postTitle');
const postSlug = document.getElementById('postSlug');
const postContent = document.getElementById('postContent');
const postStory = document.getElementById('postStory');
const postVideoUrl = document.getElementById('postVideoUrl');
const postImageInput = document.getElementById('postImageInput');
const imagePreviewWrap = document.getElementById('imagePreviewWrap');
const imagePreview = document.getElementById('imagePreview');
const removeImageBtn = document.getElementById('removeImageBtn');
const postShortDesc = document.getElementById('postShortDesc');
const metaTitle = document.getElementById('metaTitle');
const metaDesc = document.getElementById('metaDesc');
const metaKeys = document.getElementById('metaKeys');
const saveDraftBtn = document.getElementById('saveDraftBtn');
const submitBtn = document.getElementById('submitBtn');
const publishLocalBtn = document.getElementById('publishLocalBtn');

const viewModal = document.getElementById('viewModal');
const viewContent = document.getElementById('viewContent');
const editFromViewBtn = document.getElementById('editFromViewBtn');

/* State for edit */
let editingId = null;
let tempImageDataUrl = '';

/* ---------- INIT ---------- */
loadPosts();
renderPipeline();

/* sidebar / header interactions (mobile + profile) */
(function headerSetup(){
  if(window.feather) feather.replace();

  const openMobileBtn = document.getElementById('openMobileSidebar');
  const mobileSidebar = document.getElementById('mobileSidebar');
  const mobilePanel = document.getElementById('mobilePanel');
  const mobileOverlay = document.getElementById('mobileSidebarOverlay');
  openMobileBtn && openMobileBtn.addEventListener('click', () => {
    mobileSidebar.classList.remove('hidden');
    setTimeout(()=> mobilePanel.classList.add('mobile-open'), 10);
    document.documentElement.style.overflow='hidden';
  });
  mobileOverlay && mobileOverlay.addEventListener('click', () => {
    mobilePanel.classList.remove('mobile-open');
    document.documentElement.style.overflow='';
    setTimeout(()=> mobileSidebar.classList.add('hidden'), 220);
  });

  // profile dropdown
  const profileBtn = document.getElementById('profileBtn');
  const profileDropdown = document.getElementById('profileDropdown');
  const dropdownArrow = document.getElementById('dropdownArrow');
  profileBtn && profileBtn.addEventListener('click', (e)=> {
    e.stopPropagation();
    dropdownArrow.classList.toggle('rotate-180');
    profileDropdown.classList.toggle('dropdown-hidden');
    profileDropdown.classList.toggle('dropdown-visible');
  });
  document.addEventListener('click', (e)=> {
    if(!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)){
      dropdownArrow.classList.remove('rotate-180');
      profileDropdown.classList.add('dropdown-hidden');
      profileDropdown.classList.remove('dropdown-visible');
    }
  });
})();

/* ---------- RENDER PIPELINE ---------- */
function getAllItems() {
  // return a clone to avoid accidental modification
  return posts.map(p => ({ ...p }));
}

function applySearchFilterSort(items) {
  const q = (searchInput.value || '').toLowerCase().trim();
  const typ = typeFilter.value;
  const st = statusFilter.value;
  let filtered = items.filter(it => {
    let hay = (it.title + ' ' + (it.content||'') + ' ' + (it.short_description||'') + ' ' + (it.meta_title||'') + ' ' + (it.meta_description||'')).toLowerCase();
    if (q && !hay.includes(q)) return false;
    if (typ !== 'all' && it.post_type !== typ) return false;
    if (st !== 'all' && it.status !== st) return false;
    return true;
  });

  if (sortSelect.value === 'latest') {
    filtered.sort((a,b) => new Date(b.created_at) - new Date(a.created_at));
  } else {
    filtered.sort((a,b) => new Date(a.created_at) - new Date(b.created_at));
  }
  return filtered;
}

function renderTableAndCards() {
  const items = applySearchFilterSort(getAllItems());
  // pagination
  const total = items.length;
  const totalPages = Math.max(1, Math.ceil(total / perPage));
  if (page > totalPages) page = totalPages;
  const start = (page-1)*perPage;
  const paged = items.slice(start, start + perPage);

  // desktop tbody
  postsTbody.innerHTML = '';
  paged.forEach(it => {
    const tr = document.createElement('tr');
    tr.className = 'border-b';
    const typeChip = it.post_type === 'article' ? 'chip-article' : (it.post_type === 'story' ? 'chip-story' : 'chip-video');
    const statusChip = it.status === 'draft' ? 'chip-draft' : (it.status === 'submitted' ? 'chip-submitted' : (it.status === 'approved' ? 'chip-approved' : 'chip-rejected'));
    tr.innerHTML = `
      <td class="py-3 px-4 font-medium">${escapeHtml(it.title)}</td>
      <td class="py-3 px-4"><span class="chip ${typeChip}">${it.post_type}</span></td>
      <td class="py-3 px-4"><span class="chip ${statusChip}">${it.status}</span></td>
      <td class="py-3 px-4">${toDateText(it.created_at)}</td>
      <td class="py-3 px-4 text-right space-x-2">
        <button class="viewBtn px-3 py-1 bg-[#2C3E50] text-white rounded text-sm">View</button>
        <button class="editBtn px-3 py-1 bg-white border rounded text-sm">Edit</button>
        <button class="deleteBtn px-3 py-1 bg-red-50 text-red-600 rounded text-sm">Delete</button>
      </td>
    `;
    // attach handlers
    tr.querySelector('.viewBtn').addEventListener('click', () => openView(it.id));
    tr.querySelector('.editBtn').addEventListener('click', () => openEdit(it.id));
    tr.querySelector('.deleteBtn').addEventListener('click', () => removePost(it.id));
    postsTbody.appendChild(tr);
  });

  // mobile cards
  mobileCards.innerHTML = '';
  paged.forEach(it => {
    const typeChip = it.post_type === 'article' ? 'chip-article' : (it.post_type === 'story' ? 'chip-story' : 'chip-video');
    const statusChip = it.status === 'draft' ? 'chip-draft' : (it.status === 'submitted' ? 'chip-submitted' : (it.status === 'approved' ? 'chip-approved' : 'chip-rejected'));
    const card = document.createElement('div');
    card.className = 'bg-white p-4 rounded-xl shadow border';
    card.innerHTML = `
      <div class="flex justify-between items-start">
        <div>
          <h3 class="font-semibold text-[#2C3E50]">${escapeHtml(it.title)}</h3>
          <p class="text-sm text-gray-600 mt-1">${escapeHtml(it.short_description || '')}</p>
          <p class="text-xs text-gray-400 mt-2">${toDateText(it.created_at)}</p>
        </div>
        <div class="text-right space-y-2">
          <div><span class="chip ${typeChip}">${it.post_type}</span></div>
          <div><span class="chip ${statusChip}">${it.status}</span></div>
        </div>
      </div>
      <div class="mt-3 flex gap-2">
        <button class="view-mobile px-3 py-1 bg-[#2C3E50] text-white rounded text-sm">View</button>
        <button class="edit-mobile px-3 py-1 bg-white border rounded text-sm">Edit</button>
      </div>
    `;
    card.querySelector('.view-mobile').addEventListener('click', () => openView(it.id));
    card.querySelector('.edit-mobile').addEventListener('click', () => openEdit(it.id));
    mobileCards.appendChild(card);
  });

  summaryText.textContent = `Showing ${Math.min(total, start+1)}–${Math.min(total, start + paged.length)} of ${total} posts`;
  prevPageBtn.disabled = page <= 1;
  nextPageBtn.disabled = page >= totalPages;
}

/* helper */
function getAllItemsFromDOM(){ return getAllItems(); }
function renderPipeline(){ renderTableAndCards(); }

/* ---------- SEARCH / FILTER / SORT HOOKS ---------- */
[searchInput, typeFilter, statusFilter, sortSelect].forEach(el => el && el.addEventListener('input', () => { page = 1; renderPipeline(); }));

prevPageBtn.addEventListener('click', () => { if(page>1) page--; renderPipeline(); });
nextPageBtn.addEventListener('click', () => { page++; renderPipeline(); });

/* ---------- CREATE / EDIT MODAL HANDLERS ---------- */
document.getElementById('newPostBtn').addEventListener('click', ()=> openCreate());

function openCreate(){
  editingId = null;
  postModalTitle.textContent = 'Create Branding Post';
  postType.value = 'article';
  postTitle.value = '';
  postSlug.value = '';
  postContent.value = '';
  postStory.value = '';
  postVideoUrl.value = '';
  postShortDesc.value = '';
  metaTitle.value = '';
  metaDesc.value = '';
  metaKeys.value = '';
  tempImageDataUrl = '';
  imagePreviewWrap.classList.add('hidden');
  postImageInput.value = '';
  showTypeInputs('article');
  openPostModal();
}

function openEdit(id){
  const p = posts.find(x=>x.id===id);
  if(!p) return alert('Post not found');
  editingId = id;
  postModalTitle.textContent = 'Edit Post';
  postType.value = p.post_type;
  postTitle.value = p.title;
  postSlug.value = p.slug;
  postContent.value = p.content || '';
  postStory.value = p.content || '';
  postVideoUrl.value = p.video_url || '';
  postShortDesc.value = p.short_description || '';
  metaTitle.value = p.meta_title || '';
  metaDesc.value = p.meta_description || '';
  metaKeys.value = p.meta_keywords || '';
  tempImageDataUrl = p.featured_image || '';
  if(tempImageDataUrl){
    imagePreview.src = tempImageDataUrl;
    imagePreviewWrap.classList.remove('hidden');
  } else imagePreviewWrap.classList.add('hidden');
  showTypeInputs(p.post_type);
  openPostModal();
}

function openPostModal(){
  postModal.classList.remove('modal-hidden');
  postModal.classList.add('modal-show');
  // autofocus title
  setTimeout(()=> postTitle.focus(), 150);
}
function closePostModal(){
  postModal.classList.add('modal-hidden');
  postModal.classList.remove('modal-show');
}

/* file image preview */
postImageInput.addEventListener('change', (e)=> {
  const f = e.target.files && e.target.files[0];
  if(!f) return;
  const reader = new FileReader();
  reader.onload = (ev) => {
    tempImageDataUrl = ev.target.result;
    imagePreview.src = tempImageDataUrl;
    imagePreviewWrap.classList.remove('hidden');
  };
  reader.readAsDataURL(f);
});
removeImageBtn.addEventListener('click', ()=> {
  tempImageDataUrl = '';
  imagePreview.src = '';
  imagePreviewWrap.classList.add('hidden');
  postImageInput.value = '';
});

/* post type show/hide inputs */
function showTypeInputs(type){
  document.getElementById('contentArticle').classList.toggle('hidden', type!=='article');
  document.getElementById('contentStory').classList.toggle('hidden', type!=='story');
  document.getElementById('contentVideo').classList.toggle('hidden', type!=='video');
}
postType.addEventListener('change', (e)=> showTypeInputs(e.target.value));
postTitle.addEventListener('input', (e)=> {
  // update slug if empty or matches previous auto slug
  if(!editingId || postSlug.value.trim()==='' || postSlug.dataset.autogen==='1'){
    postSlug.value = slugify(e.target.value);
    postSlug.dataset.autogen = '1';
  }
});
postSlug.addEventListener('input', ()=> { postSlug.dataset.autogen = '0'; });

/* Save draft */
saveDraftBtn.addEventListener('click', ()=> {
  const data = collectPostForm();
  data.status = 'draft';
  upsertPost(data);
  closePostModal();
});

/* Submit for approval */
submitBtn.addEventListener('click', ()=> {
  const data = collectPostForm();
  data.status = 'submitted';
  upsertPost(data);
  closePostModal();
});

/* Publish local (demo approve) */
publishLocalBtn.addEventListener('click', ()=> {
  const data = collectPostForm();
  data.status = 'approved';
  upsertPost(data);
  closePostModal();
});

/* collect form */
function collectPostForm(){
  const type = postType.value;
  const title = postTitle.value.trim();
  const slug = postSlug.value.trim() || slugify(title);
  let content = '';
  if(type === 'article') content = postContent.value.trim();
  if(type === 'story') content = postStory.value.trim();
  if(type === 'video') content = postVideoUrl.value.trim();

  return {
    id: editingId || genId(),
    post_type: type,
    title: title,
    slug: slug,
    content: type === 'video' ? '' : content,
    short_description: postShortDesc.value.trim(),
    featured_image: tempImageDataUrl || '',
    video_url: type === 'video' ? postVideoUrl.value.trim() : '',
    meta_title: metaTitle.value.trim(),
    meta_description: metaDesc.value.trim(),
    meta_keywords: metaKeys.value.trim(),
    status: 'draft',
    approved_by: null,
    rejection_reason: null,
    created_at: editingId ? (posts.find(p=>p.id===editingId)?.created_at || nowISO()) : nowISO()
  };
}

/* upsert post into store */
function upsertPost(data) {
  // find existing
  const idx = posts.findIndex(p => p.id === data.id);
  // when editing the status may be set already (submit button sets it)
  if(idx >= 0){
    posts[idx] = { ...posts[idx], ...data };
  } else {
    posts.unshift(data);
  }
  savePosts();
  renderPipeline();
}

/* remove post */
function removePost(id){
  if(!confirm('Delete this post?')) return;
  posts = posts.filter(p=>p.id!==id);
  savePosts();
  renderPipeline();
}

/* ---------- VIEW POST ---------- */
function openView(id){
  const p = posts.find(x=>x.id===id);
  if(!p) return;
  // build HTML
  let html = `<h2 class="text-xl font-semibold">${escapeHtml(p.title)}</h2>`;
  html += `<div class="text-sm text-gray-500 mt-1">${escapeHtml(p.post_type)} • ${toDateText(p.created_at)} • <span class="font-medium">${escapeHtml(p.status)}</span></div>`;
  if(p.featured_image){
    html += `<div class="mt-4"><img src="${p.featured_image}" class="img-preview" alt="featured"></div>`;
  }
  if(p.post_type === 'video' && p.video_url){
    // embed youtube if possible
    const v = p.video_url;
    let embed = '';
    try {
      if(v.includes('youtube') || v.includes('youtu.be')) {
        // extract id
        const id = (v.match(/(?:v=|\/)([0-9A-Za-z_-]{11})/) || [null,null])[1] || null;
        if(id) embed = `<iframe class="w-full h-64 mt-4" src="https://www.youtube.com/embed/${id}" frameborder="0" allowfullscreen></iframe>`;
        else embed = `<div class="mt-4"><a href="${v}" target="_blank" class="text-indigo-600 underline">Open Video</a></div>`;
      } else {
        embed = `<div class="mt-4"><a href="${v}" target="_blank" class="text-indigo-600 underline">Open Video</a></div>`;
      }
    } catch(e) { embed = `<div class="mt-4"><a href="${v}" target="_blank" class="text-indigo-600 underline">Open Video</a></div>`; }
    html += embed;
  }
  if(p.post_type === 'article') {
    html += `<div class="prose mt-4">${escapeHtml(p.content).replace(/\n/g,'<br>')}</div>`;
  } else if(p.post_type === 'story') {
    html += `<div class="mt-4 text-gray-700">${escapeHtml(p.short_description) || escapeHtml(p.content)}</div>`;
  } else if(p.post_type === 'video') {
    html += `<div class="mt-4 text-gray-700">${escapeHtml(p.short_description)}</div>`;
  }

  // SEO & admin info
  html += `<div class="mt-4 p-4 bg-gray-50 rounded"><strong>SEO:</strong> ${escapeHtml(p.meta_title || '-') } • ${escapeHtml(p.meta_keywords || '-')}</div>`;
  if(p.status === 'rejected' && p.rejection_reason){
    html += `<div class="mt-3 p-3 bg-red-50 text-red-700 rounded"><strong>Rejection reason:</strong><div>${escapeHtml(p.rejection_reason)}</div></div>`;
  }

  viewContent.innerHTML = html;

  viewModal.classList.remove('modal-hidden');
  viewModal.classList.add('modal-show');

  // edit from view
  editFromViewBtn.onclick = () => { closeViewModal(); openEdit(id); };
}

function closeViewModal(){
  viewModal.classList.add('modal-hidden');
  viewModal.classList.remove('modal-show');
}

/* helper: escape html */
function escapeHtml(s){ if(s==null) return ''; return (''+s).replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;'); }

/* expose some actions for testing (approve/reject) */
// approve a post by id (demo - would be admin)
window._approvePost = function(id){
  const p = posts.find(x=>x.id===id); if(!p) return;
  p.status = 'approved'; p.approved_by = 'admin_demo'; p.rejection_reason = null;
  savePosts(); renderPipeline();
};
window._rejectPost = function(id, reason='Not approved') {
  const p = posts.find(x=>x.id===id); if(!p) return;
  p.status = 'rejected'; p.rejection_reason = reason;
  savePosts(); renderPipeline();
};

/* initial UI */
function getAllItemsFromDOM(){ return getAllItems(); }
function renderPipeline(){ renderTableAndCards(); }

/* Close modal on ESC or outside click */
document.addEventListener('keydown', (e)=> {
  if(e.key === 'Escape'){
    closePostModal();
    closeViewModal();
  }
});
[postModal, viewModal].forEach(m => {
  m.addEventListener('click', (ev) => { if(ev.target === m) { m.classList.add('modal-hidden'); m.classList.remove('modal-show'); } });
});
</script>

@include('components.script')