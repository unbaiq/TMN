@extends('layouts.app')

@section('content')
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
  <!-- MAIN CONTENT -->
<main class="w-full p-2 h-full sm:p-8 ">
      <div class="max-w-7xl mx-auto animate-fadeIn bg-white shadow-card rounded-xl p-6">
        <div class="max-w-7xl mx-auto my-10 px-4 sm:px-6 lg:px-8">
    <!-- PAGE TITLE -->
    <h2 class="text-2xl font-semibold text-[#2C3E50] mb-6">My Referrals</h2>
    <!-- SHARE REFERRAL LINK BOX -->
    <div class="bg-white shadow-md rounded-xl p-4 mb-6 border border-gray-100">
        <h3 class="text-lg font-semibold text-[#2C3E50] mb-3">Invite Members to TMN</h3>
        <div class="flex flex-col sm:flex-row sm:items-center gap-3">
            <input id="referralLink" type="text" readonly value="https://tmn.com/referral/ABC123"class="flex-1 px-4 py-2 border rounded-lg bg-gray-50 text-gray-700 focus:ring-2 focus:ring-red-400 outline-none">
            <button onclick="copyReferralLink()"class="px-4 py-2 bg-[#2C3E50] hover:bg-[#1B2631] text-white rounded-lg flex items-center gap-2 ">
                <i data-feather="copy" class="w-4"></i> Copy Link
            </button>
        </div>
    </div>
    <!-- REFERRALS TABLE & CARDS -->
    <div class="bg-white shadow-lg rounded-2xl p-6">
        <h3 class="text-lg font-semibold text-[#2C3E50]">Referral History</h3>
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-5">
    <!-- Search -->
    <div class="flex items-center gap-2 w-full md:w-1/2 relative">
        <i data-feather="search" class="w-5 h-5 text-gray-500 absolute left-3 top-1/2 -translate-y-1/2"></i>
        <input type="text" id="searchInput" placeholder="Search by name, phone or email..." class="w-full pl-11 pr-4 py-2 bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none">
            </div>
    <!-- Status Filter -->
    <select id="statusFilter" class="px-4 py-2 md:w-1/4 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-red-400 outline-none">
    <option value="all">All Status</option>
    <option value="pending">Pending Referrals</option>
    <option value="converted">Converted Referrals</option>
    <option value="rejected">Rejected Referrals</option>
   </select>
