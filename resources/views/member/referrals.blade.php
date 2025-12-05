@include('components.memberheader')
  <style>
/* Existing styles kept — only enhancements added */

.nav-active {
    background: linear-gradient(to right, #ffe6e6, #ffffff);
    border-right: 4px solid #e53935;
    box-shadow: inset 0 0 10px rgba(229, 57, 53, 0.15);
}

.nav-item {
    border-radius: 0.75rem;
    transition: all 0.25s ease;
    padding: 0.75rem 1rem;
    display: flex;
    align-items: center;
}
.nav-item:hover {
    background: rgba(255, 0, 0, 0.08);
    transform: translateX(6px);
}

/* Sidebar improvements */
.sidebar-scrollbar::-webkit-scrollbar { width: 8px; }
.sidebar-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(0,0,0,0.1);
    border-radius: 9999px;
}

/* Header premium look */
header {
    background: rgba(255,255,255,0.85) !important;
    backdrop-filter: blur(10px);
    border-bottom: 1px solid #e5e7eb;
}

/* Modern Button Style */
button {
    transition: all 0.25s ease;
}
button:hover {
    transform: translateY(-2px);
}

/* INPUTS */
input, select {
    transition: all .2s ease-in-out;
}
input:focus, select:focus {
    border-color: #e11d48 !important;
    box-shadow: 0 0 0 3px rgba(225,29,72,0.25);
}

/* Referral Box */
.bg-white.rounded-xl.shadow-md {
    transition: all 0.25s ease;
}
.bg-white.rounded-xl.shadow-md:hover {
    box-shadow: 0 12px 28px rgba(0,0,0,0.08);
}

/* Table */
table {
    border-radius: 12px;
    overflow: hidden;
}
thead tr {
    background: #f8fafc !important;
}
td {
    vertical-align: middle;
}

/* Status Badges */
.bg-yellow-100 {
    background: #fff7d1 !important;
}
.bg-green-100 {
    background: #d9fbe5 !important;
}
.bg-red-100 {
    background: #ffe2e2 !important;
}

/* Mobile referral cards */
.md\:hidden .border {
    background: #ffffff;
    border-radius: 14px;
    box-shadow: 0px 4px 14px rgba(0,0,0,0.06);
    padding: 18px;
    transition: all .2s ease;
}
.md\:hidden .border:hover {
    transform: translateY(-3px);
}

