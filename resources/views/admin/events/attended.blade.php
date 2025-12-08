@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-8">

  <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-6">
    <div>
      <h1 class="text-2xl font-semibold text-gray-800">Event Attendance — Admin</h1>
      <p class="text-sm text-gray-600">
        View which members attended which events.  
        This is a UI-only page (client-side demo).
      </p>
    </div>

    <div class="flex items-center gap-2 w-full md:w-auto">

  <!-- Search -->
  <input id="att-search" type="search" placeholder="Search members or events..."
         class="px-3 py-2 border rounded-md text-sm w-full md:w-72" />

  <!-- Status Filter -->
<select id="att-status-filter"
        class="px-3 py-2 border rounded-md text-sm bg-white">
  <option value="all">All Status</option>
  <option value="Present">Present</option>
  <option value="Late">Late</option>
  <option value="Absent">Absent</option>
</select>

<!-- Chapter Filter -->
<select id="att-chapter-filter"
        class="px-3 py-2 border rounded-md text-sm bg-white">
  <option value="all">All Chapters</option>
  <option value="Delhi NCR">Delhi NCR</option>
  <option value="Mumbai">Mumbai</option>
  <option value="Bangalore">Bangalore</option>
  <option value="Hyderabad">Hyderabad</option>
</select>

</div>
  </div>


  <div class="bg-white rounded-lg shadow-sm overflow-hidden">

    {{-- Table Header Desktop --}}
    <div class="hidden md:grid grid-cols-12 gap-4 px-4 py-3 text-xs text-gray-500 border-b bg-gray-50">
  <div class="col-span-3">Event Title</div>
  <div class="col-span-3">Member</div>
  <div class="col-span-2">Chapter</div>
  <div class="col-span-2">Attended On</div>
  <div class="col-span-1 text-center">Status</div>
  <div class="col-span-1 text-right">Actions</div>
</div>

    {{-- Rows --}}
    <div id="att-rows" class="divide-y divide-gray-100"></div>

    {{-- Pagination --}}
    <div class="px-4 py-3 border-t bg-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-sm">
      <div class="text-gray-600">Showing <span id="att-from">0</span>–<span id="att-to">0</span> of <span id="att-total">0</span></div>

      <div class="flex items-center gap-2 ml-auto">
        <button id="att-first" class="px-3 py-1 bg-white border rounded disabled:opacity-50">First</button>
        <button id="att-prev" class="px-3 py-1 bg-white border rounded disabled:opacity-50">Prev</button>
        <button id="att-next" class="px-3 py-1 bg-white border rounded disabled:opacity-50">Next</button>
      </div>
    </div>

  </div>

</div>
<!-- EDIT POPUP MODAL -->
<div id="edit-modal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
  <div class="bg-white rounded-xl p-6 w-80 shadow-xl">

    <h2 class="text-lg font-semibold mb-2">Edit Attendance</h2>

    <p class="text-sm text-gray-500 mb-4">
      Mark attendance status for this member.
    </p>

    <div class="space-y-3">
      <label class="flex items-center gap-2">
        <input type="radio" name="edit-status" value="Present" />
        <span>Present</span>
      </label>

      <label class="flex items-center gap-2">
        <input type="radio" name="edit-status" value="Late" />
        <span>Late</span>
      </label>

      <label class="flex items-center gap-2">
        <input type="radio" name="edit-status" value="Absent" />
        <span>Absent</span>
      </label>
    </div>

    <div class="flex justify-end gap-2 mt-5">
      <button id="edit-cancel" class="px-3 py-1 bg-gray-200 rounded">
        Cancel
      </button>

      <button id="edit-save" class="px-3 py-1 bg-red-600 text-white rounded">
        Save
      </button>
    </div>

    <input type="hidden" id="edit-id">
  </div>
</div>
<!-- DELETE CONFIRMATION MODAL -->
 <div id="delete-modal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
  <div class="bg-white p-5 rounded-xl w-72 shadow-xl">
    <p class="text-gray-700 text-sm mb-4">Are you sure you want to delete this record?</p>

    <div class="flex justify-end gap-2">
      <button id="delete-cancel" class="px-3 py-1 bg-gray-200 rounded">Cancel</button>
      <button id="delete-confirm" class="px-3 py-1 bg-red-600 text-white rounded">Delete</button>
    </div>

    <input type="hidden" id="delete-id">
  </div>