</div>
<!-- REFERRALS TABLE -->
<div class="overflow-x-auto">
    <table class="min-w-full border border-gray-200 rounded-lg text-sm">
        <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-semibold">
            <tr>
                <th class="py-3 px-4 border text-left">Name</th>
                <th class="py-3 px-4 border text-left">Phone</th>
                <th class="py-3 px-4 border text-left">Email</th>
                <th class="py-3 px-4 border text-left">Status</th>
                <th class="py-3 px-4 border text-left">Date</th>
                <th class="py-3 px-4 border text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-700">
            <tr class=" hover:bg-gray-50" data-name="Rahul Sharma" data-phone="9876543210" data-email="" data-status="pending" data-date="2025-12-10">
                <td class="py-3 px-4 border font-medium text-gray-800">Rahul Sharma</td>
                <td class="py-3 px-4 border text-gray-600">+91 9876543210</td>
                <td class="py-3 px-4 border text-gray-600">—</td>
                <td class="py-3 px-4 border">
                    <span class="px-2 py-1 rounded text-white text-xs bg-yellow-500">
                        Pending
                    </span>
                </td>
                <td class="py-3 px-4 border text-gray-600 text-sm">10 Dec 2025</td>
                <td class="py-3 px-4 border text-right space-x-1 whitespace-nowrap">
                    <button class="text-blue-600 hover:underline text-sm font-semibold" onclick="openViewModal('Rahul Sharma','9876543210','—','Pending','10 Dec 2025')">
                        View
                    </button>
                    <button class="text-green-600 hover:underline text-sm font-semibold" onclick="openEditModal('Rahul Sharma','9876543210','—','pending')">
                        Edit
                    </button>
                    <button class="text-red-600 hover:underline text-sm font-semibold" onclick="openDeleteModal('Rahul Sharma')">
                        Delete
                    </button>
                </td>
            </tr>
            <tr class=" hover:bg-gray-50" data-name="Priya Verma" data-phone="" data-email="priya@example.com" data-status="converted" data-date="2025-12-08">
                <td class="py-3 px-4 border font-medium text-gray-800">Priya Verma</td>
                <td class="py-3 px-4 border text-gray-600">—</td>
                <td class="py-3 px-4 border text-gray-600">priya@example.com</td>
                <td class="py-3 px-4 border">
                    <span class=" px-2 py-1 rounded text-white text-xs bg-green-500">
                        Converted
                    </span>
                </td>
                <td class="py-3 px-4 border text-gray-600 text-sm">8 Dec 2025</td>
                <!-- ACTIONS -->
                <td class="py-3 px-4 border text-right space-x-1 whitespace-nowrap">
                    <button class="text-blue-600 hover:underline text-sm font-semibold" onclick="openViewModal('Priya Verma','—','priya@example.com','Converted','8 Dec 2025')">
                        View
                    </button>
                    <button class="text-green-600 hover:underline text-sm font-semibold" onclick="openEditModal('Priya Verma','—','priya@example.com','converted')">
                        Edit
                    </button>
                    <button class="text-red-600 hover:underline text-sm font-semibold" onclick="openDeleteModal('Priya Verma')">
                        Delete
                    </button>
                </td>
            </tr>
            <tr class="hover:bg-gray-50" data-name="Sameer Patel" data-phone="9988776655" data-email="sameer@example.com" data-status="rejected" data-date="2025-12-05">
                <td class="py-3 px-4 border font-medium text-gray-800">Sameer Patel</td>
                <td class="py-3 px-4 border text-gray-600">+91 9988776655</td>
                <td class="py-3 px-4 border text-gray-600">—</td>
                <td class="py-3 px-4 border">
                    <span class="px-2 py-1 rounded text-white text-xs bg-red-500">
                        Rejected
                    </span>
                </td>
                <td class="py-3 px-4 border text-gray-600 text-sm">5 Dec 2025</td>
                <!-- ACTIONS -->
                <td class="py-3 px-4 border text-right space-x-1 whitespace-nowrap">
                    <button class="text-blue-600 hover:underline text-sm font-semibold"onclick="openViewModal('Sameer Patel','9988776655','—','Rejected','5 Dec 2025')">
                        View
                    </button>
                    <button class="text-green-600 hover:underline text-sm font-semibold"onclick="openEditModal('Sameer Patel','9988776655','—','rejected')">
                        Edit
                    </button>
                    <button class="text-red-600 hover:underline text-sm font-semibold"onclick="openDeleteModal('Sameer Patel')">
                        Delete
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<!-- Pagination -->
        <div class="mt-6">
            <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        <div class="flex justify-between flex-1 sm:hidden">
                            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md dark:text-gray-600 dark:bg-gray-800 dark:border-gray-600">
                    &laquo; Previous
                </span>
            
                            <a href="https://instakare.in/helpdesk/dashboard?page=2" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300">
                    Next &raquo;
                </a>
                    </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700 leading-5 dark:text-gray-400">
                    Showing
                                            <span class="font-medium">1</span>
                        to
                        <span class="font-medium">10</span>
                                        of
                    <span class="font-medium">13</span>
                    results
                </p>
            </div>
            <div>
                <span class="relative z-0 inline-flex rtl:flex-row-reverse shadow-sm rounded-md">
                    
                                            <span aria-disabled="true" aria-label="&amp;laquo; Previous">
                            <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5 dark:bg-gray-800 dark:border-gray-600" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    
                    
                                            
                        
                        
                                                                                                                        <span aria-current="page">
                                        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 dark:bg-gray-800 dark:border-gray-600">1</span>
                                    </span>
                                                                                                                                <a href="#" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:text-gray-300 dark:active:bg-gray-700 dark:focus:border-blue-800" aria-label="Go to page 2">
                                        2
                                    </a>
                                            <a href="#" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:active:bg-gray-700 dark:focus:border-blue-800" aria-label="Next &amp;raquo;">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                                    </span>
            </div>
             </nav>
        </div>
    </div>
</div>
</main>
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
const rows = document.querySelectorAll("tbody tr");
const searchInput = document.getElementById("searchInput");
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

searchInput.addEventListener("input", filterTable);
statusFilter.addEventListener("change", filterTable);

/* ------------------ VIEW MODAL ------------------ */
function openViewModal(name, phone, email, status, date) {
    viewName.innerText = "Name: " + name;
    viewPhone.innerText = "Phone: " + phone;
    viewEmail.innerText = "Email: " + email;
    viewStatus.innerText = "Status: " + status;
    viewDate.innerText = "Date: " + date;

    viewModal.classList.remove("hidden");
    viewModal.classList.add("flex");
function closeViewModal() { 
    viewModal.classList.add("hidden");
    viewModal.classList.remove("flex");
}
function closeViewModal() { viewModal.classList.add("hidden"); }

/* ------------------ VIEW MODAL ------------------ */
function openViewModal(name, phone, email, status, date) {
    viewName.innerText = "Name: " + name;
    viewPhone.innerText = "Phone: " + phone;
    viewEmail.innerText = "Email: " + email;
    viewStatus.innerText = "Status: " + status;
    viewDate.innerText = "Date: " + date;

    viewModal.classList.remove("hidden");
    viewModal.classList.add("flex");
}

function closeViewModal() { 
    viewModal.classList.add("hidden");
    viewModal.classList.remove("flex");
}

/* ------------------ EDIT MODAL ------------------ */
function openEditModal(name, phone, email, status) {
    editName.value = name;
    editPhone.value = phone;
    editEmail.value = email;
    editStatus.value = status;

    editModal.classList.remove("hidden");
    editModal.classList.add("flex");
}

function closeEditModal() { 
    editModal.classList.add("hidden");
    editModal.classList.remove("flex");
}
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
@endsection