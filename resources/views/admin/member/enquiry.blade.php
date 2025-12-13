@extends('layouts.app')

@section('content')

<style>
/*-----------------------------------------
 TMN PREMIUM THEME (MATCHED TO REFERRALS UI)
------------------------------------------*/

/* Navigation highlight */
.nav-active {
    background: linear-gradient(to right, #ffe6e6, #ffffff);
    border-right: 4px solid #e53935;
    box-shadow: inset 0 0 10px rgba(229, 57, 53, 0.15);
}

/* Sidebar nav item hover */
.nav-item {
    border-radius: 0.75rem;
    transition: all 0.25s ease;
}
.nav-item:hover {
    background: rgba(255, 0, 0, 0.08);
    transform: translateX(6px);
}

/* Inputs */
input, select {
    transition: all 0.2s ease-in-out;
}
input:focus, select:focus {
    border-color: #e11d48 !important;
    box-shadow: 0 0 0 3px rgba(225,29,72,0.25);
}

/* Main Cards */
.tmn-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    border: 1px solid #f1f1f1;
    box-shadow: 0px 6px 16px rgba(0,0,0,0.06);
}

/* Modern table */
table {
    border-radius: 14px;
    overflow: hidden;
}
thead tr {
    background: #f8fafc;
}
tbody tr:hover {
    background: #fafafa;
}

/* Status Badges */
.badge-new {
    background: #fff7d1 !important;
    color: #8a6c00;
}
.badge-closed {
    background: #d9fbe5 !important;
    color: #137333;
}

/* Action Menu */
.status-menu {
    box-shadow: 0px 4px 16px rgba(0,0,0,0.08);
    border-radius: 10px;
}
.statusBtn:hover {
    transform: translateY(-2px);
    transition: 0.25s ease;
}

