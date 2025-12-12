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

    <!-- PAGE HEADER -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-semibold text-[#2C3E50] mb-1">Members List</h2>
            <p class="text-gray-600">View all members and assign chapters.</p>
        </div>

        <button id="openAddMember"
                class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl shadow flex items-center gap-2">
            <i data-feather="user-plus" class="w-4"></i> Add Member
        </button>
    </div>


    <!-- FILTERS -->
    <div class="tmn-card mb-6">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-4">

            <!-- Search -->
            <div class="flex items-center gap-2 w-full md:w-1/2 relative">
            <i data-feather="search" class="w-5 h-5 text-gray-500 absolute left-3 top-1/2 -translate-y-1/2"></i>
            <input type="text" id="searchInput" placeholder="Search by name or email..." class="w-full pl-11 pr-4 py-2 bg-white border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-red-400 outline-none">
        </div>
        <select id="statusFilter"
        class="px-4 py-2 md:w-1/4 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-red-400 outline-none">
    <option value="">All Status</option>
    <option value="assigned">Assigned</option>
    <option value="not assigned">Not Assigned</option>
      </select>
     </div>
    </div>
    <!-- TABLE -->
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-100">
        <table class="min-w-full text-sm">

            <thead>
                <tr>
                    <th class="py-3 px-4 border text-left">#</th>
                    <th class="py-3 px-4 border text-left">Member</th>
                    <th class="py-3 px-4 border text-left">Contact</th>
                    <th class="py-3 px-4 border text-left">Business / City</th>
                    <th class="py-3 px-4 border text-left">Chapter</th>
                    <th class="py-3 px-4 border text-center">Action</th>
                </tr>
            </thead>

            <tbody id="membersTbody" class="divide-y divide-gray-200">

                <!-- SAMPLE ROW (Your placeholder) -->
                <tr class="hover:bg-gray-50" data-user-id="1">
                    <td class="px-4 py-3 text-gray-700">1</td>

                    <td class="px-4 py-3">
                        <div class="font-semibold text-gray-800">Ramesh Kumar</div>
                        <div class="text-xs text-gray-500">ramesh@example.com</div>
                    </td>

                    <td class="px-4 py-3 text-gray-700">
                        +91 98765 43210
                    </td>

                    <td class="px-4 py-3 text-gray-700 leading-tight">
                        Ramesh Enterprises <br>
                        <span class="text-xs text-gray-500">Delhi</span>
                    </td>

                    <td class="px-4 py-3 chapter-cell">
                        <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-xs">Not Assigned</span>
                    </td>

                    <td class="px-4 py-3 action-cell text-center">
                        <button class="assign-btn px-3 py-1 bg-white border rounded-lg shadow-sm hover:shadow text-sm flex items-center gap-2"
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
        <select id="chapterSelect" class="w-full border rounded-lg px-3 py-2 mb-4">
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
                <input name="name" required class="mt-1 w-full border rounded px-3 py-2">

                <label class="block text-sm font-medium text-gray-700 mt-3">Email</label>
                <input name="email" type="email" required class="mt-1 w-full border rounded px-3 py-2">

                <label class="block text-sm font-medium text-gray-700 mt-3">Phone</label>
                <input name="phone" class="mt-1 w-full border rounded px-3 py-2">

                <label class="block text-sm font-medium text-gray-700 mt-3">Referral Code</label>
                <input name="referral_code" class="mt-1 w-full border rounded px-3 py-2">
            </div>

            <!-- Right Column -->
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

            <div class="md:col-span-2 flex justify-end gap-3 mt-2">
                <button type="button" id="addCancel" class="px-4 py-2 bg-gray-200 rounded-lg">Cancel</button>
                <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Create Member
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
