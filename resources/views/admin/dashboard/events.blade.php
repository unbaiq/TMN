@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-8">
  <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-6">
    <div>
      <h1 class="text-2xl font-semibold text-gray-800">Events — Admin</h1>
      <p class="text-sm text-gray-600">Create, edit and manage chapter events. This is a UI-only page (client-side demo).</p>
    </div>

    <div class="flex items-center gap-2 w-full md:w-auto">
      <input id="ev-search" type="search" placeholder="Search events..." class="px-3 py-2 border rounded-md text-sm w-full md:w-72" />
      <button id="ev-createBtn" class="ml-2 px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm flex items-center gap-2">
        <i data-feather="plus" class="w-4 h-4"></i> Create Event
      </button>
    </div>
  </div>

  <div class="bg-white rounded-lg shadow-sm overflow-hidden">
    {{-- Table header for desktop --}}
    <div class="hidden md:grid grid-cols-12 gap-4 px-4 py-3 text-xs text-gray-500 border-b bg-gray-50">
      <div class="col-span-3">Title</div>
      <div class="col-span-3">When</div>
      <div class="col-span-3">Location</div>
      <div class="col-span-1 text-center">Cap.</div>
      <div class="col-span-1">Status</div>
      <div class="col-span-1 text-right">Actions</div>
    </div>

    {{-- Rows container --}}
    <div id="ev-rows" class="divide-y divide-gray-100"></div>

    {{-- Pagination area (UI only) --}}
    <div class="px-4 py-3 border-t bg-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-sm">
      <div class="text-gray-600">Showing <span id="ev-showFrom">0</span>-<span id="ev-showTo">0</span> of <span id="ev-total">0</span></div>
      <div class="flex items-center gap-2 ml-auto">
        <button id="ev-first" class="px-3 py-1 bg-white border rounded disabled:opacity-50">First</button>
        <button id="ev-prev" class="px-3 py-1 bg-white border rounded disabled:opacity-50">Prev</button>
        <button id="ev-next" class="px-3 py-1 bg-white border rounded disabled:opacity-50">Next</button>
      </div>
    </div>
  </div>
</div>

{{-- EVENT CREATE / EDIT MODAL --}}
<div id="ev-modal" class="fixed inset-0 z-50 hidden items-center justify-center" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="ev-modal-title">
  <div id="ev-overlay" class="absolute inset-0 bg-black/40"></div>

  <div class="relative max-w-3xl w-full mx-4">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
      <form id="ev-form" class="space-y-4 p-6" autocomplete="off">
        <div class="flex items-center justify-between">
          <h3 id="ev-modal-title" class="text-lg font-semibold">Create Event</h3>
          <button type="button" id="ev-close" class="text-gray-500 hover:text-gray-700" aria-label="Close">✕</button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div>
            <label class="text-xs text-gray-600">Title <span class="text-red-600">*</span></label>
            <input id="ev-title" name="title" required class="mt-1 block w-full px-3 py-2 border rounded-md" />
          </div>

          <div>
            <label class="text-xs text-gray-600">Location</label>
            <input id="ev-location" name="location" class="mt-1 block w-full px-3 py-2 border rounded-md" />
          </div>

          <div>
            <label class="text-xs text-gray-600">Starts at</label>
            <input id="ev-starts" name="starts_at" type="datetime-local" class="mt-1 block w-full px-3 py-2 border rounded-md" />
          </div>

          <div>
            <label class="text-xs text-gray-600">Ends at</label>
            <input id="ev-ends" name="ends_at" type="datetime-local" class="mt-1 block w-full px-3 py-2 border rounded-md" />
          </div>

          <div>
            <label class="text-xs text-gray-600">Capacity</label>
            <input id="ev-capacity" name="capacity" type="number" min="0" class="mt-1 block w-full px-3 py-2 border rounded-md" />
          </div>

          <div>
            <label class="text-xs text-gray-600">Status</label>
            <select id="ev-status" name="status" class="mt-1 block w-full px-3 py-2 border rounded-md">
              <option value="draft">Draft</option>
              <option value="published">Published</option>
              <option value="cancelled">Cancelled</option>
            </select>
          </div>

        </div>

        <div>
          <label class="text-xs text-gray-600">Description</label>
          <textarea id="ev-description" rows="4" class="mt-1 block w-full px-3 py-2 border rounded-md"></textarea>
        </div>

        <div>
          <label class="text-xs text-gray-600">Poster (image preview only)</label>
          <div class="flex items-center gap-3 mt-1">
            <input id="ev-poster" type="file" accept="image/*" class="px-2 py-1" />
            <div id="ev-posterPreview" class="h-16 w-24 bg-gray-50 border rounded flex items-center justify-center text-xs text-gray-400">No image</div>
          </div>
        </div>

        <div class="flex items-center justify-end gap-2 pt-2">
          <button type="button" id="ev-cancel" class="px-4 py-2 bg-white border rounded">Cancel</button>
          <button type="submit" id="ev-save" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">Save Event</button>
        </div>

        <input type="hidden" id="ev-id" value="" />
      </form>
    </div>
  </div>
