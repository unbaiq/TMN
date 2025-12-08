@extends('layouts.app')

@section('content')
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
    .dropdown-visible { display: block !important; opacity: 1 !important; }
    .mobile-slide { transform: translateX(-100%); transition: 0.25s; }
    .mobile-open { transform: translateX(0); }
    .status-chip { padding:4px 10px; border-radius:20px; font-size:12px; }
    .chip-requested { background:#fde68a; color:#92400e; }
    .chip-scheduled { background:#bfdbfe; color:#1e3a8a; }
    .chip-completed { background:#bbf7d0; color:#065f46; }
    .chip-cancelled { background:#fecaca; color:#7f1d1d; }
    .modal-hidden { display:none; }
    .modal-show { display:flex !important; }
    /* -------------------------------------------------------------
   GLOBAL UI UPGRADE (Premium Look)
----------------------------------------------------------------*/
  body {
    background: #f3f4f6;
    font-family: 'Inter', sans-serif;
  }
  </style>
    <main class="p-6 sm:p-10">
      <h2 class="text-2xl font-bold text-[#2C3E50] mb-6 flex items-center gap-2">
        <i data-feather="users"></i> 1-1 Meeting Management
      </h2>
      <!-- Toolbar -->
      <div class="flex flex-col lg:flex-row gap-3 items-start lg:items-center justify-between mb-6">
        <div class="flex gap-3 w-full lg:w-2/3">
          <div class="relative flex-1">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
              <i data-feather="search"></i>
            </span>
            <input id="searchInput" type="search" placeholder="Search member / location / notes..."
              class="w-full pl-10 pr-4 py-2 border rounded-xl bg-white" />
          </div>
          <select id="statusFilter" class="px-3 py-2 border rounded-xl bg-white">
            <option value="all">All Status</option>
            <option value="requested">Requested</option>
            <option value="scheduled">Scheduled</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
          </select>
          <select id="sortSelect" class="px-3 py-2 border rounded-xl bg-white">
            <option value="latest">Sort: Latest</option>
            <option value="oldest">Sort: Oldest</option>
          </select>
        </div>
        <button id="newMeetBtn" class="px-5 py-2 bg-[#2C3E50] text-white rounded-xl flex items-center gap-2 shadow">
          <i data-feather="plus"></i> New Meet Request
        </button>
      </div>
      <!-- TABLE -->
      <div class="bg-white rounded-xl shadow p-4 border w-full overflow-x-auto">
        <table class="w-full table-auto min-w-max block md:table whitespace-nowrap">
          <thead>
            <tr class="text-left bg-gray-100 text-gray-700 text-sm">
              <th class="py-3 px-4">Member</th>
              <th class="py-3 px-4">Location</th>
              <th class="py-3 px-4">Scheduled</th>
              <th class="py-3 px-4">Status</th>
              <th class="py-3 px-4">Actions</th>
            </tr>
          </thead>
          <tbody id="meetTbody">
            <!-- SAMPLE ROW -->
            <tr class="one-row border-b" 
                data-requested="Amit Verma"
                data-location="Coffee House, MG Road"
                data-status="requested"
                data-scheduled=""
                data-notes="Business discussion"
                data-date="2025-12-10">
              <td class="py-3 px-4 font-medium">Amit Verma</td>
              <td class="py-3 px-4">Coffee House, MG Road</td>
              <td class="py-3 px-4 text-gray-500">Not Scheduled</td>
              <td class="py-3 px-4"><span class="status-chip chip-requested">Requested</span></td>

              <td class="py-3 px-4">
  <div class="flex items-center gap-2">
    <button class="viewBtn bg-[#2C3E50] text-white px-3 py-1 rounded-md text-sm">View</button>
    <button class="editBtn bg-blue-600 text-white px-3 py-1 rounded-md text-sm">Edit</button>
    <button class="deleteBtn bg-red-600 text-white px-3 py-1 rounded-md text-sm">Delete</button>
  </div>
</td>
            </tr>
          </tbody>
        </table>
        <!-- MOBILE LIST -->
        <div id="mobileCards" class="hidden"></div>
      </div>

<!-- =================== VIEW MODAL =================== -->
<div id="viewModal" class="modal-hidden fixed inset-0 bg-black/40 z-50 items-center justify-center p-4">
  <div class="bg-white w-full max-w-md rounded-xl shadow-xl p-6 relative">
    <button id="closeViewX" class="absolute top-3 right-3 text-gray-600">
      <i data-feather="x"></i>
    </button>
    <h2 class="text-xl font-semibold mb-3">Meeting Details</h2>
    <p id="vmRequested" class="text-gray-700"></p>
    <p id="vmLocation" class="text-gray-700 mt-1"></p>
    <p id="vmStatus" class="text-gray-700 mt-1"></p>
    <p id="vmDate" class="text-gray-700 mt-1"></p>
    <p id="vmNotes" class="text-gray-700 mt-3"></p>
    <!-- Scheduling Box -->
    <div id="scheduleBox" class="hidden mt-4 bg-gray-50 p-4 rounded-lg border">
      <label class="block text-sm font-medium mb-1">Date</label>
      <input type="date" id="scheduleDate"
             class="w-full mb-3 px-3 py-2 border rounded-lg">
      <label class="block text-sm font-medium mb-1">Time</label>
      <input type="time" id="scheduleTime"
             class="w-full px-3 py-2 border rounded-lg">
      <button id="confirmScheduleBtn"
              class="mt-4 w-full bg-green-600 text-white py-2 rounded-lg">
        Confirm Schedule
      </button>
    </div>
    <!-- ACTION BUTTONS -->
    <div class="mt-6 space-y-3">
      <button id="acceptBtn"
              class="w-full bg-blue-600 text-white py-2 rounded-lg">
        Accept & Schedule
      </button>

      <button id="editFromView"
              class="w-full bg-yellow-500 text-white py-2 rounded-lg">
        Edit Meeting
      </button>

      <button id="deleteFromView"
              class="w-full bg-red-600 text-white py-2 rounded-lg">
        Delete Meeting
      </button>

      <button id="closeViewBtn"
              class="w-full bg-[#2C3E50] text-white py-2 rounded-lg">
        Close
      </button>
    </div>

  </div>
</div>

<!-- DELETE CONFIRM MODAL -->
<div id="deleteConfirmModal"
     class="modal-hidden fixed inset-0 bg-black/40 z-50 items-center justify-center p-4">

  <div class="bg-white w-full max-w-sm rounded-xl shadow-xl p-6 text-center relative">
    <button onclick="closeDeleteConfirm()" class="absolute top-3 right-3 text-gray-600">
      <i data-feather="x"></i>
    </button>

    <h2 class="text-xl font-semibold text-red-600 mb-3">Delete Meeting</h2>
    <p class="text-gray-700">Are you sure you want to delete this meeting?</p>

    <div class="mt-5 flex gap-3 justify-center">
      <button id="confirmDeleteBtn"
              class="px-5 py-2 bg-red-600 text-white rounded-lg">
        Delete
      </button>

      <button onclick="closeDeleteConfirm()"
              class="px-5 py-2 bg-gray-200 text-gray-800 rounded-lg">
        Cancel
      </button>
    </div>
  </div>
</div>

      <!-- =================== NEW MEET MODAL =================== -->
      <div id="newMeetModal" class="modal-hidden fixed inset-0 bg-black/40 z-50 items-center justify-center p-4">
        <div class="bg-white w-full max-w-lg rounded-xl shadow-xl p-6 relative">

          <button id="closeNewX" class="absolute top-3 right-3 text-gray-600">
            <i data-feather="x"></i>
          </button>

          <h2 class="text-xl font-semibold mb-4">Request 1-1 Meeting</h2>

          <div class="space-y-4">

            <div>
              <label class="block text-sm font-medium mb-1">Select Member</label>
              <select id="newRequested" class="w-full px-3 py-2 border rounded-lg">
                <option value="">Select Member</option>
                <option value="Amit Verma">Amit Verma</option>
                <option value="Karan Singh">Karan Singh</option>
                <option value="Sonia Malik">Sonia Malik</option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Location</label>
              <input id="newLocation" type="text" placeholder="Enter meeting location..."
                class="w-full px-3 py-2 border rounded-lg" />
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Notes (Optional)</label>
              <textarea id="newNotes" rows="3" class="w-full px-3 py-2 border rounded-lg"
                placeholder="Enter meeting purpose..."></textarea>
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Schedule (Optional)</label>
              <input type="date" id="newDate" class="w-full px-3 py-2 border rounded-lg mb-2">
              <input type="time" id="newTime" class="w-full px-3 py-2 border rounded-lg">
            </div>

            <button id="createMeetBtn" class="w-full bg-[#2C3E50] text-white py-2 rounded-lg">
              Submit Request
            </button>
          </div>
        </div>
      </div>
  </main>
<script>
/* Feather Icons */
feather.replace();
/* ---------------------------------------------------
   SIDEBAR + PROFILE DROPDOWN + MOBILE MENU
--------------------------------------------------- */
const openMobileBtn = document.getElementById('openMobileSidebar');
const mobileSidebar = document.getElementById('mobileSidebar');
const mobilePanel = document.getElementById('mobilePanel');
const mobileOverlay = document.getElementById('mobileSidebarOverlay');

function openMobileSidebarFn() {
  mobileSidebar.classList.remove('hidden');
  setTimeout(() => mobilePanel.classList.add('mobile-open'), 10);
  document.documentElement.style.overflow = 'hidden';
}
function closeMobileSidebarFn() {
  mobilePanel.classList.remove('mobile-open');
  document.documentElement.style.overflow = '';
  setTimeout(() => mobileSidebar.classList.add('hidden'), 220);
}
if (openMobileBtn) openMobileBtn.addEventListener('click', openMobileSidebarFn);
if (mobileOverlay) mobileOverlay.addEventListener('click', closeMobileSidebarFn);

window.addEventListener('resize', () => {
  if (window.innerWidth >= 768 && !mobileSidebar.classList.contains('hidden')) {
    closeMobileSidebarFn();
  }
});

/* Profile Dropdown */
const profileBtn = document.getElementById('profileBtn');
const profileDropdown = document.getElementById('profileDropdown');
const dropdownArrow = document.getElementById('dropdownArrow');

if (profileBtn) {
  profileBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    dropdownArrow.classList.toggle('rotate-180');
    profileDropdown.classList.toggle('dropdown-hidden');
    profileDropdown.classList.toggle('dropdown-visible');
  });
}
document.addEventListener('click', (ev) => {
  if (!profileBtn.contains(ev.target) && !profileDropdown.contains(ev.target)) {
    dropdownArrow.classList.remove('rotate-180');
    profileDropdown.classList.add('dropdown-hidden');
    profileDropdown.classList.remove('dropdown-visible');
  }
});

/* ---------------------------------------------------
   HELPER FUNCTIONS
--------------------------------------------------- */
const qs = (s, r=document) => r.querySelector(s);
const qsa = (s, r=document) => Array.from(r.querySelectorAll(s));
const pad = n => String(n).padStart(2,'0');

function escapeHtml(s){
  if (!s) return "";
  return String(s).replaceAll("&","&amp;").replaceAll("<","&lt;").replaceAll(">","&gt;");
}
function formatReadable(dstr){
  if(!dstr) return "Not Scheduled";
  const d = new Date(dstr.replace(" ", "T"));
  if(isNaN(d)) return dstr;
  return d.toLocaleString(undefined,{
    day:"numeric", month:"short", year:"numeric",
    hour:"numeric", minute:"2-digit"
  });
}
function getStatusChip(status){
  const map = {
    requested:["chip-requested","Requested"],
    scheduled:["chip-scheduled","Scheduled"],
    completed:["chip-completed","Completed"],
    cancelled:["chip-cancelled","Cancelled"],
  };
  return map[status] || ["","Unknown"];
}

/* ---------------------------------------------------
   DOM REFERENCES
--------------------------------------------------- */
const meetTbody = qs("#meetTbody");
const mobileCards = qs("#mobileCards");
const searchInput = qs("#searchInput");
const statusFilter = qs("#statusFilter");
const sortSelect = qs("#sortSelect");

const newMeetBtn = qs("#newMeetBtn");
const newMeetModal = qs("#newMeetModal");
const createMeetBtn = qs("#createMeetBtn");
const closeNewX = qs("#closeNewX");

const newRequested = qs("#newRequested");
const newLocation = qs("#newLocation");
const newNotes = qs("#newNotes");
const newDate = qs("#newDate");
const newTime = qs("#newTime");

const viewModal = qs("#viewModal");
const closeViewX = qs("#closeViewX");
const closeViewBtn = qs("#closeViewBtn");

const vmRequested = qs("#vmRequested");
const vmLocation = qs("#vmLocation");
const vmStatus = qs("#vmStatus");
const vmDate = qs("#vmDate");
const vmNotes = qs("#vmNotes");

const acceptBtn = qs("#acceptBtn");
const scheduleBox = qs("#scheduleBox");
const scheduleDate = qs("#scheduleDate");
const scheduleTime = qs("#scheduleTime");
const confirmScheduleBtn = qs("#confirmScheduleBtn");

let editingRow = null;

/* ---------------------------------------------------
   READ & RENDER FUNCTIONS
--------------------------------------------------- */
function getAllItems(){
  return qsa(".one-row", meetTbody).map(tr => ({
    requested: tr.dataset.requested,
    location: tr.dataset.location,
    status: tr.dataset.status,
    scheduled: tr.dataset.scheduled,
    notes: tr.dataset.notes,
    date: tr.dataset.date,
    _row: tr
  }));
}

function renderTable(items){
  meetTbody.innerHTML = "";
  items.forEach(item => {
    const tr = document.createElement("tr");
    tr.className = "one-row border-b";

    tr.dataset.requested = item.requested;
    tr.dataset.location = item.location;
    tr.dataset.status = item.status;
    tr.dataset.scheduled = item.scheduled;
    tr.dataset.notes = item.notes;
    tr.dataset.date = item.date;

    const readable = item.scheduled ? formatReadable(item.scheduled) : "Not Scheduled";
    const [chipClass, chipLabel] = getStatusChip(item.status);

    tr.innerHTML = `
      <td class="py-3 px-4 font-medium">${escapeHtml(item.requested)}</td>
      <td class="py-3 px-4">${escapeHtml(item.location)}</td>
      <td class="py-3 px-4">${escapeHtml(readable)}</td>
      <td class="py-3 px-4"><span class="status-chip ${chipClass}">${chipLabel}</span></td>
      <td class="py-3 px-4 space-x-2">
        <button class="viewBtn bg-[#2C3E50] text-white px-3 py-1 rounded-md text-sm">View</button>
        <button class="editBtn bg-blue-600 text-white px-3 py-1 rounded-md text-sm">Edit</button>
        <button class="deleteBtn bg-red-600 text-white px-3 py-1 rounded-md text-sm">Delete</button>
      </td>
    `;

    meetTbody.appendChild(tr);

    tr.querySelector(".viewBtn").onclick = () => openViewModal(item, tr);
    tr.querySelector(".editBtn").onclick = () => openEditMeeting(tr);
    tr.querySelector(".deleteBtn").onclick = () => deleteMeeting(tr);
  });
}

function renderMobile(items){
  mobileCards.innerHTML = "";
  items.forEach(item => {
    const [chipClass, chipLabel] = getStatusChip(item.status);
    const card = document.createElement("div");
    card.className = "bg-white p-4 rounded-xl shadow border";

    card.innerHTML = `
      <h3 class="font-semibold text-lg">${escapeHtml(item.requested)}</h3>
      <p class="text-sm mt-1">📍 ${escapeHtml(item.location)}</p>
      <p class="text-sm mt-1">📅 ${escapeHtml(formatReadable(item.scheduled))}</p>
      <span class="status-chip ${chipClass} inline-block mt-2">${chipLabel}</span>
      <p class="text-gray-600 mt-2 text-sm">${escapeHtml(item.notes)}</p>
      <button class="mt-4 w-full bg-[#2C3E50] text-white py-2 rounded-lg view-card">View Details</button>
    `;

    card.querySelector(".view-card").onclick = () => openViewModal(item);
    mobileCards.appendChild(card);
  });
}

function applyFilters(){
  let items = getAllItems();

  const q = searchInput.value.toLowerCase().trim();
  const st = statusFilter.value;

  items = items.filter(it => {
    if(q && !(it.requested.toLowerCase().includes(q) ||
             it.location.toLowerCase().includes(q) ||
             it.notes.toLowerCase().includes(q))) return false;
    if(st !== "all" && it.status !== st) return false;
    return true;
  });

  if(sortSelect.value === "latest"){
    items.sort((a,b) => new Date(b.date) - new Date(a.date));
  } else {
    items.sort((a,b) => new Date(a.date) - new Date(b.date));
  }

  renderTable(items);
  renderMobile(items);
}

[searchInput, statusFilter, sortSelect].forEach(el =>
  el.addEventListener("input", applyFilters)
);

/* ---------------------------------------------------
   NEW MEETING
--------------------------------------------------- */
function openNewMeet(){
  editingRow = null;
  newRequested.value = "";
  newLocation.value = "";
  newNotes.value = "";
  newDate.value = "";
  newTime.value = "";

  newMeetModal.classList.add("modal-show");
  newMeetModal.classList.remove("modal-hidden");
}
function closeNewMeet(){
  newMeetModal.classList.add("modal-hidden");
  newMeetModal.classList.remove("modal-show");
}

newMeetBtn.onclick = openNewMeet;
closeNewX.onclick = closeNewMeet;

createMeetBtn.onclick = () => {
  const requested = newRequested.value.trim();
  const location = newLocation.value.trim();
  const notes = newNotes.value.trim();
  const d = newDate.value, t = newTime.value;

  if(!requested) return alert("Select a member.");
  if(!location) return alert("Enter location.");

  const scheduled = d ? `${d} ${t || "00:00"}` : "";

  const item = {
    requested,
    location,
    notes,
    status: scheduled ? "scheduled" : "requested",
    scheduled,
    date: new Date().toISOString()
  };

  addOrUpdateRow(item);
  closeNewMeet();
  applyFilters();
};

function addOrUpdateRow(item){
  if(editingRow){
    editingRow.dataset.requested = item.requested;
    editingRow.dataset.location = item.location;
    editingRow.dataset.notes = item.notes;
    editingRow.dataset.status = item.status;
    editingRow.dataset.scheduled = item.scheduled;
    editingRow.dataset.date = item.date;

    editingRow = null;
  } else {
    const tr = document.createElement("tr");
    tr.className = "one-row border-b";

    tr.dataset.requested = item.requested;
    tr.dataset.location = item.location;
    tr.dataset.notes = item.notes;
    tr.dataset.status = item.status;
    tr.dataset.scheduled = item.scheduled;
    tr.dataset.date = item.date;

    meetTbody.appendChild(tr);
  }
}

/* ---------------------------------------------------
   EDIT
--------------------------------------------------- */
function openEditMeeting(tr){
  editingRow = tr;

  newRequested.value = tr.dataset.requested;
  newLocation.value = tr.dataset.location;
  newNotes.value = tr.dataset.notes;

  if(tr.dataset.scheduled){
    const [d,t] = tr.dataset.scheduled.split(" ");
    newDate.value = d;
    newTime.value = t;
  } else {
    newDate.value = "";
    newTime.value = "";
  }

  newMeetModal.classList.add("modal-show");
  newMeetModal.classList.remove("modal-hidden");
}

/* ---------------------------------------------------
   DELETE
--------------------------------------------------- */
function deleteMeeting(tr){
  if(confirm("Do you want to delete this meeting?")){
    tr.remove();
    applyFilters();
  }
}

/* ---------------------------------------------------
   VIEW MODAL
--------------------------------------------------- */
function openViewModal(item, row){
  vmRequested.innerText = "Member: " + item.requested;
  vmLocation.innerText = "Location: " + item.location;
  vmStatus.innerText = "Status: " + item.status;
  vmDate.innerText = "Scheduled: " + formatReadable(item.scheduled);
  vmNotes.innerText = "Notes: " + (item.notes || "—");

  scheduleBox.classList.add("hidden");
  acceptBtn.classList.toggle("hidden", item.status !== "requested");

  if(row){
    acceptBtn.onclick = () => {
      scheduleBox.classList.remove("hidden");
      const now = new Date();
      scheduleDate.value = now.toISOString().substring(0,10);
      scheduleTime.value = `${pad(now.getHours())}:${pad(now.getMinutes())}`;

      confirmScheduleBtn.onclick = () => {
        const d = scheduleDate.value;
        if(!d) return alert("Please select a date.");

        const scheduled = `${d} ${scheduleTime.value || "00:00"}`;

        row.dataset.scheduled = scheduled;
        row.dataset.status = "scheduled";

        closeViewModal();
        applyFilters();
      };
    };
  }

  viewModal.classList.add("modal-show");
  viewModal.classList.remove("modal-hidden");
}

function closeViewModal(){
  viewModal.classList.add("modal-hidden");
  viewModal.classList.remove("modal-show");
}

closeViewX.onclick = closeViewModal;
closeViewBtn.onclick = closeViewModal;

/* ---------------------------------------------------
   INITIALIZE
--------------------------------------------------- */
applyFilters();

/* Close modals on background click */
[newMeetModal, viewModal].forEach(modal => {
  modal.addEventListener("click", e => {
    if(e.target === modal){
      modal.classList.add("modal-hidden");
      modal.classList.remove("modal-show");
    }
  });
});
let rowToDelete = null;
let rowToEdit = null;

/* When View Modal opens */
function openViewModal(item, row){
  rowToEdit = row;
  rowToDelete = row;

  vmRequested.innerText = "Member: " + item.requested;
  vmLocation.innerText = "Location: " + item.location;
  vmStatus.innerText = "Status: " + item.status;
  vmDate.innerText = "Scheduled: " + formatReadable(item.scheduled);
  vmNotes.innerText = "Notes: " + (item.notes || "—");

  scheduleBox.classList.add("hidden");
  acceptBtn.classList.toggle("hidden", item.status !== "requested");

  viewModal.classList.add("modal-show");
  viewModal.classList.remove("modal-hidden");
}

/* EDIT INSIDE VIEW MODAL */
document.getElementById("editFromView").onclick = () => {
  openEditMeeting(rowToEdit);
  closeViewModal();
};

/* DELETE INSIDE VIEW MODAL */
document.getElementById("deleteFromView").onclick = () => {
  deleteConfirmModal.classList.add("modal-show");
  deleteConfirmModal.classList.remove("modal-hidden");
};

/* CLOSE DELETE CONFIRM */
function closeDeleteConfirm() {
  deleteConfirmModal.classList.add("modal-hidden");
  deleteConfirmModal.classList.remove("modal-show");
}

/* CONFIRM DELETE */
document.getElementById("confirmDeleteBtn").onclick = () => {
  if (rowToDelete) rowToDelete.remove();
  closeDeleteConfirm();
  closeViewModal();
  applyFilters();
};
</script>
@endsection