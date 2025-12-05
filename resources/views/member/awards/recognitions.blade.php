@include('components.memberheader')
  <style>
    .nav-active {
      background: linear-gradient(to right, #ffe6e6, #ffffff);
      border-right: 4px solid #e53935;
      box-shadow: inset 0 0 10px rgba(229, 57, 53, 0.15);
    }
    .nav-item:hover {
      background: rgba(255, 100, 100, 0.08);
      transition: 0.25s ease-in-out;
      transform: translateX(4px);
    }
    .dropdown-hidden { display: none; }
    .dropdown-visible { display: block !important; }

    .sidebar-scrollbar::-webkit-scrollbar { width: 8px; }
    .sidebar-scrollbar::-webkit-scrollbar-thumb {
      background: rgba(0,0,0,0.15); border-radius: 999px;
    }

    .mobile-slide { transform: translateX(-100%); transition: .25s; }
    .mobile-open { transform: translateX(0); }

    .status-chip { padding:4px 10px; border-radius:999px; font-size:12px; }
    .chip-active { background:#bbf7d0; color:#065f46; }
    .chip-inactive { background:#fecaca; color:#7f1d1d; }

    .modal-hidden { display:none; }
    .modal-show { display:flex !important; }
  </style>
  <!-- MAIN CONTENT -->
  <main id="mainContent" class="flex-1 md:ml-64">
    <!-- ⚡ START OF RECOGNITIONS UI -->
<div class="p-6 sm:p-10">
  <h2 class="text-2xl font-semibold text-[#2C3E50] mb-6">
    Your Recognitions
  </h2>
  <!-- ===================== TOOLBAR ===================== -->
  <div class="flex flex-col lg:flex-row gap-4 lg:items-center justify-between mb-6">

    <!-- Search -->
    <div class="relative w-full lg:w-1/3">
      <i data-feather="search" class="w-5 h-5 text-gray-500 absolute left-3 top-1/2 -translate-y-1/2"></i>
      <input id="searchInput" type="text"
             placeholder="Search title, category, description..."
             class="w-full pl-11 pr-4 py-2.5 border rounded-xl bg-white shadow-sm focus:ring-2 focus:ring-[#2C3E50]">
    </div>

    <!-- Filters -->
    <div class="flex gap-3">
      <select id="categoryFilter" class="px-4 py-2 bg-white border rounded-xl shadow-sm">
        <option value="all">All Categories</option>
        <option value="Award">Award</option>
        <option value="Star Performer">Star Performer</option>
        <option value="Business Champion">Business Champion</option>
        <option value="Leadership Badge">Leadership Badge</option>
      </select>

      <select id="statusFilter" class="px-4 py-2 bg-white border rounded-xl shadow-sm">
        <option value="all">All Status</option>
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
      </select>

      <select id="sortSelect" class="px-4 py-2 bg-white border rounded-xl shadow-sm">
        <option value="latest">Latest First</option>
        <option value="oldest">Oldest First</option>
      </select>
    </div>
  </div>


  <!-- ===================== RECOGNITIONS TABLE ===================== -->
  <div class="bg-white rounded-xl shadow-md p-6 border">

    <!-- DESKTOP TABLE -->
    <div class="hidden md:block overflow-x-auto">
      <table class="w-full table-auto border-collapse">
        <thead>
          <tr class="bg-gray-100 text-gray-700 text-left">
            <th class="py-3 px-4">Title</th>
            <th class="py-3 px-4">Category</th>
            <th class="py-3 px-4">Given By</th>
            <th class="py-3 px-4">Recognized On</th>
            <th class="py-3 px-4">Status</th>
            <th class="py-3 px-4 text-right">Actions</th>
          </tr>
        </thead>

        <tbody id="recognitionTbody">

          <!-- SAMPLE (Replace With DB Data) -->
          <tr class="recognition-row border-b"
    data-title="Star Performer"
    data-category="Star Performer"
    data-givenby="Admin"
    data-recognized_at="2025-12-01"
    data-status="active"
    data-description="Awarded for outstanding performance."
    data-certificate="sample-cert.jpg">

            <td class="py-3 px-4 font-medium">Star Performer</td>
            <td class="py-3 px-4">Star Performer</td>
            <td class="py-3 px-4">Admin</td>
            <td class="py-3 px-4">01 Dec 2025</td>
            <td class="py-3 px-4">
              <span class="status-chip chip-active">Active</span>
            </td>
            <td class="py-3 px-4 text-right">
              <button class="viewBtn bg-[#2C3E50] text-white px-3 py-1 rounded-md text-sm">View</button>
              <button class="previewBtn bg-white border px-3 py-1 rounded-md text-sm">Certificate</button>
            </td>
          </tr>

          <tr class="recognition-row border-b"
    data-title="Leadership Badge"
    data-category="Leadership Badge"
    data-givenby="Chapter Admin"
    data-recognized_at="2025-10-10"
    data-status="inactive"
    data-description="Badge awarded for leadership contribution."
    data-certificate="">


            <td class="py-3 px-4 font-medium">Leadership Badge</td>
            <td class="py-3 px-4">Leadership Badge</td>
            <td class="py-3 px-4">Chapter Admin</td>
            <td class="py-3 px-4">10 Oct 2025</td>
            <td class="py-3 px-4">
              <span class="status-chip chip-inactive">Inactive</span>
            </td>
            <td class="py-3 px-4 text-right">
              <button class="viewBtn bg-[#2C3E50] text-white px-3 py-1 rounded-md text-sm">View</button>
              <button class="previewBtn bg-white border px-3 py-1 rounded-md text-sm opacity-50 cursor-not-allowed" disabled>
                Certificate
              </button>
            </td>
          </tr>

        </tbody>
      </table>
    </div>


    <!-- MOBILE CARDS -->
    <div id="mobileCards" class="md:hidden space-y-4 mt-4"></div>

  </div>
</div>


<!-- ===================== VIEW RECOGNITION MODAL ===================== -->
<div id="viewModal"
     class="modal-hidden fixed inset-0 bg-black/40 z-50 items-center justify-center p-4">

  <div class="bg-white w-full max-w-md p-6 rounded-xl shadow-xl relative">

    <button onclick="closeViewModal()" class="absolute top-3 right-3">
      <i data-feather="x" class="w-6"></i>
    </button>

    <h2 class="text-xl font-semibold mb-3">Recognition Details</h2>

    <p id="vmTitle" class="font-semibold text-gray-800"></p>
    <p id="vmCategory" class="text-gray-600 mt-1"></p>
    <p id="vmGivenBy" class="text-gray-600 mt-1"></p>
    <p id="vmDate" class="text-gray-600 mt-1"></p>
    <p id="vmDesc" class="text-gray-700 mt-3"></p>

    <button onclick="closeViewModal()"
            class="mt-5 w-full bg-[#2C3E50] text-white py-2 rounded-lg">
      Close
    </button>

  </div>
</div>


<!-- ===================== CERTIFICATE PREVIEW MODAL ===================== -->
<div id="certModal"
     class="modal-hidden fixed inset-0 bg-black/60 z-50 items-center justify-center p-4">

  <div class="bg-white w-full max-w-2xl rounded-xl shadow-xl p-4 relative overflow-auto max-h-[90vh]">

    <button onclick="closeCertModal()" class="absolute top-3 right-3">
      <i data-feather="x" class="w-6"></i>
    </button>

    <div id="certContainer" class="w-full flex justify-center items-center">
      <!-- injected image/pdf -->
    </div>

  </div>
</div>
<script>
/* ===========================================================
     GLOBAL LAYOUT SCRIPT (Sidebar + Profile Dropdown)
   =========================================================== */

feather.replace();

/* MOBILE SIDEBAR */
const openMobileBtn = document.getElementById("openMobileSidebar");
const mobileSidebar = document.getElementById("mobileSidebar");
const mobilePanel = document.getElementById("mobilePanel");
const mobileOverlay = document.getElementById("mobileSidebarOverlay");

function openSidebar() {
    mobileSidebar.classList.remove("hidden");
    setTimeout(() => mobilePanel.classList.add("mobile-open"), 10);
    document.documentElement.style.overflow = "hidden";
}

function closeSidebar() {
    mobilePanel.classList.remove("mobile-open");
    document.documentElement.style.overflow = "";
    setTimeout(() => mobileSidebar.classList.add("hidden"), 250);
}

if (openMobileBtn) openMobileBtn.onclick = openSidebar;
if (mobileOverlay) mobileOverlay.onclick = closeSidebar;

/* PROFILE DROPDOWN */
const profileBtn = document.getElementById("profileBtn");
const profileDropdown = document.getElementById("profileDropdown");
const dropdownArrow = document.getElementById("dropdownArrow");

if (profileBtn) {
    profileBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        profileDropdown.classList.toggle("dropdown-hidden");
        profileDropdown.classList.toggle("dropdown-visible");
        dropdownArrow.classList.toggle("rotate-180");
    });
}

document.addEventListener("click", (e) => {
    if (!profileBtn.contains(e.target)) {
        profileDropdown.classList.add("dropdown-hidden");
        profileDropdown.classList.remove("dropdown-visible");
        dropdownArrow.classList.remove("rotate-180");
    }
});



/* ===========================================================
     RECOGNITIONS MODULE — Search, Filter, Sort, Modals
   =========================================================== */

const qs = (s, r=document) => r.querySelector(s);
const qsa = (s, r=document) => Array.from(r.querySelectorAll(s));
const escape = (v) => v ? v.replace(/[&<>"']/g, m => ({
  "&":"&amp;", "<":"&lt;", ">":"&gt;", "\"":"&quot;", "'":"&#39;"
}[m])) : '';