</div>

{{-- CONFIRM DELETE MODAL (simple) --}}
<div id="ev-deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center">
  <div class="absolute inset-0 bg-black/40"></div>
  <div class="relative max-w-sm w-full mx-4">
    <div class="bg-white rounded-xl shadow p-4">
      <div class="text-sm text-gray-800 font-medium mb-2">Delete event?</div>
      <div class="text-xs text-gray-600 mb-4">This will remove the event from the list (UI-only).</div>
      <div class="flex justify-end gap-2">
        <button id="ev-deleteCancel" class="px-3 py-1 bg-white border rounded">Cancel</button>
        <button id="ev-deleteConfirm" class="px-3 py-1 bg-red-600 text-white rounded">Delete</button>
      </div>
    </div>
  </div>
</div>

<style>
  /* small utils */
  .ev-card-hover:hover { background: rgba(229,57,53,0.03); transform: translateY(-1px); }
  @media (max-width: 767px) { .desktop-only { display: none; } }
</style>

<script>
/*
  Admin Events UI — client side only demo
  - Create / Edit / Delete events in-memory
  - Responsive: desktop table + mobile cards
  - Poster preview (client-only)
*/
document.addEventListener('DOMContentLoaded', () => {
  // sample events
  let events = [
    { id: 1, title: 'Chapter Meetup — May', description: 'Monthly meetup for members.', location: 'Mumbai Hall', starts_at: '2025-05-20T18:00', ends_at: '2025-05-20T20:00', capacity: 80, status: 'published', poster: '' },
    { id: 2, title: 'Networking Evening', description: 'Invite-only networking.', location: 'Delhi Club', starts_at: '2025-06-10T19:00', ends_at: '2025-06-10T22:00', capacity: 120, status: 'draft', poster: '' }
  ];

  // state
  let filtered = [...events];
  let page = 1;
  const pageSize = 8;

  // refs
  const rows = document.getElementById('ev-rows');
  const search = document.getElementById('ev-search');
  const createBtn = document.getElementById('ev-createBtn');
  const modal = document.getElementById('ev-modal');
  const overlay = document.getElementById('ev-overlay');
  const evForm = document.getElementById('ev-form');
  const evClose = document.getElementById('ev-close');
  const evCancel = document.getElementById('ev-cancel');
  const evSave = document.getElementById('ev-save');
  const evId = document.getElementById('ev-id');
  const evTitle = document.getElementById('ev-title');
  const evDescription = document.getElementById('ev-description');
  const evLocation = document.getElementById('ev-location');
  const evStarts = document.getElementById('ev-starts');
  const evEnds = document.getElementById('ev-ends');
  const evCapacity = document.getElementById('ev-capacity');
  const evStatus = document.getElementById('ev-status');
  const evPoster = document.getElementById('ev-poster');
  const evPosterPreview = document.getElementById('ev-posterPreview');

  const evFirst = document.getElementById('ev-first');
  const evPrev = document.getElementById('ev-prev');
  const evNext = document.getElementById('ev-next');
  const evShowFrom = document.getElementById('ev-showFrom');
  const evShowTo = document.getElementById('ev-showTo');
  const evTotal = document.getElementById('ev-total');

  const deleteModal = document.getElementById('ev-deleteModal');
  const deleteConfirm = document.getElementById('ev-deleteConfirm');
  const deleteCancel = document.getElementById('ev-deleteCancel');

  let pendingDeleteId = null;

  function formatWhen(s,e){
    if(!s) return '—';
    const start = new Date(s);
    const end = e ? new Date(e) : null;
    const opts = { day:'2-digit', month:'short', year:'numeric', hour:'2-digit', minute:'2-digit' };
    const sText = start.toLocaleString(undefined, opts);
    const eText = end ? end.toLocaleString(undefined, opts) : '';
    return eText ? `${sText} — ${eText}` : sText;
  }

  function esc(v){ if (v==null) return ''; return String(v).replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;'); }

  // render
  function render(){
    rows.innerHTML = '';
    const total = filtered.length;
    const start = (page -1) * pageSize;
    const end = start + pageSize;
    const list = filtered.slice(start,end);

    if(!list.length){
      rows.innerHTML = '<div class="p-6 text-center text-gray-500">No events found.</div>';
    } else {
      list.forEach((ev, idx) => {
        // desktop row
        const desktop = `
          <div class="hidden md:grid grid-cols-12 gap-4 px-4 py-4 items-center text-sm border-b ev-card-hover">
            <div class="col-span-3">
              <div class="font-medium">${esc(ev.title)}</div>
              <div class="text-xs text-gray-500 mt-1">${esc(ev.description || '')}</div>
            </div>
            <div class="col-span-3 text-sm text-gray-600">${formatWhen(ev.starts_at, ev.ends_at)}</div>
            <div class="col-span-3 text-sm text-gray-700">${esc(ev.location || '—')}</div>
            <div class="col-span-1 text-center text-sm text-gray-600">${ev.capacity ?? '—'}</div>
            <div class="col-span-1 text-sm">${ev.status}</div>
            <div class="col-span-1 text-right">
              <button class="ev-edit text-blue-600 text-sm mr-3" data-id="${ev.id}">Edit</button>
              <button class="ev-delete text-red-600 text-sm" data-id="${ev.id}">Delete</button>
            </div>
          </div>
        `;
        // mobile card
        const mobile = `
          <div class="md:hidden px-4 py-4 border-b ev-card-hover">
            <div class="flex items-start justify-between gap-3">
              <div class="min-w-0">
                <div class="font-medium">${esc(ev.title)}</div>
                <div class="text-xs text-gray-500 mt-1">${formatWhen(ev.starts_at, ev.ends_at)}</div>
                <div class="text-xs text-gray-400 mt-2">${esc(ev.location || '')}</div>
                <div class="text-xs text-gray-400 mt-1">Status: ${esc(ev.status)} • Cap: ${ev.capacity ?? '—'}</div>
              </div>
              <div class="flex flex-col gap-2 items-end">
                <button class="ev-edit text-blue-600 text-sm" data-id="${ev.id}">Edit</button>
                <button class="ev-delete text-red-600 text-sm" data-id="${ev.id}">Delete</button>
              </div>
            </div>
          </div>
        `;

        rows.insertAdjacentHTML('beforeend', desktop + mobile);
      });
    }

    evShowFrom.textContent = list.length ? (start + 1) : 0;
    evShowTo.textContent = Math.min(end, total);
    evTotal.textContent = total;

    evPrev.disabled = page <= 1;
    evFirst.disabled = page <= 1;
    evNext.disabled = end >= total;
  }

  // search filter
  function applySearch(){
    const q = (search.value || '').toLowerCase().trim();
    filtered = events.filter(e => {
      const hay = `${e.title} ${e.description} ${e.location} ${e.status}`.toLowerCase();
      return !q || hay.includes(q);
    });
    page = 1;
    render();
  }
  search.addEventListener('input', () => { page = 1; applySearch(); });

  // open modal for create
  createBtn.addEventListener('click', () => openModal());

  function openModal(evObj = null){
    // reset
    evForm.reset();
    evPosterPreview.textContent = 'No image';
    evPosterPreview.style.backgroundImage = '';
    evPosterPreview.style.backgroundSize = '';
    evPosterPreview.style.backgroundPosition = '';
    evId.value = '';

    if(evObj){
      document.getElementById('ev-modal-title').textContent = 'Edit Event';
      evId.value = evObj.id;
      evTitle.value = evObj.title || '';
      evDescription.value = evObj.description || '';
      evLocation.value = evObj.location || '';
      evStarts.value = evObj.starts_at || '';
      evEnds.value = evObj.ends_at || '';
      evCapacity.value = evObj.capacity ?? '';
      evStatus.value = evObj.status || 'draft';
      if(evObj.poster){
        evPosterPreview.textContent = '';
        evPosterPreview.style.backgroundImage = `url('${evObj.poster}')`;
        evPosterPreview.style.backgroundSize = 'cover';
        evPosterPreview.style.backgroundPosition = 'center';
      }
    } else {
      document.getElementById('ev-modal-title').textContent = 'Create Event';
    }

    modal.classList.remove('hidden');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
  }

  function closeModal(){
    modal.classList.add('hidden');
    modal.style.display = 'none';
    document.body.style.overflow = '';
  }
  evClose.addEventListener('click', closeModal);
  evCancel.addEventListener('click', closeModal);
  overlay.addEventListener('click', (ev)=> { if(ev.target === overlay) closeModal(); });
  document.addEventListener('keydown', (e) => { if(e.key === 'Escape') closeModal(); });

  // poster preview
  evPoster.addEventListener('change', (e) => {
    const f = e.target.files && e.target.files[0];
    if(!f){ evPosterPreview.textContent = 'No image'; evPosterPreview.style.backgroundImage = ''; return; }
    const reader = new FileReader();
    reader.onload = (r) => {
      evPosterPreview.textContent = '';
      evPosterPreview.style.backgroundImage = `url('${r.target.result}')`;
      evPosterPreview.style.backgroundSize = 'cover';
      evPosterPreview.style.backgroundPosition = 'center';
    };
    reader.readAsDataURL(f);
  });

  // save (create/update)
  evForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const idVal = evId.value ? Number(evId.value) : null;
    const payload = {
      id: idVal || (events.length ? Math.max(...events.map(x=>x.id))+1 : 1),
      title: evTitle.value.trim(),
      description: evDescription.value.trim(),
      location: evLocation.value.trim(),
      starts_at: evStarts.value || '',
      ends_at: evEnds.value || '',
      capacity: evCapacity.value ? Number(evCapacity.value) : null,
      status: evStatus.value || 'draft',
      poster: evPosterPreview.style.backgroundImage ? evPosterPreview.style.backgroundImage.slice(5,-2) : ''
    };

    if(!payload.title){
      alert('Title required.');
      return;
    }

    if(idVal){
      // update
      events = events.map(it => it.id === idVal ? {...it, ...payload} : it);
    } else {
      // create
      events.unshift(payload);
    }

    filtered = [...events];
    page = 1;
    render();
    closeModal();
  });

  // delegated edit/delete
  document.addEventListener('click', (ev) => {
    const edit = ev.target.closest && ev.target.closest('.ev-edit');
    if(edit){
      const id = Number(edit.dataset.id);
      const item = events.find(x=>x.id===id);
      if(item) openModal(item);
      return;
    }
    const del = ev.target.closest && ev.target.closest('.ev-delete');
    if(del){
      const id = Number(del.dataset.id);
      pendingDeleteId = id;
      deleteModal.classList.remove('hidden');
      deleteModal.style.display = 'flex';
      document.body.style.overflow = 'hidden';
      return;
    }
  });

  deleteConfirm.addEventListener('click', () => {
    if(pendingDeleteId == null) return;
    events = events.filter(x => x.id !== pendingDeleteId);
    filtered = [...events];
    pendingDeleteId = null;
    deleteModal.classList.add('hidden');
    deleteModal.style.display = 'none';
    document.body.style.overflow = '';
    render();
  });
  deleteCancel.addEventListener('click', () => {
    pendingDeleteId = null;
    deleteModal.classList.add('hidden');
    deleteModal.style.display = 'none';
    document.body.style.overflow = '';
  });

  // pagination controls
  evFirst.addEventListener('click', () => { page = 1; render(); });
  evPrev.addEventListener('click', () => { if(page>1){ page--; render(); }});
  evNext.addEventListener('click', () => { if(page * pageSize < filtered.length ){ page++; render(); }});

  // initial render
  filtered = [...events];
  render();

  // feather icons
  if (typeof feather !== 'undefined') feather.replace();
});
</script>
@endsection