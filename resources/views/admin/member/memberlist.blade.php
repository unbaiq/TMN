@extends('layouts.app')

@section('content')
<div class="p-6 sm:p-8">

  <!-- Title + Add Member Button -->
  <div class="flex items-center justify-between mb-6">
    <div>
      <h2 class="text-2xl font-semibold text-gray-800">Members List</h2>
      <p class="text-gray-600 mt-1">View all members and assign chapters.</p>
    </div>

    <button id="openAddMember" class="px-4 py-2 bg-red-600 text-white rounded-lg flex items-center gap-2 shadow">
      <i data-feather="user-plus" class="w-4"></i> Add Member
    </button>
  </div>

  <!-- Search + Refresh -->
  <div class="flex items-center justify-between mb-4">
    <input id="searchInput" type="text" placeholder="Search name or email"
           class="px-3 py-2 border rounded-md w-64" />
    <button id="refreshBtn" class="px-3 py-2 bg-red-600 text-white rounded-md">Refresh</button>
  </div>

  <!-- Members TABLE -->
  <div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">#</th>
          <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Member</th>
          <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Contact</th>
          <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Business / City</th>
          <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Chapter</th>
          <th class="px-4 py-3 text-center text-sm font-medium text-gray-500">Action</th>
        </tr>
      </thead>

      <tbody id="membersTbody" class="bg-white divide-y divide-gray-100">

        <!-- SAMPLE ROW — replace with dynamic rows from backend -->
        <tr class="hover:bg-gray-50" data-user-id="1">
          <td class="px-4 py-3 text-sm text-gray-700">1</td>
          <td class="px-4 py-3">
            <div class="font-medium text-gray-900">Ramesh Kumar</div>
            <div class="text-xs text-gray-500">ramesh@example.com</div>
          </td>
          <td class="px-4 py-3 text-sm text-gray-700">
            +91 98765 43210
          </td>
          <td class="px-4 py-3 text-sm text-gray-700">
            Ramesh Enterprises <br>
            <span class="text-xs text-gray-500">Delhi</span>
          </td>
          <td class="px-4 py-3 text-sm text-gray-700 chapter-cell">
            <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-xs">Not Assigned</span>
          </td>
          <td class="px-4 py-3 text-center action-cell">
            <button class="assign-btn px-3 py-1 bg-white border rounded shadow-sm hover:shadow text-sm flex items-center gap-2"
                    data-user-id="1"
                    data-user-name="Ramesh Kumar">
              <i data-feather="user-plus" class="w-4"></i> Assign
            </button>
          </td>
        </tr>

      </tbody>
    </table>
  </div>
</div>


<!-- ===================== ASSIGN CHAPTER MODAL ===================== -->

<div id="assignModal" class="fixed inset-0 z-50 hidden items-center justify-center">
  <div class="absolute inset-0 bg-black/40"></div>

  <div class="relative z-10 bg-white rounded-xl max-w-lg w-full p-6 shadow-lg">
    <div class="flex items-start justify-between">
      <div>
        <h3 class="text-lg font-semibold text-gray-800">Assign Chapter</h3>
        <p id="modalUser" class="text-sm text-gray-500">Member name</p>
      </div>
      <button id="modalClose" class="text-gray-400 hover:text-gray-600">✕</button>
    </div>

    <div class="mt-4">
      <label class="block text-sm font-medium text-gray-700 mb-2">Select Chapter</label>
      <select id="chapterSelect" class="w-full rounded border px-3 py-2">
        <option value="">-- Select Chapter --</option>
        <option value="1">Delhi Chapter</option>
        <option value="2">Mumbai Chapter</option>
        <option value="3">Bengaluru Chapter</option>
      </select>
    </div>

    <div class="mt-6 flex items-center justify-end gap-3">
      <button id="modalCancel" class="px-4 py-2 bg-gray-100 rounded">Cancel</button>
      <button id="modalSave" class="px-4 py-2 bg-red-600 text-white rounded">Save</button>
    </div>
  </div>
</div>


<!-- ===================== ADD MEMBER MODAL ===================== -->