/* Modal animation */
#eventModal .max-w-md {
    animation: scaleIn .25s ease;
}
@keyframes scaleIn {
    from { transform: scale(0.92); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}
/* Smooth modal pop animation */
@keyframes modalPop {
  from {
    transform: translateY(10px) scale(0.97);
    opacity: 0;
  }
  to {
    transform: translateY(0) scale(1);
    opacity: 1;
  }
}

.modal-card {
  animation: modalPop 0.22s ease-out;
}

</style>

</head>

<body class="bg-gray-100 font-sans antialiased">

<div class="min-h-screen flex">
  <!-- MAIN CONTENT -->
  <main class="flex-1 md:ml-64">
<div class="p-6 sm:p-10">
    <!-- PAGE TITLE -->
    <h2 class="text-2xl font-semibold text-[#2C3E50] mb-6">My Referrals</h2>
    <!-- SHARE REFERRAL LINK BOX -->
    <div class="bg-white rounded-xl shadow-md p-5 mb-6 border">
        <h3 class="text-lg font-semibold text-[#2C3E50] mb-3">Invite Members to TMN</h3>

        <div class="flex flex-col sm:flex-row sm:items-center gap-3">
            <input id="referralLink" type="text" readonly value="https://tmn.com/referral/ABC123"class="flex-1 px-4 py-2 border rounded-lg bg-gray-50 text-gray-700 focus:ring-2 focus:ring-red-400 outline-none">
            <button onclick="copyReferralLink()"class="px-4 py-2 bg-[#2C3E50] hover:bg-[#1B2631] text-white rounded-lg flex items-center gap-2 ">
                <i data-feather="copy" class="w-4"></i> Copy Link
            </button>
        </div>
    </div>
<!-- Toolbar (Search + Sort + Filter) -->
<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-5">

    <!-- Search -->
    <div class="relative w-full lg:w-1/3">
        <i data-feather="search" class="w-5 h-5 text-gray-500 absolute left-3 top-1/2 -translate-y-1/2"></i>
        <input type="text" id="searchInput" placeholder="Search by name, phone or email..."
               class="w-full pl-11 pr-4 py-2 bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none">
    </div>

    <!-- Status Filter -->
    <select id="statusFilter" class="px-4 py-2 bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none">
    <option value="all">All Status</option>
    <option value="pending">Pending Referrals</option>
    <option value="converted">Converted Referrals</option>
    <option value="rejected">Rejected Referrals</option>
</select>

</div>


    <!-- REFERRAL TABLE CARD -->
    <div class="bg-white rounded-xl shadow-md p-6 border">

        <!-- Table Header -->
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-[#2C3E50]">Referral History</h3>
        </div>

<!-- Desktop Table (UPGRADED UI LIKE TAKE SERVICES) -->
<div class="hidden md:block overflow-x-auto">
    <table class="w-full border-collapse bg-white shadow rounded-xl overflow-hidden">
        <thead class="bg-gray-100 text-gray-700 text-sm">
            <tr>
                <th class="py-3 px-4 text-left">Name</th>
                <th class="py-3 px-4 text-left">Phone</th>
                <th class="py-3 px-4 text-left">Email</th>
                <th class="py-3 px-4 text-left">Status</th>
                <th class="py-3 px-4 text-left">Date</th>
                <th class="py-3 px-4 text-right">Actions</th>
            </tr>
        </thead>

        <tbody>

            <!-- ROW 1 (PENDING) -->
            <tr class="ref-row border-b hover:bg-gray-50 transition"
                data-name="Rahul Sharma"
                data-phone="9876543210"
                data-email=""
                data-status="pending"
                data-date="2025-12-10">

                <td class="py-3 px-4 font-medium text-gray-800">Rahul Sharma</td>
                <td class="py-3 px-4 text-gray-600">+91 9876543210</td>
                <td class="py-3 px-4 text-gray-600">—</td>

                <td class="py-3 px-4">
                    <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                        Pending
                    </span>
                </td>

                <td class="py-3 px-4 text-gray-600 text-sm">10 Dec 2025</td>

                <!-- NEW ACTION COLUMN -->
                <td class="py-3 px-4 text-right space-x-1 whitespace-nowrap">

                    <button class="text-blue-600 hover:underline text-sm font-semibold"
                            onclick="openViewModal('Rahul Sharma','9876543210','—','Pending','10 Dec 2025')">
                        View
                    </button>

                    <button class="text-green-600 hover:underline text-sm font-semibold"
                            onclick="openEditModal('Rahul Sharma','9876543210','—','pending')">
                        Edit
                    </button>

                    <button class="text-red-600 hover:underline text-sm font-semibold"
                            onclick="openDeleteModal('Rahul Sharma')">
                        Delete
                    </button>

                </td>
            </tr>

            <!-- ROW 2 (CONVERTED) -->
            <tr class="ref-row border-b hover:bg-gray-50 transition"
                data-name="Priya Verma"
                data-phone=""
                data-email="priya@example.com"
                data-status="converted"
                data-date="2025-12-08">

                <td class="py-3 px-4 font-medium text-gray-800">Priya Verma</td>
                <td class="py-3 px-4 text-gray-600">—</td>
                <td class="py-3 px-4 text-gray-600">priya@example.com</td>

                <td class="py-3 px-4">
                    <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">
                        Converted
                    </span>
                </td>

                <td class="py-3 px-4 text-gray-600 text-sm">8 Dec 2025</td>

                <!-- ACTIONS -->
                <td class="py-3 px-4 text-right space-x-1 whitespace-nowrap">

                    <button class="text-blue-600 hover:underline text-sm font-semibold"
                            onclick="openViewModal('Priya Verma','—','priya@example.com','Converted','8 Dec 2025')">
                        View
                    </button>

                    <button class="text-green-600 hover:underline text-sm font-semibold"
                            onclick="openEditModal('Priya Verma','—','priya@example.com','converted')">
                        Edit
                    </button>

                    <button class="text-red-600 hover:underline text-sm font-semibold"
                            onclick="openDeleteModal('Priya Verma')">
                        Delete
                    </button>

                </td>
            </tr>

            <!-- ROW 3 (REJECTED) -->
            <tr class="ref-row hover:bg-gray-50 transition"
                data-name="Sameer Patel"
                data-phone="9988776655"
                data-email=""
                data-status="rejected"
                data-date="2025-12-05">

                <td class="py-3 px-4 font-medium text-gray-800">Sameer Patel</td>
                <td class="py-3 px-4 text-gray-600">+91 9988776655</td>
                <td class="py-3 px-4 text-gray-600">—</td>

                <td class="py-3 px-4">
                    <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700">
                        Rejected
                    </span>
                </td>

                <td class="py-3 px-4 text-gray-600 text-sm">5 Dec 2025</td>

                <!-- ACTIONS -->
                <td class="py-3 px-4 text-right space-x-1 whitespace-nowrap">

                    <button class="text-blue-600 hover:underline text-sm font-semibold"
                            onclick="openViewModal('Sameer Patel','9988776655','—','Rejected','5 Dec 2025')">
                        View
                    </button>

                    <button class="text-green-600 hover:underline text-sm font-semibold"
                            onclick="openEditModal('Sameer Patel','9988776655','—','rejected')">
                        Edit
                    </button>

                    <button class="text-red-600 hover:underline text-sm font-semibold"
                            onclick="openDeleteModal('Sameer Patel')">
                        Delete
                    </button>

                </td>
            </tr>

        </tbody>
    </table>
</div>
<!-- MOBILE CARD VIEW -->
<div class="md:hidden space-y-4">

    <!-- CARD 1 -->
    <div class="border rounded-xl p-4 shadow-sm">
        <h4 class="font-semibold text-[#2C3E50]">Rahul Sharma</h4>
        <p class="text-gray-600 text-sm">📞 +91 9876543210</p>
        <p class="text-gray-600 text-sm">✉️ —</p>
        <span class="inline-block mt-2 px-3 py-1 text-sm bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
        <p class="text-gray-500 text-xs mt-1">10 Dec 2025</p>

        <!-- ⭐ ACTION BUTTONS HERE -->
        <div class="flex gap-3 mt-3">
            <button onclick="openViewModal('Rahul Sharma','9876543210','—','Pending','10 Dec 2025')"
                    class="text-blue-600 font-semibold text-sm">View</button>

            <button onclick="openEditModal('Rahul Sharma','9876543210','—','pending')"
                    class="text-green-600 font-semibold text-sm">Edit</button>

            <button onclick="openDeleteModal('Rahul Sharma')"
                    class="text-red-600 font-semibold text-sm">Delete</button>
        </div>
    </div>


    <!-- CARD 2 -->
    <div class="border rounded-xl p-4 shadow-sm">
        <h4 class="font-semibold text-[#2C3E50]">Priya Verma</h4>
        <p class="text-gray-600 text-sm">📞 —</p>
        <p class="text-gray-600 text-sm">✉️ priya@example.com</p>
        <span class="inline-block mt-2 px-3 py-1 text-sm bg-green-100 text-green-700 rounded-full">Converted</span>
        <p class="text-gray-500 text-xs mt-1">8 Dec 2025</p>

        <!-- ⭐ ACTION BUTTONS HERE -->
        <div class="flex gap-3 mt-3">
            <button onclick="openViewModal('Priya Verma','—','priya@example.com','Converted','8 Dec 2025')"
                    class="text-blue-600 font-semibold text-sm">View</button>

            <button onclick="openEditModal('Priya Verma','—','priya@example.com','converted')"
                    class="text-green-600 font-semibold text-sm">Edit</button>

            <button onclick="openDeleteModal('Priya Verma')"
                    class="text-red-600 font-semibold text-sm">Delete</button>
        </div>
    </div>


    <!-- CARD 3 -->
    <div class="border rounded-xl p-4 shadow-sm">
        <h4 class="font-semibold text-[#2C3E50]">Sameer Patel</h4>
        <p class="text-gray-600 text-sm">📞 +91 9988776655</p>
        <p class="text-gray-600 text-sm">✉️ —</p>
        <span class="inline-block mt-2 px-3 py-1 text-sm bg-red-100 text-red-700 rounded-full">Rejected</span>
        <p class="text-gray-500 text-xs mt-1">5 Dec 2025</p>

        <!-- ⭐ ACTION BUTTONS HERE -->
        <div class="flex gap-3 mt-3">
            <button onclick="openViewModal('Sameer Patel','9988776655','—','Rejected','5 Dec 2025')"
                    class="text-blue-600 font-semibold text-sm">View</button>

            <button onclick="openEditModal('Sameer Patel','9988776655','—','rejected')"
                    class="text-green-600 font-semibold text-sm">Edit</button>

            <button onclick="openDeleteModal('Sameer Patel')"
                    class="text-red-600 font-semibold text-sm">Delete</button>
        </div>
    </div>

</div>
  </main>
</div>

<!-- VIEW MODAL -->
<div id="viewModal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center p-4 z-50">
  <div class="bg-white rounded-xl p-6 w-full max-w-sm shadow-lg relative">

    <button onclick="closeViewModal()" class="absolute top-3 right-3">
      <i data-feather="x"></i>
    </button>

    <h2 class="text-xl font-semibold mb-3">Referral Details</h2>

    <p id="viewName" class="text-gray-700"></p>
    <p id="viewPhone" class="text-gray-700"></p>
    <p id="viewEmail" class="text-gray-700"></p>
    <p id="viewStatus" class="text-gray-700"></p>
    <p id="viewDate" class="text-gray-700"></p>

    <button onclick="closeViewModal()" class="mt-4 w-full bg-[#2C3E50] text-white py-2 rounded-lg">Close</button>
  </div>
</div>

<!-- EDIT MODAL -->
<div id="editModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
  <div class="bg-white rounded-2xl w-full max-w-md shadow-xl relative border border-gray-100 modal-card p-6 sm:p-7">

    <!-- Close Button -->
    <button onclick="closeEditModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
      <i data-feather="x"></i>
    </button>

    <!-- Title -->
    <h2 class="text-2xl font-semibold text-[#2C3E50] mb-5 flex items-center gap-2">
      <i data-feather="edit-3" class="w-5 h-5"></i>
      Edit Referral
    </h2>

    <!-- Name -->
    <div class="mb-4">
      <label class="block text-sm font-semibold text-gray-700 mb-1">Name</label>
      <input id="editName"
             class="w-full px-3 py-2.5 border rounded-xl bg-gray-50 text-sm
                    focus:ring-2 focus:ring-red-400 focus:border-red-400 outline-none">
    </div>

    <!-- Phone -->
    <div class="mb-4">
      <label class="block text-sm font-semibold text-gray-700 mb-1">Phone</label>
      <input id="editPhone"
             class="w-full px-3 py-2.5 border rounded-xl bg-gray-50 text-sm
                    focus:ring-2 focus:ring-red-400 focus:border-red-400 outline-none">
    </div>

    <!-- Email -->
    <div class="mb-4">
      <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
      <input id="editEmail"
             class="w-full px-3 py-2.5 border rounded-xl bg-gray-50 text-sm
                    focus:ring-2 focus:ring-red-400 focus:border-red-400 outline-none">
    </div>

    <!-- Status -->
    <div class="mb-2">
      <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
      <select id="editStatus"
              class="w-full px-3 py-2.5 border rounded-xl bg-gray-50 text-sm
                     focus:ring-2 focus:ring-red-400 focus:border-red-400 outline-none">
        <option value="pending">Pending</option>
        <option value="converted">Converted</option>
        <option value="rejected">Rejected</option>
      </select>
    </div>

    <!-- Buttons -->
    <div class="mt-6 flex flex-col sm:flex-row gap-3 justify-end">
      <button onclick="closeEditModal()"
              class="w-full sm:w-auto px-4 py-2.5 rounded-xl border border-gray-200 text-gray-700
                     hover:bg-gray-100 text-sm font-medium">
        Cancel
      </button>

      <button onclick="saveReferral()"
              class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-[#2C3E50] text-white text-sm font-medium
                     shadow hover:shadow-md hover:scale-[1.02] transition">
        Save Changes
      </button>
    </div>

  </div>
</div>

<!-- DELETE MODAL -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center p-4 z-50">
  <div class="bg-white rounded-2xl w-full max-w-sm shadow-xl relative border border-gray-100 modal-card p-6 sm:p-7">

    <!-- Close Button -->
    <button onclick="closeDeleteModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
      <i data-feather="x"></i>
    </button>

    <div class="flex flex-col items-center text-center">
      <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center mb-3">
        <i data-feather="alert-triangle" class="text-red-500"></i>
      </div>

      <h2 class="text-xl sm:text-2xl font-semibold text-red-600 mb-2">
        Delete Referral
      </h2>

      <p id="deleteText" class="text-sm text-gray-700 mb-5 px-2">
        Are you sure you want to delete this request?
      </p>
    </div>

    <div class="flex flex-col sm:flex-row gap-3 mt-1">
      <button onclick="confirmDelete()"
              class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-red-600 text-white text-sm font-medium
                     shadow hover:bg-red-700 hover:shadow-md transition">
        Delete
      </button>

      <button onclick="closeDeleteModal()"
              class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-gray-100 text-gray-800 text-sm font-medium
                     border border-gray-200 hover:bg-gray-200 transition">
        Cancel
      </button>
    </div>

  </div>
</div>

<script>
feather.replace();

/* MOBILE SIDEBAR */
const openMobileBtn = document.getElementById("openMobileSidebar");
const mobileSidebar = document.getElementById("mobileSidebar");
const mobilePanel = document.getElementById("mobilePanel");
const mobileOverlay = document.getElementById("mobileSidebarOverlay");

openMobileBtn.onclick = () => {
  mobileSidebar.classList.remove("hidden");
  setTimeout(() => mobilePanel.classList.add("mobile-open"), 10);
  document.body.style.overflow = "hidden";
};

mobileOverlay.onclick = () => closeMobileSidebar();

function closeMobileSidebar() {
  mobilePanel.classList.remove("mobile-open");
  document.body.style.overflow = "";
  setTimeout(() => mobileSidebar.classList.add("hidden"), 250);
}

/* PROFILE DROPDOWN */
const profileBtn = document.getElementById("profileBtn");
const profileDropdown = document.getElementById("profileDropdown");
const dropdownArrow = document.getElementById("dropdownArrow");

profileBtn.onclick = (e) => {
  e.stopPropagation();
  profileDropdown.classList.toggle("dropdown-hidden");
  profileDropdown.classList.toggle("dropdown-visible");
  dropdownArrow.classList.toggle("rotate-180");
};

document.onclick = (e) => {
  if (!profileBtn.contains(e.target)) {
    profileDropdown.classList.add("dropdown-hidden");
    profileDropdown.classList.remove("dropdown-visible");
    dropdownArrow.classList.remove("rotate-180");
  }
};

function copyReferralLink() {
    let link = document.getElementById("referralLink");
    link.select();
    navigator.clipboard.writeText(link.value);
    alert("Referral link copied!");
}
// SEARCH + SORT + FILTER SYSTEM
const rows = document.querySelectorAll(".ref-row");
const searchInput = document.getElementById("searchInput");
const sortSelect = document.getElementById("sortSelect");
const statusFilter = document.getElementById("statusFilter");

function filterTable() {
    let search = searchInput.value.toLowerCase();
    let status = statusFilter.value;

    rows.forEach(row => {
        let name = row.dataset.name.toLowerCase();
        let phone = row.dataset.phone.toLowerCase();
        let email = row.dataset.email.toLowerCase();
        let rowStatus = row.dataset.status.toLowerCase();

        let matchesSearch =
            name.includes(search) ||
            phone.includes(search) ||
            email.includes(search);

        let matchesStatus = (status === "all" || rowStatus === status);

        row.classList.toggle("hidden", !(matchesSearch && matchesStatus));
    });
}

function sortTable() {
    let sortValue = sortSelect.value;
    let tbody = document.querySelector("tbody");

    let sorted = Array.from(rows).sort((a, b) => {
        if (sortValue === "latest") return new Date(b.dataset.date) - new Date(a.dataset.date);
        if (sortValue === "oldest") return new Date(a.dataset.date) - new Date(b.dataset.date);
        if (sortValue === "status") return a.dataset.status.localeCompare(b.dataset.status);
        if (sortValue === "name") return a.dataset.name.localeCompare(b.dataset.name);
    });

    sorted.forEach(r => tbody.appendChild(r));
}

searchInput.addEventListener("input", filterTable);
statusFilter.addEventListener("change", filterTable);
sortSelect.addEventListener("change", sortTable);

/* ------------------ VIEW MODAL ------------------ */
function openViewModal(name, phone, email, status, date) {
    viewName.innerText = "Name: " + name;
    viewPhone.innerText = "Phone: " + phone;
    viewEmail.innerText = "Email: " + email;
    viewStatus.innerText = "Status: " + status;
    viewDate.innerText = "Date: " + date;

    viewModal.classList.remove("hidden");
}
function closeViewModal() { viewModal.classList.add("hidden"); }

/* ------------------ EDIT MODAL ------------------ */
function openEditModal(name, phone, email, status) {
    editName.value = name;
    editPhone.value = phone;
    editEmail.value = email;
    editStatus.value = status;

    editModal.classList.remove("hidden");
}
function closeEditModal() { editModal.classList.add("hidden"); }

function saveReferral() {
    alert("Referral updated!");
    closeEditModal();
}

/* ------------------ DELETE MODAL ------------------ */
let deleteName = "";

function openDeleteModal(name) {
    deleteName = name;
    deleteText.innerText = `Are you sure you want to delete referral of ${name}?`;

    const modal = document.getElementById("deleteModal");
    modal.classList.remove("hidden");
    modal.classList.add("flex");     // show modal container
    document.body.style.overflow = "hidden";  // prevent scrolling
}


function closeDeleteModal() {
    const modal = document.getElementById("deleteModal");
    modal.classList.add("hidden");
    modal.classList.remove("flex");
    document.body.style.overflow = "";  // restore scroll
}


function confirmDelete() {
    alert("Referral deleted: " + deleteName);
    closeDeleteModal();
}

</script>
@include('components.script')