const recognitionTbody = qs("#recognitionTbody");
const mobileCards = qs("#mobileCards");
const searchInput = qs("#searchInput");
const categoryFilter = qs("#categoryFilter");
const statusFilter = qs("#statusFilter");
const sortSelect = qs("#sortSelect");

const viewModal = qs("#viewModal");
const certModal = qs("#certModal");

const vmTitle = qs("#vmTitle");
const vmCategory = qs("#vmCategory");
const vmGivenBy = qs("#vmGivenBy");
const vmDate = qs("#vmDate");
const vmDesc = qs("#vmDesc");

const certContainer = qs("#certContainer");


/* --------- Read rows from DOM ---------- */
function readRows() {
  return qsa(".recognition-row").map(r => ({
    element: r,
    title: r.dataset.title,
    category: r.dataset.category,
    givenby: r.dataset.givenby,
    date: r.dataset.recognized_at,  
    status: r.dataset.status,
    desc: r.dataset.description,
    cert: r.dataset.certificate
  }));
}

/* --------- FILTER + SEARCH + SORT ---------- */
function filterSearchSort(list) {
  let q = searchInput.value.toLowerCase().trim();
  let cat = categoryFilter.value;
  let st = statusFilter.value;

  let res = list.filter(x => {
    let hay = (x.title+" "+x.category+" "+x.desc+" "+x.givenby).toLowerCase();
    if (q && !hay.includes(q)) return false;
    if (cat !== "all" && x.category !== cat) return false;
    if (st !== "all" && x.status !== st) return false;
    return true;
  });

  res.sort((a, b) => {
    let da = new Date(a.date || "1970");
    let db = new Date(b.date || "1970");
    return sortSelect.value === "latest" ? db - da : da - db;
  });

  return res;
}