<div id="addModal" class="fixed inset-0 z-50 hidden items-center justify-center">
  <div class="absolute inset-0 bg-black/40"></div>

  <div class="relative z-10 bg-white rounded-xl max-w-2xl w-full p-6 shadow-lg">
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-lg font-semibold text-gray-800">Add Member</h3>
      <button id="addClose" class="text-gray-400 hover:text-gray-600">✕</button>
    </div>

    <form id="addMemberForm" class="grid grid-cols-1 md:grid-cols-2 gap-4">

      <!-- LEFT -->
      <div>
        <label class="block text-sm font-medium text-gray-700">Full Name</label>
        <input name="name" required class="mt-1 w-full border rounded px-3 py-2">

        <label class="block text-sm font-medium text-gray-700 mt-3">Email</label>
        <input name="email" type="email" required class="mt-1 w-full border rounded px-3 py-2">

        <label class="block text-sm font-medium text-gray-700 mt-3">Phone</label>
        <input name="phone" class="mt-1 w-full border rounded px-3 py-2">

        <label class="block text-sm font-medium text-gray-700 mt-3">Referral Code (optional)</label>
        <input name="referral_code" class="mt-1 w-full border rounded px-3 py-2">
      </div>

      <!-- RIGHT -->
      <div>
        <label class="block text-sm font-medium text-gray-700">Business Name</label>
        <input name="business_name" class="mt-1 w-full border rounded px-3 py-2">

        <label class="block text-sm font-medium text-gray-700 mt-3">Address</label>
        <input name="address" class="mt-1 w-full border rounded px-3 py-2">

        <label class="block text-sm font-medium text-gray-700 mt-3">City</label>
        <input name="city" class="mt-1 w-full border rounded px-3 py-2">

        <label class="block text-sm font-medium text-gray-700 mt-3">Pincode</label>
        <input name="pincode" class="mt-1 w-full border rounded px-3 py-2">
      </div>

      <div class="md:col-span-2 flex items-center justify-end gap-3 mt-2">
        <button type="button" id="addCancel" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Create Member</button>
      </div>
    </form>
  </div>
</div>

