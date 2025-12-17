@extends('layouts.app')

@section('content')
    <style>
        /* ==============================
       TMN Enquiry Management UI
       ============================== */
        .nav-active {
            background: linear-gradient(to right, #ffe6e6, #ffffff);
            border-right: 4px solid #e53935;
            box-shadow: inset 0 0 10px rgba(229, 57, 53, 0.15);
        }

        .tmn-card {
            background: #fff;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
        }

        table {
            border-radius: 14px;
            overflow: hidden;
        }

        tbody tr:hover {
            background: #fafafa;
        }

        .badge-new {
            background: #22c55e;
            color: #fff;
        }

        .badge-closed {
            background: #ef4444;
            color: #fff;
        }

        .modal-card {
            animation: pop 0.25s ease;
        }

        @keyframes pop {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }
/* Modern Button Style */
button {
    transition: all 0.25s ease;
}
button:hover {
    transform: translateY(-2px);
}

/* INPUTS */
input,
select,
textarea {
    transition: all .2s ease-in-out;
}

input:focus,
select:focus,
textarea:focus {
    border-color: #e11d48 !important;
    box-shadow: 0 0 0 3px rgba(225,29,72,0.25);
    outline: none;
}

    </style>

    <main class="w-full p-2 sm:p-2">
        <div class="max-w-7xl mx-auto bg-white shadow-md rounded-xl p-6">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                <h3 class="text-2xl font-semibold text-gray-700">Enquiry Management</h3>
                <button id="addBtn" class="bg-[#CF2031] text-white px-5 py-2 rounded-lg hover:bg-[#b81a28] transition">
                    + Add Enquiry
                </button>
            </div>

            <!-- Filters -->
            <div class="flex flex-col lg:flex-row items-center justify-between gap-4 mb-6">
            <div class="relative w-full lg:w-1/2">
        <i data-feather="search" class="w-5 h-5 text-gray-500 absolute left-3 top-1/2 -translate-y-1/2"></i>
        <input type="text" id="searchInput" placeholder="Search by name, email or profession..." class="w-full pl-11 pr-4 py-2 bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none">
    </div>
    <select id="statusFilter" class="w-full lg:w-auto px-4 py-2 bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none">
        <option value="">All Status</option>
        <option value="new">New</option>
        <option value="closed">Closed</option>
    </select>
</div>
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 text-sm">
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
                    <tbody id="rowsContainer">
                        @foreach($enquiries as $i => $e)
                            <tr class="hover:bg-gray-50" data-id="{{ $e->id }}" data-name="{{ strtolower($e->name) }}"
                                data-email="{{ strtolower($e->email) }}" data-profession="{{ strtolower($e->profession) }}"
                                data-status="{{ strtolower($e->status) }}">
                                <td class="py-3 px-4 border">{{ $i + 1 }}</td>
                                <td class="py-3 px-4 border font-medium text-gray-800">{{ $e->name }}</td>
                                <td class="py-3 px-4 border text-gray-600">{{ $e->email }}</td>
                                <td class="py-3 px-4 border text-gray-600">{{ $e->contact_number }}</td>
                                <td class="py-3 px-4 border text-gray-600">{{ $e->profession }}</td>
                                <td class="py-3 px-4 border">
                                    <span
                                        class="px-2 py-1 rounded text-xs {{ $e->status === 'new' ? 'badge-new' : 'badge-closed' }}">
                                        {{ ucfirst($e->status) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 border text-right space-x-2">
                                    <button class="viewBtn text-blue-600 hover:underline text-sm font-semibold"
                                        data-id="{{ $e->id }}">View</button>
                                    <button class="editBtn text-green-600 hover:underline text-sm font-semibold"
                                        data-id="{{ $e->id }}">Edit</button>
                                    <button class="deleteBtn text-red-600 hover:underline text-sm font-semibold"
                                        data-id="{{ $e->id }}">Delete</button>
                                    <button class="linkBtn text-[#CF2031] hover:underline text-sm font-semibold"
                                        data-id="{{ $e->id }}">
                                        Send Link
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">{{ $enquiries->links() }}</div>
        </div>
    </main>

    <!-- CRUD Modal -->
    <div id="crudModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl p-6 modal-card w-full max-w-lg mx-4">
            <h3 id="modalTitle" class="text-lg font-semibold mb-4">Add Enquiry</h3>

            <form id="crudForm" class="space-y-3">
                @csrf
                <input type="hidden" id="enquiryId">
                <input type="text" id="name" placeholder="Name" class="w-full p-2 bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none" required>
                <input type="email" id="email" placeholder="Email" class="w-full p-2 bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none">
                <input type="text" id="contact_number" placeholder="Phone" class="w-full p-2 bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none">
                <input type="text" id="profession" placeholder="Profession" class="w-full p-2 bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none">
                <select id="status" class="w-full p-2 bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none" required>
                    <option value="new">New</option>
                    <option value="closed">Closed</option>
                </select>
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" id="cancelBtn" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
                    <button type="submit" id="saveBtn" class="px-4 py-2 bg-[#CF2031] text-white rounded">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Modal -->
    <div id="viewModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl p-6 modal-card w-full max-w-md mx-4">
            <h3 class="text-lg font-semibold mb-3">View Enquiry</h3>
            <div id="viewBody" class="text-gray-700 space-y-2"></div>
            <div class="text-right mt-4">
                <button id="closeView" class="px-4 py-2 bg-[#CF2031] text-white rounded">Close</button>
            </div>
        </div>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', () => {
    const addBtn = document.getElementById('addBtn');
    const crudModal = document.getElementById('crudModal');
    const cancelBtn = document.getElementById('cancelBtn');
    const crudForm = document.getElementById('crudForm');
    const modalTitle = document.getElementById('modalTitle');
    const rowsContainer = document.getElementById('rowsContainer');
    const viewModal = document.getElementById('viewModal');
    const viewBody = document.getElementById('viewBody');
    const closeView = document.getElementById('closeView');
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const table = document.querySelector('table');
    let sortDirection = 1; // 1 = ascending, -1 = descending

    /* =============================
       ADD / UPDATE / DELETE / VIEW
       ============================= */
    addBtn.addEventListener('click', () => {
        crudForm.reset();
        document.getElementById('enquiryId').value = '';
        modalTitle.innerText = 'Add Enquiry';
        crudModal.classList.remove('hidden');
        crudModal.classList.add('flex');
    });

    cancelBtn.addEventListener('click', () => crudModal.classList.add('hidden'));

    crudForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const id = document.getElementById('enquiryId').value;
        const data = {
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            contact_number: document.getElementById('contact_number').value,
            profession: document.getElementById('profession').value,
            status: document.getElementById('status').value,
            _token: '{{ csrf_token() }}'
        };

        const method = id ? 'PUT' : 'POST';
        const url = id ? `/admin/enquiries/${id}` : `/admin/enquiries`;

        fetch(url, {
            method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(res => {
            crudModal.classList.add('hidden');
            Swal.fire({
                title: '✅ Success',
                text: res.message || (id ? 'Enquiry updated successfully.' : 'Enquiry added successfully.'),
                icon: 'success',
                background: '#fff',
                color: '#333',
                confirmButtonColor: '#CF2031',
                iconColor: '#CF2031',
                width: '22em',
            }).then(() => location.reload());
        })
        .catch(() => {
            Swal.fire({
                title: '❌ Error',
                text: 'Something went wrong while saving the enquiry.',
                icon: 'error',
                background: '#fff',
                color: '#333',
                confirmButtonColor: '#CF2031',
                iconColor: '#CF2031',
                width: '22em'
            });
        });
    });

    /* =============================
       ROW ACTIONS
       ============================= */
    rowsContainer.addEventListener('click', (e) => {
        const row = e.target.closest('tr');
        if (!row) return;
        const id = row.dataset.id;

        // View
        if (e.target.classList.contains('viewBtn')) {
            fetch(`/admin/enquiries/${id}`)
                .then(res => res.json())
                .then(data => {
                    viewBody.innerHTML = `
                        <p><strong>Name:</strong> ${data.name}</p>
                        <p><strong>Email:</strong> ${data.email || 'N/A'}</p>
                        <p><strong>Phone:</strong> ${data.contact_number || 'N/A'}</p>
                        <p><strong>Profession:</strong> ${data.profession || 'N/A'}</p>
                        <p><strong>Status:</strong> ${data.status}</p>
                    `;
                    viewModal.classList.remove('hidden');
                    viewModal.classList.add('flex');
                });
        }

        // Edit
        if (e.target.classList.contains('editBtn')) {
            fetch(`/admin/enquiries/${id}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('enquiryId').value = data.id;
                    document.getElementById('name').value = data.name;
                    document.getElementById('email').value = data.email;
                    document.getElementById('contact_number').value = data.contact_number;
                    document.getElementById('profession').value = data.profession;
                    document.getElementById('status').value = data.status;
                    modalTitle.innerText = 'Edit Enquiry';
                    crudModal.classList.remove('hidden');
                    crudModal.classList.add('flex');
                });
        }

        // Delete
        if (e.target.classList.contains('deleteBtn')) {
            Swal.fire({
                title: 'Delete Enquiry?',
                text: 'This enquiry will be permanently removed.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#CF2031',
                cancelButtonColor: '#6b7280',
                background: '#fff',
                color: '#333',
                iconColor: '#CF2031',
                width: '22em',
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/enquiries/${id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    })
                    .then(res => res.json())
                    .then(res => {
                        Swal.fire({
                            title: 'Deleted!',
                            text: res.message || 'Enquiry deleted successfully.',
                            icon: 'success',
                            confirmButtonColor: '#CF2031',
                            iconColor: '#CF2031',
                            width: '22em'
                        }).then(() => location.reload());
                    })
                    .catch(() => {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to delete enquiry.',
                            icon: 'error',
                            confirmButtonColor: '#CF2031',
                            iconColor: '#CF2031',
                            width: '22em'
                        });
                    });
                }
            });
        }

        // ✅ Send Membership Link
        if (e.target.classList.contains('linkBtn')) {
            Swal.fire({
                title: 'Send Membership Link?',
                text: 'A secure registration link will be emailed to the member.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#CF2031',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Send Link',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create spinner overlay
                    const spinner = document.createElement('div');
                    spinner.id = 'spinnerOverlay';
                    spinner.innerHTML = `
                        <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
                            <div class="w-14 h-14 border-4 border-white border-t-[#CF2031] rounded-full animate-spin"></div>
                        </div>
                    `;
                    document.body.appendChild(spinner);

                    // Send link request
                    fetch(`/admin/enquiries/${id}/send-link`, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    })
                    .then(res => {
                        if (!res.ok) throw new Error('Request failed');
                        return res.json();
                    })
                    .then(data => {
                        document.getElementById('spinnerOverlay').remove();
                        Swal.fire({
                            title: '✅ Membership Link Sent!',
                            html: `<a href="${data.link}" target="_blank">${data.link}</a><br><small>You can share this link manually too.</small>`,
                            icon: 'success',
                            confirmButtonColor: '#CF2031',
                            width: '22em'
                        });
                    })
                    .catch(() => {
                        document.getElementById('spinnerOverlay').remove();
                        Swal.fire({
                            title: '❌ Error',
                            text: 'Failed to send membership link. Check your route or controller.',
                            icon: 'error',
                            confirmButtonColor: '#CF2031',
                            width: '22em'
                        });
                    });
                }
            });
        }
    });

    closeView.addEventListener('click', () => viewModal.classList.add('hidden'));

    /* =============================
       SEARCH + FILTER + SORT
       ============================= */
    function filterRows() {
        const query = searchInput.value.toLowerCase();
        const status = statusFilter.value;

        rowsContainer.querySelectorAll('tr').forEach(row => {
            const name = row.dataset.name || '';
            const email = row.dataset.email || '';
            const profession = row.dataset.profession || '';
            const rowStatus = row.dataset.status || '';

            const matchesSearch =
                name.includes(query) || email.includes(query) || profession.includes(query);
            const matchesStatus = !status || rowStatus === status;

            row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterRows);
    statusFilter.addEventListener('change', filterRows);

    /* =============================
       SORTING (click on headers)
       ============================= */
    table.querySelectorAll('th').forEach((th, i) => {
        th.addEventListener('click', () => {
            if (i === 0 || i === 6) return;
            const rows = Array.from(rowsContainer.querySelectorAll('tr'));
            const sorted = rows.sort((a, b) => {
                const textA = a.children[i].textContent.trim().toLowerCase();
                const textB = b.children[i].textContent.trim().toLowerCase();
                return textA.localeCompare(textB) * sortDirection;
            });
            rowsContainer.innerHTML = '';
            sorted.forEach(r => rowsContainer.appendChild(r));
            sortDirection *= -1;
        });
    });
});
</script>

@endsection
