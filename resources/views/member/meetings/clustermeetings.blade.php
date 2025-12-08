@extends('layouts.app')

@section('content')
  <style>
    /* Sidebar/Header shared styles (taken from your last layout) */
    .nav-active {
      background: linear-gradient(to right, #ffe6e6, #ffffff);
      border-right: 4px solid #e53935;
      box-shadow: inset 0 0 10px rgba(229, 57, 53, 0.15);
    }
    .nav-item:hover { transform: translateX(4px); transition: .2s; }
    .dropdown-hidden { display:none; }
    .dropdown-visible { display:block !important; opacity:1 !important; transform:scale(1) !important; }
    .sidebar-scrollbar::-webkit-scrollbar { width: 8px; }
    .sidebar-scrollbar::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.12); border-radius:9999px; }
    .mobile-slide { transform: translateX(-100%); transition: transform 240ms ease-in-out; }
    .mobile-open { transform: translateX(0); }

    /* small UI chips */
    .status-chip{ padding:4px 10px; font-size:12px; border-radius:9999px; display:inline-block; }
    .s-upcoming{ background:#e6f4ff; color:#0f172a; } /* upcoming */
    .s-past{ background:#f3f4f6; color:#374151; } /* past */
    .s-cancelled{ background:#fee2e2; color:#991b1b; } /* cancelled */

    /* modal helpers */
    .modal-hidden{ display:none; }
    .modal-show{ display:flex !important; }

    /* analytics bars */
    .bar-bg{ background:#f1f5f9; height:10px; border-radius:999px; overflow:hidden; }
    .bar-fill{ height:100%; border-radius:999px; background:linear-gradient(90deg,#16a34a,#34d399); }

    /* small mobile card tweaks */
    @media (max-width:767px){
      .hide-sm { display:none; }
      .show-sm { display:block; }
    }
    @media (min-width:768px){
      .hide-md { display:none; }
      .show-md { display:block; }
    }
    /* ================================
   PREMIUM UI UPGRADE (MATCHES YOUR PREVIOUS PAGES)
   ================================ */

/* Sidebar Items */
.nav-item {
  border-radius: 12px;
  padding: 10px 14px;
  transition: 0.25s ease;
}
.nav-item:hover {
  background: rgba(230, 57, 53, 0.09);
  transform: translateX(6px);
}

/* Active Nav Item */
.nav-active {
  background: linear-gradient(to right, #ffe5e5, #ffffff);
  border-right: 4px solid #e53935 !important;
  box-shadow: inset 0 0 10px rgba(229, 57, 53, 0.15);
  border-radius: 12px;
}

/* ------------------------------
   TABLE UPGRADE
------------------------------ */
table {
  border-spacing: 0;
  width: 100%;
}

thead tr {
  background: #f7f7f7;
}

th {
  font-weight: 600;
  color: #2C3E50;
  font-size: 14px;
}

td {
  font-size: 15px;
  color: #2C3E50;
}

tbody tr {
  transition: 0.2s ease;
}

tbody tr:hover {
  background: #f9fafb;
}

/* Actions column buttons */
.viewClusterBtn,
.manageBtn {
  transition: 0.2s;
}
.viewClusterBtn:hover {
  background: #1a242f !important;
}

/* ------------------------------
   CARDS UI (Mobile Cards)
------------------------------ */
#mobileCards > div {
  border-radius: 18px;
  background: white;
  border: 1px solid #e5e7eb;
  box-shadow: 0 4px 12px rgba(0,0,0,0.06);
  transition: 0.25s ease;
}
#mobileCards > div:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 16px rgba(0,0,0,0.10);
}

/* ------------------------------
   STATUS CHIPS
------------------------------ */
.status-chip {
  padding: 5px 12px;
  border-radius: 50px;
  font-size: 12px;
  font-weight: 600;
}
.s-upcoming { background:#e0f2fe; color:#075985; }
.s-past { background:#f3f4f6; color:#374151; }
.s-cancelled { background:#fee2e2; color:#991b1b; }

/* ------------------------------
   MODAL UI UPGRADE
------------------------------ */
.modal-show {
  display: flex !important;
  align-items: center;
  justify-content: center;
}

.modal-show > div {
  animation: popIn 0.25s ease;
}

@keyframes popIn {
  from { transform: scale(0.9); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}

#viewClusterModal > div,
#newClusterModal > div {
  border-radius: 20px;
  border: 1px solid #ececec;
  box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

/* Inputs */
input, select, textarea {
  border-radius: 10px !important;
  border: 1px solid #d1d5db !important;
}
input:focus, select:focus, textarea:focus {
  box-shadow: 0 0 0 2px rgba(44,62,80,0.3) !important;
  border-color: #2C3E50 !important;
}

/* Buttons */
button {
  transition: 0.25s ease;
}
button:hover {
  opacity: 0.9;
}

/* New Cluster Button */
#newClusterBtn {
  border-radius: 12px;
  padding: 10px 16px;
  font-weight: 500;
  box-shadow: 0px 4px 12px rgba(0,0,0,0.08);
}
#newClusterBtn:hover {
  background: #1B2631 !important;
}

/* Analytics Cards */
#analyticsArea .p-4 {
  border-radius: 14px;
  transition: 0.25s;
}
#analyticsArea .p-4:hover {
  background: #f9fafb;
}

/* Attendance bar */
.bar-bg {
  background: #e5e7eb !important;
}
.bar-fill {
  background: linear-gradient(90deg, #2ecc71, #27ae60) !important;
}

/* Pagination */
#prevPage, #nextPage {
  border-radius: 10px;
  padding: 6px 12px;
  font-size: 14px;
  transition: 0.2s;
}
#prevPage:hover, #nextPage:hover {
  background: #f1f5f9;
}

  </style>
  <!-- MAIN -->
    <main class="p-6 sm:p-10">
      <!-- Page toolbar -->
      <div class="flex flex-col lg:flex-row gap-4 justify-between items-start mb-6">
        <div class="flex gap-3 flex-1">
          <div class="relative flex-1">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i data-feather="search" class="w-4 h-4"></i></span>
            <input id="searchInput" type="text" placeholder="Search meeting title / host / venue..." class="w-full pl-10 pr-4 py-2 border rounded-xl bg-white">
          </div>
          <select id="filterType" class="px-3 py-2 border rounded-xl bg-white">
            <option value="all">All</option>
            <option value="upcoming">Upcoming</option>
            <option value="past">Past</option>
            <option value="cancelled">Cancelled</option>
          </select>
          <input id="fromDate" type="date" class="px-3 py-2 border rounded-xl bg-white" />
          <input id="toDate" type="date" class="px-3 py-2 border rounded-xl bg-white" />
        </div>
      </div>
      <!-- Tabs content area -->
      <div id="listArea" class="bg-white rounded-xl shadow p-4 border">
        <!-- Desktop table -->
        <div class="hidden md:block overflow-x-auto">
          <table class="w-full table-auto border-collapse">
            <thead>
              <tr class="text-left bg-gray-100 text-sm text-gray-700">
                <th class="py-3 px-4">Title</th>
                <th class="py-3 px-4">Host</th>
                <th class="py-3 px-4">Venue</th>
                <th class="py-3 px-4">Date</th>
                <th class="py-3 px-4">Participants</th>
                <th class="py-3 px-4">Status</th>
                <th class="py-3 px-4 text-right">Actions</th>
              </tr>
            </thead>
            <tbody id="clusterTbody">
              <!-- rows populated by JS -->
            </tbody>
          </table>
        </div>

        <!-- Mobile cards -->
        <div id="mobileCards" class="md:hidden space-y-3"></div>

        <!-- Pagination / summary -->
        <div class="mt-4 flex items-center justify-between">
          <div id="summaryText" class="text-sm text-gray-600">Showing 0</div>
          <div class="flex items-center gap-2">
            <button id="prevPage" class="px-3 py-1 border rounded">Prev</button>
            <button id="nextPage" class="px-3 py-1 border rounded">Next</button>
          </div>
        </div>
      </div>
    </div>
  </main>

<!-- NEW CLUSTER MODAL -->
<div id="newClusterModal" class="modal-hidden fixed inset-0 bg-black/50 z-50 items-center justify-center p-4">
  <div class="bg-white w-full max-w-2xl rounded-xl shadow-xl p-6 relative">
    <button onclick="closeNewCluster()" class="absolute top-3 right-3"><i data-feather="x" class="w-6"></i></button>
    <h3 class="text-xl font-semibold mb-4">Create Cluster Meeting</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
      <div>
        <label class="text-sm block mb-1">Title</label>
        <input id="newTitle" class="w-full px-3 py-2 border rounded" />
      </div>
      <div>
        <label class="text-sm block mb-1">Host</label>
        <input id="newHost" class="w-full px-3 py-2 border rounded" />
      </div>
      <div>
        <label class="text-sm block mb-1">Venue</label>
        <input id="newVenue" class="w-full px-3 py-2 border rounded" />
      </div>
      <div>
        <label class="text-sm block mb-1">Date</label>
        <input id="newDate" type="date" class="w-full px-3 py-2 border rounded" />
      </div>
      <div>
        <label class="text-sm block mb-1">Time</label>
        <input id="newTime" type="time" class="w-full px-3 py-2 border rounded" />
      </div>
      <div>
        <label class="text-sm block mb-1">Invite Members (comma separated names)</label>
        <input id="newParticipants" class="w-full px-3 py-2 border rounded" placeholder="Alice, Bob, Charlie" />
      </div>
    </div>

    <div class="flex gap-3 justify-end">
      <button class="px-4 py-2 bg-white border rounded" onclick="closeNewCluster()">Cancel</button>
      <button class="px-4 py-2 bg-[#2C3E50] text-white rounded" onclick="createCluster()">Create</button>
    </div>
  </div>
</div>

<!-- VIEW CLUSTER MODAL -->
<div id="viewClusterModal" class="modal-hidden fixed inset-0 bg-black/60 z-50 items-center justify-center p-4">
  <div class="bg-white w-full max-w-3xl rounded-xl shadow-xl p-6 relative max-h-[90vh] overflow-y-auto">
    <button onclick="closeViewCluster()" class="absolute top-3 right-3"><i data-feather="x" class="w-6"></i></button>
    <h3 id="vcTitle" class="text-xl font-semibold mb-2">Meeting Title</h3>
    <div class="text-sm text-gray-600 mb-3" id="vcMeta">Host • Venue • Date</div>
    <p id="vcNotes" class="text-gray-700 mb-4"></p>

    <div class="mb-4">
      <h4 class="font-medium mb-2">Participants</h4>
      <div id="participantList" class="space-y-2"></div>
    </div>

    <div id="attendanceActions" class="gap-3 justify-end hidden">
    <button id="declineBtn" class="px-4 py-2 bg-red-500 text-white rounded">Decline</button>
    <button id="confirmBtn" class="px-4 py-2 bg-green-600 text-white rounded">Confirm Attendance</button>
</div>
<div class="flex gap-3 justify-end mt-3">
    <button class="px-4 py-2 bg-white border rounded" onclick="closeViewCluster()">Close</button>
</div>

  </div>
</div>

<script>
feather.replace();

/* ------------------------------------
   USER ROLE – MEMBER ONLY
   ------------------------------------ */
const loggedInUser = "Me";      // Your logged-in member
const userRole = "member";      // Member only (no admin features)

/* -------------------------
   Demo data & in-memory model
------------------------- */
let clusters = [
  {
    id: 1,
    title: "North Cluster — Growth Strategies",
    host: "Priya Verma",
    venue: "Cafe Central",
    date: "2025-12-10",
    time: "18:30",
    notes: "Discuss business growth & referrals.",
    status: "upcoming",
    participants: [
      { name: "Rahul Sharma", attendance: "pending", notes: "" },
      { name: "Amit Verma", attendance: "pending", notes: "" },
      { name: "Sonia Malik", attendance: "accepted", notes: "" }
    ]
  },
  {
    id: 2,
    title: "West Cluster — Marketing",
    host: "Karan Singh",
    venue: "Community Hall",
    date: "2025-11-20",
    time: "16:00",
    notes: "Hands-on on micro-marketing for small biz.",
    status: "past",
    participants: [
      { name: "Arjun Kumar", attendance: "present", notes: "" },
      { name: "Sana Ali", attendance: "absent", notes: "" },
      { name: "Rajesh Singh", attendance: "present", notes: "" }
    ]
  },
  {
    id: 3,
    title: "South Cluster — Startups",
    host: "Riya Patel",
    venue: "CoWork Hub",
    date: "2025-12-22",
    time: "10:30",
    notes: "Early-stage founders meetup.",
    status: "upcoming",
    participants: [
      { name: "Me", attendance: "pending", notes: "" },
      { name: "Alice Bose", attendance: "accepted", notes: "" }
    ]
  }
];

/* -------------------------
   Pagination & refs
------------------------- */
const clusterTbody = document.getElementById("clusterTbody");
const mobileCards = document.getElementById("mobileCards");
const summaryText = document.getElementById("summaryText");
const prevPage = document.getElementById("prevPage");
const nextPage = document.getElementById("nextPage");
const searchInput = document.getElementById("searchInput");
const filterType = document.getElementById("filterType");
const fromDate = document.getElementById("fromDate");
const toDate = document.getElementById("toDate");

let page = 1;
let perPage = 6;

/* -------------------------
   Helper
------------------------- */
function escapeHTML(s) {
  return s ? s.replace(/[&<>]/g, t => ({'&':'&amp;','<':'&lt;','>':'&gt;'}[t])) : "";
}
function formatReadableDate(d, t) {
  if (!d) return "TBD";
  return new Date(d + "T" + t).toLocaleString();
}

/* -------------------------
   Filtering
------------------------- */
function getFiltered() {
  const q = searchInput.value.toLowerCase();
  const type = filterType.value;
  const from = fromDate.value;
  const to = toDate.value;

  return clusters.filter(c => {
    if (type !== "all" && c.status !== type) return false;
    if (q && !(c.title.toLowerCase().includes(q) || c.host.toLowerCase().includes(q) )) return false;
    if (from && c.date < from) return false;
    if (to && c.date > to) return false;
    return true;
  });
}

/* -------------------------
   Render List (TABLE + CARDS)
------------------------- */
function renderList() {
  const items = getFiltered();
  const total = items.length;
  const totalPages = Math.ceil(total / perPage);
  if (page > totalPages) page = totalPages;

  const start = (page - 1) * perPage;
  const paged = items.slice(start, start + perPage);

  clusterTbody.innerHTML = "";
  paged.forEach(c => {
    clusterTbody.innerHTML += `
      <tr class="border-b">
        <td class="py-3 px-4 font-medium">${escapeHTML(c.title)}</td>
        <td class="py-3 px-4">${escapeHTML(c.host)}</td>
        <td class="py-3 px-4">${escapeHTML(c.venue)}</td>
        <td class="py-3 px-4">${formatReadableDate(c.date, c.time)}</td>
        <td class="py-3 px-4">${c.participants.length}</td>
        <td class="py-3 px-4"><span class="status-chip s-${c.status}">${c.status}</span></td>
        <td class="py-3 px-4 text-right">
          <button class="viewClusterBtn px-3 py-1 bg-[#2C3E50] text-white rounded text-sm" data-id="${c.id}">
            View
          </button>
        </td>
      </tr>`;
  });

  /* Mobile Cards */
  mobileCards.innerHTML = "";
  paged.forEach(c => {
    mobileCards.innerHTML += `
      <div class="bg-white p-4 rounded-xl shadow border">
        <h3 class="font-semibold">${escapeHTML(c.title)}</h3>
        <p class="text-sm">${escapeHTML(c.host)} • ${escapeHTML(c.venue)}</p>
        <p class="text-xs text-gray-500">${formatReadableDate(c.date, c.time)}</p>
        <button class="viewClusterBtn mt-3 w-full bg-[#2C3E50] text-white py-1 rounded text-sm" data-id="${c.id}">
          View
        </button>
      </div>`;
  });

  summaryText.textContent = `Showing ${start + 1}–${start + paged.length} of ${total}`;

  /* Attach View listeners */
  document.querySelectorAll(".viewClusterBtn").forEach(btn => {
    btn.onclick = () => openViewCluster(parseInt(btn.dataset.id));
  });
}

/* -------------------------
   View Cluster (MEMBER MODE)
------------------------- */
const viewClusterModal = document.getElementById("viewClusterModal");
const participantList = document.getElementById("participantList");
let currentCluster = null;

function openViewCluster(id) {
  const c = clusters.find(x => x.id === id);
  currentCluster = c;

  document.getElementById("vcTitle").innerText = c.title;
  document.getElementById("vcMeta").innerText =
      `${c.host} • ${c.venue} • ${formatReadableDate(c.date, c.time)}`;
  document.getElementById("vcNotes").innerText = c.notes || "";

  // Populate participant list
  participantList.innerHTML = "";
  c.participants.forEach((p) => {
    participantList.innerHTML += `
      <div class="p-2 border rounded">
        <div class="font-medium">${p.name}</div>
        <div class="text-xs text-gray-500">Status: ${p.attendance}</div>
      </div>`;
  });

  /* -----------------------------------------------------------
     MEMBER ATTENDANCE BUTTON LOGIC (IMPROVED)
     ----------------------------------------------------------- */

  const actionsDiv = document.getElementById("attendanceActions");

  // Find logged-in user in participant list
  let me = c.participants.find(p => p.name === loggedInUser);

  // If not invited, auto-create placeholder so they can confirm
  if (!me) {
    me = { name: loggedInUser, attendance: "pending", notes: "" };
    c.participants.push(me);
  }

  // Show buttons only for upcoming meetings
  if (c.status === "upcoming") {

    // Member has not responded → show Confirm / Decline
    if (me.attendance === "pending" || me.attendance === "rejected") {
      actionsDiv.classList.remove("hidden");
      actionsDiv.classList.add("flex");

      document.getElementById("confirmBtn").onclick = () => {
        me.attendance = "accepted";
        closeViewCluster();
        renderList();
      };

      document.getElementById("declineBtn").onclick = () => {
        me.attendance = "rejected";
        closeViewCluster();
        renderList();
      };

    } else {
      // Already accepted or present or absent → hide buttons
      actionsDiv.classList.add("hidden");
    }

  } else {
    // Past or cancelled → no attendance buttons
    actionsDiv.classList.add("hidden");
  }

  viewClusterModal.classList.add("modal-show");
  viewClusterModal.classList.remove("modal-hidden");
}
function closeViewCluster() {
  viewClusterModal.classList.add("modal-hidden");
  viewClusterModal.classList.remove("modal-show");
  currentCluster = null;
}
/* -------------------------
   Pagination
------------------------- */
prevPage.onclick = () => { if (page > 1) page--; renderList(); };
nextPage.onclick = () => { page++; renderList(); };
searchInput.oninput = () => { page = 1; renderList(); };
filterType.onchange = () => { page = 1; renderList(); };

/* -------------------------
   INIT
------------------------- */
renderList();
/* -------------------------
   PROFILE DROPDOWN
   ------------------------- */
const profileBtn = document.getElementById("profileBtn");
const profileDropdown = document.getElementById("profileDropdown");
const dropdownArrow = document.getElementById("dropdownArrow");

// Toggle dropdown
profileBtn.addEventListener("click", (e) => {
    e.stopPropagation();

    const isOpen = profileDropdown.classList.contains("dropdown-visible");

    if (isOpen) {
        // Hide
        profileDropdown.classList.add("dropdown-hidden");
        profileDropdown.classList.remove("dropdown-visible");
        dropdownArrow.classList.remove("rotate-180");
    } else {
        // Show
        profileDropdown.classList.remove("dropdown-hidden");
        profileDropdown.classList.add("dropdown-visible");
        dropdownArrow.classList.add("rotate-180");
    }
});

// Click outside closes dropdown
document.addEventListener("click", (e) => {
    if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
        profileDropdown.classList.add("dropdown-hidden");
        profileDropdown.classList.remove("dropdown-visible");
        dropdownArrow.classList.remove("rotate-180");
    }
});
</script>
@endsection