/* ---------- RENDER DESKTOP TABLE ---------- */
function renderTable(items) {
  recognitionTbody.innerHTML = "";

  items.forEach(x => {
    const tr = document.createElement("tr");
    tr.className = "recognition-row border-b";
    Object.assign(tr.dataset, {
  title: x.title,
  category: x.category,
  givenby: x.givenby,
  recognized_at: x.date,
  status: x.status,
  description: x.desc,
  certificate: x.cert
});
    let niceDate = x.date ? new Date(x.date).toLocaleDateString() : "-";
    tr.innerHTML = `
      <td class="py-3 px-4 font-medium">${escape(x.title)}</td>
      <td class="py-3 px-4">${escape(x.category)}</td>
      <td class="py-3 px-4">${escape(x.givenby)}</td>
      <td class="py-3 px-4">${escape(niceDate)}</td>
      <td class="py-3 px-4">
        <span class="status-chip ${x.status === "active" ? "chip-active" : "chip-inactive"}">${x.status}</span>
      </td>
      <td class="py-3 px-4 text-right">
        <button class="viewBtn bg-[#2C3E50] text-white px-3 py-1 rounded-md text-sm">View</button>
        <button class="certBtn bg-white border px-3 py-1 rounded-md text-sm ${x.cert ? "" : "opacity-50 cursor-not-allowed"}"
                ${x.cert ? "" : "disabled"}>Certificate</button>
      </td>
    `;

    tr.querySelector(".viewBtn").onclick = () => openViewModal(x);
    let certBtn = tr.querySelector(".certBtn");
    if (x.cert) certBtn.onclick = () => openCertModal(x.cert);

    recognitionTbody.appendChild(tr);
  });

  feather.replace(); // important after re-render
}
/* ---------- RENDER MOBILE CARDS ---------- */
function renderMobile(items) {
  mobileCards.innerHTML = "";
  items.forEach(x => {
    let card = document.createElement("div");
    card.className = "bg-white p-4 rounded-xl shadow border";
    card.innerHTML = `
      <h3 class="font-semibold text-[#2C3E50]">${escape(x.title)}</h3>
      <p class="text-sm text-gray-600">${escape(x.category)} • ${escape(x.givenby)}</p>
      <p class="text-sm text-gray-600 mt-2">${escape(x.desc)}</p>
      <p class="text-xs text-gray-500 mt-2">${escape(x.date)}</p>

      <div class="mt-3 flex gap-2">
        <button class="view-card px-3 py-1 bg-[#2C3E50] text-white rounded text-sm">View</button>
        <button class="cert-card px-3 py-1 border rounded text-sm ${x.cert ? "" : "opacity-50 cursor-not-allowed"}"
                ${x.cert ? "" : "disabled"}>Certificate</button>
      </div>
    `;

    card.querySelector(".view-card").onclick = () => openViewModal(x);
    if (x.cert) card.querySelector(".cert-card").onclick = () => openCertModal(x.cert);

    mobileCards.appendChild(card);
  });
}

