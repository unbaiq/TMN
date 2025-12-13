@extends('layouts.app')

@section('content')

<style>
/*-----------------------------------------
 TMN PREMIUM THEME — SAME AS ENQUIRY LIST
------------------------------------------*/

/* Inputs & Select */
input, select {
    transition: all 0.2s ease-in-out;
}
input:focus, select:focus {
    border-color: #e11d48 !important;
    box-shadow: 0 0 0 3px rgba(225,29,72,0.25);
}

/* Card wrapper */
.tmn-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    border: 1px solid #f1f1f1;
    box-shadow: 0px 6px 16px rgba(0,0,0,0.06);
}

/* Premium Table */
table {
    border-radius: 14px;
    overflow: hidden;
}
thead tr {
    background: #f8fafc;
    text-transform: uppercase;
    font-size: 11px;
    color: #6b7280;
}
tbody tr:hover {
    background: #fafafa;
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

<main class="w-full p-2 sm:p-8">
  <div class="max-w-7xl mx-auto animate-fadeIn bg-white shadow-card rounded-xl p-6">

    <div class="mb-6 bg-white shadow-lg rounded-2xl p-6 tmn-card">

        <!-- PAGE HEADER -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-semibold text-[#2C3E50] mb-1">Members List</h2>
            </div>

            <button id="openAddMember"
                    class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl shadow flex items-center gap-2">
                <i data-feather="user-plus" class="w-4"></i> Add Member
            </button>
        </div>

        <!-- ================= FILTERS + TABLE NOW IN ONE CARD ================= -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">

            <!-- Search -->
            <div class="flex items-center gap-2 w-full md:w-1/2 relative">
                <i data-feather="search"
                   class="w-5 h-5 text-gray-500 absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input type="text" id="searchInput" placeholder="Search by name or email..."
                       class="w-full pl-11 pr-4 py-2 bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none">
            </div>

            <!-- Status Filter -->
            <select id="statusFilter"
                    class="px-4 py-2 md:w-1/4 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-red-400 outline-none">
                <option value="">All Status</option>
                <option value="assigned">Assigned</option>
                <option value="not assigned">Not Assigned</option>
            </select>
        </div>

        <!-- ================= TABLE NOW INSIDE FILTER CARD ================= -->
        <div class="overflow-x-auto mt-4">
            <table class="min-w-full border border-gray-200 rounded-lg text-sm">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="py-3 px-4 border text-left">#</th>
                        <th class="py-3 px-4 border text-left">Member</th>
                        <th class="py-3 px-4 border text-left">Contact</th>
                        <th class="py-3 px-4 border text-left">Business / City</th>
                        <th class="py-3 px-4 border text-left">Chapter</th>
                        <th class="py-3 px-4 border text-center">Action</th>
                    </tr>
                </thead>

                <tbody id="membersTbody" class="text-gray-700">

@php
$members = [
    [1, "Ramesh Kumar",   "ramesh@example.com",   "9876543210", "Ramesh Enterprises", "Delhi", "not assigned"],
    [2, "Priya Sharma",   "priya@gmail.com",      "9988776655", "Sharma Designs",     "Mumbai", "assigned"],
    [3, "Amit Verma",     "amitv@gmail.com",      "9090909090", "Verma Consultancy",  "Pune", "not assigned"],
    [4, "Sneha Kapoor",   "sneha@kapoor.com",     "9822113344", "Kapoor Arts",        "Delhi", "assigned"],
    [5, "Arjun Malhotra", "arjun@mtech.com",      "8765432111", "Malhotra Legal",     "Chandigarh", "not assigned"],
    [6, "Neha Singh",     "neha.s@gmail.com",     "9090123456", "Singh Traders",      "Mumbai", "assigned"],
    [7, "Karan Patel",    "karanp@gmail.com",     "9988123456", "Patel Motors",       "Ahmedabad", "not assigned"],
    [8, "Divya Mehta",    "divya@mehta.com",      "9900112233", "Mehta Creations",    "Surat", "not assigned"],
    [9, "Rohit Sharma",   "rohit@biz.com",        "9812345670", "Sharma Marketing",   "Delhi", "assigned"],
    [10,"Harshita Rao",   "harshita@rao.com",     "9123456780", "Rao Foods",          "Hyderabad", "assigned"],
    [11,"Lokesh Kumar",   "lokesh@itpro.com",     "9988123499", "IT Pro Services",    "Bengaluru", "not assigned"],
    [12,"Asha Mehta",     "asha@heal.com",        "9099887766", "Heal Therapy",       "Pune", "assigned"],
    [13,"Rohit Nair",     "rohit.nair@gmail.com", "9876001122", "Nair Logistics",     "Kochi", "not assigned"],
    [14,"Tanvi Shah",     "tanvi@studio.com",     "9000112299", "Studio Tanvi",       "Mumbai", "assigned"],
    [15,"Sagar Thakur",   "sagar@chef.com",       "9555002200", "Thakur Kitchen",     "Indore", "assigned"],
    [16,"Mira Bansal",    "mira@ads.in",          "9900998877", "Bansal Ads",         "Jaipur", "not assigned"],
    [17,"Nikhil Arora",   "nikhil@data.com",      "9700112233", "Data Analytics Pro", "Gurgaon", "assigned"],
    [18,"Simran Kaur",    "simran@hrhub.com",     "9955443322", "HR Hub",             "Amritsar", "not assigned"],
    [19,"Uday Shetty",    "uday@biz.com",         "9988991122", "Shetty Group",       "Mangalore", "assigned"],
    [20,"Pooja Reddy",    "pooja@dentist.com",    "9090776655", "Reddy Dental",       "Hyderabad", "not assigned"],
];
@endphp

@foreach($members as $m)
<tr class="hover:bg-gray-50" data-user-id="{{ $m[0] }}" data-status="{{ strtolower($m[6]) }}">
    
    <!-- Index -->
    <td class="px-4 py-3 border text-gray-700">{{ $m[0] }}</td>

    <!-- Member -->
    <td class="px-4 py-3 border">
        <div class="font-semibold text-gray-800">{{ $m[1] }}</div>
        <div class="text-xs text-gray-500">{{ $m[2] }}</div>
    </td>

    <!-- Contact -->
    <td class="px-4 py-3 border text-gray-700">{{ $m[3] }}</td>

    <!-- Business + City -->
    <td class="px-4 py-3 border text-gray-700 leading-tight">
        {{ $m[4] }} <br>
        <span class="text-xs text-gray-500">{{ $m[5] }}</span>
    </td>

    <!-- Chapter Badge -->
    <td class="chapter-cell border px-4 py-3 text-gray-700" data-status="{{ strtolower($m[6]) }}">
        @if($m[6] === "assigned")
            <span class="px-2 py-1 rounded text-white text-xs bg-red-500 font-medium">Assigned</span>
        @else
            <span class="px-2 py-1 rounded text-gray-700 bg-gray-100 text-xs font-medium">Not Assigned</span>
        @endif
    </td>

    <!-- Action -->
    <td class="px-4 py-3 action-cell text-center">
        <button class="assign-btn px-3 py-1 bg-white border rounded-lg shadow-sm hover:shadow text-sm flex items-center gap-2"
                data-user-id="{{ $m[0] }}"
                data-user-name="{{ $m[1] }}">
            <i data-feather="{{ $m[6] === 'assigned' ? 'repeat' : 'user-plus' }}" class="w-4"></i>
            {{ $m[6] === "assigned" ? "Change" : "Assign" }}
        </button>
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


<!-- =================================================================
                          ASSIGN MODAL
================================================================= -->
<div id="assignModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl modal-card max-w-lg w-full p-6">
        
        <div class="flex justify-between mb-3">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Assign Chapter</h3>
                <p id="modalUser" class="text-sm text-gray-500">Loading…</p>
            </div>
            <button id="modalClose" class="text-gray-400 hover:text-gray-600">✕</button>
        </div>

        <label class="text-sm font-medium text-gray-700 mb-1 block">Select Chapter</label>
        <select id="chapterSelect" class="w-full border rounded-lg px-3 py-2 mb-4 shadow-sm focus:ring-2 focus:ring-red-400 outline-none">
            <option value="">-- Select Chapter --</option>
            <option value="1">Delhi Chapter</option>
            <option value="2">Mumbai Chapter</option>
            <option value="3">Bengaluru Chapter</option>
        </select>

        <div class="flex justify-end gap-3">
            <button id="modalCancel" class="px-4 py-2 bg-gray-200 rounded-lg">Cancel</button>
            <button id="modalSave" class="px-4 py-2 bg-red-600 text-white rounded-lg">Save</button>
        </div>

    </div>
</div>


<!-- =================================================================
                          ADD MEMBER MODAL
================================================================= -->
<div id="addModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl modal-card max-w-2xl w-full p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Add Member</h3>
            <button id="addClose" class="text-gray-400 hover:text-gray-600">✕</button>
        </div>
        <form id="addMemberForm" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Left Column -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Full Name</label>
                <input name="name" required class="mt-1 w-full border rounded px-3 py-2 shadow-sm focus:ring-2 focus:ring-red-400 outline-none">
                <label class="block text-sm font-medium text-gray-700 mt-3">Email</label>
                <input name="email" type="email" required class="mt-1 w-full border rounded px-3 py-2 shadow-sm focus:ring-2 focus:ring-red-400 outline-none">
                <label class="block text-sm font-medium text-gray-700 mt-3">Phone</label>
                <input name="phone" class="mt-1 w-full border rounded px-3 py-2 shadow-sm focus:ring-2 focus:ring-red-400 outline-none">
                <label class="block text-sm font-medium text-gray-700 mt-3">Password</label>
                <input name="password" type="password" required class="mt-1 w-full border rounded px-3 py-2 shadow-sm focus:ring-2 focus:ring-red-400 outline-none">
                <label class="block text-sm font-medium text-gray-700 mt-3">Confirm Password</label>
                <input name="password_confirmation" type="password" required class="mt-1 w-full border rounded px-3 py-2 shadow-sm focus:ring-2 focus:ring-red-400 outline-none">
            </div>
            <!-- Right Column -->
            <div>
                <label class="block text-sm font-medium text-gray-700 ">Business Name</label>
                <input name="business_name" class="mt-1 w-full border rounded px-3 py-2 shadow-sm focus:ring-2 focus:ring-red-400 outline-none">

                <label class="block text-sm font-medium text-gray-700 mt-3">Address</label>
                <input name="address" class="mt-1 w-full border rounded px-3 py-2 shadow-sm focus:ring-2 focus:ring-red-400 outline-none">

                <label class="block text-sm font-medium text-gray-700 mt-3">City</label>
                <input name="city" class="mt-1 w-full border rounded px-3 py-2 shadow-sm focus:ring-2 focus:ring-red-400 outline-none">

                <label class="block text-sm font-medium text-gray-700 mt-3">Pincode</label>
                <input name="pincode" class="mt-1 w-full border rounded px-3 py-2 shadow-sm focus:ring-2 focus:ring-red-400 outline-none  ">

                <label class="block text-sm font-medium text-gray-700 mt-3">Referral Code (Optional)</label>
                <input name="referral_code" class="mt-1 w-full border rounded px-3 py-2 shadow-sm focus:ring-2 focus:ring-red-400 outline-none">
            </div>

            <div class="md:col-span-2 flex justify-end gap-3 mt-2">
                <button type="button" id="addCancel" class="px-4 py-2 bg-gray-200 rounded-lg">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Create Member
                </button>
            </div>

        </form>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", () => {

    /* ---------------------- ELEMENTS ---------------------- */

    const membersTbody = document.getElementById("membersTbody");
    const searchInput = document.getElementById("searchInput");
    const statusFilter = document.getElementById("statusFilter");

    /* ---------------------- ADD MEMBER MODAL ---------------------- */

    const addModal = document.getElementById("addModal");
    const openAddMember = document.getElementById("openAddMember");
    const addClose = document.getElementById("addClose");
    const addCancel = document.getElementById("addCancel");
    const addMemberForm = document.getElementById("addMemberForm");

    /* Open Add Modal */
    openAddMember.addEventListener("click", () => {
        addModal.classList.remove("hidden");
        addModal.classList.add("flex");
    });

    /* Close Add Modal */
    function closeAddModal() {
        addModal.classList.add("hidden");
        addModal.classList.remove("flex");
        addMemberForm.reset();
    }

    addClose.addEventListener("click", closeAddModal);
    addCancel.addEventListener("click", closeAddModal);


    /* ---------------------- SEARCH + FILTER ---------------------- */

    function applyFilters() {
        const q = searchInput.value.toLowerCase().trim();
        const statusVal = statusFilter.value;

        const rows = membersTbody.querySelectorAll("tr");

        rows.forEach(row => {
            const name = row.querySelector("td:nth-child(2) div").innerText.toLowerCase();
            const email = row.querySelector("td:nth-child(2) div.text-xs").innerText.toLowerCase();
            const chapterStatus = row.querySelector(".chapter-cell").dataset.status;

            const matchesSearch =
                name.includes(q) ||
                email.includes(q);

            const matchesStatus =
                statusVal === "" || statusVal === chapterStatus;

            row.classList.toggle("hidden", !(matchesSearch && matchesStatus));
        });
    }

    searchInput.addEventListener("input", applyFilters);
    statusFilter.addEventListener("change", applyFilters);


    /* ---------------------- ADD MEMBER: FORM SUBMIT ---------------------- */
    addMemberForm.addEventListener("submit", (e) => {
        e.preventDefault();

        const form = new FormData(addMemberForm);
        const fullName = form.get("name");
        const email = form.get("email");
        const phone = form.get("phone") || "—";
        const business = form.get("business_name") || "—";
        const city = form.get("city") || "—";
        const password = form.get("password");
        const confirmPassword = form.get("password_confirmation");

        /* PASSWORD VALIDATION */
        if (password.length < 6) {
            alert("Password must be at least 6 characters.");
            return;
        }
        if (password !== confirmPassword) {
            alert("Passwords do not match.");
            return;
        }

        const newId = Date.now(); // temp ID

        /* Create new row */
        const tr = document.createElement("tr");
        tr.className = "hover:bg-gray-50";
        tr.setAttribute("data-user-id", newId);
        tr.setAttribute("data-status", "not assigned");

        tr.innerHTML = `
            <td class="px-4 py-3 text-gray-700">NEW</td>

            <td class="px-4 py-3">
                <div class="font-semibold text-gray-800">${fullName}</div>
                <div class="text-xs text-gray-500">${email}</div>
            </td>

            <td class="px-4 py-3 text-gray-700">${phone}</td>

            <td class="px-4 py-3 text-gray-700 leading-tight">
                ${business}<br>
                <span class="text-xs text-gray-500">${city}</span>
            </td>

            <td class="chapter-cell" data-status="not assigned">
                <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-xs">
                    Not Assigned
                </span>
            </td>

            <td class="px-4 py-3 action-cell text-center">
                <button class="assign-btn px-3 py-1 bg-white border rounded-lg shadow-sm hover:shadow text-sm flex items-center gap-2"
                        data-user-id="${newId}"
                        data-user-name="${fullName}">
                    <i data-feather="user-plus" class="w-4"></i> Assign
                </button>
            </td>
        `;

        /* Add row to table */
        membersTbody.prepend(tr);

        /* Re-run icons */
        feather.replace();

        /* Attach assign handler to new row */
        attachAssignHandler(tr.querySelector(".assign-btn"));

        /* Close modal */
        closeAddModal();
    });


    /* ---------------------- ASSIGN CHAPTER MODAL ---------------------- */

    const assignModal = document.getElementById("assignModal");
    const modalUser = document.getElementById("modalUser");
    const modalClose = document.getElementById("modalClose");
    const modalCancel = document.getElementById("modalCancel");
    const modalSave = document.getElementById("modalSave");
    const chapterSelect = document.getElementById("chapterSelect");

    let selectedUserId = null;

    function attachAssignHandler(button) {
        button.addEventListener("click", () => {
            selectedUserId = button.dataset.userId;
            modalUser.innerText = "Assign chapter for: " + button.dataset.userName;
            assignModal.classList.remove("hidden");
            assignModal.classList.add("flex");
        });
    }

    /* Attach to existing buttons */
    document.querySelectorAll(".assign-btn").forEach(attachAssignHandler);


    /* Close Assign Modal */
    function closeAssignModal() {
        assignModal.classList.add("hidden");
        chapterSelect.value = "";
    }

    modalClose.addEventListener("click", closeAssignModal);
    modalCancel.addEventListener("click", closeAssignModal);


    /* Save Assignment */
    modalSave.addEventListener("click", () => {
        if (!selectedUserId) return;

        const row = document.querySelector(`tr[data-user-id="${selectedUserId}"]`);
        const chapterCell = row.querySelector(".chapter-cell");

        chapterCell.dataset.status = "assigned";
        chapterCell.innerHTML = `
            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs">
                Assigned
            </span>
        `;

        const btn = row.querySelector(".assign-btn");
        btn.innerHTML = `<i data-feather="repeat" class="w-4"></i> Change`;
        feather.replace();

        closeAssignModal();
        applyFilters();
    });

});
</script>
@endsection