/* Modal Animation */
.modal-card {
    animation: modalPop 0.22s ease-out;
}
@keyframes modalPop {
    from { opacity: 0; transform: translateY(10px) scale(0.95); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}
</style>
<!-- Main Content -->
<main class="w-full p-2 sm:p-8">
  <div class="max-w-7xl mx-auto animate-fadeIn bg-white shadow-card rounded-xl p-6">
   <div class="  mb-6 bg-white shadow-lg rounded-2xl p-6">
    <h3 class="text-xl font-semibold mb-6 text-gray-700">Enquiry List</h3>
    <!-- FILTERS -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
        <!-- Search -->
        <div class="flex items-center gap-2 w-full md:w-1/2 relative">
            <i data-feather="search" class="w-5 h-5 text-gray-500 absolute left-3 top-1/2 -translate-y-1/2"></i>
            <input type="text" id="searchInput" placeholder="Search by name, email, profession..." class="w-full pl-11 pr-4 py-2 bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none">
        </div>
        <!-- Status Filter -->
        <select id="statusFilter"
                class="px-4 py-2 md:w-1/4 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-red-400 outline-none">
            <option value="">All Status</option>
            <option value="new">New</option>
            <option value="closed">Closed</option>
        </select>
    </div>
    <!-- TABLE -->
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-semibold">
                <tr>
                    <th class="py-3 px-4 border text-left">#</th>
                    <th class="py-3 px-4 border text-left">Name</th>
                    <th class="py-3 px-4 border text-left">Email</th>
                    <th class="py-3 px-4 border text-left">Phone</th>
                    <th class="py-3 px-4 border text-left">Profession</th>
                    <th class="py-3 px-4 border text-left">Status</th>
                    <th class="py-3 px-4 border text-right">Actions</th>
                </tr>
            </thead>
            <tbody id="rowsContainer" class="text-gray-700">
@php
$dummy = [
    ["Ravi Sharma", "ravi@example.com", "9876543210", "Doctor", "new"],
    ["Aditi Verma", "aditi@example.com", "9988776655", "Engineer", "closed"],
    ["Mohit Jain", "mohit@example.com", "9090909090", "Teacher", "new"],
    ["Sneha Kapoor", "sneha@example.com", "9922113344", "Architect", "new"],
    ["Arjun Malhotra", "arjun@example.com", "8765432109", "Lawyer", "closed"],
    ["Priya Singh", "priya@example.com", "9090901212", "Consultant", "new"],
    ["Manish Patel", "manish@example.com", "9887766554", "Entrepreneur", "new"],
    ["Kiran Desai", "kiran@example.com", "9900112233", "Artist", "closed"],
    ["Deepak Yadav", "deepak@example.com", "9812345678", "Professor", "new"],
    ["Harshita Rao", "harshita@example.com", "9123456780", "Writer", "closed"],
    ["Lokesh Kumar", "lokesh@example.com", "9988123456", "IT Specialist", "new"],
    ["Asha Mehta", "asha@example.com", "9099887766", "Therapist", "closed"],
    ["Rohit Nair", "rohit@example.com", "9876001122", "Manager", "new"],
    ["Tanvi Shah", "tanvi@example.com", "9000112233", "Designer", "new"],
    ["Sagar Thakur", "sagar@example.com", "9555122233", "Chef", "closed"],
    ["Mira Bansal", "mira@example.com", "9900998877", "Marketer", "new"],
    ["Nikhil Arora", "nikhil@example.com", "9700112233", "Data Analyst", "closed"],
    ["Simran Kaur", "simran@example.com", "9955443322", "HR Specialist", "new"],
    ["Uday Shetty", "uday@example.com", "9988991122", "Business Owner", "closed"],
    ["Pooja Reddy", "pooja@example.com", "9090776655", "Dentist", "new"],
];
@endphp
@foreach($dummy as $i => $d)
<tr class="hover:bg-gray-50"
    data-name="{{ strtolower($d[0]) }}"
    data-email="{{ strtolower($d[1]) }}"
    data-phone="{{ strtolower($d[2]) }}"
    data-profession="{{ strtolower($d[3]) }}"
    data-status="{{ strtolower($d[4]) }}"
>
    <td class="py-3 px-4 border text-gray-600">{{ $i+1 }}</td>
    <td class="py-3 px-4 border font-medium text-gray-800">{{ $d[0] }}</td>
    <td class="py-3 px-4 border text-gray-600">{{ $d[1] }}</td>
    <td class="py-3 px-4 border text-gray-600">{{ $d[2] }}</td>
    <td class="py-3 px-4 border text-gray-600">{{ $d[3] }}</td>
    <td class="py-3 px-4 border">
        @if($d[4] === "new")
            <span class="px-2 py-1 rounded text-white text-xs bg-green-500">New</span>
        @else
            <span class="px-2 py-1 rounded text-white text-xs bg-red-500">Closed</span>
        @endif
    </td>

    <td class="py-3 px-4 border text-right space-x-2">
  <button class="viewBtn text-blue-600 hover:underline text-sm font-semibold" data-index="{{ $i }}">View</button>
  <button class="editBtn text-green-600 hover:underline text-sm font-semibold" data-index="{{ $i }}">Edit</button>
  <button class="deleteBtn text-red-600 hover:underline text-sm font-semibold" data-index="{{ $i }}">Delete</button>
</td>
</tr>
@endforeach
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
                  <a href="#" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300">
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
<!-- MODAL -->
 <!-- VIEW MODAL -->
<div id="viewModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl modal-card max-w-md w-full mx-4 p-6">

        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Enquiry Details</h3>
            <button id="closeViewX" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>

        <div id="modalBody" class="text-sm text-gray-700 space-y-2"></div>

        <div class="mt-4 flex justify-end">
            <button id="closeViewBtn" class="px-4 py-2 bg-red-600 text-white rounded">
                Close
            </button>
        </div>

    </div>
</div>
<!-- EDIT MODAL -->
<div id="editModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
  <div class="bg-white rounded-xl shadow-xl modal-card max-w-lg w-full mx-4 p-6">
      <h3 class="text-lg font-semibold mb-4">Edit Enquiry</h3>

      <input type="hidden" id="editIndex">

      <div class="grid gap-3 text-sm">
          <input id="editName" class="border p-2 rounded" placeholder="Name">
          <input id="editEmail" class="border p-2 rounded" placeholder="Email">
          <input id="editPhone" class="border p-2 rounded" placeholder="Phone">
          <input id="editProfession" class="border p-2 rounded" placeholder="Profession">

          <select id="editStatus" class="border p-2 rounded">
              <option value="new">New</option>
              <option value="closed">Closed</option>
          </select>
      </div>

      <div class="mt-4 flex justify-end gap-2">
          <button class="px-3 py-2 bg-gray-200 rounded" id="closeEditBtn">Cancel</button>
          <button class="px-3 py-2 bg-red-600 text-white rounded" id="saveEditBtn">Save</button>
      </div>
  </div>
</div>
<!-- DELETE MODAL -->
<div id="deleteModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
  <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6 modal-card">
      <h3 class="text-lg font-semibold mb-3">Delete Enquiry</h3>
      <p class="text-gray-600 mb-4">Are you sure you want to delete this enquiry?</p>

      <input type="hidden" id="deleteIndex">

      <div class="flex justify-end gap-3">
          <button id="closeDeleteBtn" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
          <button id="confirmDeleteBtn" class="px-4 py-2 bg-red-600 text-white rounded">Delete</button>
      </div>
  </div>
</div>
<!-- SCRIPTS -->
<script>
document.addEventListener("DOMContentLoaded", () => {

    /* ----------------------------------------------------
       SELECTORS
    ---------------------------------------------------- */
    const rowsContainer = document.getElementById("rowsContainer");
    const searchInput = document.getElementById("searchInput");
    const statusFilter = document.getElementById("statusFilter");

    const showStart = document.getElementById("showStart");
    const showEnd = document.getElementById("showEnd");
    const totalCount = document.getElementById("totalCount");

    /* ----------- View Modal Elements ----------- */
    const viewModal = document.getElementById("viewModal");
    const modalBody = document.getElementById("modalBody");
    const closeViewX = document.getElementById("closeViewX");
    const closeViewBtn = document.getElementById("closeViewBtn");

    /* ----------- Edit Modal Elements ----------- */
    const editModal = document.getElementById("editModal");
    const editIndexEl = document.getElementById("editIndex");
    const editName = document.getElementById("editName");
    const editEmail = document.getElementById("editEmail");
    const editPhone = document.getElementById("editPhone");
    const editProfession = document.getElementById("editProfession");
    const editStatus = document.getElementById("editStatus");
    const closeEditBtn = document.getElementById("closeEditBtn");
    const saveEditBtn = document.getElementById("saveEditBtn");

    /* ----------- Delete Modal Elements ----------- */
    const deleteModal = document.getElementById("deleteModal");
    const deleteIndexEl = document.getElementById("deleteIndex");
    const closeDeleteBtn = document.getElementById("closeDeleteBtn");
    const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");


    /* ----------------------------------------------------
       HELPERS
    ---------------------------------------------------- */

    function getRows() {
        return Array.from(rowsContainer.querySelectorAll("tr"));
    }

    function refreshRowIndexes() {
        const rows = getRows();

        rows.forEach((row, idx) => {
            row.querySelector("td").innerText = idx + 1;

            row.querySelectorAll(".viewBtn, .editBtn, .deleteBtn").forEach(btn => {
                btn.dataset.index = idx;
            });
        });

        if (totalCount) totalCount.innerText = rows.length;
    }


    /* ----------------------------------------------------
       FILTER FUNCTION
    ---------------------------------------------------- */
    function applyFilters() {
        const q = searchInput.value.toLowerCase().trim();
        const s = statusFilter.value.trim();

        const rows = getRows();
        let count = 0;

        rows.forEach(row => {
            const name = row.dataset.name;
            const email = row.dataset.email;
            const phone = row.dataset.phone;
            const profession = row.dataset.profession;
            const status = row.dataset.status;

            const matchesSearch =
                name.includes(q) ||
                email.includes(q) ||
                phone.includes(q) ||
                profession.includes(q);

            const matchesStatus = (s === "" || s === status);

            if (matchesSearch && matchesStatus) {
                row.classList.remove("hidden");
                count++;
            } else {
                row.classList.add("hidden");
            }
        });

        showStart.innerText = count > 0 ? 1 : 0;
        showEnd.innerText = count;
    }

    searchInput.addEventListener("input", applyFilters);
    statusFilter.addEventListener("change", applyFilters);


    /* ----------------------------------------------------
       EVENT DELEGATION (View, Edit, Delete)
    ---------------------------------------------------- */
    rowsContainer.addEventListener("click", (ev) => {

        const viewBtn = ev.target.closest(".viewBtn");
        const editBtn = ev.target.closest(".editBtn");
        const deleteBtn = ev.target.closest(".deleteBtn");

        /* ---------- VIEW ---------- */
        if (viewBtn) {
            const index = viewBtn.dataset.index;
            const row = getRows()[index];

            modalBody.innerHTML = `
                <p><strong>Name:</strong> ${row.children[1].innerText}</p>
                <p><strong>Email:</strong> ${row.children[2].innerText}</p>
                <p><strong>Phone:</strong> ${row.children[3].innerText}</p>
                <p><strong>Profession:</strong> ${row.children[4].innerText}</p>
                <p><strong>Status:</strong> ${row.children[5].innerText}</p>
            `;

            viewModal.classList.remove("hidden");
            viewModal.classList.add("flex");
        }

        /* ---------- EDIT ---------- */
        if (editBtn) {
            const index = editBtn.dataset.index;
            const row = getRows()[index];

            editIndexEl.value = index;
            editName.value = row.children[1].innerText;
            editEmail.value = row.children[2].innerText;
            editPhone.value = row.children[3].innerText;
            editProfession.value = row.children[4].innerText;
            editStatus.value = row.dataset.status;

            editModal.classList.remove("hidden");
            editModal.classList.add("flex");
        }

        /* ---------- DELETE ---------- */
        if (deleteBtn) {
            deleteIndexEl.value = deleteBtn.dataset.index;
            deleteModal.classList.remove("hidden");
            deleteModal.classList.add("flex");
        }
    });


    /* ----------------------------------------------------
       VIEW MODAL CLOSE
    ---------------------------------------------------- */
    closeViewX.addEventListener("click", () => viewModal.classList.add("hidden"));
    closeViewBtn.addEventListener("click", () => viewModal.classList.add("hidden"));


    /* ----------------------------------------------------
       SAVE EDIT
    ---------------------------------------------------- */
    saveEditBtn.addEventListener("click", () => {
        const index = editIndexEl.value;
        const row = getRows()[index];

        row.children[1].innerText = editName.value;
        row.children[2].innerText = editEmail.value;
        row.children[3].innerText = editPhone.value;
        row.children[4].innerText = editProfession.value;

        row.dataset.name = editName.value.toLowerCase();
        row.dataset.email = editEmail.value.toLowerCase();
        row.dataset.phone = editPhone.value.toLowerCase();
        row.dataset.profession = editProfession.value.toLowerCase();
        row.dataset.status = editStatus.value;

        row.children[5].innerHTML =
            editStatus.value === "new"
                ? '<span class="px-2 py-1 rounded text-white text-xs bg-green-500">New</span>'
                : '<span class="px-2 py-1 rounded text-white text-xs bg-red-500">Closed</span>';

        editModal.classList.add("hidden");

        refreshRowIndexes();
        applyFilters();
    });


    /* ----------------------------------------------------
       DELETE CONFIRM
    ---------------------------------------------------- */
    confirmDeleteBtn.addEventListener("click", () => {
        const index = deleteIndexEl.value;
        const row = getRows()[index];

        if (row) row.remove();

        deleteModal.classList.add("hidden");

        refreshRowIndexes();
        applyFilters();
    });

    closeDeleteBtn.addEventListener("click", () => deleteModal.classList.add("hidden"));


    /* ----------------------------------------------------
       INITIALIZE
    ---------------------------------------------------- */
    refreshRowIndexes();
    applyFilters();
});
</script>
@endsection