/* ---------- PIPELINE ---------- */
function updateUI() {
  let list = readRows();
  let filtered = filterSearchSort(list);
  renderTable(filtered);
  renderMobile(filtered);
}


/* ----------------- VIEW MODAL ----------------- */
function openViewModal(x) {
  vmTitle.textContent = x.title;
  vmCategory.textContent = "Category: " + x.category;
  vmGivenBy.textContent = "Given by: " + x.givenby;
  vmDate.textContent = "Recognized on: " + x.date;
  vmDesc.textContent = x.desc || "-";

  viewModal.classList.add("modal-show");
}
function closeViewModal() {
  viewModal.classList.remove("modal-show");
}
window.closeViewModal = closeViewModal;


/* ----------------- CERTIFICATE MODAL ----------------- */
function openCertModal(path) {
  certContainer.innerHTML = "";

  let ext = path.split(".").pop().toLowerCase();

  if (["png","jpg","jpeg","gif","webp"].includes(ext)) {
    certContainer.innerHTML = `<img src="${path}" class="max-h-[75vh] mx-auto rounded-lg shadow" />`;
  } else if (ext === "pdf") {
    certContainer.innerHTML = `<iframe src="${path}" class="w-full h-[75vh]"></iframe>`;
  } else {
    certContainer.innerHTML = `<a href="${path}" target="_blank" class="text-blue-600 underline">Open File</a>`;
  }

  certModal.classList.add("modal-show");
}
function closeCertModal() {
  certModal.classList.remove("modal-show");
}
window.closeCertModal = closeCertModal;


/* ---------- EVENT LISTENERS ---------- */
[searchInput, categoryFilter, statusFilter, sortSelect].forEach(el => {
  el.addEventListener("input", updateUI);
});

document.addEventListener("keydown", (e) => {
  if (e.key === "Escape") {
    closeViewModal();
    closeCertModal();
  }
});

[viewModal, certModal].forEach(mod => {
  mod.addEventListener("click", (e) => {
    if (e.target === mod) {
      mod.classList.remove("modal-show");
    }
  });
});


/* ---------- INITIALIZE ---------- */
updateUI();
feather.replace();
</script>
@include('components.script')