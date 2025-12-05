@include('components.memberheader')
<style>
.modal-hidden { display:none !important; pointer-events:none; }
.modal-show { display:flex !important; pointer-events:auto; }
body.modal-open { overflow:hidden !important; }
/* --------------------------------------
   GLOBAL
-------------------------------------- */
body {
    background: #f3f4f6;
    font-family: 'Inter', sans-serif;
}

/* Smooth transitions for all UI */
* {
    transition: 0.25s ease;
}

/* --------------------------------------
   SIDEBAR
-------------------------------------- */
#sidebar {
    background: #ffffff;
    border-right: 1px solid #e5e7eb;
}

#sidebar nav a {
    border-radius: 12px;
    font-weight: 500;
    padding: 12px 14px;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: .25s ease;
}

#sidebar nav a:hover {
    background: rgba(227, 28, 40, 0.08);
    transform: translateX(4px);
}

#sidebar nav .active {
    background: linear-gradient(to right, #ffe5e5, #ffffff);
    border-right: 4px solid #d93333;
    font-weight: 600;
}

/* --------------------------------------
   HEADER
-------------------------------------- */
header {
    background: rgba(255,255,255,0.85) !important;
    backdrop-filter: blur(10px);
    border-bottom: 1px solid #e5e7eb;
}

header h1 {
    font-weight: 600;
}

/* --------------------------------------
   BUTTONS
-------------------------------------- */
button {
    transition: all .25s ease-in-out;
}

button:hover {
    transform: translateY(-2px);
}

button:active {
    transform: scale(0.96);
}

/* Premium Gradient Button */
.btn-primary {
    background: linear-gradient(to right, #2C3E50, #1B2735);
    color: white;
    padding: 0.6rem 1.5rem;
    border-radius: 999px;
    font-weight: 600;
    box-shadow: 0px 4px 12px rgba(0,0,0,0.12);
}

.btn-primary:hover {
    filter: brightness(1.1);
}

/* --------------------------------------
   SEARCH + SELECT INPUTS
-------------------------------------- */
input, select {
    border-radius: 12px;
    padding: 10px 14px;
    border: 1px solid #d1d5db;
    background: white;
}

input:focus, select:focus {
    border-color: #2C3E50;
    box-shadow: 0 0 0 3px rgba(44,62,80,0.25);
}

/* --------------------------------------
   TABLE MODERN STYLE
-------------------------------------- */
table {
    border-radius: 16px;
    overflow: hidden;
}

thead tr {
    background: #f8fafc !important;
    font-size: 14px;
    letter-spacing: 0.3px;
}

tbody tr {
    border-bottom: 1px solid #f0f0f0;
}

tbody tr:hover {
    background: #f9fafb;
}

/* --------------------------------------
   STATUS BADGES
-------------------------------------- */
.badge {
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

.badge-yellow {
    background: #fff4d6;
    color: #b58500;
}

.badge-green {
    background: #e0f9e8;
    color: #177d3a;
}

.badge-red {
    background: #ffe2e2;
    color: #b42525;
}

/* --------------------------------------
   CARDS (mobile)
-------------------------------------- */
.ref-card {
    background: white;
    padding: 18px;
    border-radius: 16px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.06);
}

.ref-card:hover {
    transform: translateY(-3px);
}

/* --------------------------------------
   MODALS
-------------------------------------- */
.modal-show {
    display: flex !important;
}

.modal-hidden {
    display: none !important;
}

#serviceModal > div,
#addReqModal > div,
#deleteModal > div,
#editModal > div {
    border-radius: 18px;
    animation: modalPop .25s ease;
}

@keyframes modalPop {
    from { transform: scale(0.92); opacity: 0; }
    to   { transform: scale(1); opacity: 1; }
}

/* --------------------------------------
   MOBILE RESPONSIVE FIXES
-------------------------------------- */
@media (max-width: 640px) {
    header h1 {
        font-size: 1rem;
    }
    #sidebar {
        width: 70%;
    }
    .ref-card {
        padding: 14px;
    }
    .toolbar-flex {
        flex-direction: column !important;
        gap: 10px;
    }
}
</style>
</head>
<body class="bg-gray-100">