<script>
  feather.replace();

  /* ---------------------- UTILS ---------------------- */

  // helper to find table row by user id
  function findRowByUserId(userId) {
    return document.querySelector('#membersTbody tr[data-user-id="' + userId + '"]');
  }

  // helper to update chapter badge HTML
  function chapterBadgeHtml(name) {
    return '<span class="px-3 py-1 rounded-full bg-green-50 text-green-700 text-xs font-medium">' + escapeHtml(name) + '</span>';
  }

  // simple escape for safety
  function escapeHtml(str) {
    return String(str).replace(/[&<>"'`=\/]/g, function(s) {
      return ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;', '`':'&#96;','=':'&#61;','/':'&#47;'
      })[s];
    });
  }

  /* ---------------------- ASSIGN CHAPTER MODAL ---------------------- */

  const assignBtns = document.querySelectorAll('.assign-btn');
  const assignModal = document.getElementById('assignModal');
  const modalUser = document.getElementById('modalUser');
  const chapterSelect = document.getElementById('chapterSelect');
  const modalClose = document.getElementById('modalClose');
  const modalCancel = document.getElementById('modalCancel');
  const modalSave = document.getElementById('modalSave');
  let selectedUserId = null;

  // fill a map of chapterId => name for quick lookup
  const chapterOptions = Array.from(chapterSelect.options).reduce((acc, opt) => {
    if (opt.value) acc[opt.value] = opt.text;
    return acc;
  }, {});

  assignBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      selectedUserId = btn.dataset.userId;
      modalUser.textContent = "Assign chapter for: " + btn.dataset.userName;
      // pre-select current chapter if available
      const row = findRowByUserId(selectedUserId);
      if (row) {
        const badge = row.querySelector('.chapter-cell span');
        if (badge && badge.textContent !== 'Not Assigned') {
          // find matching option by text and select it
          const text = badge.textContent.trim();
          const opt = Array.from(chapterSelect.options).find(o => o.text === text);
          if (opt) chapterSelect.value = opt.value;
          else chapterSelect.value = '';
        } else {
          chapterSelect.value = '';
        }
      }
      assignModal.classList.remove('hidden');
      assignModal.classList.add('flex');
    });
  });

  function closeAssignModal() {
    assignModal.classList.add('hidden');
    assignModal.classList.remove('flex');
    chapterSelect.value = "";
    selectedUserId = null;
  }

  modalClose.addEventListener('click', closeAssignModal);
  modalCancel.addEventListener('click', closeAssignModal);

  modalSave.addEventListener('click', async () => {
    if (!selectedUserId) return alert("No member selected");
    const chapterId = chapterSelect.value;
    if (!chapterId) return alert("Select a chapter");

    // --- TODO: call your backend API here to save assignment ---
    // Example (uncomment and set correct URL & CSRF token):
    /*
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    try {
      const res = await fetch(`/admin/members/${selectedUserId}/assign-chapter`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
          'Accept': 'application/json'
        },
        body: JSON.stringify({ chapter_id: chapterId })
      });
      if (!res.ok) throw new Error('Request failed');
      const data = await res.json();
      if (!data.success) throw new Error(data.message || 'Server error');
      // proceed with UI update
    } catch (err) {
      return alert('Unable to assign chapter: ' + err.message);
    }
    */

    // UI update (instant)
    const row = findRowByUserId(selectedUserId);
    if (row) {
      // update chapter cell
      const chapterCell = row.querySelector('.chapter-cell');
      if (chapterCell) {
        chapterCell.innerHTML = chapterBadgeHtml(chapterOptions[chapterId] || 'Assigned');
      }

      // update action cell (button text -> Change)
      const actionCell = row.querySelector('.action-cell');
      if (actionCell) {
        const btn = actionCell.querySelector('button.assign-btn');
        if (btn) {
          btn.innerHTML = '<i data-feather="repeat" class="w-4"></i> Change';
          btn.dataset.userName = row.querySelector('.font-medium') ? row.querySelector('.font-medium').textContent.trim() : btn.dataset.userName;
          // re-run feather icons replacement for the new icon
          feather.replace();
        }
      }
    }

    // optional small success toast
    const toast = document.createElement('div');
    toast.className = 'fixed bottom-6 right-6 bg-green-600 text-white px-4 py-2 rounded shadow';
    toast.textContent = 'Chapter assigned successfully';
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 2500);

    closeAssignModal();
  });



  /* ---------------------- ADD MEMBER MODAL ---------------------- */

  const addModal = document.getElementById('addModal');
  const openAddMember = document.getElementById('openAddMember');
  const addClose = document.getElementById('addClose');
  const addCancel = document.getElementById('addCancel');
  const addMemberForm = document.getElementById('addMemberForm');
  const membersTbody = document.getElementById('membersTbody');

  openAddMember.addEventListener('click', () => {
    addModal.classList.remove('hidden');
    addModal.classList.add('flex');
  });

  function closeAddModal() {
    addModal.classList.add('hidden');
    addModal.classList.remove('flex');
    addMemberForm.reset();
  }

  addClose.addEventListener('click', closeAddModal);
  addCancel.addEventListener('click', closeAddModal);

  addMemberForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(addMemberForm);
    const payload = {};
    for (const [k, v] of formData.entries()) payload[k] = v;

    if (!payload.name || !payload.email) return alert('Name and email are required');

    // --- TODO: call your backend API to create the member ---
    // Example (uncomment + set CSRF token):
    /*
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const res = await fetch('/admin/members', {
      method: 'POST',
      headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': csrfToken },
      body: JSON.stringify(payload)
    });
    const data = await res.json();
    if (!data.success) return alert(data.message || 'Failed to create member');
    const newUser = data.user; // expect server to return created user object
    */

    // For demo UI-only mode: append a new row with a generated user-id
    const newId = Date.now(); // temp id — replace with server user id in real app
    const tr = document.createElement('tr');
    tr.className = 'hover:bg-gray-50';
    tr.setAttribute('data-user-id', newId);
    tr.innerHTML = `
      <td class="px-4 py-3 text-sm text-gray-700">NEW</td>
      <td class="px-4 py-3">
        <div class="font-medium text-gray-900">${escapeHtml(payload.name)}</div>
        <div class="text-xs text-gray-500">${escapeHtml(payload.email)}</div>
      </td>
      <td class="px-4 py-3 text-sm text-gray-700">${escapeHtml(payload.phone || '—')}</td>
      <td class="px-4 py-3 text-sm text-gray-700">${escapeHtml(payload.business_name || '—')}<br><span class="text-xs text-gray-500">${escapeHtml(payload.city || '')}</span></td>
      <td class="px-4 py-3 text-sm text-gray-700 chapter-cell"><span class="px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-xs">Not Assigned</span></td>
      <td class="px-4 py-3 text-center action-cell">
        <button class="assign-btn px-3 py-1 bg-white border rounded shadow-sm hover:shadow text-sm flex items-center gap-2" data-user-id="${newId}" data-user-name="${escapeHtml(payload.name)}">
          <i data-feather="user-plus" class="w-4"></i> Assign
        </button>
      </td>
    `;
    membersTbody.prepend(tr);

    // rebind new row's assign button
    const newBtn = tr.querySelector('.assign-btn');
    if (newBtn) {
      newBtn.addEventListener('click', () => {
        selectedUserId = newBtn.dataset.userId;
        modalUser.textContent = "Assign chapter for: " + newBtn.dataset.userName;
        chapterSelect.value = '';
        assignModal.classList.remove('hidden');
        assignModal.classList.add('flex');
      });
    }

    feather.replace();
    closeAddModal();
  });



  /* ---------------------- SEARCH & REFRESH ---------------------- */

  document.getElementById('refreshBtn').addEventListener('click', () => location.reload());

</script>
@endsection