</div>

<style>
  .att-hover:hover { background: rgba(229,57,53,0.03); transform: translateY(-1px); }
</style>


<script>
document.addEventListener('DOMContentLoaded', () => {

  // ============================================
  // SAMPLE UI-ONLY ATTENDANCE DATA
  // ============================================
  let attendance = [
    {
      id: 1,
      event: 'Business Networking Summit',
      member: 'Aarav Sharma',
      email: 'aarav@example.com',
      chapter: 'Delhi NCR',
      attended_at: '2025-02-24T18:30',
      status: 'Present'
    },
    {
      id: 2,
      event: 'Leadership Meetup',
      member: 'Priya Patel',
      email: 'priya@example.com',
      chapter: 'Mumbai',
      attended_at: '2025-03-10T10:00',
      status: 'Present'
    },
    {
      id: 3,
      event: 'Leadership Meetup',
      member: 'Rahul Verma',
      email: 'rahul@example.com',
      chapter: 'Mumbai',
      attended_at: '2025-03-10T10:10',
      status: 'Late'
    }
  ];

  let filtered = [...attendance];
  const pageSize = 8;
  let page = 1;

  // ============================================
  // DOM REFERENCES
  // ============================================
  const rows     = document.getElementById('att-rows');
  const search   = document.getElementById('att-search');
  const statusF  = document.getElementById('att-status-filter');
  const chapterF = document.getElementById('att-chapter-filter');

  const totalSpan = document.getElementById('att-total');
  const fromSpan  = document.getElementById('att-from');
  const toSpan    = document.getElementById('att-to');

  const btnFirst = document.getElementById('att-first');
  const btnPrev  = document.getElementById('att-prev');
  const btnNext  = document.getElementById('att-next');

  // MODALS
  const editModal = document.getElementById("edit-modal");
  const deleteModal = document.getElementById("delete-modal");

  const editIdField = document.getElementById("edit-id");
  const deleteIdField = document.getElementById("delete-id");


  // ============================================
  // UTILITY FUNCTIONS
  // ============================================
  function formatDateTime(dt) {
    if (!dt) return '—';
    const d = new Date(dt);
    return d.toLocaleString(undefined, {
      day: '2-digit', month: 'short', year: 'numeric',
      hour: '2-digit', minute: '2-digit'
    });
  }

  function esc(v) {
    return String(v ?? '').replace(/&/g, '&amp;')
                          .replace(/</g, '&lt;')
                          .replace(/>/g, '&gt;');
  }

  // ============================================
  // MAIN RENDER FUNCTION
  // ============================================
  function render() {
    rows.innerHTML = '';

    const total = filtered.length;
    const start = (page - 1) * pageSize;
    const end   = start + pageSize;
    const list  = filtered.slice(start, end);

    if (!list.length) {
      rows.innerHTML = `<div class="p-6 text-center text-gray-500">No attendance records found.</div>`;
    } else {
      list.forEach(item => {
        const desktopRow = `
          <div class="hidden md:grid grid-cols-12 gap-4 px-4 py-4 items-center text-sm border-b att-hover">

            <div class="col-span-3 font-medium">${esc(item.event)}</div>

            <div class="col-span-3">
              <div class="font-medium">${esc(item.member)}</div>
              <div class="text-xs text-gray-500">${esc(item.email)}</div>
            </div>

            <div class="col-span-2 text-sm">${esc(item.chapter)}</div>

            <div class="col-span-2 text-sm text-gray-600">${formatDateTime(item.attended_at)}</div>

            <div class="col-span-1 text-center">
              <span class="px-3 py-1 rounded bg-green-100 text-green-700 text-xs">
                ${esc(item.status)}
              </span>
            </div>

            <div class="col-span-1 text-right space-x-2">
              <button class="att-edit text-blue-600 text-xs font-semibold" data-id="${item.id}">Edit</button>
              <button class="att-delete text-red-600 text-xs font-semibold" data-id="${item.id}">Delete</button>
            </div>

          </div>
        `;

        const mobileRow = `
          <div class="md:hidden px-4 py-4 border-b att-hover">

            <div class="font-semibold">${esc(item.event)}</div>
            <div class="mt-1 text-sm">${esc(item.member)} (${esc(item.chapter)})</div>
            <div class="text-xs text-gray-500">${esc(item.email)}</div>
            <div class="text-xs text-gray-500 mt-2">${formatDateTime(item.attended_at)}</div>
            <div class="text-xs text-green-600 mt-2 font-medium">${esc(item.status)}</div>

            <div class="mt-3 flex gap-3">
              <button class="att-edit text-blue-600 text-xs" data-id="${item.id}">Edit</button>
              <button class="att-delete text-red-600 text-xs" data-id="${item.id}">Delete</button>
            </div>
          </div>
        `;

        rows.insertAdjacentHTML('beforeend', desktopRow + mobileRow);
      });
    }

    // Update pagination
    fromSpan.textContent = list.length ? start + 1 : 0;
    toSpan.textContent   = Math.min(end, total);
    totalSpan.textContent = total;

    btnPrev.disabled  = page <= 1;
    btnFirst.disabled = page <= 1;
    btnNext.disabled  = end >= total;
  }

  // ============================================
  // FILTER LOGIC
  // ============================================
  function applySearch() {
    const q       = search.value.toLowerCase().trim();
    const status  = statusF.value;
    const chapter = chapterF.value;

    filtered = attendance.filter(item => {
      const matchesSearch = (item.event + item.member + item.chapter + item.email)
                              .toLowerCase()
                              .includes(q);

      const matchesStatus  = (status === 'all'   || item.status === status);
      const matchesChapter = (chapter === 'all' || item.chapter === chapter);

      return matchesSearch && matchesStatus && matchesChapter;
    });

    page = 1;
    render();
  }

  search.addEventListener('input', applySearch);
  statusF.addEventListener('change', applySearch);
  chapterF.addEventListener('change', applySearch);

  // ============================================
  // PAGINATION
  // ============================================
  btnFirst.addEventListener('click', () => { page = 1; render(); });
  btnPrev.addEventListener('click',  () => { if (page > 1) page--; render(); });
  btnNext.addEventListener('click',  () => { if (page * pageSize < filtered.length) page++; render(); });

  // ============================================
  // ACTION BUTTONS (Edit, Delete, View, Verify)
  // ============================================
  document.addEventListener("click", (e) => {

    // EDIT BUTTON
    if (e.target.classList.contains("att-edit")) {
      const id = e.target.dataset.id;
      const record = attendance.find(a => a.id == id);

      if (record) {
        editIdField.value = id;

        document.querySelectorAll("input[name='edit-status']").forEach(radio => {
          radio.checked = (radio.value === record.status);
        });

        editModal.classList.remove("hidden");
        editModal.style.display = "flex";
      }
    }

    // DELETE BUTTON
    if (e.target.classList.contains("att-delete")) {
      deleteIdField.value = e.target.dataset.id;
      deleteModal.classList.remove("hidden");
      deleteModal.style.display = "flex";
    }

    // VIEW MEMBER
    if (e.target.classList.contains("att-view-member")) {
      alert("Viewing member details (UI only).");
    }

    // VIEW EVENT
    if (e.target.classList.contains("att-view-event")) {
      alert("Viewing event details (UI only).");
    }

  });

  // ============================================
  // SAVE EDIT
  // ============================================
  document.getElementById("edit-save").addEventListener("click", () => {
    const id = editIdField.value;
    const chosen = document.querySelector("input[name='edit-status']:checked");

    if (!chosen) {
      alert("Please select a status.");
      return;
    }

    const record = attendance.find(a => a.id == id);
    record.status = chosen.value;

    editModal.style.display = "none";
    editModal.classList.add("hidden");
    applySearch();
  });

  // CANCEL EDIT
  document.getElementById("edit-cancel").addEventListener("click", () => {
    editModal.classList.add("hidden");
    editModal.style.display = "none";
  });

  // ============================================
  // DELETE CONFIRM
  // ============================================
  document.getElementById("delete-confirm").addEventListener("click", () => {
    const id = deleteIdField.value;
    attendance = attendance.filter(a => a.id != id);

    deleteModal.classList.add("hidden");
    deleteModal.style.display = "none";
    applySearch();
  });

  document.getElementById("delete-cancel").addEventListener("click", () => {
    deleteModal.classList.add("hidden");
    deleteModal.style.display = "none";
  });

  // ============================================
  // INITIAL RENDER
  // ============================================
  applySearch();

});
</script>

@endsection