<!-- PAGE WRAPPER -->
<div class="min-h-screen flex">

  <!-- MOBILE OVERLAY FOR SIDEBAR -->
  <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-30 hidden md:hidden"></div>

  <!-- MAIN CONTENT -->
  <main class="flex-1 md:ml-64">
        <!-- TOOLBAR + TABLE -->
    <div class="p-4 sm:p-6">
      <!-- TOP TOOLBAR -->
      <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
        <!-- LEFT: Search + Filters -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full lg:w-auto flex-1">
          <!-- Search -->
          <div class="relative flex-1">
            <input id="searchInput"
                   type="text"
                   placeholder="Search requester / requested / notes..."
                   class="w-full pl-10 pr-4 py-2 bg-white rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none">
            <i data-feather="search"
               class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
          </div>
          <!-- Status Filter -->
          <select id="statusFilter"
                  class="px-4 py-2 bg-white rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none">
            <option value="all">All Status</option>
            <option value="Requested">Requested</option>
            <option value="Received">Received</option>
            <option value="Cancelled">Cancelled</option>
          </select>

          <!-- Sort Dropdown -->
          <select id="sortSelect"
                  class="w-full sm:w-auto px-4 py-2 bg-white rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none">
            <option value="latest">Sort: Latest</option>
            <option value="oldest">Sort: Oldest</option>
            <option value="az">Sort: A → Z</option>
            <option value="za">Sort: Z → A</option>
          </select>
        </div>

        <!-- RIGHT: Add Request Button -->
        <button id="openAddReq"
        class="w-full sm:w-auto px-7 py-2.5 
               bg-gradient-to-r from-[#2C3E50] to-[#1B2735]
               text-white rounded-full flex justify-center items-center gap-2 
               shadow-lg hover:shadow-xl hover:scale-[1.03] active:scale-[0.98]
               transition-all duration-200">
  <i data-feather="plus" class="w-5 h-5"></i>
  <span class="font-medium tracking-wide">New Request</span>
</button>
      </div>

      <!-- TABLE WRAPPER (scroll on mobile) -->
      <div class="mt-6 overflow-x-auto">
        <table class="min-w-[720px] w-full bg-white shadow rounded-xl overflow-hidden">
          <thead class="bg-gray-100">
            <tr>
              <th class="p-3 text-left">Service</th>
              <th class="p-3 text-left">Giver</th>
              <th class="p-3 text-left">Status</th>
              <th class="p-3 text-left">Date</th>
              <th class="p-3 text-right">Actions</th>
            </tr>
          </thead>
          <tbody id="servicesTbody"></tbody>
        </table>
      </div>

      <!-- PAGINATION -->
      <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mt-4">

        <div class="flex items-center gap-2">
          <span class="text-gray-600 text-sm">Rows per page:</span>
          <select id="rowsPerPage"
                  class="px-3 py-1 border rounded-lg bg-white shadow-sm">
            <option>5</option>
            <option>10</option>
            <option>20</option>
          </select>
        </div>
        <div id="paginationBtns" class="flex items-center gap-1"></div>
      </div>
    </div>
  </main>
</div>
<!-- ==========================
     MODERN VIEW MODAL
=========================== -->
<div id="serviceModal" class="modal-hidden fixed inset-0 bg-black/60 z-50 items-center justify-center p-4">
  <div class="bg-white rounded-xl w-full max-w-lg p-6 relative shadow-xl max-h-[90vh] overflow-y-auto">

    <button onclick="closeServiceModal()" class="absolute top-3 right-3">
      <i data-feather="x" class="text-gray-600"></i>
    </button>

    <div class="flex items-center gap-3 mb-4">
      <div class="w-12 h-12 bg-[#2C3E50] text-white rounded-xl flex justify-center items-center">
        <i data-feather="file-text"></i>
      </div>
      <div>
        <h2 id="svcTitle" class="text-xl font-semibold"></h2>
        <span id="svcStatus" class="text-xs px-2 py-1 rounded-full"></span>
      </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
      <div>
        <p class="font-semibold text-gray-600">Giver</p>
        <p id="svcGiver" class="text-gray-900"></p>
      </div>
      <div>
        <p class="font-semibold text-gray-600">Email</p>
        <p id="svcEmail" class="text-gray-900"></p>
      </div>
      <div>
        <p class="font-semibold text-gray-600">Phone</p>
        <p id="svcPhone" class="text-gray-900"></p>
      </div>
      <div>
        <p class="font-semibold text-gray-600">Date</p>
        <p id="svcDate" class="text-gray-900"></p>
      </div>
    </div>

    <div class="mt-5">
      <p class="font-semibold text-gray-600">Description</p>
      <p id="svcDesc" class="text-gray-900 mt-1"></p>
    </div>

    <div class="mt-6 text-right">
      <button onclick="closeServiceModal()" 
              class="px-5 py-2 bg-[#2C3E50] text-white rounded-lg">
        Close
      </button>
    </div>

  </div>
</div>
<!-- ADD REQUEST MODAL -->
<div id="addReqModal" class="modal-hidden fixed inset-0 bg-black/60 z-50 items-center justify-center p-4">
<div class="bg-white rounded-2xl max-w-2xl w-full p-6 sm:p-8 relative shadow-xl max-h-[90vh] overflow-y-auto">

  <button onclick="closeAddReqModal()" class="absolute top-4 right-4">
    <i data-feather="x" class="text-gray-500 hover:text-gray-700"></i>
  </button>

  <h2 class="text-2xl font-semibold text-[#2C3E50] mb-6 flex items-center gap-2">
    <i data-feather="clipboard" class="w-6 h-6"></i>
    Add New Service Request
  </h2>

  <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

    <!-- Service Title -->
    <div class="col-span-2">
      <label class="text-sm font-semibold text-gray-700">Service Title</label>
      <input id="formService"
             class="w-full mt-1 p-3 border rounded-xl shadow-sm focus:ring-2 focus:ring-[#2C3E50]"
             placeholder="Example: SEO Consultation">
    </div>

    <!-- Giver -->
    <div class="relative">
  <label class="text-sm font-semibold text-gray-700">Giver</label>

  <select id="formGiver"
          class="w-full mt-1 p-3 border rounded-xl shadow-sm bg-white 
                 text-gray-800 font-medium
                 focus:ring-2 focus:ring-[#2C3E50] focus:border-[#2C3E50]
                 appearance-none cursor-pointer">

    <option value="" selected disabled class="text-gray-400">
      -- Select Giver --
    </option>

    <option value="Nisha Rao">Nisha Rao</option>
    <option value="Rajesh Singh">Rajesh Singh</option>
    <option value="Sana Ali">Sana Ali</option>

  </select>

  <!-- Custom dropdown arrow -->
  <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500">
    <i data-feather="chevron-down"></i>
  </div>
</div>


    <!-- Phone -->
    <div>
      <label class="text-sm font-semibold text-gray-700">Phone</label>
      <input id="formPhone"
             class="w-full mt-1 p-3 border rounded-xl shadow-sm focus:ring-2 focus:ring-[#2C3E50]"
             placeholder="+91 98765 43210">
    </div>

    <!-- Email -->
    <div>
      <label class="text-sm font-semibold text-gray-700">Email</label>
      <input id="formEmail"
             class="w-full mt-1 p-3 border rounded-xl shadow-sm focus:ring-2 focus:ring-[#2C3E50]"
             placeholder="giver@example.com">
    </div>

    <!-- Date -->
    <div>
      <label class="text-sm font-semibold text-gray-700">Preferred Date</label>
      <input id="formDate" type="date"
             class="w-full mt-1 p-3 border rounded-xl shadow-sm focus:ring-2 focus:ring-[#2C3E50]">
    </div>

  </div>

  <!-- Description -->
  <div class="mt-5">
    <label class="text-sm font-semibold text-gray-700">Description</label>
    <textarea id="formDesc"
              rows="3"
              class="w-full mt-1 p-3 border rounded-xl shadow-sm focus:ring-2 focus:ring-[#2C3E50]"
              placeholder="Write details about the service you need..."></textarea>
  </div>

  <div class="mt-7 flex justify-end gap-3">
    <button onclick="closeAddReqModal()"
            class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 rounded-lg transition">
      Cancel
    </button>

    <button id="submitAddReq"
            class="px-6 py-2.5 bg-[#2C3E50] text-white rounded-lg shadow hover:scale-[1.02] transition-all">
      Submit Request
    </button>
  </div>
</div>
</div>
<!-- EDIT MODAL -->
<div id="editModal" class="modal-hidden fixed inset-0 bg-black/60 z-50 items-center justify-center p-4">
  <div class="bg-white rounded-xl max-w-2xl w-full p-4 sm:p-6 relative max-h-[90vh] overflow-y-auto">

    <button onclick="closeEditModal()" class="absolute top-3 right-3">
      <i data-feather="x"></i>
    </button>

    <h2 class="text-xl font-semibold mb-4">Edit Request</h2>

    <label>Service Title</label>
    <input id="editService" class="w-full p-2 border rounded">

    <label class="block mt-3">Giver</label>
    <input id="editGiver" class="w-full p-2 border rounded">

    <label class="block mt-3">Phone</label>
    <input id="editPhone" class="w-full p-2 border rounded">

    <label class="block mt-3">Email</label>
    <input id="editEmail" class="w-full p-2 border rounded">

    <label class="block mt-3">Date</label>
    <input id="editDate" type="date" class="w-full p-2 border rounded">

    <label class="block mt-3">Description</label>
    <textarea id="editDesc" class="w-full p-2 border rounded"></textarea>

    <label class="block mt-3">Status</label>
    <select id="editStatus" class="w-full p-2 border rounded">
      <option value="Requested">Requested</option>
      <option value="Received">Received</option>
      <option value="Cancelled">Cancelled</option>
    </select>

    <button id="submitEdit" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded w-full sm:w-auto">
      Save Changes
    </button>

  </div>
</div>


<!-- DELETE MODAL -->
<div id="deleteModal" class="modal-hidden fixed inset-0 bg-black/70 z-50 items-center justify-center p-4">
  <div class="bg-white rounded-xl p-4 sm:p-6 w-full max-w-sm text-center relative max-h-[90vh] overflow-y-auto">

    <button onclick="closeDeleteModal()" class="absolute top-3 right-3">
      <i data-feather="x"></i>
    </button>

    <h2 class="text-xl font-semibold mb-4 text-red-600">Confirm Delete</h2>
    <p class="mb-4">Are you sure you want to delete this request?</p>

    <div class="flex flex-col sm:flex-row justify-center gap-3">
      <button id="confirmDeleteBtn" class="px-4 py-2 bg-red-600 text-white rounded w-full sm:w-auto">
        Delete
      </button>
      <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 rounded w-full sm:w-auto">
        Cancel
      </button>
    </div>

  </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {

  feather.replace();

  /* SIDEBAR TOGGLE (MOBILE) */
  const sidebar = document.getElementById("sidebar");
  const sidebarOverlay = document.getElementById("sidebarOverlay");
  const menuBtn = document.getElementById("menuBtn");
  const closeSidebarBtn = document.getElementById("closeSidebarBtn");

  function openSidebar() {
    sidebar.classList.remove("-translate-x-full");
    sidebarOverlay.classList.remove("hidden");
  }

  function closeSidebar() {
    sidebar.classList.add("-translate-x-full");
    sidebarOverlay.classList.add("hidden");
  }

  if (menuBtn) menuBtn.addEventListener("click", openSidebar);
  if (closeSidebarBtn) closeSidebarBtn.addEventListener("click", closeSidebar);
  sidebarOverlay.addEventListener("click", closeSidebar);


  /* MODAL ENGINE */
  function showModal(modal) {
    modal.classList.replace("modal-hidden", "modal-show");
    document.body.classList.add("modal-open");
  }
  function hideModal(modal) {
    modal.classList.replace("modal-show", "modal-hidden");
    document.body.classList.remove("modal-open");
  }

  window.closeAddReqModal = () => hideModal(addReqModal);
  window.closeServiceModal = () => hideModal(serviceModal);
  window.closeDeleteModal = () => hideModal(deleteModal);
  window.closeEditModal = () => hideModal(editModal);

  const addReqModal = document.getElementById("addReqModal");
  const serviceModal = document.getElementById("serviceModal");
  const deleteModal = document.getElementById("deleteModal");
  const editModal   = document.getElementById("editModal");

  /* SAMPLE DATA */
  let rows = [
   {id:1, service:"SEO Consultation", giver:"Nisha Rao", phone:"9876543210", email:"nisha@example.com", desc:"Audit session", status:"Requested", date:"2025-12-10"},
   {id:2, service:"Website Design", giver:"Rajesh Singh", phone:"9123456789", email:"rajesh@studio.com", desc:"Landing page", status:"Received", date:"2025-11-21"},
   {id:3, service:"Logo Design", giver:"Sana Ali", phone:"9001122334", email:"sana@art.com", desc:"3 concepts", status:"Cancelled", date:"2025-10-05"}
  ];

  let deleteID = null;
  let editID = null;

  let currentPage = 1;
  let rowsPerPage = 5;

  const tbody = document.getElementById("servicesTbody");
  const searchInput = document.getElementById("searchInput");
  const statusFilter = document.getElementById("statusFilter");
  const sortSelect = document.getElementById("sortSelect");


  /* PAGINATION BUTTONS */
  function renderPagination(totalRows) {
    const pagination = document.getElementById("paginationBtns");
    const totalPages = Math.ceil(totalRows / rowsPerPage);

    pagination.innerHTML = "";

    const prev = document.createElement("button");
    prev.innerText = "Prev";
    prev.className = "px-3 py-1 border rounded";
    prev.disabled = currentPage === 1;
    prev.onclick = () => { currentPage--; renderTable(); };
    pagination.appendChild(prev);

    for (let i = 1; i <= totalPages; i++) {
      const btn = document.createElement("button");
      btn.innerText = i;
      btn.className =
        "px-3 py-1 border rounded " +
        (currentPage === i ? "bg-[#2C3E50] text-white" : "bg-white");
      btn.onclick = () => { currentPage = i; renderTable(); };
      pagination.appendChild(btn);
    }

    const next = document.createElement("button");
    next.innerText = "Next";
    next.className = "px-3 py-1 border rounded";
    next.disabled = currentPage === totalPages;
    next.onclick = () => { currentPage++; renderTable(); };
    pagination.appendChild(next);
  }


  /* RENDER TABLE */
  function renderTable() {
    const search = searchInput.value.toLowerCase();
    const statusVal = statusFilter.value;

    let filtered = rows.filter(r => {
      const hay = (r.service + r.giver + r.desc).toLowerCase();
      if (search && !hay.includes(search)) return false;
      if (statusVal !== "all" && r.status !== statusVal) return false;
      return true;
    });

    filtered.sort((a, b) => {
      if (sortSelect.value === "latest") return new Date(b.date) - new Date(a.date);
      if (sortSelect.value === "oldest") return new Date(a.date) - new Date(b.date);
      if (sortSelect.value === "az") return a.service.localeCompare(b.service);
      if (sortSelect.value === "za") return b.service.localeCompare(a.service);
    });

    const start = (currentPage - 1) * rowsPerPage;
    const paginated = filtered.slice(start, start + rowsPerPage);

    tbody.innerHTML = "";

    paginated.forEach(item => {
      const tr = document.createElement("tr");
      tr.classList.add("hover:bg-gray-50", "transition");

tr.innerHTML = `

  <td class="p-4 font-medium text-gray-800">
    ${item.service}
  </td>

  <td class="p-4 text-gray-600">
    ${item.giver}
  </td>

  <td class="p-4">
    <span class="
      px-3 py-1 rounded-full text-xs font-semibold
      ${item.status === "Requested" ? "bg-yellow-100 text-yellow-700" : ""}
      ${item.status === "Received" ? "bg-green-100 text-green-700" : ""}
      ${item.status === "Cancelled" ? "bg-red-100 text-red-700" : ""}
    ">
      ${item.status}
    </span>
  </td>

  <td class="p-4 text-gray-500">
    ${item.date}
  </td>

  <td class="p-4 text-right space-x-2 whitespace-nowrap">

    <button 
      class="viewBtn px-4 py-1.5 rounded-lg text-white bg-gray-700 hover:bg-gray-900 transition text-sm"
      data-id="${item.id}">
      View
    </button>

    <button 
      class="editBtn px-4 py-1.5 rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition text-sm"
      data-id="${item.id}">
      Edit
    </button>

    <button 
      class="deleteBtn px-4 py-1.5 rounded-lg text-white bg-red-600 hover:bg-red-700 transition text-sm"
      data-id="${item.id}">
      Delete
    </button>

  </td>

`;
      tbody.appendChild(tr);
    });

    document.querySelectorAll(".viewBtn").forEach(b => b.onclick = () => openView(b.dataset.id));
    document.querySelectorAll(".editBtn").forEach(b => b.onclick = () => openEdit(b.dataset.id));
    document.querySelectorAll(".deleteBtn").forEach(b => b.onclick = () => openDelete(b.dataset.id));

    renderPagination(filtered.length);
  }

  renderTable();

  searchInput.addEventListener("input", renderTable);
  statusFilter.addEventListener("change", renderTable);
  sortSelect.addEventListener("change", renderTable);

  document.getElementById("rowsPerPage").addEventListener("change", function() {
    rowsPerPage = parseInt(this.value);
    currentPage = 1;
    renderTable();
  });


  /* VIEW MODAL */
  function openView(id) {
    const item = rows.find(r => r.id == id);

    svcTitle.innerText = item.service;
    svcGiver.innerText = item.giver;
    svcEmail.innerText = item.email;
    svcPhone.innerText = item.phone;
    svcDate.innerText = item.date;
    svcDesc.innerText = item.desc;

    const badge = document.getElementById("svcStatus");
    badge.innerText = item.status;

    badge.className =
      "text-xs px-2 py-1 rounded-full " +
      (item.status === "Requested" ? "bg-yellow-100 text-yellow-800" :
       item.status === "Received"  ? "bg-green-100 text-green-800" :
                                     "bg-red-100 text-red-800");

    showModal(serviceModal);
  }


  /* DELETE */
  function openDelete(id) {
    deleteID = id;
    showModal(deleteModal);
  }

  confirmDeleteBtn.onclick = () => {
    rows = rows.filter(r => r.id != deleteID);
    hideModal(deleteModal);
    renderTable();
  };


  /* EDIT */
  function openEdit(id) {
    editID = id;
    const item = rows.find(r => r.id == id);

    editService.value = item.service;
    editGiver.value   = item.giver;
    editPhone.value   = item.phone;
    editEmail.value   = item.email;
    editDate.value    = item.date;
    editDesc.value    = item.desc;
    editStatus.value  = item.status;

    showModal(editModal);
  }

  submitEdit.onclick = () => {
    const r = rows.find(r => r.id == editID);

    r.service = editService.value;
    r.giver   = editGiver.value;
    r.phone   = editPhone.value;
    r.email   = editEmail.value;
    r.date    = editDate.value;
    r.desc    = editDesc.value;
    r.status  = editStatus.value;

    hideModal(editModal);
    renderTable();
  };


  /* ADD NEW REQUEST */
  openAddReq.onclick = () => showModal(addReqModal);

  submitAddReq.onclick = () => {
    rows.unshift({
      id: Date.now(),
      service: formService.value,
      giver: formGiver.value,
      phone: formPhone.value,
      email: formEmail.value,
      date: formDate.value,
      desc: formDesc.value,
      status: "Requested"
    });

    hideModal(addReqModal);
    renderTable();
  };

});
</script>
@include('components.script')