@extends('layouts.app')

@section('content')

<style>
/* -----------------------------------------
   TMN PREMIUM THEME — GLOBAL UI MATCHED
------------------------------------------ */

/* Inputs */
input, select {
    transition: all .2s ease;
}
input:focus, select:focus {
    border-color:#e11d48 !important;
    box-shadow:0 0 0 3px rgba(225,29,72,.25);
}

/* Card */
.tmn-card {
    background:white;
    border-radius:1rem;
    padding:1.5rem;
    border:1px solid #f1f1f1;
    box-shadow:0 6px 16px rgba(0,0,0,.06);
}

/* Table */
table {
    border-radius:14px;
    overflow:hidden;
}
thead tr {
    background:#f8fafc;
    text-transform:uppercase;
    font-size:11px;
    color:#6b7280;
}
tbody tr:hover {
    background:#fafafa;
}

/* Modal Animation */
.modal-card {
    animation:modalPop .22s ease-out;
}
@keyframes modalPop {
    from {opacity:0; transform:translateY(10px) scale(.95);}
    to {opacity:1; transform:translateY(0) scale(1);}
}

/* TMN badge */
.badge-role {
    background:#f3f4f6;
    padding:4px 10px;
    border-radius:8px;
    font-size:12px;
    color:#374151;
}
</style>


<main class="w-full p-2 sm:p-8">
  <div class="max-w-7xl mx-auto animate-fadeIn bg-white shadow-card rounded-xl p-6">
   <div class="  mb-6 bg-white shadow-lg rounded-2xl p-6">
        <!-- PAGE HEADER -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-semibold text-[#2C3E50]">Assigned Members</h2>
            </div>
        </div>

        <!-- FILTERS -->
        <div class="flex flex-col lg:flex-row gap-4 items-center justify-between mb-6">
            <div class="flex items-center gap-2 w-full md:w-1/2 relative">
                <i data-feather="search"
                    class="w-5 h-5 text-gray-500 absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input type="search" id="assignedSearch"
                    placeholder="Search member name / id / role..."
                    class="w-full pl-11 pr-4 py-2 border rounded-xl shadow-sm bg-white focus:ring-2 focus:ring-red-400 outline-none">
            </div>
            <select id="filterChapter"
                class="px-4 py-2 md:w-1/4 bg-white border rounded-lg shadow-sm focus:ring-2 focus:ring-red-400 outline-none">
                <option value="">All Chapters</option>
            </select>
        </div>


        <!-- TABLE -->
        <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="py-3 px-4 border text-left">#</th>
                        <th class="py-3 px-4 border text-left">Member</th>
                        <th class="py-3 px-4 border text-left">Chapter</th>
                        <th class="py-3 px-4 border text-left">Role</th>
                        <th class="py-3 px-4 border text-center">Actions</th>
                    </tr>
                </thead>

                <tbody id="assignedRows" class="text-gray-700">

                <!-- DUMMY DATA FROM SERVER (NOT JS) -->
                @php
                $assigned = [
                    [1, 101, "Ramesh Kumar", "Delhi Chapter", 1, "member", "Active"],
                    [2, 102, "Priya Sharma", "Delhi Chapter", 1, "coordinator", ""],
                    [3, 103, "Amit Verma", "Mumbai Chapter", 2, "member", "On probation"],
                ];
                @endphp

                @foreach($assigned as $a)
                <tr class="hover:bg-gray-50"
                    data-id="{{ $a[0] }}"
                    data-member-id="{{ $a[1] }}"
                    data-member-name="{{ $a[2] }}"
                    data-chapter="{{ $a[3] }}"
                    data-chapter-id="{{ $a[4] }}"
                    data-role="{{ $a[5] }}"
                    data-notes="{{ $a[6] }}">

                    <td class="px-4 py-3 border">{{ $a[0] }}</td>

                    <td class="px-4 py-3 border">
                        <div class="font-semibold text-gray-800 am-member-link cursor-pointer"
                             data-member-id="{{ $a[1] }}">{{ $a[2] }}</div>
                        <div class="text-xs text-gray-500">ID: {{ $a[1] }}</div>
                    </td>
                    <td class="px-4 py-3 border">{{ $a[3] }}</td>
                    <td class="px-4 py-3 border">
                        <span class="px-2 py-1 rounded text-white text-xs bg-red-500 font-medium">{{ $a[5] }}</span>
                    </td>

                    <td class="px-4 py-3 border text-center">
                        <button class="am-view text-blue-600 hover:underline text-sm font-semibold mr-3" data-id="{{ $a[0] }}">View</button>
                        <button class="am-remove text-red-600 hover:underline text-sm font-semibold" data-id="{{ $a[0] }}">Remove</button>
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


<!-- ========================= MODAL ============================= -->

<div id="am-modal" class="fixed inset-0 bg-black/30 hidden items-center justify-center z-50">
    <div id="am-modalOverlay" class="absolute inset-0"></div>

    <div class="relative bg-white rounded-2xl shadow-xl modal-card max-w-2xl w-full mx-4">
        <div class="flex items-center justify-between p-6 border-b">
            <h3 id="am-modalTitle" class="text-lg font-semibold"></h3>
            <button id="am-closeModal" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>

        <div id="am-modalContent" class="p-6 text-sm space-y-3"></div>

        <div class="p-4 border-t flex justify-end gap-3">
            <button id="am-cancel" class="px-4 py-2 bg-gray-100 rounded-lg">Close</button>
            <button id="am-removeBtn" class="px-4 py-2 bg-red-600 text-white rounded-lg">Remove Assignment</button>
        </div>
    </div>
</div>




<script>
/* ============================================================
   JS UPDATED — LOADS DATA FROM TABLE, NOT SCRIPT ARRAY
============================================================ */
(function(){

/* -------- Load Assigned Members from <tbody> -------- */
function loadAssignedFromDOM(){
    const rows = document.querySelectorAll("#assignedRows tr");
    const list = [];

    rows.forEach(r => {
        list.push({
            id: Number(r.dataset.id),
            member_id: Number(r.dataset["memberId"]),
            member_name: r.dataset["memberName"],
            chapter_name: r.dataset["chapter"],
            chapter_id: Number(r.dataset["chapterId"]),
            role: r.dataset["role"],
            admin_notes: r.dataset["notes"],
        });
    });

    return list;
}

let assigned = loadAssignedFromDOM();
let filtered = assigned.slice();


/* ------------- Pagination Vars ------------- */
let page = 1;
const pageSize = 6;


/* ------------- Elements ------------- */
const assignedRows = document.getElementById("assignedRows");
const filterChapter = document.getElementById("filterChapter");
const assignedSearch = document.getElementById("assignedSearch");

const showStart = document.getElementById("am-showStart");
const showEnd = document.getElementById("am-showEnd");
const totalEl = document.getElementById("am-total");

const btnFirst = document.getElementById("am-first");
const btnPrev = document.getElementById("am-prev");
const btnNext = document.getElementById("am-next");

/* Populate chapter dropdown dynamically */
const uniqueChapters = [...new Set(assigned.map(a => a.chapter_name))];
uniqueChapters.forEach(ch => {
    const o=document.createElement("option");
    o.value = ch;
    o.textContent = ch;
    filterChapter.appendChild(o);
});


/* ------------ Build HTML Row ------------ */
function rowHTML(item,index){
    return `
<tr class="hover:bg-gray-50"
    data-id="${item.id}"
    data-member-id="${item.member_id}"
    data-member-name="${item.member_name}"
    data-chapter="${item.chapter_name}"
    data-chapter-id="${item.chapter_id}"
    data-role="${item.role}"
    data-notes="${item.admin_notes}">

    <td class="px-4 py-3 border">${index}</td>

    <td class="px-4 py-3 border">
        <div class="font-semibold text-gray-800 am-member-link cursor-pointer" data-member-id="${item.member_id}">
            ${item.member_name}
        </div>
        <div class="text-xs text-gray-500">ID: ${item.member_id}</div>
    </td>

    <td class="px-4 py-3 border">${item.chapter_name}</td>

    <td class="px-4 py-3 border">
        <span class="badge-role">${item.role}</span>
    </td>

    <td class="px-4 py-3 border text-center">
        <button class="am-view text-blue-600 text-sm mr-3" data-id="${item.id}">View</button>
        <button class="am-remove text-red-600 text-sm" data-id="${item.id}">Remove</button>
    </td>
</tr>`;
}


/* ------------ Render Table ------------ */
function render(){
    assignedRows.innerHTML = "";

    const total = filtered.length;
    const start = (page-1) * pageSize;
    const end = Math.min(start + pageSize, total);

    const list = filtered.slice(start, end);

    if(list.length === 0){
        assignedRows.innerHTML = `
            <tr><td colspan="5" class="text-center py-6 text-gray-500">No assigned members.</td></tr>
        `;
    } else {
        list.forEach((item, i) => {
            assignedRows.insertAdjacentHTML("beforeend", rowHTML(item, start+i+1));
        });
    }

    showStart.textContent = list.length ? start+1 : 0;
    showEnd.textContent = end;
    totalEl.textContent = total;

    btnPrev.disabled = page === 1;
    btnFirst.disabled = page === 1;
    btnNext.disabled = end >= total;

    wireEvents();
}


/* ------------ Filtering ------------ */
function applyFilters() {

    const q = assignedSearch.value.toLowerCase().trim();
    const chapter = filterChapter.value;

    filtered = assigned.filter(a => {
        if(chapter && a.chapter_name !== chapter) return false;

        if(q){
            const hay = `${a.member_name} ${a.member_id} ${a.role}`.toLowerCase();
            if(!hay.includes(q)) return false;
        }

        return true;
    });

    page = 1;
    render();
}

assignedSearch.addEventListener("input", applyFilters);
filterChapter.addEventListener("change", applyFilters);


/* ------------ Pagination ------------ */
btnFirst.onclick = ()=>{ page=1; render(); };
btnPrev.onclick = ()=>{ if(page>1) page--; render(); };
btnNext.onclick = ()=>{ if(page*pageSize < filtered.length) page++; render(); };


/* ------------ Modal Logic ------------ */
const modal = document.getElementById("am-modal");
const modalOverlay = document.getElementById("am-modalOverlay");
const modalTitle = document.getElementById("am-modalTitle");
const modalContent = document.getElementById("am-modalContent");
const closeModal = document.getElementById("am-closeModal");
const cancelModal = document.getElementById("am-cancel");
const removeBtn = document.getElementById("am-removeBtn");

let modalId = null;

function openModal(item){

    modalId = item.id;

    modalTitle.textContent = `${item.member_name} — ${item.role}`;

    modalContent.innerHTML = `
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">

        <div>
            <h4 class="font-semibold text-gray-800 mb-2">Member Info</h4>
            <p><b>ID:</b> ${item.member_id}</p>
            <p><b>Name:</b> ${item.member_name}</p>
            <p><b>Role:</b> ${item.role}</p>
        </div>

        <div>
            <h4 class="font-semibold text-gray-800 mb-2">Chapter Info</h4>
            <p><b>Chapter:</b> ${item.chapter_name}</p>
            <p><b>Chapter ID:</b> ${item.chapter_id}</p>
            <p><b>Notes:</b> ${item.admin_notes || "—"}</p>
        </div>

    </div>`;

    modal.classList.remove("hidden");
    modal.style.display="flex";
}

function closeModalFn(){
    modal.classList.add("hidden");
    modal.style.display="none";
}

modalOverlay.onclick = closeModalFn;
closeModal.onclick = closeModalFn;
cancelModal.onclick = closeModalFn;

removeBtn.onclick = () => {
    if(!confirm("Remove assignment?")) return;

    assigned = assigned.filter(a => a.id !== modalId);
    filtered = filtered.filter(a => a.id !== modalId);

    closeModalFn();
    render();
};


/* ------------ Actions Wiring ------------ */
function wireEvents(){

    document.querySelectorAll(".am-view").forEach(btn=>{
        btn.onclick = () => {
            const id = Number(btn.dataset.id);
            const item = assigned.find(a => a.id === id);
            if(item) openModal(item);
        };
    });

    document.querySelectorAll(".am-remove").forEach(btn=>{
        btn.onclick = () => {
            const id = Number(btn.dataset.id);
            if(!confirm("Remove assignment?")) return;

            assigned = assigned.filter(a => a.id !== id);
            filtered = filtered.filter(a => a.id !== id);
            render();
        };
    });

    document.querySelectorAll(".am-member-link").forEach(link=>{
        link.onclick = ()=>{
            window.location.href="/admin/member/index";
        };
    });
}


/* ------------ INIT ------------ */
render();
feather.replace();

})();
</script>

@endsection
